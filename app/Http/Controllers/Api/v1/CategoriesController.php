<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryAddRequest;
use App\Http\Requests\CategoryDeleteRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Images;
use Exception;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getAll($id=null){

        /*
         * Поиск категорий по заданому id сборника
         */

        $collections = Category::with('images')->where('collection_id', $id)->get();

        /*
         * При указанном id после / возвращается список категорий определенного сборника
         * При не указанном id после / возвращается список всех категорий из БД
         */

        return response()
            ->json($id?$collections:Category::with('images')->get())
            ->setStatusCode(200, "Categories list");
    }

    public function categoryAdd(CategoryAddRequest $request){
        try {
            $file_upload = $request->image_url->store('public/image/');

            $image = Images::create([
                "image_url" => $file_upload
            ]);

            $category = Category::create([
                "name" => $request->name,
                "collection_id" => $request->collection_id,
                "image_id" => $image->id_image
            ]);

            return response()
                ->json(["status" => true, "id" => $category->id_category])
                ->setStatusCode(200, "Add category");
        } catch (Exception $e){
            return response()
                ->json(["status" => false, "error" => $e])
                ->setStatusCode(421, "Not add category");
        }
    }

    public function categoryUpdate(CategoryUpdateRequest $request){
        try {
            $category = Category::find($request->id_category);
            if ($category){
                /*
                * Заполнение новыми значениями
                */

                $category->name = $request->name;
                $category->collection_id = $request->collection_id;

                /*
                 * Сохранение новых данных
                 */

                $category->save();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Category update");
            }
        } catch (Exception $e){
            return response()
                ->json(["status" => false, "error" => $e])
                ->setStatusCode(421, "Category not update");
        }
    }

    public function categoryDelete(CategoryDeleteRequest $request){
        try {
            $category = Category::find($request->id_category);

            if ($category){

                $category->delete();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Category delete");
            }
        } catch (Exception $e){
            return response()
                ->json(["status" => false])
                ->setStatusCode(421, "Category not delete");
        }
    }
}
