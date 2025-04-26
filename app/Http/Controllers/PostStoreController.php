<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Discussion;
use App\Models\Post;

class PostStoreController extends Controller
{
    public function __invoke(PostStoreRequest $request, Discussion $discussion)
    {
        $post = Post::make($request->validated());

        $post->user()->associate($request->user());
        $post->discussion()->associate($discussion);
        $post->parent()->associate($discussion->post);

        $post->save();

        return to_route('discussions.show', $discussion);
    }
}
