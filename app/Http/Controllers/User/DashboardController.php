<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Company, Product};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query     = $request->get('q');
        $category  = $request->get('category');
        $companyId = $request->get('company_id');

        $products = Product::where('active', true)
            ->with('company')
            ->when($query, fn($q) => $q->where('name', 'like', "%$query%"))
            ->when($category, fn($q) => $q->whereHas('company', fn($c) => $c->where('category', $category)))
            ->when($companyId, fn($q) => $q->where('company_id', $companyId))
            ->latest()->paginate(12);

        $companies  = Company::where('status', 'active')->get();
        $categories = Company::where('status', 'active')->distinct()->pluck('category')->filter();

        return view('user.dashboard', compact('products', 'companies', 'categories'));
    }

    public function map(Request $request)
    {
        $companies = Company::where('status', 'active')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('user.map', compact('companies'));
    }
}
