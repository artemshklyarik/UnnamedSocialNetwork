<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

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
            ->where('answered', '=', 0)
            ->get();
        return $newQuestions;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function getQuestions($userId)
    {
        $newQuestions = self::latest('answer_time')
            ->where('answer_man', '=', $userId)
            ->where('answered', '=', 1)
            ->get();
        return $newQuestions;
    }

    public static function askQuestion($params)
    {
        DB::table('questions')->insert([
                'question' => $params['question'],
                'question_man' => $params['question_man'],
                'question_time' => Carbon::now(),
                'answer_man' => $params['answer_man']
            ]
        );

        return true;
    }

    public static function answerQuestion($params)
    {
        DB::table('questions')
            ->where('id', $params['idQuestion'])
            ->update([
                'answer' => $params['answer'],
                'answered' => 1,
                'answer_time' => Carbon::now()
            ]);

        return true;
    }
}
