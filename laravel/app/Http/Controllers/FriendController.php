<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use App\Question;
use App\Http\Requests;

class FriendController extends Controller
{
    public function userFriends(Request $request)
    {
        if (isset($request->id) && $request->id) {
            $userId = $request->id;
            $owner = false;
        } else {
            $userId = $request->user()->id;
            $owner = true;
        }
        $friends = Friend::getUserFriends($userId);
        $newQuestions = Question::getNewQuestions($request->user()->id);
        $questions = Question::getQuestions($request->user()->id);

        return view('friends/list', [
            'owner' => $owner,
            'newQuestions' => $newQuestions,
            'Questions' => $questions,
            'friends' => $friends
        ]);
    }

    public function addFriend(Request $request)
    {
        $idFrom = $userId = $request->user()->id;
        $idTo = $request->requestId;

        if (Friend::sendFriendRequest($idFrom, $idTo)) {
            $response = [
                'status' => 'success'
            ];
        } else {
            $response = [
                'status' => 'error'
            ];
        }

        return response()->json($response);
    }

    public function acceptRequestFriend(Request $request)
    {
        $idFrom = $userId = $request->user()->id;
        $idTo = $request->requestId;

        $response = [
            'status' => Friend::acceptFriendRequest($idFrom, $idTo)
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
