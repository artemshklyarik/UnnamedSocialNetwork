<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
use Illuminate\Support\Facades\Auth;

class Friend extends Model
{
    public static function sendFriendRequest($idFrom, $idTo)
    {
        if (!$idFrom || !$idTo) {
            return false;
        }

        if (DB::table('friends')
                ->where('user_id_1', '=', $idFrom)
                ->where('user_id_2', '=', $idTo)
                ->get() || DB::table('friends')
                ->where('user_id_2', '=', $idFrom)
                ->where('user_id_1', '=', $idTo)
                ->get()
        ) {
            return false;
        }

        DB::table('friends')->insert([
                'user_id_1' => $idFrom,
                'user_id_2' => $idTo
            ]
        );

        return true;
    }

    public static function isFriend($idFrom, $idTo)
    {
        if ($data = DB::table('friends')
            ->where('user_id_1', '=', $idFrom)
            ->where('user_id_2', '=', $idTo)
            ->first()
        ) {
            if ($data->confirmed) {
                return true;
            } else {
                return 'send request';
            }
        } elseif ($data = DB::table('friends')
            ->where('user_id_2', '=', $idFrom)
            ->where('user_id_1', '=', $idTo)
            ->first()
        ) {
            if ($data->confirmed) {
                return true;
            } else {
                return 'get request';
            }
        }

        return false;
    }

    public static function getUserFriends($idUser1, $idUser2 = null)
    {
        $friends = array();

        $friends['all'] = DB::table('friends')
            ->where('user_id_1', '=', $idUser1)
            ->where('confirmed', '=', 1)
            ->select('id', 'user_id_2 as user_id')
            ->get();

        $friends['all'] += DB::table('friends')
            ->where('user_id_2', '=', $idUser1)
            ->where('confirmed', '=', 1)
            ->select('id', 'user_id_1 as user_id')
            ->get();


        $authUserId = Auth::user()->id;
        $friends['requests'] = DB::table('friends')
            ->where('user_id_2', '=', $authUserId)
            ->where('confirmed', '=', 0)
            ->select('id', 'user_id_1 as user_id')
            ->get();

        foreach ($friends['requests'] as &$friend) {
            $userId = $friend->user_id;
            $friend->userInfo = User::getUserInfo($userId);
            $friend->userName = User::find($userId)->name;
        }

        foreach ($friends['all'] as &$friend) {
            $userId = $friend->user_id;
            $friend->userInfo = User::getUserInfo($userId);
            $friend->userName = User::find($userId)->name;
        }

        return $friends;
    }

    public static function acceptFriendRequest($idFrom, $idTo)
    {
        if (DB::table('friends')
                ->where('user_id_1', $idFrom)
                ->where('user_id_2', $idTo)
                ->update(['confirmed' => 1]) || DB::table('friends')
                ->where('user_id_2', $idFrom)
                ->where('user_id_1', $idTo)
                ->update(['confirmed' => 1])
        ) {
            return true;
        }

        return false;
    }

    public static function removeFriend($idFrom, $idTo)
    {
        if (DB::table('friends')
                ->where('user_id_1', $idFrom)
                ->where('user_id_2', $idTo)
                ->delete() || DB::table('friends')
                ->where('user_id_2', $idFrom)
                ->where('user_id_1', $idTo)
                ->delete()
        ) {
            return true;
        }

        return false;
    }
}
