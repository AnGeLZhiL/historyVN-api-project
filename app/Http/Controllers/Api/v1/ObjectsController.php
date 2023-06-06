<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ObjectAddRequest;
use App\Http\Requests\ObjectDeleteRequest;
use App\Http\Requests\ObjectUpdateRequest;
use App\Models\Images;
use App\Models\Objects;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function objectUpdate(ObjectUpdateRequest $request){
        try {
            $object = Objects::find($request->id_object);
            if ($object){
                /*
                * Заполнение новыми значениями
                */

                $object->name = $request->name;
                $object->category_id = $request->category_id;
                $object->year = $request->year;
                $object->location = $request->location;
                $object->description = $request->description;
                $object->map_marker = $request->map_marker;

                /*
                 * Сохранение новых данных
                 */

                $object->save();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Object update");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Object not update");
        }
    }

    public function objectDelete(ObjectDeleteRequest $request){
        try {
            $object = Objects::find($request->id_object);

            if ($object){

                $object->delete();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Object delete");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Object not delete");
        }
    }

    public function objectAddImage(Request $request){
        try{
            $file_upload = $request->image_url->store('public/image/');
            $image = Images::create([
                "image_url" => $file_upload
            ]);

            DB::table('object_image')->insert([
                "image_id" => $image->id_image,
                "object_id" => $request->id_object
            ]);

            return response()
                ->json([
                    "status" => true
                ])
                ->setStatusCode(200, "Object image add");
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Object image not add");
        }
    }

    public function objectDeleteImage(Request $request){
        try{
            $image = Images::find($request->image_id);
            if($image){
                DB::table('object_image')->where('image_id', $request->image_id)->delete();

                $image->delete();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Object image delete");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Object image not delete");
        }
    }
}
