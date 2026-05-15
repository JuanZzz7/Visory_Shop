<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;

class PublicController extends Controller
{
    /**
     * Página pública de una empresa con todos sus productos activos.
     * Accesible sin autenticación.
     */
    public function company(Company $company)
    {
        // Solo mostrar empresas activas
        abort_if($company->status !== 'active', 404);

        $products = Product::where('company_id', $company->id)
            ->where('active', true)
            ->latest()
            ->paginate(12);

        return view('public.company', compact('company', 'products'));
    }

    /**
     * API: datos rápidos de empresa para el tooltip hover (JSON).
     */
    public function companyTooltip(Company $company)
    {
        abort_if($company->status !== 'active', 404);

        return response()->json([
            'name'        => $company->name,
            'category'    => $company->category,
            'description' => $company->description,
            'phone'       => $company->phone,
            'email'       => $company->email,
            'address'     => $company->address,
            'instagram'   => $company->instagram,
            'facebook'    => $company->facebook,
            'website'     => $company->website,
            'logo'        => $company->logo ? asset('storage/' . $company->logo) : null,
            'products_count' => Product::where('company_id', $company->id)->where('active', true)->count(),
        ]);
    }
}
