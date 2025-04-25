<?php

namespace App\Http\Controllers;

class ForumIndexController extends Controller
{
    public function __invoke()
    {
        return inertia()->render('Forum/Index');
    }
}
