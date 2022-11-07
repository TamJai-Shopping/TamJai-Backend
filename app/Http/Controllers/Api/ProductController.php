<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    public function index()
    {
        $products = Product::with('categories', 'comments')->get();
        return ProductResource::collection($products);
    }

    public function store(Request $request){
        $product = new Product();
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->total_amount = $request->get('total_amount');
        $product->sell_amount = $request->get('sell_amount');
        $product->alert_amount = $request->get('alert_amount');
        $product->image_path = $request->get('image_path');
        $product->price = $request->get('price');
        $product->rating = $request->get('rating');
        $product->shop_id = $request->get('shop_id');
        $categories = $request->get('categories');
        $categorie_ids = $this->syncCatagories($categories);
        if ($product->save()) {
            $product->categories()->sync($categorie_ids);
            return response()->json([
                'success' => true,
                'message' => 'Product created with id '.$product->id,
                'product_id' => $product->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function show(Product $product)
    {
        return (new ProductResource($product->loadMissing(['categories', 'comments', 'reviews'])))->response();
    }

    public function update(Request $request, Product $product)
    {
        if ($request->has('name')) $product->name = $request->get('name');
        if ($request->has('description')) $product->description = $request->get('description');
        if ($request->has('total_amount')) $product->total_amount = $request->get('total_amount');
        if ($request->has('sell_amount')) $product->sell_amount = $request->get('sell_amount');
        if ($request->has('alert_amount')) $product->alert_amount = $request->get('alert_amount');
        if ($request->has('image_path')) $product->image_path = $request->get('image_path');
        if ($request->has('price')) $product->price = $request->get('price');
        if ($request->has('categories_str')){
            $categories = $request->get('categories_str');
            $categorie_ids = $this->syncCatagories($categories);
        }
        if ($product->save()) {
            $product->categories()->sync($categorie_ids);
            
            return response()->json([
                'success' => true,
                'message' => 'Product updated with id '.$product->id,
                'product_id' => $product->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        if ($product->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Product {$name} has deleted",
                'product_id' => $product->id
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Product {$name} delete failed",
            'product_id' => $product->id
        ], Response::HTTP_BAD_REQUEST);
    }

    public function search(Request $request) {
        $q = $request->query('q'); // เป็นตัวบอกตัวแปลที่ส่งเข้ามา ซึ่งจะต้องมี ? ก่อนแล้วค่อยชื่อตัวแปล ขั้นด้วย & เช่น
        // ?q=word&sort=DESC
        // $sort_variable = $request->query('sort') ?? 'asc';
        $product = Product::where('name', 'LIKE', "%{$q}%")
            ->get();
        return $product;
    }

    private function syncCatagories($categories) {
        // explode() -> แยกสตริงเป็นก้อนๆ
        $categories= explode(',', $categories);
        // แปลง string เพราะมี ' ' ขั้นหน้า เลยต้องตัดออก
        $categories = array_map(function ($v) {
            // associative function (unnamed function / closure)

            // uppercase first
            return Str::ucfirst(trim($v));
        }, $categories);

        $categorie_ids = [];
        foreach ($categories as $catagorie_name) {
            $category = Category::where('name', $catagorie_name)->first();
            if (!$category) {
                $category = new Category();
                $category->name = $catagorie_name;
                $category->save();
            }
            $categorie_ids[] = $category->id;
        }

        return $categorie_ids;
    }

}
