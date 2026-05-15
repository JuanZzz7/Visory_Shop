<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Company, Product, Order};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'      => User::where('role', 'user')->count(),
            'businesses' => User::where('role', 'business')->count(),
            'companies'  => Company::count(),
            'products'   => Product::count(),
            'orders'     => Order::count(),
            'revenue'    => Order::sum('total'),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
