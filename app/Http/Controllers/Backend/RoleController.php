<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    public function index(): Response
    {
        $roles = Role::with('permissions')->paginate(10);
        return Inertia::render('Backend/Role/Index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = Permission::whereStatus(1)->get();
        return Inertia::render('Backend/Role/Create',
            [
                'permissions' => $permissions
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name' => ['required', 'string', 'unique:roles,display_name'],
            'name'         => ['required', 'string'],
            'permissions'  => ['required', 'array']
        ]);

        $role = Role::create($request->all());
        if ($role) {
            $role->permissions()->attach($request->permissions);
        }

        return redirect()->route('backend.role.index');

    }

    public function edit(Role $role)
    {
        $permissions = Permission::whereStatus(1)->get();
        $roleData    = $this->transformRole($role);
        return Inertia::render('Backend/Role/Edit', [
            'role'        => $roleData,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'display_name' => ['required', 'string', Rule::unique('roles')->ignore($role->id)],
            'name'         => ['required', 'string'],
            'permissions'  => ['required', 'array']
        ]);

        if ($role->update($request->all())) {
            $role->syncPermissions($request->permissions);
        }
        return redirect()->route('backend.role.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
    }

    private function transformRole(Role $role)
    {
        return [
            'id'           => data_get($role, 'id'),
            'display_name' => data_get($role, 'display_name'),
            'name'         => data_get($role, 'name'),
            'description'  => data_get($role, 'description'),
            'permissions'  => $role->permissions()->pluck('id'),
        ];
    }

}
