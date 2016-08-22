<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;

class MainController extends Controller
{
    public function __construct()
    {

    }
    public function index(Request $request)
    {
        $users = User::all();

        if ($request->user()) {
            return view('profile', ['users' => $users]);
        } else {
            return view('auth.auth');
        }
    }

    public function showProfile(Request $request, $id)
    {
        $users = User::all();

        return view('profile', ['users' => $users]);
    }
}
