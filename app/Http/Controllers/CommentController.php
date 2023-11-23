<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /*
    //get all comments in the post
    public function index($id)
    {
        $post = Post::find($id);

        if (! $post) {
            return response([
                'message' => 'post not found',
            ], 403);

        }

        return response([
            'post' => $post->comments()->with('user:id,name,image')->save(),
        ], 200);

    }

    //create comment
    public function store(Request $request, $id)
    {
        $post = Post::find($id);

        if (! $post) {
            return response([
                'message' => 'post not found',
            ], 403);

        }

        //validation
        $attrs = $request->validate([
            'comment' => 'required|string',
        ]);

        Comment::create([
            'comment' => $attrs['comment'],
            'post_id' => $post,
            'user_id' => auth()->user()->id,

        ]);

        return response([
            'message' => 'comment created',

        ], 200);

    }

    */
    //get all comments in the post
    public function index($id)
    {
        $post = Post::find($id);

        if (! $post) {
            return response([
                'message' => 'post not found',
            ], 404); // Correct HTTP status code to 404 for "Not Found"
        }

        return response([
            'comments' => $post->comments()->with('user:id,name,image')->get(),
        ], 200);
    }

    //create comment
    public function store(Request $request, $id)
    {
        $post = Post::find($id);

        if (! $post) {
            return response([
                'message' => 'post not found',
            ], 404); // Change HTTP status code to 404 for "Not Found"
        }

        //validation
        $attrs = $request->validate([
            'comment' => 'required|string',
        ]);

        Comment::create([
            'comment' => $attrs['comment'],
            'post_id' => $post->id, // Use post_id as the actual ID of the post
            'user_id' => auth()->user()->id,
        ]);

        return response([
            'message' => 'comment created',
        ], 200);
    }

    //update comment

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (! $comment) {
            return response([
                'message' => 'comment not found',
            ], 403);

        }
        if ($comment->user_id != auth()->user()->id) {
            return response([
                'message' => 'permission denied',

            ]);

        }
        //validation
        $attrs = $request->validate([
            'comment' => 'required|string',
        ]);

        $comment->update([
            'comment' => $attrs['comment'],

        ]);

        return response([
            'message' => 'comment updated',
        ]);

    }

    //delete a comment

    public function destroy($id)
    {

        $comment = Comment::find($id);

        if (! $comment) {
            return response([
                'message' => 'comment not found',
            ], 403);

        }
        if ($comment->user_id != auth()->user()->id) {
            return response([
                'message' => 'permission denied',

            ]);

        }

        $comment->delete();

        return response([
            'message' => 'comment deleted',
        ], 200);

    }
}
