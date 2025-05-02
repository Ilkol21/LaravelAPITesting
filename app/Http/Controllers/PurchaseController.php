<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(PurchaseRequest $request)
    {
        $user = $request->user();

        DB::beginTransaction();

        try {
            $total = 0;
            $items = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                ];
            }

            $purchase = Purchase::create([
                'user_id' => $user->id,
                'total' => $total,
            ]);

            $purchase->items()->createMany($items);

            DB::commit();

            return response()->json([
                'message' => 'Покупка оформлена',
                'purchase_id' => $purchase->id
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ошибка при оформлении заказа'], 500);
        }
    }
}
