<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter with price
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Filter popularity
        $query->orderBy('popularity', 'desc');

        // Load comments
        $query->with('comments.user');

        // Filtered data
        $products = $query->paginate(5);

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $product->load('comments.user');
        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {


        $data = $request->validated();

        // If the image has been transferred, save it
        if ($request->hasFile('image')) {
            // Сохраняем изображение в папку 'products' в публичном хранилище
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // If category_id is not passed, we return an error
        if (!$request->has('category_id')) {
            return response()->json(['message' => 'Category ID is required'], 400);
        }

        $product = Product::create($data);

        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
