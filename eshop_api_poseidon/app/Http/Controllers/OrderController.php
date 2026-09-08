<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with('products')
            ->get();

        return OrderResource::collection($orders);
    }

    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Non autorisé'
            ], 403);
        }

        $order->load('products');

        return new OrderResource($order);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'products' => ['required', 'array', 'min:1'],

            'products.*.id' => [
                'required',
                'integer',
                'exists:products,id'
            ],

            'products.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],
        ]);

        return DB::transaction(function () use ($request, $validated) {

            $total = 0;

            $productsToAttach = [];

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail($item['id']);

                $quantity = $item['quantity'];

                $price = $product->price;

                $total += $price * $quantity;

                $productsToAttach[$product->id] = [
                    'quantity' => $quantity,
                    'price' => $price,
                ];
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'total' => $total,
            ]);

            $order->products()->attach($productsToAttach);

            $order->load('products');

            return new OrderResource($order);
        });
    }
}