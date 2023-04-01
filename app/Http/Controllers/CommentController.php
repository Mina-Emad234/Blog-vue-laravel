<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Events\NewComment;
use Illuminate\Http\Request;
use App\Notifications\NotifyOwner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Broadcasting\PrivateChannel;

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
        $post = Post::find($comment->post_id);
        $post_owner=$post->user;
        if ($post_owner->id != $comment->user_id) {
            $post_owner->notify(new NotifyOwner($comment, $post));
        }

        return response()->json([
            'id'=>$comment->id,
            'body'=>$comment->body,
            'created_at'=>$comment->created_at,
            'user'=>$comment->user,
        ]);
    }
}
