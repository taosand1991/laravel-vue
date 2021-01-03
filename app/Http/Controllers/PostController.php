<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;



class PostController extends Controller
{
    public function index()
    {
        $post = Post::select()->orderBy('created_at', 'desc')->with(['users'])->get();
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
            'likes' => [],
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

    public function likePost(Post $post)
    {
        $user_id = Auth::user()->id;
        $new_post = $post->likes;
        $get_id = array_search($user_id, $new_post);
        if (!in_array($user_id, $new_post)) {
            array_push($new_post, $user_id);
            $post->likes = $new_post;
            $post->save();
            return response()->json(['success' => 'You liked this post'], 200);
        } else {
            array_splice($new_post, $get_id, 1);
            $post->likes = $new_post;
            $post->save();
            return response()->json(['success' => 'You dislike this post'], 200);
        }
    }

    public function getUserPosts($name)
    {
        $user = User::where('name', '=', $name)->first();
        $posts = Post::where('user_id', '=', $user->id)->with(['users'])->get();
        return response()->json(['posts' => $posts, 'user' => $user], 200);
    }
}