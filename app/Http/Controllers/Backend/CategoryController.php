<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryType;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Enums\AppEnum;
use Inertia\Response;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $items = Category::with('categoryType')
                    ->isUser()
                    ->latest()
                    ->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Category/Index', ['items' => $items]);
    }

    public function create(): Response
    {
        $categories = Category::categories();
        $categoryType = CategoryType::types();

        return Inertia::render('Backend/Category/Create', [
            'parentCategories' => $categories,
            'categoryType' => $categoryType,
        ]);
    }

    public function store(CategoryRequest $request, $tenantName): RedirectResponse
    {
        try {
            $data = $request->all();

            $data['user_id'] = Auth::id();
            $data['slug'] = Str::slug(data_get($request, 'title_en'));
            $data['order'] = $request->order ?? 0;

            $category = Category::create($data);

            if ($request->hasFile('image')) {
                $category->addMediaFromRequest('image')->toMediaCollection('image');
            }

            return redirect()->route('backend.categories.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function edit($tenantName, Category $category): Response
    {
        $categories = Category::categories();
        $categoryType = CategoryType::types();

        return Inertia::render('Backend/Category/Edit', [
            'category'         => $category,
            'parentCategories' => $categories,
            'categoryType'     => $categoryType,
        ]);
    }

    public function update(CategoryRequest $request, $tenantName, Category $category): RedirectResponse
    {
        try {
            $data = $request->all();
            $data['slug'] = Str::slug(data_get($request, 'title_en'));
            $data['order'] = $request->order ?? 0;

            $category->update($data);

            if ($request->hasFile('image')) {
                $category->clearMediaCollection('image');

                $category->addMediaFromRequest('image')->toMediaCollection('image');
            }

            return redirect()->route('backend.categories.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function destroy($tenantName, Category $category): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $productIds = $category->products()->pluck('id')->toArray();

            $category->products()->detach($productIds);
            Product::destroy($productIds);

            $category->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e);
        }

        return redirect()->route('backend.categories.index', $tenantName);
    }
}

