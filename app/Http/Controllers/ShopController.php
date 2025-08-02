<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Start with the base query
        $query = Product::with(['images', 'category']);

        // Check for a search term
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Check for a category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Get the paginated products
        $products = $query->latest()->paginate(12);

        // Get all categories for the filter dropdown
        $categories = Category::all();

        // Return the view with all necessary data
        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        // Eager load the images and category for the single product
        $product->load(['images', 'category']);

        return view('shop.show', compact('product'));
    }

    public function home()
    {
        $featuredProducts = Product::with('images')->where('is_featured', true)->latest()->take(4)->get();
        $newArrivals = Product::with('images')->latest()->take(8)->get();

        return view('home', compact('featuredProducts', 'newArrivals'));
    }

    public function contact()
    {
        return view('shop.contact');
    }

    public function handleContactForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Here you could add logic to send an email in a real application
        // Mail::to('your-email@example.com')->send(new ContactFormMail($request->all()));

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}