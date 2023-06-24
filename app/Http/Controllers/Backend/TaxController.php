<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TaxRequest;
use App\Enums\AppEnum;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Tax;

class TaxController extends Controller
{
    public function index(): Response
    {
        $items = Tax::latest()->isUser()->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Tax/Index', ['items' => $items]);
    }

    public function create(): Response
    {
        return Inertia::render('Backend/Tax/Create');
    }

    public function store($tenantName, TaxRequest $request): RedirectResponse
    {
        try {
            $data = $request->all();
            $data['user_id'] = Auth::id();

            Tax::create($data);

            return redirect()->route('backend.taxes.index', $tenantName);
        } catch(\Exception $e) {
            Log::error($e);

           return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function edit($tenantName, Tax $tax): Response
    {
        return Inertia::render('Backend/Tax/Edit', ['tax' => $tax]);
    }

    public function update(TaxRequest $request, $tenantName, Tax $tax): RedirectResponse
    {
        try {
            $tax->update($request->all());

            return redirect()->route('backend.taxes.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function destroy($tenantName, Tax $tax): RedirectResponse
    {
        try {
            $tax->delete();

            return redirect()->route('backend.taxes.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }
}

