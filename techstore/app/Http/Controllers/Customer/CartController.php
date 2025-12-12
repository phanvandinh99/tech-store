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

        // Get variant info
        $variant = \App\Models\BienThe::with('sanPham')->findOrFail($request->variant_id);
        
        // Check stock
        if ($variant->so_luong_ton < $request->quantity) {
            return back()->withErrors(['quantity' => 'Số lượng sản phẩm không đủ trong kho.'])->withInput();
        }

        $cart = session('cart', []);
        $key = $request->product_id . '_' . $request->variant_id;

        if (isset($cart[$key])) {
            $newQuantity = $cart[$key]['quantity'] + $request->quantity;
            if ($newQuantity > $variant->so_luong_ton) {
                return back()->withErrors(['quantity' => 'Số lượng sản phẩm không đủ trong kho.'])->withInput();
            }
            $cart[$key]['quantity'] = $newQuantity;
        } else {
            $primaryImage = $variant->sanPham->anhSanPhams->where('la_anh_chinh', true)->first() 
                         ?? $variant->sanPham->anhSanPhams->first();
            $imageUrl = $primaryImage ? asset('storage/' . $primaryImage->url) : asset('assets/img/product/product1.jpg');
            
            $cart[$key] = [
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'name' => $request->product_name ?? $variant->sanPham->ten,
                'price' => $request->price ?? $variant->gia,
                'quantity' => $request->quantity,
                'image' => $request->image ?? $imageUrl,
            ];
        }

        session(['cart' => $cart]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        
        if (isset($cart[$key])) {
            // Check stock
            $variant = \App\Models\BienThe::findOrFail($cart[$key]['variant_id']);
            if ($variant->so_luong_ton < $request->quantity) {
                return back()->withErrors(['quantity' => 'Số lượng sản phẩm không đủ trong kho.'])->withInput();
            }
            
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

