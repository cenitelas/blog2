<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $data = $this->validated();
        $data['post_id'] = $request['post'];
        /** @var User $user */
        $user = auth()->user();
        $user->comments()->create($data);
        /** @var Post $post */
        $post = Post::query()
            ->where('id',$request['post'])
            ->first();
        return redirect()->route('posts.show', $post);
    }

    public function destroy(Comment $comment)
    {
        $post = $comment->post_id;
        $comment->delete();
        return redirect()->route('posts.show',$post);
    }

    protected function validated() {
        return request()->validate([
            'message' => 'required|string|min:5'
        ]);
    }
}
