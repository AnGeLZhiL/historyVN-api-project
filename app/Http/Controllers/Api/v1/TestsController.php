<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Tests;
use Illuminate\Http\Request;

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

    public function userTests($id){

    }
}
