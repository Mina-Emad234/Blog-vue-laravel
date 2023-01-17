<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = Comment::create([
            'body'=>$request->body,
            'user_id'=>Auth::user()->id,
            'post_id'=>$request->post_id,
        ]);
        $comment->load('user');
        return response()->json([
            'id'=>$comment->id,
            'body'=>$comment->body,
            'created_at'=>$comment->created_at,
            'user'=>$comment->user,
        ]);
    }
}
