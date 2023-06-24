<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['permission','parent'])->paginate(10);
        return Inertia::render('Backend/Menu/Index', [
            'menus' => $menus
        ]);

//        $roles = Role::with('permissions')->paginate(10);
//        return Inertia::render('Backend/Role/Index', [
//            'roles' => $roles
//        ]);
    }
}
