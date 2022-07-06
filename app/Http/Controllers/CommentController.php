<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = $request->user()->id;
        $comment->post_id = $request->post_id;
        $comment->save();
        return response()->json($comment);
    }
    public function edit(Request $request, $id) {
        if(!$comment = Comment::find($id)) {
            return response()->json(['error' => 'comment not found'], 404);
        }
        if($request->user()->id !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $comment->body = $request->body;
        $comment->save();
        return response()->json($comment);
    }
    public function delete(Request $request ,$id){
        if(!$comment = Comment::find($id)) {
            return response()->json(['error' => 'comment not found'], 404);
        }
        if($request->user()->id !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $comment->delete();
        return response()->json(['success' => 'comment deleted']);
    }
    
}
