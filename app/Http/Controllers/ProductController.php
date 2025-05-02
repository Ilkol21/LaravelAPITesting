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

        // Фильтрация по категории
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Фильтрация по диапазону цен
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Сортировка по популярности всегда
        $query->orderBy('popularity', 'desc');

        // Подгружаем комментарии (если нужно)
        $query->with('comments.user');

        // Получаем отфильтрованные товары с пагинацией
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

        // Получаем валидированные данные из запроса
        $data = $request->validated();

        // Если изображение передано, сохраняем его
        if ($request->hasFile('image')) {
            // Сохраняем изображение в папку 'products' в публичном хранилище
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Если category_id не передано, возвращаем ошибку
        if (!$request->has('category_id')) {
            return response()->json(['message' => 'Category ID is required'], 400);
        }

        // Создаем новый продукт
        $product = Product::create($data);

        // Возвращаем результат в виде ресурса
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
