<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\GroupSettingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use App\Enums\AppEnum;
use Inertia\Inertia;

class GroupSettingController extends Controller
{
    private array $inputTypes = [
        [
            'label' => 'Text',
            'name' => 'text',
        ],
        [
            'label' => 'Image',
            'name' => 'image',
        ],
//        [
//            'label' => 'Select',
//            'name' => 'select',
//        ],
        [
            'label' => 'Textarea',
            'name' => 'textarea',
        ]
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $items = SiteSetting::whereNull('parent_id')->latest()->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Settings/Group/Index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Backend/Settings/Group/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupSettingRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->all();
            $data['slug'] = Str::slug(data_get($request, 'title'));
            $data['saved_by'] = Auth::id();

            SiteSetting::create($data);

            return redirect()->route('backend.groups.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteSetting $group): \Inertia\Response
    {
        return Inertia::render('Backend/Settings/Group/Edit', ['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupSettingRequest $request, SiteSetting $group): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->all();
            $data['slug'] = Str::slug(data_get($request, 'title'));
            $data['saved_by'] = Auth::id();

            $group->update($data);

            return redirect()->route('backend.groups.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteSetting $group)
    {
        try {
            $group->children()->delete();
            $group->delete();
        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect()->route('backend.groups.index');
    }

    public function getForm(SiteSetting $group): \Inertia\Response
    {
        $attributes = $this->inputTypes;

        $group = SiteSetting::whereId($group->id)->with('children')->first();

        return Inertia::render('Backend/Settings/Group/Form', [
            'group' => $group,
            'attributes' => $attributes,
        ]);
    }

    public function storeForm(Request $request, SiteSetting $group): \Illuminate\Http\RedirectResponse
    {
        try {
            $items = data_get($request, 'fieldRows');

            $childOldIds = $group->children()->pluck('id')->toArray();

            if (! blank($items)) {
                collect($items)->map(function ($item) use ($group) {
                    $group->children()->updateOrCreate(
                        ['id' => data_get($item, 'id')],
                        [
                            'title' => data_get($item, 'title'),
                            'slug' => Str::slug(data_get($item, 'title')),
                            'input_type' => data_get($item, 'input_type'),
                            'order' => data_get($item, 'order'),
                            'status' => data_get($item, 'status'),
                            'saved_by' => Auth::id(),
                        ],
                    );
                });
            }

            $childNewIds = array_column($items, 'id');

            $childDeletedIds = array_diff($childOldIds, $childNewIds);

            if (! blank($childDeletedIds)) {
                $group->destroy($childDeletedIds);
            }

            return redirect()->route('backend.groups.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }
}
