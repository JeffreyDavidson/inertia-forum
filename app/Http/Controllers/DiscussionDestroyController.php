<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscussionDestroyRequest;
use App\Models\Discussion;

class DiscussionDestroyController extends Controller
{
    public function __invoke(DiscussionDestroyRequest $request, Discussion $discussion)
    {
        $discussion->delete();

        return to_route('home');
    }
}
