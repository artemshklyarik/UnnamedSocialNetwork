<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Geo extends Model
{
    public static function getCountryNameById($id)
    {
        $country = DB::table('country')
            ->where('Code', '=', $id)
            ->first();

        return $country->Name;
    }

    public static function getCityNameById($id)
    {
        $city = DB::table('city')
            ->where('id', '=', $id)
            ->first();

        return $city->Name;
    }

    public static function getAllCountries()
    {
        $countries = DB::table('country')
            ->orderBy('Name', 'asc')
            ->get();

        return $countries;
    }

    public static function getCitiesByCountyId($countryId)
    {
        $cities = DB::table('city')
            ->where('CountryCode', '=', $countryId)
            ->orderBy('Population', 'desc')
//            ->orderBy('Name', 'asc')
            ->get();

        return $cities;
    }
}
