<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Resources\OrderItemResource;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderitems = OrderItem::with(['orders','products'])->get();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderItem)
    {
        return new OrderItemResource($orderItem->loadMissing(['orders','products']))->response();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
