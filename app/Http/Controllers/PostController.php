<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::with(['users'])->orderBy('updated_at', 'desc')->get();
        return response()->json(['posts' => $post], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        };
        $title = $request->input('title');
        $body = $request->input('body');
        $user_id = Auth::user()->id;
        $post = Post::create([
            'title' => $title,
            'body' => $body,
            'user_id' => $user_id,
        ]);
        // $post = Post::create($request->all());
        return response()->json(['post' => $post], 201);
    }
    public function getPost($id)
    {
        $post = Post::with(['users'])->find($id);
        return response()->json(['post' => $post], 200);
    }
    public function deletePost($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json(204);
    }
    public function editPost(Request $request, $id)
    {
        $post = Post::find($id)->update($request->all());
        if ($post) {
            return response()->json(['message' => 'Your post has been updated'], 200);
        } else return response()->json(['message' => 'Your update request was found with error(s)'], 400);
    }
}