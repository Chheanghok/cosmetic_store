<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with the base query to get products with their related images and category
        $query = Product::with(['images', 'category'])->latest();

        // Check if a search term was provided
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Check if a category filter was applied
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Paginate the results
        $products = $query->paginate(10); // Show 10 products per page

        // Get all categories to populate the filter dropdown
        $categories = Category::all();

        // Return the view with the products and categories
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Prepare the data for the product
        $productData = Arr::except($validated, ['images']);
        $productData['slug'] = Str::slug($validated['name']);
        $productData['is_featured'] = $request->has('is_featured');

        // 2. Create the product
        $product = Product::create($productData);

        // 3. Handle the multiple file upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imagePath = $imageFile->store('products', 'public');
                $product->images()->create(['image_path' => $imagePath]);
            }
        }

        // 4. Redirect with a success message
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validate the request and get the data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_images' => 'nullable|array',
        ]);

        // 2. Handle image deletion first
        if ($request->has('delete_images')) {
            $imagesToDelete = ProductImage::where('product_id', $product->id)
                                        ->whereIn('id', $request->delete_images)
                                        ->get();

            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        // Prepare the data for updating the product
        $productData = Arr::except($validated, ['images', 'delete_images']);
        $productData['slug'] = Str::slug($validated['name']);
        $productData['is_featured'] = $request->has('is_featured');
        
        // 3. Update the product
        $product->update($productData);

        // 4. Handle adding new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imagePath = $imageFile->store('products', 'public');
                $product->images()->create(['image_path' => $imagePath]);
            }
        }

        // 5. Redirect with a success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 1. Delete all associated image files from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // 2. Delete the product from the database
        // (The database will automatically delete the image records because of onDelete('cascade'))
        $product->delete();

        // 3. Redirect with a success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
