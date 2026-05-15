<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Product, Order, OrderDetail};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session('cart', []);
    }

    public function index()
    {
        $cart  = $this->getCart();
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal = $product->price * $qty;
                $total   += $subtotal;
                $items[]  = ['product' => $product, 'quantity' => $qty, 'subtotal' => $subtotal];
            }
        }

        return view('user.cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = $this->getCart();
        $qty  = $request->get('quantity', 1);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;
        session(['cart' => $cart]);
        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function remove(Product $product)
    {
        $cart = $this->getCart();
        unset($cart[$product->id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function update(Request $request, Product $product)
    {
        $cart = $this->getCart();
        $qty  = (int) $request->get('quantity', 1);
        if ($qty <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $qty;
        }
        session(['cart' => $cart]);
        return back();
    }

    public function checkout()
    {
        $cart = $this->getCart();
        if (empty($cart)) return redirect()->route('user.cart.index')->with('error', 'El carrito está vacío.');

        $items = [];
        $total = 0;
        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal = $product->price * $qty;
                $total   += $subtotal;
                $items[]  = ['product' => $product, 'quantity' => $qty, 'subtotal' => $subtotal];
            }
        }

        return view('user.cart.checkout', compact('items', 'total'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'card_name'   => 'required|string',
            'card_number' => 'required|string',
            'exp_date'    => 'required|string',
            'cvv'         => 'required|string|max:4',
            'address'     => 'required|string',
        ]);

        $cart = $this->getCart();
        if (empty($cart)) return redirect()->route('user.cart.index');

        $total = 0;
        $details = [];

        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);
            if ($product && $product->stock >= $qty) {
                $subtotal  = $product->price * $qty;
                $total    += $subtotal;
                $details[] = ['product' => $product, 'quantity' => $qty, 'subtotal' => $subtotal];
                $product->decrement('stock', $qty);
            }
        }

        if (empty($details)) {
            return back()->with('error', 'No se pudo procesar ningún producto (sin stock).');
        }

        // Crear la orden con estado 'paid' (simulando éxito de pasarela)
        $order = Order::create([
            'user_id' => Auth::id(), 
            'total'   => $total, 
            'status'  => 'paid'
        ]);

        foreach ($details as $d) {
            OrderDetail::create([
                'order_id'   => $order->id,
                'product_id' => $d['product']->id,
                'quantity'   => $d['quantity'],
                'unit_price' => $d['product']->price,
                'subtotal'   => $d['subtotal'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('user.orders.index')->with('success', '¡Pago procesado y compra realizada con éxito!');
    }
}
