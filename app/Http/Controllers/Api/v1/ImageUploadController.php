<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageUploadController extends Controller
{
    public function imageUpload(Request $request){
        $user = User::find(Auth::id());

        if ($user){
            $file_upload = $request->file->store('app/public/image/');
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
}
