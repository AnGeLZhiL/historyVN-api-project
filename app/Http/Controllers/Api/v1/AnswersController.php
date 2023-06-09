<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerAddRequest;
use App\Http\Requests\AnswerDeleteRequest;
use App\Http\Requests\AnswerUpdateRequest;
use App\Models\Answers;
use Exception;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function answerAdd(AnswerAddRequest $request){
        try {
            $answers = Answers::create([
                "text_answer" => $request->text_answer,
                "question_id" => $request->question_id,
                "correctness" => $request->correctness
            ]);
            return response()
                ->json(["status" => true, "id" => $answers->id_answer])
                ->setStatusCode(200, "Add object");
        } catch (Exception $e) {
            return response()
                ->json(["status" => false, "error" => $e])
                ->setStatusCode(421, "Object not add");
        }
    }

    public function answerUpdate(AnswerUpdateRequest $request){
        try {
            $answers = Answers::find($request->id_answer);
            if ($answers){
                /*
                * Заполнение новыми значениями
                */

                $answers->text_answer = $request->text_answer;
                $answers->correctness = $request->correctness;

                /*
                 * Сохранение новых данных
                 */

                $answers->save();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Answer update");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Answer not update");
        }
    }

    public function answerDelete(AnswerDeleteRequest $request){
        try {
            $answers = Answers::find($request->id_answer);

            if ($answers){

                $answers->delete();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Answer delete");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Answer not delete");
        }
    }
}
