<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function create()
    {
        // If the cart is empty, redirect to the shop page
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.index');
    }

    public function store(Request $request)
    {
        // Redirect if cart is empty
        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        // Recalculate total including discount
        $subtotal = 0;
        foreach($cart as $details) {
            $subtotal += $details['price'] * $details['quantity'];
        }

        $discount = 0;
        $coupon = session()->get('coupon');
        if($coupon) {
            if ($coupon['type'] == 'percent') {
                $discount = $subtotal * ($coupon['value'] / 100);
            } else {
                $discount = $coupon['value'];
            }
        }
        $total = $subtotal - $discount;

        // Create the Order with the final total
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
            'total' => $total, // Use the calculated final total
        ]);

        // Calculate the total price
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // Create the Order
        $order = Order::create([
            'user_id' => Auth::id(), // null if guest
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
            'total' => $total,
        ]);

        // Create the Order Items
        foreach ($cart as $id => $details) {
            $order->items()->create([
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        // Increment coupon usage count if one was used
        if ($coupon) {
            $couponToUpdate = Coupon::where('code', $coupon['code'])->first();
            if ($couponToUpdate) {
                $couponToUpdate->increment('times_used');
            }
        }

        // Clear the cart from the session
        session()->forget(['cart', 'coupon']);

        try {
            $token = env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');

            // Format the message
            $message = "\n*New Order Received!*\n\n";
            $message .= "*Order ID:* `" . $order->id . "`\n";
            $message .= "*Customer:* " . $order->customer_name . "\n";
            $message .= "*Shipping Address:* " . $order->shipping_address . "\n";
            $message .= "*Total:* $" . number_format($order->total, 2) . "\n\n";
            $message .= "*Items:*\n";
            foreach($order->items as $item) {
                $message .= "- " . $item->product->name . " (Qty: " . $item->quantity . ")\n";
            }

            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $e) {
            // If Telegram fails, the user still sees the success page.
            // You can log the error here if needed: \Log::error($e->getMessage());
        }

        return redirect()->route('shop.index')->with('success', 'Your order has been placed successfully!');
    }
}