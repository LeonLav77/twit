<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function all()
    {
        return response()->json(Post::all());
    }
    public function find($id)
    {
        if(!$post = Post::find($id)) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        return response()->json($post);
    }
    public function create(Request $request)
    {
        $title = $request->title;
        $body = $request->body;
        $post = Post::create([
                'title' => $title,
                'body' => $body,
                'user_id' => $request->user()->id,
            ]);
        return response()->json($post, 201);
    }
    public function update(Request $request, $id)
    {
        if(!$post = Post::find($id)) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        if($request->user()->id !== $post->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        return response()->json($post);
    }
    public function delete(Request $request, $id)
    {
        if(!$post = Post::find($id)) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        if($request->user()->id !== $post->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $post->delete();
        return response()->json(['success' => 'Post deleted']);
    }
    public function comments($id){
        $post = Post::find($id);
        return response()->json($post->comments);
    }
}
