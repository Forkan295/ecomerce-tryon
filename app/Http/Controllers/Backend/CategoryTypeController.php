<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CategoryTypeRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\CategoryType;
use Illuminate\Support\Str;
use App\Enums\AppEnum;
use Inertia\Response;
use Inertia\Inertia;

class CategoryTypeController extends Controller
{
    public function index(): Response
    {
        $items = CategoryType::isUser()
                        ->latest()
                        ->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/CategoryType/Index', ['items' => $items]);
    }

    public function create(): Response
    {
        return Inertia::render('Backend/CategoryType/Create');
    }

    public function store(CategoryTypeRequest $request, $tenantName): RedirectResponse
    {
        try {
            $data = $request->all();
            $data['user_id'] = Auth::id();
            $data['slug'] = Str::slug(data_get($request, 'title'));

            CategoryType::create($data);

            return redirect()->route('backend.category-types.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function edit($tenantName, CategoryType $categoryType): Response
    {
        return Inertia::render('Backend/CategoryType/Edit', ['categoryType' => $categoryType]);
    }

    public function update(CategoryTypeRequest $request, $tenantName, CategoryType $categoryType): RedirectResponse
    {
        try {
            $data = $request->all();
            $data['slug'] = Str::slug(data_get($request, 'title'));

            $categoryType->update($data);

            return redirect()->route('backend.category-types.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function destroy($tenantName, CategoryType $categoryType): RedirectResponse
    {
        try {
            $categoryType->delete();

            return redirect()->route('backend.category-types.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }
}

