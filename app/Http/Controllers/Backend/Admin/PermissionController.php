<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Permission;
use App\Enums\AppEnum;
use Inertia\Response;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function index(): Response
    {
        $permissions = Permission::with('parent')->latest()->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Admin/Permission/Index', [
                    'permissions' => $permissions
                ]);
    }

    public function create(): Response
    {
        $parents = $this->getPatents();

        return Inertia::render('Backend/Admin/Permission/Create', [
                    'parents' => $parents
                ]);
    }

    public function store(PermissionRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            Permission::create($request->all());

            return redirect()->route('admin.permission.index');

        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function edit(Permission $permission): Response
    {
        $parents = $this->getPatents($permission->id);

        return Inertia::render('Backend/Admin/Permission/Edit', [
            'permission' => $permission,
            'parents'    => $parents
        ]);
    }

    public function update(PermissionRequest $request, Permission $permission): \Illuminate\Http\RedirectResponse
    {
        try {
            $permission->update($request->all());

            return redirect()->route('admin.permission.index');

        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function destroy(Permission $permission): \Illuminate\Http\RedirectResponse
    {
        try {
            $permission->delete();

            return redirect()->route('admin.permission.index');

        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    private function getPatents($id = null)
    {
        return Permission::active()->where('id','!=',$id)->get();
    }
}
