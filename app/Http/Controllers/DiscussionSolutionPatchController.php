<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscussionSolutionPatchRequest;
use App\Models\Discussion;

class DiscussionSolutionPatchController extends Controller
{
    public function __invoke(DiscussionSolutionPatchRequest $request, Discussion $discussion)
    {
        $discussion->solution()->associate($discussion->posts()->find($request->post_id));
        $discussion->save();

        return back();
    }
}
