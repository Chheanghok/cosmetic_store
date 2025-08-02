<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        // Get the cart from the session, or an empty array if it doesn't exist
        $cart = session()->get('cart', []);

        // Check if the product is already in the cart
        if (isset($cart[$product->id])) {
            // If yes, increment the quantity
            $cart[$product->id]['quantity']++;
        } else {
            // If no, add it to the cart
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image_path" => $product->images->first()?->image_path
            ];
        }

        // Put the updated cart back into the session
        session()->put('cart', $cart);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $coupon = session()->get('coupon', null);

        $subtotal = 0;
        foreach ($cart as $details) {
            $subtotal += $details['price'] * $details['quantity'];
        }

        $discount = 0;
        if ($coupon) {
            if ($coupon['type'] == 'percent') {
                $discount = $subtotal * ($coupon['value'] / 100);
            } else {
                $discount = $coupon['value'];
            }
        }

        $total = $subtotal - $discount;

        return view('cart.index', compact('cart', 'subtotal', 'discount', 'total'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed from cart successfully.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Coupon removed.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);

        $coupon = Coupon::where('code', $request->coupon_code)->first();
        if (!$coupon || ($coupon->expires_at && $coupon->expires_at < now()) || ($coupon->usage_limit && $coupon->times_used >= $coupon->usage_limit)) {
            return redirect()->back()->with('error', 'Invalid or expired coupon code.');
        }

        // If valid, store in session
        session()->put('coupon', ['code' => $coupon->code, 'type' => $coupon->type, 'value' => $coupon->value]);

        // Return a success response with new totals
        return redirect()->back()->with('success', 'Coupon applied successfully!');
    }
}