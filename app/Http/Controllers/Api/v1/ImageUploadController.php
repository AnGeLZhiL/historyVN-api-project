<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Images;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageUploadController extends Controller
{
    public function imageUpload(Request $request){
        $user = User::find(Auth::id());

        if ($user){
            $file_upload = $request->file->store('public/image/');
            $user->image = $file_upload;
            $result = $user->save();

            /*
             * Проверка
             */

            if($result){
                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Update");
            } else {
                return response()
                    ->json([
                        "status" => false
                    ])
                    ->setStatusCode(401, "Not update");
            }
        } else {

            /*
             * Возврат ответа JSON в случает неудачной авторизации.
             * Возвращается статус false
             */

            return response()
                ->json([
                    "status" => false
                ],401);
        }
    }

    public function collectionImageUpload(Request $request){
        try {
            $collection = Collection::find($request->id_collection);

            if ($collection) {
                $image = Images::find($request->image_id);
                if ($image) {
                    $file_upload = $request->image_url->store('public/image/');
                    $image->image_url = $file_upload;
                    $result = $image->save();

                    /*
                     * Проверка
                     */

                    if ($result) {
                        return response()
                            ->json([
                                "status" => true
                            ])
                            ->setStatusCode(200, "Update");
                    } else {
                        return response()
                            ->json([
                                "status" => false
                            ])
                            ->setStatusCode(401, "Not update");
                    }
                } else {

                    /*
                     * Возврат ответа JSON в случает неудачной авторизации.
                     * Возвращается статус false
                     */

                    return response()
                        ->json([
                            "status" => false
                        ], 401);
                }
            } else {

                /*
                 * Возврат ответа JSON в случает неудачной авторизации.
                 * Возвращается статус false
                 */

                return response()
                    ->json([
                        "status" => false
                    ], 401);
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(401, "Not update");
        }
    }
}
