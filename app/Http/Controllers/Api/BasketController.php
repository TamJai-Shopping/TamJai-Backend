<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Shop;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Http\Resources\BasketResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $baskets = Basket::with('basketItems')->get();
        return BasketResource::collection($baskets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $basket = new Basket();
        $basket->user_id= $request->get('user_id');
        $basket->selectShop = $request->get('selectShop');
        $basket->total_price = $request->get('total_price');

        if ($basket->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Basket created with id '.$basket->id,
                'basket_id' => $basket->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Basket creation failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function show(Basket $basket)
    {
        return (new BasketResource($basket->loadMissing(['basketItems'])))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Basket $basket)
    {
        if($request->has('selectShop'))$basket->selectShop = $request->get('selectShop');
        if($request->has('user_id'))$basket->user_id= $request->get('user_id');
        if($request->has('total_price'))$basket->total_price= $request->get('total_price');
        if ($basket->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Basket updated with id '.$basket->id,
                'basket_id' => $basket->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Basket update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Basket $basket)
    {
        $id = $basket->id;
        if($basket->delete()){
            return response()->json([
                'success' => true,
                'message' => "Basket id{$id} with deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Basket id{$id} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }

    public function search(Request $request) {
        $q = $request->query('q'); // เป็นตัวบอกตัวแปลที่ส่งเข้ามา ซึ่งจะต้องมี ? ก่อนแล้วค่อยชื่อตัวแปล ขั้นด้วย & เช่น
        // ?q=word&sort=DESC
        // $sort_variable = $request->query('sort') ?? 'asc';
        $baskets = Basket::where('id', 'LIKE', "%{$q}%")
                         ->get();
        return $baskets;
    }

    public function totalPrice(Request $request){
        // $user_id = $request->get('user_id');
        $user_id = 1;
        $basket = Basket::where('user_id', $user_id)->get();
        $basketItems = BasketItem::where('basket_id', $basket->id)->where('shop_id', $basket->selectShop)->get();
        foreach($basketItems->quantity as $quantity){
            $basket->product_id =
            $basket->total_price = $basket->total_price + $quantity;
        }
        if($request->has('selectShop'))$basket->selectShop = $request->get('selectShop');
        if($request->has('user_id'))$basket->user_id= $request->get('user_id');

        if ($basket->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Basket updated with id '.$basket->id,
                'basket_id' => $basket->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Basket update failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    public function createOrder(Request $request){
        $user_id = 1;
        $basket = Basket::where('id', $user_id)->get();
        // $basket = Basket::find(1);
        $basketItems = BasketItem::where('basket_id', $basket->id)->where('shop_id', $basket->selectShop)->get();
        $order = new Order();

        $order->status = "statusTest";
        $order->total_price = $basket->total_price;
        $order->package_number = "PACTEST";
        $order->location = "LOCATIONTEST";
        $order->shop_id = $basket->selectShop;
        $order->user_id = $user_id;
        if ($order->save()) {
            return response()->json([
                'success' => true,
                'message' => 'order created with id '.$order->id,
                'order_id' => $order->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'orderItem creation failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    public function createOrderItem(Request $request){
        $user_id = 1;
        $basket = Basket::where('id', $user_id)->get();
        // $basket = Basket::find(1);
        $basketItems = BasketItem::where('basket_id', $basket->id)->where('shop_id', $basket->selectShop)->get();

        $orderItemArray = [];
        foreach($basketItems as $basketItem){
            $orderItem = new OrderItem();
            $orderItem->order_id = 22;
            $orderItem->product_id = $basketItem->product_id;
            $orderItem->quantity = $basketItem->quantity;
            $orderItem->save();
            $orderItemArray = $orderItem;
        }
        if ($orderItemArray) {
            return response()->json([
                'success' => true,
                'message' => 'orderItem created '
                // 'orderItem_id' => $orderItem->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'orderItem creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function initBasket(Request $request){
        $user_id = $request->get('user_id');
        $basket = Basket::where('user_id', $user_id)->first();
        if(!$basket){
            $this->store($request);
        }
    }
}
