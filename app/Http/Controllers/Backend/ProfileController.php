<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Enums\AppEnum;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $user = $this->transformUser($user);
        $roles = Role::all();
        $user->domain = data_get($user, 'tenant.domain');

        return Inertia::render('Backend/Profile/Index', ['user' => $user, 'roles' => $roles]);
    }

    public function update(ProfileRequest $request, $tenantName, User $user)
    {
        DB::beginTransaction();

        try {
            $password = data_get($request, 'password');

            $data = $request->except(['domain', 'password']);

            if (! blank($password)) {
                $data['password'] = Hash::make($password);
            }

            if ($user->update($data)) {
                $user->roles()->sync($request->get('roles'));
                $user->permissions()->sync($request->permissions);
            }

            DB::commit();

            return redirect()->route('backend.profile.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();

            return back()->withErrors(AppEnum::ERROR);
        }
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
