<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionAddRequest;
use App\Http\Requests\CollectionDeleteRequest;
use App\Http\Requests\CollectionUpdateRequest;
use App\Models\City;
use App\Models\Collection;
use App\Models\Images;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionsController extends Controller
{
    /**
     * Вывод сборников определенного города по его id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAll($id=null){

        /*
         * Поиск сборников по заданому id города
         */

        $collections = Collection::with('images')->where('city_id', $id)->get();

        /*
         * При указанном id после / возвращается список сборников определенного города
         * При не указанном id после / возвращается список все сборников из БД
         */

        return response()
            ->json($id?$collections:Collection::with('images')->get())
            ->setStatusCode(200, "Collections list");
//        return response()
//            ->json($id?Collection::find($id):Collection::all())
//            ->setStatusCode(200, "Collections list");
    }

    public function collectionAdd(CollectionAddRequest $request){
        try {
//            $image = DB::table('images')->insertGetId([
//                "image_url" => $request->image_url
//            ]);
//            return response()
//                ->json(["status" => true, "id" => $image])
//                ->setStatusCode(200, "Add collection");
//            $image = DB::table('images')->insert([
//                "image_url" => $request->image_url
//            ]);
            $file_upload = $request->image_url->store('public/image/');

            $image = Images::create([
                "image_url" => $file_upload
            ]);

            $collection = Collection::create([
                "name" => $request->name,
                "city_id" => $request->city_id,
                "image_id" => $image->id_image
            ]);

            return response()
                ->json(["status" => true, "id" => $collection->id_collection])
                ->setStatusCode(200, "Add collection");
        } catch (Exception $e) {
            return response()
                ->json(["status" => false, "error" => $e])
                ->setStatusCode(421, "Not add collection");
        }
    }

    public function collectionUpdate(CollectionUpdateRequest $request){
        try {
            $collection = Collection::find($request->id_collection);
            if ($collection){
                /*
                * Заполнение новыми значениями
                */

                $collection->name = $request->name;
                $collection->city_id = $request->city_id;

                /*
                 * Сохранение новых данных
                 */

                $collection->save();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Collection update");
            }
        } catch (Exception $e){
            return response()
                ->json(["status" => false])
                ->setStatusCode(421, "Collection not update");
        }
    }

    public function collectionDelete(CollectionDeleteRequest $request){
        try {
            $collection = Collection::find($request->id_collection);

            if ($collection){

                $collection->delete();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "City delete");
            }
        } catch (Exception $e){
            return response()
                ->json(["status" => false])
                ->setStatusCode(421, "City not delete");
        }
    }
}
