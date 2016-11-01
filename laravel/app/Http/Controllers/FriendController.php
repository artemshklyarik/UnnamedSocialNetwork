<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use App\User;
use App\Question;
use App\Http\Requests;
use View;


class FriendController extends Controller
{
    public function userFriendsAjax(Request $request)
    {
        $params = array();
        $params['page'] = $request->page;
        $params['ownerId'] = $request->ownerId;
        $scope = $request->scope;
        $friends = array();

        //filters
        if ($request->gender) {
            $params['filters']['gender'] = $request->gender;
        }

        if ($scope == 'general') {
            if (isset($request->ownerId) && isset($request->userId)) {
                $ownerId = $request->ownerId;
                $userId  = $request->userId;

                $friends = Friend::getUserFriends($userId, $ownerId, $params);
            } else if (isset($request->ownerId)) {
                $userId = $request->ownerId;
                $friends = Friend::getUserFriends($userId, null, $params);
            }
        }

        if ($scope == 'requests') {
            $ownerId = $request->ownerId;
            $friends = Friend::getUserFriendRequests($ownerId, $params);
        }

        if ($scope == 'mutual') {
            $ownerId = $request->ownerId;
            $userId  = $request->userId;

            $friends = Friend::getMutualUserFriend($ownerId, $userId, $params);
        }

        if ($scope == 'action') {
            $ownerId = $request->ownerId;
            $userId  = $request->userId;

            $action  = $request->action;

            if ($action == 'accept') {
                Friend::acceptFriendRequest($ownerId, $userId);
            } else if ($action == 'remove') {
                Friend::removeFriend($ownerId, $userId);
            }

            $friends['all']      = Friend::getUserFriends($userId, null, $params);
            $friends['requests'] = Friend::getUserFriendRequests($ownerId, $params);
            $friends['count']    = Friend::getUserFriendsCount($ownerId);
        }

        $response = [
            'friends' => $friends,
        ];
        return response()->json($response);
    }

    public function userFriends(Request $request)
    {
        if (isset($request->id) && $request->id) {
            $userId = $request->id;
            $authUserId = $request->user()->id;
            $owner = false;
            $friendsCount = Friend::getUserFriendsCount($authUserId, $userId);
            $userInfo = User::getUserInfo($request->id);
        } else {
            $userId = $request->user()->id;
            $owner = true;
            $friendsCount = Friend::getUserFriendsCount($userId);
            $userInfo = null;
        }
        $newQuestions = Question::getNewQuestions($request->user()->id);
        $authUserInfo = User::getUserInfo($request->user()->id);

        return view('friends/list', [
            'owner' => $owner,
            'newQuestions' => $newQuestions,
            'authUserInfo' => $authUserInfo,
            'userInfo' => $userInfo,
            'friendsCount' => $friendsCount
        ]);
    }

    public function addFriend(Request $request)
    {
        $idFrom = $request->user()->id;
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
            'status' => Friend::removeFriend($idFrom, $idTo),
        ];

        return response()->json($response);
    }
}
