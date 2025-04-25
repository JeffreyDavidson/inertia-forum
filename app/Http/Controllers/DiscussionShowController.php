<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;

class DiscussionShowController extends Controller
{
    public function __invoke(Discussion $discussion)
    {
        $discussion->load(['topic']);

        return inertia()->render('Forum/Show', [
            'discussion' => DiscussionResource::make($discussion),
        ]);
    }
}
