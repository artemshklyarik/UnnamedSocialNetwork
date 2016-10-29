<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
use App\Question;
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

    public static function getUserFriendsCount($idUser1, $idUser2 = null)
    {
        $authUser = $idUser1;
        if ($idUser2) {
            $user = $idUser2;
        } else {
            $user = $idUser1;
        }

        $friendsCount['all'] = DB::table('friends')
            ->where(function ($query) use ($user) {
                $query->where('user_id_1', '=', $user)
                    ->orWhere('user_id_2', '=', $user);
            })
            ->where('confirmed', '=', 1)
            ->count();

        $friendsCount['request'] = DB::table('friends')
            ->where('user_id_2', '=', $authUser)
            ->where('confirmed', '=', 0)
            ->select('user_id_1 as user_id')
            ->count();

        if ($idUser2) {
            $friends['allTemp'] = DB::table('friends')
                ->where(function ($query) use ($authUser) {
                    $query->where('user_id_1', '=', $authUser)
                        ->orWhere('user_id_2', '=', $authUser);
                })
                ->where('confirmed', '=', 1)
                ->get();

            foreach ($friends['allTemp'] as $friend) {
                if ($authUser != $friend->user_id_1) {
                    $tempUserId = $friend->user_id_1;
                } else {
                    $tempUserId = $friend->user_id_2;
                }

                $allOwnerFriends[] = $tempUserId;
            }

            $friendsCount['mutual'] = DB::table('friends')
                ->where(function ($query) use ($allOwnerFriends, $user) {
                    $query->whereIn('user_id_1', $allOwnerFriends)
                        ->where('user_id_2', $user);
                })
                ->orWhere(function ($query) use ($allOwnerFriends, $user) {
                    $query->whereIn('user_id_2', $allOwnerFriends)
                        ->where('user_id_1', $user);
                })
                ->where('confirmed', '=', 1)
                ->count();

            $friendsCount['test'] = $user . ' ' . $authUser;
        }

        return $friendsCount;
    }

    public static function getUserFriends($idUser1, $idUser2 = null, $params = null)
    {
        $friends = array();
        $page    = $params['page'];
        $limit   = 20; //constant
        $offset  = ($page - 1) * $limit;
        $allfriends = array();

        $friends['allTemp'] = DB::table('friends')
            ->where(function ($query) use ($idUser1) {
                $query->where('user_id_1', '=', $idUser1)
                    ->orWhere('user_id_2', '=', $idUser1);
            })
            ->where('confirmed', '=', 1)
            ->get();

        foreach ($friends['allTemp'] as $friend) {
            if ($params['ownerId'] != $friend->user_id_1) {
                $userId = $friend->user_id_1;
            } else {
                $userId = $friend->user_id_2;
            }

            $allfriends[] = $userId;
        }

        if (isset($params['filters'])) {
            $friends = User::getCustomUsersInfo($allfriends, $limit, $offset, $params['filters']);
        } else {
            $friends = User::getCustomUsersInfo($allfriends, $limit, $offset);
        }

        return $friends;
    }

    public static function getUserFriendRequests($userId, $params = null)
    {
        $requestsIds = array();

        $temp = DB::table('friends')
            ->where('user_id_2', '=', $userId)
            ->where('confirmed', '=', 0);

        $temp = $temp->select('user_id_1 as user_id');
        if ($params['page']) {
            $page    = $params['page'];
            $limit   = 20; //constant
            $offset  = ($page - 1) * $limit;

            $temp = $temp->offset($offset)
                ->limit($limit);
        }

        $temp = $temp->get();

        foreach ($temp as $item) {
            $requestsIds[] = $item->user_id;
        }

        $requests = User::getCustomUsersInfo($requestsIds);


        return $requests;
    }

    public static function getMutualUserFriend($ownerId, $userId, $params)
    {
        $friends = array();

        $page    = $params['page'];
        $limit   = 20; //constant
        $offset  = ($page - 1) * $limit;
        $allFriends = array();
        $allOwnerFriends = array();

        $friends['allTemp'] = DB::table('friends')
        ->where(function ($query) use ($ownerId) {
            $query->where('user_id_1', '=', $ownerId)
                ->orWhere('user_id_2', '=', $ownerId);
        })
        ->where('confirmed', '=', 1)
        ->get();

        foreach ($friends['allTemp'] as $friend) {
            if ($ownerId != $friend->user_id_1) {
                $tempUserId = $friend->user_id_1;
            } else {
                $tempUserId = $friend->user_id_2;
            }

            $allOwnerFriends[] = $tempUserId;
        }

        $friends['allTemp'] = DB::table('friends')
            ->where(function ($query) use ($allOwnerFriends, $userId) {
                $query->whereIn('user_id_1', $allOwnerFriends)
                    ->where('user_id_2', $userId);
            })
            ->orWhere(function ($query) use ($allOwnerFriends, $userId) {
                $query->whereIn('user_id_2', $allOwnerFriends)
                    ->where('user_id_1', $userId);
            })
            ->where('confirmed', '=', 1)
            ->get();

        foreach ($friends['allTemp'] as $friend) {
            if ($userId != $friend->user_id_1) {
                $tempUserId = $friend->user_id_1;
            } else {
                $tempUserId = $friend->user_id_2;
            }

            $allFriends[] = $tempUserId;
        }

        if (isset($params['filters'])) {
            $friends = User::getCustomUsersInfo($allFriends, $limit, $offset, $params['filters']);
        } else {
            $friends = User::getCustomUsersInfo($allFriends, $limit, $offset);
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
