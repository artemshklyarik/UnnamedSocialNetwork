<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use App\User;
use App\Question;
use App\Http\Requests;

class FriendController extends Controller
{
    public function userFriends(Request $request)
    {
        if (isset($request->id) && $request->id) {
            $userId = $request->id;
            $authUserId = $request->user()->id;
            $owner = false;
            $friends = Friend::getUserFriends($userId, $authUserId);
        } else {
            $userId = $request->user()->id;
            $owner = true;
            $friends = Friend::getUserFriends($userId);
        }
        $newQuestions = Question::getNewQuestions($request->user()->id);
        $questions = Question::getQuestions($request->user()->id);
        $userInfo = User::getUserInfo($request->user()->id);

        return view('friends/list', [
            'owner' => $owner,
            'newQuestions' => $newQuestions,
            'questions' => $questions,
            'authUserInfo' => $userInfo,
            'friends' => $friends
        ]);
    }

    public function addFriend(Request $request)
    {
        $idFrom = $userId = $request->user()->id;
        $idTo = $request->requestId;

        if (Friend::sendFriendRequest($idFrom, $idTo)) {
            $response = [
                'status' => true
            ];
        } else {
            $response = [
                'status' => false
            ];
        }

        return response()->json($response);
    }

    public function acceptRequestFriend(Request $request)
    {
        $idFrom = $userId = $request->user()->id;
        $idTo = $request->requestId;

        $response = [
            'status' => Friend::acceptFriendRequest($idFrom, $idTo),
        ];

        return response()->json($response);
    }

    public function rejectRequestFriend(Request $request)
    {
        $idFrom = $userId = $request->user()->id;
        $idTo = $request->requestId;

        $response = [
            'status' => Friend::removeFriend($idFrom, $idTo)
        ];

        return response()->json($response);
    }
}
