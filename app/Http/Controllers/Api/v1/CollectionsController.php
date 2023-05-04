<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;

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
}
