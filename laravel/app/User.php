<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use Carbon\Carbon;
use App\Geo;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'second_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param $id
     * @param $avatarLink
     */
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

    /**
     * @param $userId
     * @return array
     */
    public static function getUserInfo($userId)
    {
        $userInfo = array();

        //get general info
        $select = DB::table('users')
            ->where('id', $userId)
            ->first();

        $userInfo['id'] = $userId;
        $userInfo['name'] = $select->name;
        $userInfo['second_name'] = $select->second_name;

        //get User avatar link
        $select = DB::table('users_info')
            ->where('id', $userId)
            ->first();

        if ($select) {
            $imageMediumUrl = asset('uploads/medium/' . $select->avatar_link);
            $imageSmallUrl = asset('uploads/small/' . $select->avatar_link);
            $imageOriginalUrl = asset('uploads/original/' . $select->avatar_link);

            if (file_exists('uploads/medium/' . $select->avatar_link) && $select->avatar_link != '') {
                $userInfo['avatarLink'] = $imageMediumUrl;
                $userInfo['avatarLinkSmall'] = $imageSmallUrl;
                $userInfo['avatarLinkOriginal'] = $imageOriginalUrl;
            } else {
                $userInfo['avatarLink'] = asset('assets/img/defaultAvatar.jpg');
                $userInfo['avatarLinkSmall'] = asset('assets/img/defaultAvatar.jpg');
                $userInfo['avatarLinkOriginal'] = asset('assets/img/defaultAvatar.jpg');
            }

            $userInfo['gender'] = '';
            if ($select->gender != 'hide') {
                $userInfo['gender'] = $select->gender;
            }

            $userInfo['date_of_birthday'] = $select->date_of_birthday;
            $userInfo['status'] = $select->status;

            if ($select->thumbnail) {
                $userInfo['thumbnail'] = unserialize($select->thumbnail);
            } else {
                $userInfo['thumbnail']['offsetX'] = 0;
                $userInfo['thumbnail']['offsetY'] = 0;
                $userInfo['thumbnail']['sizeX'] = 100;
                $userInfo['thumbnail']['sizeY'] = 100;
            }

            $userInfo['country']['id'] = $select->country_id;
            $userInfo['city']['id'] = $select->city_id;

            if ($userInfo['country']['id']) {
                $userInfo['country']['name'] = Geo::getCountryNameById($userInfo['country']['id']);
            } else {
                $userInfo['country']['name'] = '';
            }

            if ($userInfo['city']['id']) {
                $userInfo['city']['name'] = Geo::getCityNameById($userInfo['city']['id']);
            } else {
                $userInfo['city']['name'] = '';
            }

        } else {
            $userInfo['avatarLink'] = asset('assets/img/defaultAvatar.jpg');
            $userInfo['avatarLinkSmall'] = asset('assets/img/defaultAvatar.jpg');
            $userInfo['avatarLinkOriginal'] = asset('assets/img/defaultAvatar.jpg');
            $userInfo['gender'] = '';
            $userInfo['date_of_birthday'] = '';
            $userInfo['status'] = '';
            $userInfo['thumbnail'] = '';
            $userInfo['thumbnail']['offsetX'] = 0;
            $userInfo['thumbnail']['offsetY'] = 0;
            $userInfo['thumbnail']['sizeX'] = 100;
            $userInfo['thumbnail']['sizeY'] = 100;
            $userInfo['country'] = 0;
            $userInfo['city'] = 0;

        }

        return $userInfo;
    }

    /**
     * @param null $ownerId
     * @return array
     */
    public static function getAllUsersIdsArray($ownerId = null)
    {
        $usersIds = array();
        $users = DB::table('users')
            ->select('id');

        if ($ownerId) {
            $users = $users
                ->where('id', '<>', $ownerId);
        }

        $users = $users->get();

        foreach ($users as $user) {
            $usersIds[] = $user->id;
        }

        return $usersIds;
    }

    /**
     * @param $usersIds
     * @param null $limit
     * @param null $offset
     * @param null $filters
     * @param null $q
     * @return mixed
     */
    public static function getCustomUsersInfo($usersIds, $limit = null, $offset = null, $filters = null, $q = null)
    {
        $users = DB::table('users')
            ->leftJoin('users_info', 'users.id', '=', 'users_info.id')
            ->whereIn('users.id', $usersIds);

        if ($filters) {
            foreach ($filters as $key => $value) {
                $users = $users->where('users_info.' . $key, '=', $value);
            }
        }

        //string search
        if ($q) {

            $q = explode(' ', $q);

            if (count($q) == 1) {
                $users = $users->where(function ($users) use ($q) {
                    $users->where('users.name', 'like', $q[0] . '%')
                        ->orWhere('users.second_name', 'like', $q[0] . '%');
                });
            } else if (count($q) == 2) {
                $users = $users->where(function ($users) use ($q) {
                    $users = $users->where(function ($users) use ($q) {
                        $users->where('users.name', 'like', $q[0] . '%')
                            ->where('users.second_name', 'like', $q[1] . '%');
                    });

                    $users = $users->orWhere(function ($users) use ($q) {
                        $users->where('users.name', 'like', $q[1] . '%')
                            ->where('users.second_name', 'like', $q[0] . '%');
                    });
                });
            } else {
                return false;
            }
        }

        $users = $users->select('users_info.*', 'users.id', 'users.name', 'users.second_name');

        if ($limit) {
            $users = $users->offset($offset)
                ->limit($limit);
        }

        $users = $users->get();

        if ($users) {
            foreach ($users as &$user) {

                if ($user->avatar_link && file_exists('uploads/medium/' . $user->avatar_link)) {
                    $user->smallAvatarLink = asset('uploads/small/' . $user->avatar_link);
                    $user->mediumAvatarLink = asset('uploads/medium/' . $user->avatar_link);
                    $user->avatarLink = asset('uploads/original/' . $user->avatar_link);
                } else {
                    $user->smallAvatarLink = asset('assets/img/defaultAvatar.jpg');
                    $user->mediumAvatarLink = asset('assets/img/defaultAvatar.jpg');
                    $user->avatarLink = asset('assets/img/defaultAvatar.jpg');
                }

                if ($user->thumbnail) {
                    $user->thumbnail = unserialize($user->thumbnail);
                } else {
                    $user->thumbnail['sizeX'] = '100';
                    $user->thumbnail['sizeY'] = '100';
                    $user->thumbnail['offsetX'] = '0';
                    $user->thumbnail['offsetY'] = '0';
                }

                if ($user->date_of_birthday) {
                    $born = Carbon::parse($user->date_of_birthday);
                    $age = $born->diff(Carbon::now())->format('%y years');

                    $user->age = $age;
                } else {
                    $user->age = '';
                }

                if ($user->country_id) {
                    $user->geo->country['id']   = $user->country_id;
                    $user->geo->country['name'] = Geo::getCountryNameById($user->country_id);

                    if ($user->city_id) {
                        $user->geo->city['id']   = $user->city_id;
                        $user->geo->city['name'] = Geo::getCityNameById($user->city_id);
                    }
                }

                foreach ($user as $key => $value) {
                    if (!$value) {
                        $user->$key = '';
                    }
                }
            }
        }

        return $users;
    }

    /**
     * @param $userId
     * @return bool
     */
    public static function deletePreviewPhoto($userId)
    {
        $select = DB::table('users_info')
            ->where('id', $userId)
            ->first();

        if ($select && $select->avatar_link) {
            $originalImage = 'uploads/original/' . $select->avatar_link;
            $smallImage = 'uploads/small/' . $select->avatar_link;
            $mediumImage = 'uploads/medium/' . $select->avatar_link;

            if (file_exists($originalImage)) {
                unlink($originalImage);
            }

            if (file_exists($smallImage)) {
                unlink($smallImage);
            }

            if (file_exists($mediumImage)) {
                unlink($mediumImage);
            }

            return true;
        }

        return false;
    }

    /**
     * @param $userId
     * @param $data
     * @return mixed
     */
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

    /**
     * @param $userId
     * @param $params
     * @return null
     */
    public static function changeThumbnail($userId, $params)
    {
        $findUserInfo = DB::table('users_info')
            ->where('id', $userId)
            ->first();

        if ($findUserInfo) {
            DB::table('users_info')
                ->where('id', $userId)
                ->update(['thumbnail' => serialize($params)]);
        } else {
            DB::table('users_info')->insert(
                ['id' => $userId, 'thumbnail' => serialize($params)]
            );
        }

        return null;
    }
}
