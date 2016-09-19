<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * @param $userId
     * @return mixed
     */
    public static function getNewQuestions($userId)
    {
        $newQuestions = self::latest('question_time')
            ->where('answer_man', '=', $userId)
            ->where('answered',   '=', 0)
            ->get();
        return $newQuestions;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function getQuestions($userId)
    {
        $newQuestions = self::latest('question_time')
            ->where('answer_man', '=', $userId)
            ->where('answered',   '=', 1)
            ->get();
        return $newQuestions;
    }
}
