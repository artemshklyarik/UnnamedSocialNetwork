<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;


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

    public static function getAvatarLink($userId)
    {
        $select = DB::table('users_info')
            ->where('id', $userId)
            ->first();

        if ($select) {
            return $select->avatar_link;
        } else {
            return asset('assets/img/defaultAvatar.jpg');
        }
    }
}
