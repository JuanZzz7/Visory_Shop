<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\{Expense, OrderDetail};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        $income  = 0;
        $expenses = 0;
        $sales = [];

        if ($company) {
            $productIds = $company->products->pluck('id');
            $income = OrderDetail::whereIn('product_id', $productIds)->sum('subtotal');
            $expenses = Expense::where('company_id', $company->id)->sum('amount');
            $sales = OrderDetail::whereIn('product_id', $productIds)
                ->with(['product', 'order.user'])->latest()->take(10)->get();
        }

        $net = $income - $expenses;
        return view('business.dashboard', compact('company', 'income', 'expenses', 'net', 'sales'));
    }
}
