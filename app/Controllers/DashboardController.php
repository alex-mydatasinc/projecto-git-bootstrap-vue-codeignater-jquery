<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('templates/header')
                .view('admin/dashboard')
                .view('templates/footer');
    }
}
