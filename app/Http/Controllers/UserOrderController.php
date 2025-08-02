<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Abort if the authenticated user is not the owner of the order
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        // Eager load the related items and their product details
        $order->load('items.product.images');

        return view('orders.show', compact('order'));
    }
}