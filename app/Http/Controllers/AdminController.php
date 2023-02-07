<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function getPosts()
    {
        $posts = Post::latest()->with(['user','category'])->withCount('comments')->paginate(5);
        return response()->json($posts);
    }

    public function getCategories()
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
            'category_id'=>$request->category,
            'image'=>$request->image,
            'user_id'=>Auth::user()->id,
        ]);

        return response()->json($post);
    }

    public function updatePost(Request $request)
    {
        $post = Post::find($request->id);
        if ($post && !empty($request->image) && File::exists($post->image)) {
            unlink($post->image);
        }
        $post->Update([
            'title'=>$request->title,
            'slug'=>Str::slug($request->title),
            'body'=>$request->body,
            'category_id'=>$request->category,
            'image'=>$request->image,
            'user_id'=>Auth::user()->id,
        ]);

        return response()->json($post);
    }

    public function deletePosts(Request $request)
    {
        $posts = Post::whereIn('id',$request->posts_ids)->get();
        foreach ( $posts as $post) {
            $post->delete();
            if ($post && File::exists($post->image)) {
                unlink($post->image);
            }
        }
        return response()->json(['message'=>'deleted']);
    }
    public function deletePost(Request $request)
        {
            $post = Post::where('slug',$request->slug)->firstOrFail();
                $post->delete();
                if ($post && File::exists($post->image)) {
                    unlink($post->image);
                }

            return response()->json(['message'=>'post deleted']);
        }


}
