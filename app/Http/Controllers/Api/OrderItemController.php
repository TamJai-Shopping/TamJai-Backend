<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Resources\OrderItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderitems = OrderItem::with(['order','product'])->get();
        return OrderItemResource::collection($orderitems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderItem = new OrderItem();
        $orderItem->order_id = $request->get('order_id');
        $orderItem->product_id = $request->get('product_id');
        $orderItem->quantity = $request->get('quantity');

        if ($orderItem->save()) {
            return response()->json([
                'success' => true,
                'message' => 'orderItem created with id '.$orderItem->id,
                'orderItem_id' => $orderItem->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'orderItem creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderItem)
    {
        return new OrderItemResource($orderItem->loadMissing(['orders','products']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        if ($request->has('product_id')) $orderItem->product_id = $request->get('product_id');
        if ($request->has('order_id')) $orderItem->order_id = $request->get('order_id');
        if ($request->has('quantity')) $orderItem->quantity = $request->get('quantity');

        if ($orderItem->save()) {
            return response()->json([
                'success' => true,
                'message' => 'orderItem updated with id '.$orderItem->id,
                'orderItem_id' => $orderItem->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'orderItem update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)
    {
        $id = $orderItem->id;
        if ($orderItem->delete()) {
            return response()->json([
                'success' => true,
                'message' => "orderItem {$id} has deleted",
                'orderItem_id' => $orderItem->id
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "orderItem {$id} delete failed",
            'orderItem_id' => $orderItem->id
        ], Response::HTTP_BAD_REQUEST);
    }
}
