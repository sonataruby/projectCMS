<?php

namespace App\Controllers\Admin;

class Home extends AdminController
{
    public function index()
    {
        return view('admin/home');
    }
}
