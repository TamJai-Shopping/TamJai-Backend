<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($request->file('image')))
            return response()->json([
                'success' => false,
                'message' => 'Image upload fail'
            ], Response::HTTP_BAD_REQUEST);
        if (is_null($request->get('product_id'))) {
            return response()->json([
                'success' => false,
                'message' => 'product not found'
            ], Response::HTTP_BAD_REQUEST);
        }

//        Log::info($request->file())
        $path = $request->file('image')->store('public/images');
        $path = trim(strstr($path,"images"));
        $product = Product::find($request->get('product_id'));
        $product->image_path = $path;
        $product->save();
        return response()->json([
            'success' => true,
            'path' => $path
        ], Response::HTTP_OK);
    }

    public function search(Request $request) {
        $product_id = $request->query('id');
        $path = Product::find($product_id)->image_path;
        return response()->file("storage/".$path);
    }
}
