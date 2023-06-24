<?php

namespace App\Http\Controllers\Backend;

use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\ProductRequest;
use App\Models\ProductAttributeGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Enums\AppEnum;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Tag;
use App\Models\Tax;

class ProductController extends Controller
{
    public function index(): Response
    {
        $items = Product::isUser()->latest()->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Product/Index', ['items' => $items]);
    }

    public function create(): Response
    {
        $categories = Category::with(['parent', 'children'])
                        ->isUser()
                        ->active()
                        ->whereNull('parent_id')
                        ->get(['id', 'title_en']);

        $attrs = Attribute::isUser()->active()->get();
        $tags = Tag::isUser()->active()->get();
        $taxes = $this->getTaxes();

        return Inertia::render('Backend/Product/Create', [
            'categories' => $categories,
            'attrs'      => $attrs,
            'taxes'      => $taxes,
            'tags'       => $tags,
        ]);
    }

    public function store(ProductService $productService, ProductRequest $request, $tenantName)
    {
        DB::beginTransaction();

        try {
            $productService->storeProduct($request);
            $productService->storeFiles($request->images, 'images');
            $productService->storeFiles($request['files'], 'files', 'file');
            $productService->storeTags($request->tags);
            $productService->storeCategory($request->category);

            if (!empty($request->optionCombinations)) {
                $productService->storeAttributes($request->optionCombinations);
            }

            DB::commit();

            return redirect()->route('backend.product.index', $tenantName);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception->getMessage());
        }
    }

    public function edit($tenantName, Product $product): Response
    {
        $optionCombination = $this->transformOptionCombination($product);
        $categories        = Category::with(['parent', 'children'])->get(['id', 'title_en']);
        $attrs             = Attribute::whereStatus(1)->get();
        $taxes             = $this->getTaxes();
        $tags              = $product->tags;
        $allTags           = Tag::all();
        $images            = $this->getMediaUrls($product->getMedia('image'));


        return Inertia::render('Backend/Product/Edit', [
            'product'           => $product,
            'categories'        => $categories,
            'attrs'             => $attrs,
            'taxes'             => $taxes,
            'productTags'       => $tags,
            'optionCombination' => $optionCombination,
            'images'            => $images,
            'allTags'           => $allTags,
        ]);
    }

    public function update(ProductService $productService, ProductRequest $request, $tenantName, Product $product)
    {
        DB::beginTransaction();

        try {
            $productService->updateProduct($request, $product);
            $productService->updateTags($request->tags);

            if (!empty($request->optionCombinations)) {
                $productService->updateAttributes($request->optionCombinations);
            }

            if (!empty($request->newOptionCombinations)) {
                $productService->storeAttributes($request->newOptionCombinations);
            }

            if (!empty($request->images)) {
                $productService->updateFiles($request->images);
            }

            if (!empty($request['files'])) {
                $product->clearMediaCollection('file');
                $productService->storeFiles($request['files'], 'files', 'file');
            }

            $productService->updateCategory($request->category);

            DB::commit();

            return redirect()->route('backend.product.index', $tenantName);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error('product Update', $exception->getTrace());
        }
    }

    public function productSingleMediaDelete(Request $request, $tenantName)
    {
        $media = Media::find($request->data['mediaId']);
        $model = Product::find($media->model_id);
        $model->deleteMedia($media->id);
    }

    public function destroy($tenantName, Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('backend.product.index', $tenantName);
    }

    public function destroyAttribute($tenantName, ProductAttributeGroup $attribute): RedirectResponse
    {
        $attribute->delete();

        return back();
    }

    public function getChildCategory($tenantName, Category $category): JsonResponse
    {
        $childCategory = $category->children;

        if (empty($childCategory)) {
            return response()->json([
                "data" => false
            ]);
        }

        return response()->json([
            "data"     => $childCategory,
            "isParent" => $category->isPatent
        ]);
    }

    public function getAttrs()
    {
        $attrs = Attribute::whereStatus(1)->get();
        return $attrs->map(function ($item) {
            if (collect(request()->attrs)->contains($item->id)) {
                $item['disabled'] = true;
            } else {
                $item['disabled'] = false;
            }
            return $item;
        });


//        $attrs = Attribute::whereStatus(1);
//        if (!empty(request()->attrs)) {
//            $attrs = $attrs->whereNotIn('id', request()->attrs);
//        }
//        return $attrs->get();
    }

    private function getTaxes()
    {
        return Tax::isUser()->active()->get()->transform(function ($item) {
            return [
                'id'                  => data_get($item, 'id'),
                'title'               => data_get($item, 'title'),
                'titleWithPercentage' => data_get($item, 'title') . ' - ' . data_get($item, 'percentage') . '%',
            ];
        });
    }

    private function transformOptionCombination($product)
    {
        return $product->attributeGroups->transform(function ($item) {
            $imageUrl = '';

            if ($item->hasMedia('image')) {
                $imageUrl = $item->media('image')->first()->getUrl();
            }

            return [
                'id'        => data_get($item, 'id'),
                'available' => data_get($item, 'available'),
                'onHand'    => data_get($item, 'on_hand'),
                'price'     => data_get($item, 'price'),
                'sku'       => data_get($item, 'sku'),
                'image'     => '',
                'file'      => '',
                'value'     => $this->transformOptionCombinationValue($item->productAttributes),
                'imageUrl'  => $imageUrl
            ];
        });
    }

    private function transformOptionCombinationValue($item)
    {
        return $item->transform(function ($item) {
            return [
                'id'       => data_get($item, 'id'),
                'value'    => data_get($item, 'attribute_value'),
                'optionId' => data_get($item, 'attribute_id'),
            ];
        });
    }

    private function getMediaUrls(MediaCollection $getMedia): MediaCollection
    {
        return $getMedia->transform(function ($media) {
            return [
                'isStored' => true,
                'url'      => $media->getUrl(),
                'id'       => $media->id,
            ];
        });

    }

    private function getAttributeImageUrls(mixed $attributeGroups)
    {
        return $attributeGroups->transform(function ($attributeGroup) {
            dd($attributeGroup);
            return ['url' => $attributeGroup->media('image')->first()->getUrl()];
        });
    }
}
