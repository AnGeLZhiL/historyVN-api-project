<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ObjectAddRequest;
use App\Models\Objects;
use Exception;
use Illuminate\Http\Request;

class ObjectsController extends Controller
{
    /**
     * Вывод объектов определенной категории по её id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function getObjects($id){

        /*
         * Получение списка объектов по заданому id каталога
         */

        $objects = Objects::with('images')->where('category_id', $id)->get();

        /*
         * Возвращает список объектов
         */

        return response()
            ->json($objects)
            ->setStatusCode(200, 'Objects list');

    }

    /**
     * Вывод объектов определенной категории по её id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function getObject($id){

        /*
         * Получение списка объектов по заданому id каталога
         */

        $object = Objects::with('tests' ,'images')->findOrFail($id);

        /*
         * Возвращает список объектов
         */

        return response()
            ->json($object)
            ->setStatusCode(200, 'Object information');

    }
//
//    public function testsObject(){
//        $tests = Objects::with('tests')->get();
//
//        return response()
//            ->json($tests)
//            ->setStatusCode(200, 'Tests list');
//    }

    public function objectAdd(ObjectAddRequest $request){
        try {
            $object = Objects::create([
                "name" => $request->name,
                "category_id" => $request->category_id,
                "year" => $request->year,
                "location" => $request->location,
                "description" => $request->description,
                "map_marker" => $request->map_marker
            ]);
            return response()
                ->json(["status" => true, "id" => $object->id_object])
                ->setStatusCode(200, "Add object");
        } catch (Exception $e) {
            return response()
                ->json(["status" => false, "error" => $e])
                ->setStatusCode(421, "Object not add");
        }
    }
}
