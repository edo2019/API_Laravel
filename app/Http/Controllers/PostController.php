<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //get all post
    public function index()
    {
        return response([
            'post' => Post::orderBy('created_at', 'desc')->with('user:id,name,image')->withcount('comments', 'likes')
                ->get(),
        ], 200);
    }

    //get single post
    public function show($id)
    {
        return response([
            'post' => Post::where('id', $id)->withcount('comments', 'likes')->get(),
        ], 200);
    }

    //create a post
    public function store(Request $request)
    {
        //validation
        $attrs = $request->validate([
            'body' => 'required|string',
        ]);

        $post = Post::create([
            'body' => $attrs['body'],
            'user_id' => auth()->user()->id,
        ]);

        //skip image first

        return response([
            'message' => 'post created',
            'post' => $post,
        ], 200);
    }

    //update a post
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (! $post) {
            return response([
                'message' => 'post not found',
            ], 403);

        }

        if ($post->user_id != auth()->user()->id) {
            return response([
                'message' => 'permission denied',

            ]);

        }

        //validation
        $attrs = $request->validate([
            'body' => 'required|string',
        ]);

        $post->update([
            'body' => $attrs['body'],

        ]);

        //skip image first

        return response([
            'message' => 'post updated',
            'post' => $post,
        ], 200);
    }

    //delete post
    public function destroy($id)
    {
        $post = Post::find($id);

        if (! $post) {
            return response([
                'message' => 'post not found',
            ], 404); // Change the HTTP status code to 404 for "Not Found"
        }

        if (auth()->user()->id != $post->user_id) {
            return response([
                'message' => 'permission denied',
            ], 403); // Change the HTTP status code to 403 for "Forbidden"
        }

        // Delete associated comments and likes
        $post->comments()->delete();
        $post->likes()->delete();

        // Delete the post
        $post->delete();

        return response([
            'message' => 'post deleted',
        ], 200);
    }
}
