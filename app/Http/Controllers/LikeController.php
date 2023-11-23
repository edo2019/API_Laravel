<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
class LikeController extends Controller
{
    //
    public function likeorunlike()
    {
        $post = Post::find($id);

        if (! $post) {
            return response([
                'message' => 'post not found',
            ], 403);

        }

        $like = $post->likes()->where('user_id', auth()->user()->id)->first();

        if (! $like) {
            Like::create([
                'post_id' => $id,
                'user_id' => auth()->user()->id,

            ]);

            return response([
                'message' => 'Liked',
            ], 200);

        }
    $like->delete();
     
    return response([
        'message' => 'Disliked'
    ],200);

    }
}
