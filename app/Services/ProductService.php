<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Illuminate\Foundation\Application;
use App\Http\Requests\ProductRequest;
use App\Models\ProductAttributeGroup;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductAttribute;
use Illuminate\Support\Str;
use App\Models\Attribute;
use App\Models\Product;

class ProductService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|Application|mixed
     */
    protected mixed $productModel;

    public function __construct()
    {
        $this->productModel = resolve(Product::class);
    }

    public function storeProduct($request)
    {

        $this->productModel = $this->productModel::create([
            'uuid'          => Str::uuid(),
            'user_id'       => Auth::id(),
            'title_en'      => data_get($request, 'title_en'),
            'title_bn'      => data_get($request, 'title_bn'),
            'content_en'    => data_get($request, 'content_en'),
            'content_bn'    => data_get($request, 'content_bn'),
            'slug'          => Str::slug(data_get($request, 'title_en')),
            'compare_price' => data_get($request, 'compare_price'),
            'profit_margin' => data_get($request, 'profit_margin'),
            'sales_price'   => data_get($request, 'sales_price'),
            'cost_price'    => data_get($request, 'cost_price'),
            'sku'           => data_get($request, 'sku'),
            'status'        => data_get($request, 'status'),
            'tax_id'        => data_get($request, 'tax'),
        ]);

        return $this->productModel;
    }

    public function storeAttributes($combinations): void
    {
        foreach ($combinations as $combination) {
            $productAttrGroup = $this->productModel->attributeGroups()->create([
                'sku'       => $combination['sku'],
                'price'     => $combination['price'],
                'available' => $combination['available'],
                'on_hand'   => $combination['onHand'],
            ]);

            if (isset($combination['image'][0])) {
                $productAttrGroup->addMedia($combination['image'][0])->toMediaCollection('image', 'mediaLibrary');
            }

            if (isset($combination['file'][0])) {
                $productAttrGroup->addMedia($combination['file'][0])->toMediaCollection('file', 'mediaLibrary');
            }

            foreach ($combination['value'] as $attrValue) {
                $attribute = Attribute::find($attrValue['optionId']);
                $productAttrGroup->productAttributes()->create([
                    'attribute_id'    => $attribute->id,
                    'attribute_name'  => $attribute->title_en,
                    'attribute_value' => $attrValue['value'],
                ]);
            }
        }
    }

    public function storeTags($tags): void
    {
        $this->productModel->tags()->attach($tags);
    }

    public function storeCategory($category): void
    {
        $this->productModel->categories()->attach($category);
    }

    public function storeFiles(mixed $files, $requestFileName, $collectionName = "image"): void
    {
        if (!empty($files)) {
            $this->productModel->addMultipleMediaFromRequest([$requestFileName])
                ->each(function (FileAdder $fileAdder, $id) use ($files, $collectionName) {
                    $customFileName = time() . md5($files[$id]->getClientOriginalName()) . '.' . $files[$id]->getClientOriginalExtension();
                    $fileAdder->usingFileName($customFileName)->toMediaCollection($collectionName, 'mediaLibrary');
                });
        }
    }

    public function updateProduct(ProductRequest $request, Product $product): void
    {
        $this->productModel = $product;

        $this->productModel->update([
            'title_en'      => data_get($request, 'title_en'),
            'title_bn'      => data_get($request, 'title_bn'),
            'content_en'    => data_get($request, 'content_en'),
            'content_bn'    => data_get($request, 'content_bn'),
            'compare_price' => data_get($request, 'compare_price'),
            'profit_margin' => data_get($request, 'profit_margin'),
            'sales_price'   => data_get($request, 'sales_price'),
            'cost_price'    => data_get($request, 'cost_price'),
            'sku'           => data_get($request, 'sku'),
            'status'        => data_get($request, 'status'),
            'tax_id'        => data_get($request, 'tax'),
        ]);
    }

    public function updateTags(mixed $tags): void
    {
        if (!empty($tags) && !is_array($tags[0])) {
            $this->productModel->tags()->sync($tags);
        }
    }

    public function updateAttributes(mixed $optionCombinations): void
    {
        foreach ($optionCombinations as $combination) {
            $productAttrGroup = ProductAttributeGroup::find($combination['id']);
            if (isset($combination['image'][0])) {
                $productAttrGroup->clearMediaCollection('image');
                $productAttrGroup->addMedia($combination['image'][0])->toMediaCollection('image', 'mediaLibrary');
            }

            if (isset($combination['file'][0])) {
                $productAttrGroup->clearMediaCollection('file');
                $productAttrGroup->addMedia($combination['image'][0])->toMediaCollection('image', 'mediaLibrary');
            }

            $productAttrGroup->update([
                'sku'       => $combination['sku'],
                'price'     => $combination['price'],
                'available' => $combination['available'],
                'on_hand'   => $combination['onHand'],
            ]);


            foreach ($combination['value'] as $attrValue) {
                $attribute        = Attribute::find($attrValue['optionId']);
                $productAttrValue = ProductAttribute::find($attrValue['id']);
                $productAttrValue->update([
                    'attribute_id'    => $attribute->id,
                    'attribute_name'  => $attribute->title_en,
                    'attribute_value' => $attrValue['value'],
                ]);
            }
        }
    }

    public function updateCategory($category): void
    {
        $this->productModel->categories()->sync($category);
    }

    public function updateFiles(mixed $files, $collectionName = 'image'): void
    {
        foreach ($files as $file) {
            if (is_object($file)) {
                $this->productModel->addMedia($file)->toMediaCollection($collectionName, 'mediaLibrary');
            }
        }
    }
}
