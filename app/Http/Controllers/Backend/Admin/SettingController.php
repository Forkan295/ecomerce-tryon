<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Requests\Admin\StoreDetailsRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Country;
use App\Models\Setting;
use App\Enums\AppEnum;
use Inertia\Response;
use App\Models\User;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $items = Setting::with('user')->latest()->paginate(AppEnum::PAGINATION);

        if (! blank($items)) {
            $items->map(function ($item) {
                $item->logo = data_get($item, 'logo');

                return $item;
            });

        }

        return Inertia::render('Backend/Admin/Settings/StoreDetails/Index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $users = $this->getUsers();
        $countries = $this->getCountries();

        return Inertia::render('Backend/Admin/Settings/StoreDetails/Create', [
                    'users' => $users,
                    'countries' => $countries,
                ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetailsRequest $request): RedirectResponse
    {
        try {
            $item = Setting::create($request->all());

            if ($request->hasFile('logo')) {
                $item->addMediaFromRequest('logo')->toMediaCollection('logo');
            }

            return redirect()->route('admin.store-detail.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting): Response
    {
        $users = $this->getUsers();
        $countries = $this->getCountries();

        $setting->country_id = data_get($setting, 'country_id') ? (int)data_get($setting, 'country_id') : '';
        $setting->user_id = (int)data_get($setting, 'user_id');

        return Inertia::render('Backend/Admin/Settings/StoreDetails/Edit', [
                    'setting' => $setting,
                    'users' => $users,
                    'countries' => $countries,
                ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDetailsRequest $request, Setting $setting): RedirectResponse
    {
        try {
            $data = $request->except('logo');

            $setting->update($data);

            if ($request->hasFile('logo')) {
                $setting->clearMediaCollection('logo');

                $setting->addMediaFromRequest('logo')->toMediaCollection('logo');
            }

            return redirect()->route('admin.store-detail.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting): RedirectResponse
    {
        try {
            $setting->delete();
        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect()->route('admin.store-detail.index');
    }

    private function getUsers()
    {
        return User::active()->select(['name', 'id'])->get()->toArray();
    }

    private function getCountries()
    {
        return Country::active()->select(['name', 'id'])->get()->toArray();
    }
}
