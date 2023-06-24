<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AdminUser;
use App\Models\Category;
use App\Models\Product;
use Inertia\Response;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalProduct = Product::isUser()->count();
        $totalCategory = Category::isUser()->count();

        $data = DB::table('product_views')
                    ->where('user_id', Auth::id())
                    ->selectRaw('DATE(created_at) as date, count(*) as total')
                    ->groupBy('date')
                    ->get();

        $date = $data->pluck('date')->toArray();
        $total = $data->pluck('total')->toArray();

        return Inertia::render('Dashboard', [
            'totalProduct' => $totalProduct,
            'totalCategory' => $totalCategory,
            'date' => $date,
            'total' => $total,
        ]);
    }

    public function admin(): Response
    {

//        $query = DB::table('product_views')
//                    ->selectRaw('DATE(product_views.created_at) as date, count(*) as total, product_views.user_id, users.name')
//                    ->leftJoin('users', 'product_views.user_id', '=', 'users.id')
//                    ->groupBy(['date', 'user_id'])
//                    ->get();
//
//        $data = $query->groupBy('user_id')->toArray();

        $data = DB::table('product_views')
                    ->selectRaw('product_views.user_id, count(*) as total, users.name, tenants.domain')
                    ->leftJoin('users', 'product_views.user_id', '=', 'users.id')
                    ->leftJoin('tenants', 'users.tenant_id', '=', 'tenants.id')
                    ->groupBy('user_id')
                    ->get();

        $client = $data->pluck('domain')->toArray();
        $total = $data->pluck('total')->toArray();

        $totalCategory = Category::count();
        $totalProduct = Product::count();
        $totalAdmin = AdminUser::count();
        $totalClient = User::count();

        return Inertia::render('Backend/Admin/Dashboard', [
            'totalCategory' => $totalCategory,
            'totalProduct' => $totalProduct,
            'totalAdmin' => $totalAdmin,
            'totalClient' => $totalClient,
            'client' => $client,
            'total' => $total,
        ]);
    }
}

