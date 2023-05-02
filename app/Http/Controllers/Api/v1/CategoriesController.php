<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getAll($id=null){

        /*
         * Поиск категорий по заданому id сборника
         */

        $collections = Category::where('collection_id', $id)->get();

        /*
         * При указанном id после / возвращается список категорий определенного сборника
         * При не указанном id после / возвращается список всех категорий из БД
         */

        return response()
            ->json($id?$collections:Category::all())
            ->setStatusCode(200, "Categories list");
    }
}
