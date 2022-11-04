<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shop;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('orderItems')->get();
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->status = $request->get('status');
        $order->total_price = $request->get('total_price');
        $order->package_number = $request->get('package_number') ?? null;
        $order->location = $request->get('location');
        $order->shop_id= $request->get('shop_id');
        // $order->shop_id = new Shop();
        // $shop->shop_id = Shop::where('id',$request->get('shop_id'))->first();
        // $order->shop_id = $shop;
        if ($order->save()) {
            // $orderitems = [];
            // $orderallitem = OrderItem::get();
            // foreach($orderallitem as $orderitem){
            //     if($orderitem->order_id == $order->id){
            //         $orderitems[] = $orderitem;
            //     }
            // }
            // $order->orderItems()->saveMany($orderitems);
            return response()->json([
                'success' => true,
                'message' => 'Order created with id '.$order->id,
                'order_id' => $order->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Order creation failed'
        ], Response::HTTP_BAD_REQUEST);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return (new OrderResource($order->loadMissing(['orderItems'])))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if($request->has('status'))$order->status = $request->get('status');
        if($request->has('total_price'))$order->total_price = $request->get('total_price');
        if($request->has('package_number'))$order->package_number = $request->get('package_number');
        if($request->has('location'))$order->location = $request->get('location');
        if($request->has('shop_id'))$order->shop_id= $request->get('shop_id');
        if ($order->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Order updated with id '.$order->id,
                'order_id' => $order->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Order update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $id = $order->id;
        if($order->delete()){
            return respone()->json([
                'success' => true,
                'message' => "Order id{$id} with deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Order id{$id} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }

    public function search(Request $request) {
        $q = $request->query('q'); // เป็นตัวบอกตัวแปลที่ส่งเข้ามา ซึ่งจะต้องมี ? ก่อนแล้วค่อยชื่อตัวแปล ขั้นด้วย & เช่น
        // ?q=word&sort=DESC
        // $sort_variable = $request->query('sort') ?? 'asc';
        $orders = Order::where('id', 'LIKE', "%{$q}%")
                         ->get();
        return $orders;
    }
}
