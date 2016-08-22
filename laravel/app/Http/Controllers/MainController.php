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
        if ($request->user()) {
            return view('profile');
        } else {
            return view('auth.auth');
        }
    }

    public function showProfile(Request $request, $id)
    {
        $users = User::all();

        return view('user.profile', ['users' => $users]);
    }
}
