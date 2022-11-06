<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::orderBy('create_at', 'asc');
        return ReviewResource::collection($reviews);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // TODO:แก้ให้ปุ่มแนบภาพได้
        $success = true;
        $message = 'Create review success with id ';
        $status = Response::HTTP_CREATED;
        if (is_null($request->has('product_id')) ||
            is_null($request->has('user_id')) ||
            is_null($request->has('rating')) ||
            is_null($request->has('detail'))) {
            $success = false;
            $message = 'Some argument was missing';
            $status = Response::HTTP_BAD_REQUEST;
        }
        $review = new Review();
        $review->product_id = $request->get('product_id');
        $review->user_id = $request->get('user_id');
        $review->rating = $request->get('rating');
        $review->detail = $request->get('detail');
        $review->save();

        $product = Product::find($review->product_id);
        $product->rating = Review::where('product_id', $product->id)->sum('rating') / Review::where('product_id', $product->id)->count();
        $product->save();

        return response()->json([
            'success' => $success,
            'message' => $message,
            'review_id' => $review->id
        ], $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
