<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;

use Carbon\Carbon;


class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function changePhoto($id, $avatarLink)
    {
        $user = DB::table('users_info')->where('id', $id)->first();
        if ($user) {
            DB::table('users_info')
                ->where('id', $id)
                ->update([
                    'avatar_link' => $avatarLink
                ]);
        } else {
            DB::table('users_info')->insert([
                'id' => $id,
                'avatar_link' => $avatarLink
            ]);
        }
    }

    public static function getUserInfo($userId)
    {
        $userInfo = array();

        //get User avatar link
        $select = DB::table('users_info')
            ->where('id', $userId)
            ->first();

        if ($select) {
            if (file_exists($select->avatar_link)) {
                $userInfo['avatarLink']       = asset($select->avatar_link);
            } else {
                $userInfo['avatarLink']       = asset('assets/img/defaultAvatar.jpg');
            }

            $userInfo['gender'] = '';
            if ($select->gender != 'hide') {
                $userInfo['gender']           = $select->gender;
            }

            $userInfo['date_of_birthday']     = $select->date_of_birthday;
            $userInfo['status']               = $select->status;
        } else {
            $userInfo['avatarLink']           = asset('assets/img/defaultAvatar.jpg');
            $userInfo['gender']               = '';
            $userInfo['date_of_birthday']     = '';
            $userInfo['status']               = '';
        }

        return $userInfo;
    }

    public static function deletePreviewPhoto($userId)
    {
        $select = DB::table('users_info')
            ->where('id', $userId)
            ->first();

        if ($select) {
            unlink($select->avatar_link);

            return true;
        }

        return false;
    }

    public static function saveUserInfo($userId, $data)
    {
        $user = DB::table('users_info')->where('id', $userId)->first();
        unset($data['_token']);

        if ($user) {
            DB::table('users_info')
                ->where('id', $userId)
                ->update($data);
        } else {
            $data['id'] = $userId;
            DB::table('users_info')->insert($data);
        }
        return $userId;
    }
}
