<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreDetailsRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Country;
use App\Models\Setting;
use App\Enums\AppEnum;
use Inertia\Response;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $countries = Country::active()->select(['name', 'id'])->get()->toArray();

        $setting = Setting::isUser()->first();

        if (! blank($setting)) {
            $setting->country_id = data_get($setting, 'country_id') ? (int)data_get($setting, 'country_id') : '';
        }

        return Inertia::render('Backend/Settings/StoreDetails/Show', [
            'setting' => $setting,
            'countries' => $countries,
        ]);
    }

    public function update($tenantName, StoreDetailsRequest $request): RedirectResponse
    {
        try {
            $data = $request->except('logo');

            $setting = Setting::updateOrCreate(['user_id' => auth()->id()], $data);

            if ($request->hasFile('logo')) {
                $setting->clearMediaCollection('logo');

                $setting->addMediaFromRequest('logo')->toMediaCollection('logo');
            }

            return back();
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }
}
