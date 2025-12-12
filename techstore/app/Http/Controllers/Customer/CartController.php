<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('frontend.cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:sanpham,id',
            'variant_id' => 'required|exists:bien_the,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        $key = $request->product_id . '_' . $request->variant_id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'name' => $request->product_name ?? 'Sản phẩm',
                'price' => $request->price ?? 0,
                'quantity' => $request->quantity,
                'image' => $request->image ?? '',
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request, $key)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật giỏ hàng!');
    }

    public function remove($key)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function clear()
    {
        session(['cart' => []]);
        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}

