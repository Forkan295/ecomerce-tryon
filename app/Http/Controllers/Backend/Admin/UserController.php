<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Enums\AppEnum;
use App\Models\Tenant;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(): \Inertia\Response
    {
        $items = User::latest()->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Admin/Client/Index', ['items' => $items]);
    }

    public function create(): \Inertia\Response
    {
        $roles = Role::all();

        return Inertia::render('Backend/Admin/Client/Create', [
            'roles' => $roles
        ]);
    }

    public function store(UserRequest $request): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();

        try {
            $data             = $request->except(['password', 'domain']);
            $data['password'] = Hash::make(data_get($request, 'password'));

            $user = User::create($data);
            if ($user && !empty($request->roles)) {
                $user->roles()->attach($request->roles);
            }

            if ($user && !empty($request->permissions)) {
                $user->permissions()->attach($request->permissions);
            }

            $tenant = Tenant::create([
                'name'   => data_get($user, 'name'),
                'domain' => data_get($request, 'domain'),
            ]);

            $user->tenants()->attach(['tenant_id' => data_get($tenant, 'id')]);

            $user->update(['tenant_id' => data_get($tenant, 'id')]);

            DB::commit();

            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function edit($id): \Inertia\Response
    {
        $user         = User::with(['permissions'])->whereId($id)->first();
        $user         = $this->transformUser($user);
        $permissions  = $user->permissions()->get()->pluck('id');
        $roles        = Role::all();
        $user->domain = data_get($user, 'tenant.domain');

        return Inertia::render('Backend/Admin/Client/Edit', ['user' => $user, 'roles' => $roles, 'permissions' => $permissions]);
    }

    public function update(UserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();

        try {
            $data = $request->except('domain');

            if ($user->update($data)) {
                $user->roles()->sync($request->get('roles'));
                $user->permissions()->sync($request->permissions);
            }

            $user->tenant()->update([
                'name'   => data_get($user, 'name'),
                'domain' => data_get($request, 'domain'),
            ]);

            DB::commit();

            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {
            $tenantIds = $user->tenants()->pluck('tenant_id')->toArray();

            $user->tenants()->detach($tenantIds);
            $user->tenant()->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function getPermissions()
    {
        return Permission::whereStatus(1)->paginate(10);
    }

    public function checkPermissions(Request $request)
    {
        $checked = auth()->user()->hasPermission($request->data);
//        dd($checked);
        return $checked;

    }

    private function transformUser($user)
    {
        $roles = $user->roles()->get()->map(function ($item) {
            return $item->id;
        });

        $user['roles'] = $roles;
        return $user;
    }
}

