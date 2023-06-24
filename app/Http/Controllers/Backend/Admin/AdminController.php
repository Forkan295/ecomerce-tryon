<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Requests\Admin\AdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\AdminUser;
use App\Enums\AppEnum;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(): \Inertia\Response
    {
        $items = AdminUser::latest()->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Admin/User/Index', ['items' => $items]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Backend/Admin/User/Create');
    }

    public function store(AdminRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->all();
            $data['password'] = bcrypt(data_get($request, 'password'));

            AdminUser::create($data);

            return redirect()->route('admin.admins.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function edit($id): \Inertia\Response
    {
        $adminUser = AdminUser::find($id);

        return Inertia::render('Backend/Admin/User/Edit', ['user' => $adminUser]);
    }

    public function update(AdminRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        try {
            $adminUser = AdminUser::find($id);

            $adminUser->update($request->all());

            return redirect()->route('admin.admins.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $adminUser = AdminUser::find($id);
            $adminUser->delete();

            return redirect()->route('admin.admins.index');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }
}

