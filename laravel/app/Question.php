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
        $newQuestions = DB::table('questions')
            ->join('users', 'users.id', '=', 'questions.question_man')
            ->where('answer_man', '=', $userId)
            ->where('answered', '=', 0)
            ->select('questions.*', 'users.name', 'users.second_name')
            ->get();

        return $newQuestions;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function getQuestions($userId)
    {
        $newQuestions = DB::table('questions')
            ->join('users', 'users.id', '=', 'questions.question_man')
            ->where('answer_man', '=', $userId)
            ->where('answered', '=', 1)
            ->select('questions.*', 'users.name', 'users.second_name')
            ->get();

        return $newQuestions;
    }


    public static function removeItem($itemId, $authUserId)
    {
        $checkQuestions = DB::table('questions')
            ->where('id', '=', $itemId)
            ->where('answer_man', '=', $authUserId)
            ->first();

        if (isset($checkQuestions) && $checkQuestions) {
            if (DB::table('questions')
                ->where('id', '=', $itemId)
                ->where('answer_man', '=', $authUserId)
                ->delete()
            ) {
                return true;
            }
        }

        return false;
    }

    public static function askQuestion($params)
    {
        if (!isset($params['anonimous'])) {
            $params['anonimous'] = 0;
        }

        DB::table('questions')->insert([
                'question' => $params['question'],
                'question_man' => $params['question_man'],
                'question_time' => Carbon::now(),
                'answer_man' => $params['answer_man'],
                'anonimous' => $params['anonimous']
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

    public static function getUserCount($userId)
    {
        $count = 0;

        $count = DB::table('questions')
            ->where('answer_man', $userId)
            ->count();

        return $count;
    }
}
