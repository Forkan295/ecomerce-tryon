<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller
{
    public function index(): Response
    {
        $parmissions = Permission::with('parent')->paginate(10);
//        dd($parmissions);
        return Inertia::render('Backend/Permission/Index', [
            'permissions' => $parmissions
        ]);
    }

    public function create()
    {
        $parents = $this->getPatents();
        return Inertia::render('Backend/Permission/Create', [
            'parents' => $parents
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name' => ['required', 'string', 'unique:permissions,display_name'],
            'name'         => ['required', 'string'],
            'parent_id'    => ['nullable', 'numeric'],
            'status'       => ['required', 'boolean'],
        ]);

        Permission::create($request->all());

        return redirect()->back();

    }

    public function edit(Permission $permission)
    {
        $parents = $this->getPatents($permission->id);

        return Inertia::render('Backend/Permission/Edit', [
            'permission' => $permission,
            'parents'    => $parents
        ]);
    }

    public function update(Request $request, Permission $permission): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'display_name' => ['required', 'string', Rule::unique('permissions')->ignore($permission->id)],
            'name'         => ['required', 'string'],
            'parent_id'    => ['nullable', 'numeric'],
            'status'       => ['required', 'boolean'],
        ]);

        $permission->update($request->all());
        return redirect()->back();
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
    }

    private function getPatents($id = null)
    {
        return Permission::whereStatus(1)->where('id','!=',$id)->get();
    }
}
