<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use App\Question;
use App\Photos;
use App\Geo;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Session;
use App\Friend;

class NewsletterController extends Controller
{
    public function __construct()
    {

    }

    public function getPage(Request $request)
    {
        $authUserId = $request->user()->id;
        $authUserInfo = User::getUserInfo($authUserId);
        $friendsCount = Friend::getUserFriendsCount($authUserId);

        return view('newsletter/index', [
            'authUserInfo' => $authUserInfo,
            'friendsCount' => $friendsCount,
        ]);
    }

    public function NewsletterAjax(Request $request)
    {
        $page = $request->page;
        $ownerId = $request->user()->id;
        $friendsIds = Friend::getUserFriendsIdsById($ownerId);

        $questions = Question::getQuestionsByUsersIds($friendsIds, $page);


        $response = [
            'data' => $questions
        ];
        return response()->json($response);
    }
}
