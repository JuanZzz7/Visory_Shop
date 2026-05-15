<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Order, OrderDetail, User, Company, Product};

class ReportController extends Controller
{
    public function index()
    {
        $totalRevenue   = Order::sum('total');
        $totalOrders    = Order::count();
        $topProducts    = OrderDetail::selectRaw('product_id, SUM(quantity) as total_sold, SUM(subtotal) as revenue')
                            ->groupBy('product_id')->orderByDesc('total_sold')
                            ->with('product')->take(10)->get();
        $topCompanies   = Company::withCount('products')->orderByDesc('products_count')->take(5)->get();
        $recentOrders   = Order::with(['user', 'details.product'])->latest()->take(10)->get();

        return view('admin.reports.index', compact(
            'totalRevenue', 'totalOrders', 'topProducts', 'topCompanies', 'recentOrders'
        ));
    }
}
