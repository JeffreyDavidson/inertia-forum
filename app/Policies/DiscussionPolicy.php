<?php

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;

class DiscussionPolicy
{
    public function create(User $user)
    {
        return true;
    }

    public function reply(User $user, Discussion $discussion)
    {
        return true;
    }

    public function delete(User $user, Discussion $discussion)
    {
        return $discussion->user()->is($user);
    }

    public function solve(User $user, Discussion $discussion)
    {
        return $discussion->user()->is($user);
    }
}
