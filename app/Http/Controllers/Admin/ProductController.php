<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('company')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function toggleActive(Product $product)
    {
        $product->update(['active' => !$product->active]);
        return back()->with('success', 'Estado del producto actualizado.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado.');
    }
}
