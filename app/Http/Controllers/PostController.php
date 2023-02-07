<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->with('user')->withCount('comments')->paginate(5);
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load(['comments.user','user']);
        return response()->json([
            'id'=>$post->id,
            'slug'=>$post->slug,
            'body'=>$post->body,
            'created_at'=>$post->created_at,
            'comments'=>$post->comments,
            'user'=>$post->user,
            'image'=>$post->image,
            'title'=>$post->title,
            'category'=>$post->category,
        ]);
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

    public function searchPosts($query)
    {
        $posts = Post::latest()->with('user')->withCount('comments')->where('title','like',"%$query%")->paginate(5);
        return response()->json($posts);
    }
}
