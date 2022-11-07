<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Shop;
use App\Http\Resources\BasketItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BasketItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $basketItems = BasketItem::with(['basket'])->get();
        return BasketItemResource::collection($basketItems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $basketItem = new BasketItem();
        $basketItem->basket_id= $request->get('basket_id');
        $basketItem->product_id= $request->get('product_id');
        $basketItem->shop_id = $request->get('shop_id');
        $basketItem->quantity = $request->get('quantity');

        if ($basketItem->save()) {
            return response()->json([
                'success' => true,
                'message' => 'BasketItem created with id '.$basketItem->id,
                'basket_id' => $basketItem->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'BasketItem creation failed'
        ], Response::HTTP_BAD_REQUEST);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BasketItem  $basketItem
     * @return \Illuminate\Http\Response
     */
    public function show(BasketItem $basketItem)
    {
        return (new BasketItemResource($basketItem->loadMissing('basket')))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BasketItem  $basketItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BasketItem $basketItem)
    {
        if($request->has('quantity'))$basketItem->quantity = $request->get('quantity');
        if($request->has('product_id'))$basketItem->product_id= $request->get('product_id');
        if($request->has('basket_id'))$basketItem->basket_id= $request->get('basket_id');
        if($request->has('shop_id'))$basketItem->shop_id= $request->get('shop_id');
        if ($basketItem->save()) {
            return response()->json([
                'success' => true,
                'message' => 'BasketItem updated with id '.$basketItem->id,
                'basket_id' => $basketItem->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'BasketItem update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BasketItem  $basketItem
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $basket = Basket::find(1);
        $basketItems = BasketItem::where('basket_id', $basket->id)->where('shop_id', $basket->selectShop)->get();
        // $basketItemArray = [];
        // foreach($basketItems as $basketItem){
        //     $basketItemArray = $basketItem->id;
        // }

        if($basketItems->delete()){
            return response()->json([
                'success' => true,
                'message' => "BasketItem deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "BasketItem delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }

    public function search(Request $request) {
        $q = $request->query('q'); // เป็นตัวบอกตัวแปลที่ส่งเข้ามา ซึ่งจะต้องมี ? ก่อนแล้วค่อยชื่อตัวแปล ขั้นด้วย & เช่น
        // ?q=word&sort=DESC
        // $sort_variable = $request->query('sort') ?? 'asc';
        $basketItems = BasketItem::where('id', 'LIKE', "%{$q}%")
                         ->get();
        return $basketItems;
    }

    public function createBasketItem(Request $request){
        $basket = Basket::where('user_id', 3)->first();

        $basketItem = new BasketItem();
        $basketItem->basket_id= $request->get('basket_id');
        $basketItem->product_id= $request->get('product_id');
        $basketItem->shop_id = $request->get('shop_id');
        $basketItem->quantity = $request->get('quantity');

        if ($basketItem->save()) {
            return response()->json([
                'success' => true,
                'message' => 'BasketItem created with id '.$basketItem->id,
                'basket_id' => $basketItem->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'BasketItem creation failed'
        ], Response::HTTP_BAD_REQUEST);
        
    }

    public function deleteManyBasketItem()
    {
        $basket = Basket::find(1);
        $basketItems = BasketItem::where('basket_id', $basket->id)->where('shop_id', $basket->selectShop)->get();
        foreach($basketItems as $basketItem){
            $basketItem->delete();
        }

        if(!$basketItems){
            return response()->json([
                'success' => true,
                'message' => "BasketItem deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "BasketItem delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }
}
