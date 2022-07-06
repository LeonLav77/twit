<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request,$id)
    {
        $post = Post::findOrFail($id);
        if($post->likes()->where('user_id',$request->user()->id)->exists()){
            $post->likes()->where('user_id',$request->user()->id)->delete();
            return response()->json(['message'=>'unliked']);
        } // this if is unnecesary but again just for frontend safety
        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);
        return response()->json(['success' => 'You liked this post.']);
    }
    public function unlike(Request $request,$id) {
        $post = Post::findOrFail($id);
        if($post->likes()->where('user_id',$request->user()->id)->exists()){
            $post->likes()->where('user_id',$request->user()->id)->delete();
            return response()->json(['message'=>'unliked']);
        } // this if is unnecesary but again just for frontend safety
        $post->likes()->where('user_id', $request->user()->id)->delete();
        return response()->json(['success' => 'You unliked this post.']);
    }
    
}
