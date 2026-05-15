<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private function company()
    {
        return Auth::user()->company;
    }

    public function index()
    {
        $company  = $this->company();
        $products = $company ? $company->products()->latest()->paginate(15) : collect();
        return view('business.products.index', compact('products', 'company'));
    }

    public function create()
    {
        return view('business.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'active'      => 'nullable|boolean',
            'featured'    => 'nullable|boolean',
        ]);

        $company = $this->company();
        if (!$company) {
            return redirect()->route('business.company.edit')->with('error', 'Debes crear tu empresa primero.');
        }

        $data = $request->except(['image', '_token']);
        $data['active']   = $request->boolean('active', true);
        $data['featured'] = $request->boolean('featured', false);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $company->products()->create($data);
        return redirect()->route('business.products.index')->with('success', 'Producto creado.');
    }

    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        return view('business.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['image', '_token', '_method']);
        $data['active']   = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('business.products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);
        $product->delete();
        return redirect()->route('business.products.index')->with('success', 'Producto eliminado.');
    }

    private function authorizeProduct(Product $product)
    {
        $company = $this->company();
        if (!$company || $product->company_id !== $company->id) {
            abort(403);
        }
    }
}
