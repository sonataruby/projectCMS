<?php

namespace App\Controllers\Admin;

class Account extends AdminController
{
    public function index()
    {
        return view('admin/account');
    }
}
