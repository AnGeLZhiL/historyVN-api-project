<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionAddRequest;
use App\Http\Requests\QuestionDeleteRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Models\Answers;
use App\Models\Questions;
use App\Models\Tests;
use Exception;
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

    public function questionAdd(QuestionAddRequest $request){
        try {
            $question = Questions::create([
                "text_question" => $request->text_question,
                "test_id" => $request->test_id
            ]);
            return response()
                ->json(["status" => true, "id" => $question->id_question])
                ->setStatusCode(200, "Add object");
        } catch (Exception $e) {
            return response()
                ->json(["status" => false, "error" => $e])
                ->setStatusCode(421, "Object not add");
        }
    }

    public function questiontUpdate(QuestionUpdateRequest $request){
        try {
            $question = Questions::find($request->id_question);
            if ($question){
                /*
                * Заполнение новыми значениями
                */

                $question->text_question = $request->text_question;

                /*
                 * Сохранение новых данных
                 */

                $question->save();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Question update");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Question not update");
        }
    }

    public function questionDelete(QuestionDeleteRequest $request){
        try {
            $question = Questions::find($request->id_question);

            if ($question){

                $question->delete();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Question delete");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Question not delete");
        }
    }
}
