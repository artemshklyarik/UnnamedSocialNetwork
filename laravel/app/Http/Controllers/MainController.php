<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use App\Question;
use Carbon\Carbon;
use DB;

class MainController extends Controller
{
    public function __construct()
    {

    }
    public function index(Request $request)
    {
        if ($request->user()) {
            $users        = User::all();
            $userId       = $request->user()->id;
            $newQuestions = $this->getNewQuestions($userId);
            $questions    = $this->getQuestions($userId);

            return view('profile', [
                'users'        => $users,
                'newQuestions' => $newQuestions,
                'Questions'    => $questions
            ]);
        } else {
            return view('auth.auth');
        }
    }

    public function showProfile(Request $request, $id)
    {
        $users = User::all();
        $userId = $request->user()->id;
        $newQuestions = $this->getNewQuestions($userId);
        $questions    = $this->getQuestions($id);

        return view('profile', [
            'users'    => $users,
            'id'       => $id,
            'newQuestions' => $newQuestions,
            'Questions'    => $questions
        ]);
    }

    public function getNewQuestions($userId)
    {
        $newQuestions = Question::latest('question_man')
            ->where('answer_man', '=', $userId)
            ->where('answered',   '=', 0)
            ->get();
        return $newQuestions;
    }

    public function getQuestions($userId)
    {
        $newQuestions = Question::latest('question_man')
            ->where('answer_man', '=', $userId)
            ->where('answered',   '=', 1)
            ->get();
        return $newQuestions;
    }

    public function editProfile(Request $request)
    {
        return 'edit page';
    }

    public function askQuestion(Request $request, $id)
    {
        $fromId = $request->user()->id;

        DB::table('questions')->insert([
                'question'      => $request->question,
                'question_man'  => $fromId,
                'question_time' => Carbon::now(),
                'answer_man'    => $id
            ]
        );

        return redirect()->route('user', ['id' => $id]);
    }

    public function answerQuestion(Request $request, $idQuestion)
    {
        DB::table('questions')
            ->where('id', $idQuestion)
            ->update([
                'answer' => $request->answer,
                'answered' => 1,
                'answer_time' => Carbon::now()
            ]);

        return redirect('/');
    }
}
