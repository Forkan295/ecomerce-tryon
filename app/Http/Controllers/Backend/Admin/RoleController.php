<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Requests\Admin\RoleRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Permission;
use App\Enums\AppEnum;
use Inertia\Response;
use App\Models\Role;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index(): Response
    {
        $roles = Role::with('permissions')->latest()->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Admin/Role/Index', [
            'roles' => $roles
        ]);
    }

    public function create(): Response
    {
        $permissions = Permission::active()->get();

        return Inertia::render('Backend/Admin/Role/Create', [
                'permissions' => $permissions
            ]);
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        try {
            $role = Role::create($request->all());

            if ($role) {
                $role->syncPermissions(data_get($request, 'permissions'));
            }

            return redirect()->route('admin.role.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function edit(Role $role): Response
    {
        $permissions = Permission::active()->get();

        $roleData = $this->transformRole($role);

        return Inertia::render('Backend/Admin/Role/Edit', [
            'role'        => $roleData,
            'permissions' => $permissions
        ]);
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        try {
            $data = $request->all();

            if ($role->update($data)) {
                $role->syncPermissions(data_get($request, 'permissions'));
            }

            return redirect()->route('admin.role.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function destroy(Role $role): RedirectResponse
    {
        try {
            $role->delete();

            return redirect()->route('admin.role.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    private function transformRole(Role $role)
    {
        return [
            'id'           => data_get($role, 'id'),
            'display_name' => data_get($role, 'display_name'),
            'name'         => data_get($role, 'name'),
            'description'  => data_get($role, 'description'),
            'permissions'  => $role->permissions()->pluck('id'),
            'status'       => data_get($role, 'status'),
        ];
    }
}
