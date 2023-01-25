<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function getPosts()
    {
        $posts = Post::latest()->with(['user','category'])->withCount('comments')->paginate(10);
        return response()->json($posts);
    }

    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function addPost(Request $request)
    {
        $post = Post::Create([
            'title'=>$request->title,
            'slug'=>Str::slug($request->title),
            'body'=>$request->body,
            'category'=>$request->category,
            'image'=>$request->image,
            'user_id'=>Auth::user()->id,
        ]);

        return response()->json($post);
    }

    public function updatePost(Request $request)
    {
        $post = Post::find($request->id);
        if ($post && !empty($request->image)) {
            unlink($post->image);
        }
        $post->Update([
            'title'=>$request->title,
            'slug'=>Str::slug($request->title),
            'body'=>$request->body,
            'category'=>$request->category,
            'image'=>$request->image,
            'user_id'=>Auth::user()->id,
        ]);

        return response()->json($post);
    }

    public function deletePost(Request $request)
    {
        Post::whereIn('id',$request->post_ids)->delete();
        return response()->json(['message'=>'deleted']);
    }


}
