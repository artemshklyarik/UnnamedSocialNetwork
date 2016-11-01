<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Filter extends Model
{
    /**
     * @param $query
     * @return mixed
     */
    public static function nameFilter($query, $q)
    {


        return $query;
    }
}
