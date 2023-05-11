<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\Questions;
use App\Models\Tests;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function getQuestions($id){

        $questions = Questions::with('answers')->where('test_id', $id)->get();

        return response()
            ->json($questions)
            ->setStatusCode(200, 'Questions list');
    }

    public function getAnswers($id){

        $answers = Questions::with('answers')->findOrFail($id);

        return response()
            ->json($answers->answers)
            ->setStatusCode(200, 'Tests list');
    }
}
