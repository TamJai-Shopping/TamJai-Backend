<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($request->file('file')))
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
        $path = $request->file('file')->store('public/images');
        $path = trim(strstr($path,"images"));
        $product = Product::find($request->get('product_id'));
        $product->image_path = $path;
        $product->save();
        return response()->json([
            'success' => true,
            'path' => $path
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request) {
        $product_id = $request->query('id');
        $path = Product::find($product_id)->image_path;
        return response()->file("storage/".$path);
    }
}
