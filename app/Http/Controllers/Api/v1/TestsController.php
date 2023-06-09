<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestAddRequest;
use App\Http\Requests\TestDeleteRequest;
use App\Http\Requests\TestObjectAddRequest;
use App\Http\Requests\TestObjectDeleteRequest;
use App\Http\Requests\TestObjectUpdateRequest;
use App\Http\Requests\TestUpdateRequest;
use App\Models\Tests;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestsController extends Controller
{
    public function getTests($id){

        $tests = Tests::where('id_test', $id)->get();

        return response()
            ->json($tests)
            ->setStatusCode(200, 'Tests list');
    }

//    public function testsObject(){
//        $tests = Tests::with('objects')->get();
//
//        return response()
//            ->json($tests)
//            ->setStatusCode(200, 'Tests list');
//    }

    public function getTest($id){
        $test = Tests::with('questions')->where('id_test', $id)->get();

        return response()
            ->json($test)
            ->setStatusCode(200, 'Test Information');
    }

    public function testAdd(TestAddRequest $request){
        try {
            $test = Tests::create([
                "name" => $request->name,
                "category_id" => $request->category_id
            ]);
            return response()
                ->json(["status" => true, "id" => $test->id_test])
                ->setStatusCode(200, "Add object");
        } catch (Exception $e) {
            return response()
                ->json(["status" => false, "error" => $e])
                ->setStatusCode(421, "Object not add");
        }
    }

    public function testUpdate(TestUpdateRequest $request){
        try {
            $test = Tests::find($request->id_test);
            if ($test){
                /*
                * Заполнение новыми значениями
                */

                $test->name = $request->name;
                $test->category_id = $request->category_id;

                /*
                 * Сохранение новых данных
                 */

                $test->save();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Test update");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Test not update");
        }
    }

    public function testDelete(TestDeleteRequest $request){
        try {
            $test = Tests::find($request->id_test);

            if ($test){

                $test->delete();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Test delete");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Test not delete");
        }
    }

    public function testObjectAdd(TestObjectAddRequest $request){
        try {
            $test = Tests::create([
                "name" => $request->name,
                "category_id" => $request->category_id
            ]);

            DB::table('object_test')->insert([
                "test_id" => $test->id_test,
                "object_id" => $request->object_id
            ]);

            return response()
                ->json(["status" => true, "id" => $test->id_test])
                ->setStatusCode(200, "Add object");
        } catch (Exception $e) {
            return response()
                ->json(["status" => false, "error" => $e])
                ->setStatusCode(421, "Object not add");
        }
    }
}
