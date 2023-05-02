<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

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
            ->json(City::all())
            ->setStatusCode(200, "Cities list");
    }
}
