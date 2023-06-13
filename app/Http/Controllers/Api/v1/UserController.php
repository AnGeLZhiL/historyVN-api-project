<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Http\Requests\PasswordUserUpdateRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\TestDeleteRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserTestRequest;
use App\Models\Tests;
use App\Models\User;
use App\Http\Requests\LoginUserRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function userTestCreate(UserTestRequest $request){
        $user = User::find(Auth::id());

        if ($user) {
//            UserTest::create(
//                [
//                    "test_id" => $request->test_id,
//                    "user_id" => $request->user_id,
//                    "passed" => $request->passed,
//                    "mark" => $request->mark
//                ]
//            );

            DB::table('user_test')->insert([
                "test_id" => $request->test_id,
                "user_id" => $user->id_user,
                "passed" => $request->passed,
                "mark" => $request->mark
            ]);

            return response()
                ->json([
                    "status" => true
                ],200);
        } else {

            /*
             * Возврат ответа JSON в случает неудачного добавления попытки прохождения теста.
             * Возвращается статус false
             */

            return response()
                ->json([
                    "status" => false
                ],401);
        }
    }

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

    /**
     * Изменение данных пользователя
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function userUpdate(UpdateUserRequest $request){

        /*
         * Поиск пользователя по введенному токену
         */

        $user = User::find(Auth::id());

        if ($user){
            /*
            * Заполнение новыми значениями
            */

            $user->last_name = $request->last_name;
            $user->first_name = $request->first_name;
            $user->midlle_name = $request->midlle_name;
            $user->login = $request->login;
            $user->birthday = $request->birthday;

            /*
             * Сохранение новых данных
             */

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
                    ->setStatusCode(421, "Not update");
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

    public function usersGet(){
        return response()
            ->json(User::with('tests')->get())
            ->setStatusCode(200, "Cities list");
    }

    public function userAdminUpdate(AdminUserUpdateRequest $request){
        /*
         * Поиск пользователя по введенному токену
         */

        $user = User::find($request->id_user);

        if ($user){
            /*
            * Заполнение новыми значениями
            */

            $user->last_name = $request->last_name;
            $user->first_name = $request->first_name;
            $user->midlle_name = $request->midlle_name;
            $user->login = $request->login;
            $user->birthday = $request->birthday;

            /*
             * Сохранение новых данных
             */

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
                    ->setStatusCode(421, "Not update");
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

    public function userPasswordUpdate(PasswordUserUpdateRequest $request){
        /*
         * Поиск пользователя по введенному токену
         */

        $user = User::find(Auth::id());

        if ($user){
            /*
            * Заполнение новыми значениями
            */

            $user->password = $request->password;

            /*
             * Сохранение новых данных
             */

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
                    ->setStatusCode(421, "Not update");
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

    public function userAdminDelete(UserDeleteRequest $request){
        try {
            $user = User::find($request->id_user);

            if ($user){

                $user->delete();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Test delete");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Test not delete");
        }
    }

    public function userDelete(){
        try {
            $user = User::find(Auth::id());

            if ($user){

                $user->delete();

                return response()
                    ->json([
                        "status" => true
                    ])
                    ->setStatusCode(200, "Test delete");
            }
        } catch (Exception $e){
            return response()
                ->json([
                    "status" => false,
                    "error" => $e
                ])
                ->setStatusCode(421, "Test not delete");
        }
    }
}
