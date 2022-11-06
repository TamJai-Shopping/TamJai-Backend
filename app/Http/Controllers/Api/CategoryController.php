<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {}

    public function index()
    {
        $categorys = Category::with('products')->get();
        return $categorys;
    }

    public function store(Request $request){
        $category = new Category();
        $category->name = $request->get('name');
        $shop = $request->get('shop');

        if ($category->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Shop created with id '.$category->id,
                'category_id' => $shop->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'category creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function show(Category $category)
    {
        return (new CategoryResource($category->loadMissing(['products'])))->response();
    }

    public function update(Request $request, Category $category)
    {
        if ($request->has('name')) $category->name = $request->get('name');

        if ($category->save()) {
            return response()->json([
                'success' => true,
                'message' => 'category updated with id '.$category->id,
                'category_id' => $category->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'category update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        if ($category->delete()) {
            return response()->json([
                'success' => true,
                'message' => "category {$name} has deleted",
                'category_id' => $category->id
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "category {$name} delete failed",
            'category_id' => $category->id
        ], Response::HTTP_BAD_REQUEST);
    }

}
