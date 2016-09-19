<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use App\Question;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Session;

class MainController extends Controller
{
    public function __construct()
    {

    }
    public function index(Request $request)
    {
        if ($request->user()) {
            $users        = User::all();
            $userId       = $request->user()->id;
            $newQuestions = Question::getNewQuestions($userId);
            $questions    = Question::getQuestions($userId);
            $avatarLink   = User::getAvatarLink($userId);

            return view('user/profile', [
                'users'         => $users,
                'newQuestions'  => $newQuestions,
                'Questions'     => $questions,
                'avatarLink'    => $avatarLink
            ]);
        } else {
            return view('auth.auth');
        }
    }

    public function showProfile(Request $request, $id)
    {
        $users        = User::all();
        $userId       = $request->user()->id;
        $newQuestions = Question::getNewQuestions($userId);
        $questions    = Question::getQuestions($id);
        $avatarLink   = User::getAvatarLink($id);

        return view('user/profile', [
            'users'         => $users,
            'id'            => $id,
            'newQuestions'  => $newQuestions,
            'Questions'     => $questions,
            'avatarLink'    => $avatarLink
        ]);
    }

    public function editProfile(Request $request)
    {
        $userId     = $request->user()->id;
        $avatarLink = User::getAvatarLink($userId);

        return view('user/editProfile', [
            'avatarLink' => $avatarLink
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $file = array('image' => Input::file('photo'));
        // setting up rules
        $rules = array('image' => 'required'); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return Redirect::to('edit_profile')->withInput()->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('photo')->isValid()) {
                $destinationPath = 'uploads'; // upload path
                $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111,99999).'.'.$extension; // renameing image
                Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
                // sending back with message
                Session::flash('success', 'Upload successfully');

                $userId = $request->user()->id;
                $avatarLink = $destinationPath . '/' . $fileName;
                User::changePhoto($userId, $avatarLink);

                return Redirect::to('edit_profile');
            }
            else {
                // sending back with error message.
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('edit_profile');
            }
        }
    }
}
