<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityAddRequest;
use App\Http\Requests\CityDeleteRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Models\City;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitiesController extends Controller
{
    /**
     * Вывод списка городов из БД
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAll(){

        /*
         * Возврат полного списка городов
         */

        return response()
            ->json(City::with('images')->get())
            ->setStatusCode(200, "Cities list");
    }

    /**
     * Добавление города администратором
     * @param CityAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function cityAdd(CityAddRequest $request){
        try {
            DB::table('cities')->insert([
                "name" => $request->name
            ]);

            return response()
                ->json(["status" => true])
                ->setStatusCode(200, "City add");
        } catch (Exception $e){
            return response()
                ->json(["status" => false])
                ->setStatusCode(421, "Not add city");
        }
    }

    /**
     * Обновление города по указанному id
     * @param CityUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */

    public function cityUpdate(CityUpdateRequest $request){
        try {
            $city = City::find($request->id_city);

            if ($city){
                /*
                * Заполнение новыми значениями
                */

                $city->name = $request->name;

                /*
                 * Сохранение новых данных
                 */

                $city->save();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "City update");
            }
        } catch (Exception $e){
            return response()
                ->json(["status" => false])
                ->setStatusCode(421, "City not update");
        }
    }

    public function cityDelete(CityDeleteRequest $request){
        try {
            $city = City::find($request->id_city);

            if ($city){

                $city->delete();

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
