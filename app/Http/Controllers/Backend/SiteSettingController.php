<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Inertia\Inertia;

class SiteSettingController extends Controller
{
    public function getSetting($slug = null): \Inertia\Response
    {
        $setting = SiteSetting::query();

        if ($slug) {
            $setting = $setting->whereNull('parent_id')->where('slug', $slug)->first();
        }

        $items = SiteSetting::where('parent_id', data_get($setting, 'id'))
                    ->active()
                    ->select([
                        'id as id',
                        'title as title',
                        'slug',
                        'input_type',
                        'input_options',
                        'setting_value'
                    ])
                    ->orderBy('order')
                    ->get();

        $groups = SiteSetting::active()
                    ->whereNull('parent_id')
                    ->orderByDesc('order')
                    ->get();

        return Inertia::render('Backend/Settings/General/Index', [
                    'groups' => $groups,
                    'setting' => $setting,
                    'items' => $items ?? [],
                ]);
    }

    public function storeSetting(Request $request, SiteSetting $settingGroup)
    {
        dd($request->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
//        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
