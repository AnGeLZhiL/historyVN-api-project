<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Tests;
use App\Models\User;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Регистрация пользователя через API
     * @param RegisterUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request){
        /*
         * Добавление пользователя в БД
         */

        User::create(
            [
                "last_name" => $request->last_name,
                "first_name" => $request->first_name,
                "midlle_name" => $request->midlle_name,
                "login" => $request->login,
                "password" => $request->password,
            ]
        );

        /*
         * Возврат ответа JSON
         */

        return response()
            ->json(["status" => true])
            ->setStatusCode(201, "Accout registered");
    }

    /**
     * Авторизация пользователя через API
     * @param LoginUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(LoginUserRequest $request){

        /*
         * Поиск пользователя с заданным логином
         */

        $user = User::where('login', $request->login)->first();

        /*
         * Проверка на существование пользователя с заданным логином
         * Проверка на соответствие паролей
         */

        if ($user && Hash::check($request->password, $user->password)){

            /*
             * Формирование токена для авторизирующегося ползователя
             */
            $user->api_token = Str::random(200);
            $user->save();

            /*
             * Возврат ответа JSON в случает успешной авторизации.
             * Возвращается статус true и данные авторизированного пользователя
             */

            return response()
                ->json([
                    "status" => true,
                    "user" => $user
                ])
                ->setStatusCode(200, "Authenticated");
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

    public function userTests(){
        $usertests = User::with('tests')->findOrFail(Auth::id());

        return response()
            ->json($usertests->tests)
            ->setStatusCode(200, 'Object information');
    }

    public function getUser(){
        $user = User::where('id_user', Auth::id())->get();
        return response()
            ->json($user)
            ->setStatusCode(200, 'User informations');
    }
}
