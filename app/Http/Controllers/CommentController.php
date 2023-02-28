<?php

namespace App\Http\Controllers;

use App\Events\NewComment;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\NotifyOwner;
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
        broadcast(new NewComment($comment->user,$comment))->toOthers();
        $post = Post::find($request->post_id);
        if ($post->user_id != $comment->user_id) {
            $post->user->notify(new NotifyOwner($comment,$post));
        }
        return response()->json([
            'id'=>$comment->id,
            'body'=>$comment->body,
            'created_at'=>$comment->created_at,
            'user'=>$comment->user,
        ]);
    }
}
