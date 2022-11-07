<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Shop;

class ShopController extends Controller
{
    public function __construct()
    {}

    public function index()
    {
        $shops = Shop::with('products', 'orders')->get();
        return ShopResource::collection($shops);
    }

    public function store(Request $request){
        $shop = new Shop();
        $shop->name = $request->get('name');
        $shop->description = $request->get('description');
        $shop->user_id = $request->get('user_id');

        if ($shop->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Shop created with id '.$shop->id,
                'shop_id' => $shop->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Shop creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function show(Shop $shop)
    {
        return (new ShopResource($shop->loadMissing(['products','orders'])))->response();
    }

    public function update(Request $request, Shop $shop)
    {
        if ($request->has('name')) $shop->name = $request->get('name');
        if ($request->has('description')) $shop->description = $request->get('description');
        if ($request->has('image_path')) $shop->image_path = $request->get('image_path');

        if ($shop->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Shop updated with id '.$shop->id,
                'shop_id' => $shop->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Shop update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Shop $shop)
    {
        $name = $shop->name;
        if ($shop->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Shop {$name} has deleted",
                'shop_id' => $shop->id
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Shop {$name} delete failed",
            'shop_id' => $shop->id
        ], Response::HTTP_BAD_REQUEST);
    }

    public function search(Request $request) {
        $q = $request->query('q'); // เป็นตัวบอกตัวแปลที่ส่งเข้ามา ซึ่งจะต้องมี ? ก่อนแล้วค่อยชื่อตัวแปล ขั้นด้วย & เช่น
        // ?q=word&sort=DESC
        // $sort_variable = $request->query('sort') ?? 'asc';
        $shops = Shop::get();
        return $shops;
    }
}
