<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login()
    {
        return response("Admin Login Page (Placeholder)", 200);
    }

    public function dashboard()
    {
        return response("Admin Dashboard (Protected)", 200);
    }
}
