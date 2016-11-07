<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use App\User;
use App\Http\Requests;
use View;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function searchPeople(Request $request)
    {
        $authUserId = $request->user()->id;
        $authUserInfo = User::getUserInfo($authUserId);
        $friendsCount = Friend::getUserFriendsCount($authUserId);

        return view('search/people', [
            'authUserInfo' => $authUserInfo,
            'friendsCount' => $friendsCount,
            'q' => $request->q
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchPeopleAjax(Request $request)
    {
        $ownerId = $request->user()->id;

        $params['page'] = $request->page;
        $page = $params['page'];
        $limit = 20; //constant
        $offset = ($page - 1) * $limit;

        if (isset($request->q)) {
            $q = $request->q;
        } else {
            $q = '';
        }

        $usersIds = User::getAllUsersIdsArray($ownerId);

        if ($request->gender) {
            $params['filters']['gender'] = $request->gender;
        }

        if (isset($params['filters'])) {
            $people = User::getCustomUsersInfo($usersIds, $limit, $offset, $params['filters'], $q);
        } else {
            $people = User::getCustomUsersInfo($usersIds, $limit, $offset, null, $q);
        }

        $response = [
            'friends' => $people
        ];
        return response()->json($response);
    }
}
