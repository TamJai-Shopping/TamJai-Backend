<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    public function index()
    {
        $comments = Comment::get();
        return CommentResource::collection($comments);
    }

    public function store(Request $request){
        $comment = new Comment();
        $comment->product_id = $request->get('product_id');
        $comment->message = $request->get('message');

        if ($comment->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment created with id '.$comment->id,
                'comment_id' => $comment->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Comment creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(Request $request, Comment $comment)
    {
        if ($request->has('product_id')) $comment->product_id = $request->get('product_id');
        if ($request->has('message')) $comment->message = $request->get('message');

        if ($comment->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment updated with id '.$comment->id,
                'comment_id' => $comment->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Comment update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Comment $comment)
    {
        $id = $comment->id;
        if ($comment->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Comment {$id} has deleted",
                'comment_id' => $comment->id
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Comment {$id} delete failed",
            'comment_id' => $comment->id
        ], Response::HTTP_BAD_REQUEST);
    }
    
    public function search(Request $request) {
        $q = $request->query('q'); // เป็นตัวบอกตัวแปลที่ส่งเข้ามา ซึ่งจะต้องมี ? ก่อนแล้วค่อยชื่อตัวแปล ขั้นด้วย & เช่น
        // ?q=word&sort=DESC
        // $sort_variable = $request->query('sort') ?? 'asc';
        $comments = Comment::get();
        return $comments;
    }

}
