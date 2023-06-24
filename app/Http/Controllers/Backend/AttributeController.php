<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\AttributeRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Attribute;
use App\Enums\AppEnum;
use Inertia\Response;
use Inertia\Inertia;

class AttributeController extends Controller
{

    public function index(): Response
    {
        $items = Attribute::isUser()->latest()->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Attribute/Index', ['items' => $items]);
    }

    public function create(): Response
    {
        return Inertia::render('Backend/Attribute/Create');
    }

    public function store($tenantName, AttributeRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            Attribute::create($data);

            return redirect()->route('backend.attributes.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function edit($tenantName, Attribute $attribute): Response
    {
        return Inertia::render('Backend/Attribute/Edit', ['attribute' => $attribute]);
    }

    public function update(AttributeRequest $request, $tenantName,  Attribute $attribute): RedirectResponse
    {
        try {
            $attribute->update($request->validated());

            return redirect()->route('backend.attributes.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function destroy($tenantName, Attribute $attribute): RedirectResponse
    {
        try {
            $attribute->delete();

            return redirect()->route('backend.attributes.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }
}

