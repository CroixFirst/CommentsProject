<?php

namespace App\Controllers;

class Comments extends BaseController
{
    public function index()
    {
        return view('comments_page');
    }
}
