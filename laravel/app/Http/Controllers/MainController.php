<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use App\Question;
use App\Photos;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Session;
use App\Friend;

class MainController extends Controller
{
    public function __construct()
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->user()) {
            $userId = $request->user()->id;
            $newQuestions = Question::getNewQuestions($userId);
            $questions = Question::getQuestions($userId);
            $userInfo = User::getUserInfo($userId);
            $friendsCount = Friend::getUserFriendsCount($userId);

            return view('user/profile', [
                'newQuestions' => $newQuestions,
                'questions' => $questions,
                'userInfo' => $userInfo,
                'authUserInfo' => $userInfo,
                'friendsCount' => $friendsCount
            ]);
        } else {
            return view('auth.auth');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile(Request $request, $id)
    {
        $userId = $request->user()->id;
        $newQuestions = Question::getNewQuestions($userId);
        $questions = Question::getQuestions($id);
        $userInfo = User::getUserInfo($id);
        $authUserInfo = User::getUserInfo($userId);
        $isfriend = Friend::isfriend($request->user()->id, $id);
        $friends = Friend::getUserFriends($id);
        $friendsCount = Friend::getUserFriendsCount($request->user()->id, $id);

        return view('user/profile', [
            'id' => $id,
            'newQuestions' => $newQuestions,
            'questions' => $questions,
            'userInfo' => $userInfo,
            'authUserInfo' => $authUserInfo,
            'isfriend' => $isfriend,
            'friendsCount' => $friendsCount
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProfile(Request $request)
    {
        $userId = $request->user()->id;
        $userInfo = User::getUserInfo($userId);
        $friends = Friend::getUserFriends($userId);
        $friendsCount = Friend::getUserFriendsCount($userId);

        return view('user/editProfile', [
            'userInfo' => $userInfo,
            'authUserInfo' => $userInfo,
            'friends' => $friends,
            'friendsCount' => $friendsCount
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function uploadPhoto(Request $request)
    {
        $file = array('image' => Input::file('photo'));
        // setting up rules
        $rules = array('image' => 'required'); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return Redirect::to('edit_profile')->withInput()->withErrors($validator);
        } else {
            // checking file is valid.
            if (Input::file('photo')->isValid()) {
                $destinationPath = 'uploads/original'; // upload path
                $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
                // sending back with message
                Session::flash('success', 'Upload successfully');

                $userId = $request->user()->id;
                $avatarLink = $fileName;
                User::deletePreviewPhoto($userId);
                User::changePhoto($userId, $avatarLink);
                Photos::createAllPhotos($fileName);
                return Redirect::to('edit_profile');
            } else {
                // sending back with error message.
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('edit_profile');
            }
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function editUserInfo(Request $request)
    {
        $data = Input::all();
        $userId = $request->user()->id;
        User::saveUserInfo($userId, $data);

        return Redirect::to('edit_profile');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function editGeneralUserInfo(Request $request)
    {
        $data = Input::all();
        $userId = $request->user()->id;
        $user = User::find($userId);
        $user->name = $data['name'];
        $user->second_name = $data['second_name'];
        $user->save();

        return Redirect::to('edit_profile');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeQuestion(Request $request)
    {
        $itemId = $request->requestId;
        $authUserId = $request->user()->id;

        if (Question::removeItem($itemId, $authUserId)) {
            $response = [
                'status' => true
            ];
        } else {
            $response = [
                'status' => false
            ];
        }

        return response()->json($response);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function askQuestion(Request $request, $id)
    {
        $validator = Validator::make(
            ['question' => $request->question],
            ['question' => 'required']
        );

        if ($validator->fails()) {
            return redirect()->route('user', ['id' => $id])->withInput()->withErrors($validator);
        }

        $fromId = $request->user()->id;

        Question::askQuestion([
            'question' => $request->question,
            'question_man' => $fromId,
            'answer_man' => $id,
            'anonimous' => $request->anonimous
        ]);

        Session::flash('success', 'Question successfully');

        return redirect()->route('user', ['id' => $id]);
    }

    /**
     * @param Request $request
     * @param $idQuestion
     * @return Redirect
     */
    public function answerQuestion(Request $request, $idQuestion)
    {
        $validator = Validator::make(
            ['answer' => $request->answer],
            ['answer' => 'required']
        );

        if ($validator->fails()) {
            return redirect()->route('main')->withInput()->withErrors($validator);
        }

        Question::answerQuestion([
            'idQuestion' => $idQuestion,
            'answer' => $request->answer
        ]);

        Session::flash('success', 'Answer successfully');

        return redirect('/');
    }

    /**
     * @param Request $request
     * @return null
     */
    public function saveThumbnailAjax(Request $request)
    {
        $userId = $request->user()->id;
        $sizeX = $request->sizeX;
        $sizeY = $request->sizeY;
        $offsetX = $request->offsetX;
        $offsetY = $request->offsetY;

        $params = array();

        $params['sizeX'] = $sizeX;
        $params['sizeY'] = $sizeY;
        $params['offsetX'] = $offsetX;
        $params['offsetY'] = $offsetY;

        User::changeThumbnail($userId, $params);

        return null;
    }
}
