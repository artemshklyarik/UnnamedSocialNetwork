<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MainController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()) {
            return view('profile');
        } else {
            return view('auth.auth');
        }
    }
}
