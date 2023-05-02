<?php

use App\Http\Controllers\Api\v1\CategoriesController;
use App\Http\Controllers\Api\v1\CitiesController;
use App\Http\Controllers\Api\v1\CollectionsController;
use App\Http\Controllers\Api\v1\ObjectsController;
use App\Http\Controllers\Api\v1\QuestionsController;
use App\Http\Controllers\Api\v1\TestsController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 * User Routes
 */

Route::post('/register', [UserController::class, 'register']); //Register
Route::post('/login', [UserController::class, 'login']); //Login
//Route::group(['middleware' => ['auth:api']], function (){
//    Route::get('/testsuser', [UserController::class, 'userTests']);
//});

//Route::middleware('auth:sanctum')->group(function (){
//    Route::get('/testsuser', [UserController::class, 'userTests']);
//});

Route::middleware('auth:api')->get('/testsuser', [UserController::class, 'userTests']);

//Route::middleware('auth')->get('/testsuser', [UserController::class, 'userTests']);

/*
 * Collection Routers
 */

Route::get('/collections/{id?}', [CollectionsController::class, 'getAll']);

/*
 * Cities Routers
 */

Route::get('/cities', [CitiesController::class, 'getAll']);

/*
 * Categories Routers
 */
Route::get('/categories/{id?}', [CategoriesController::class, 'getAll']);

/*
 * Objects Routers
 */

Route::get('/objects/{id}',[ObjectsController::class, 'getObjects']);
Route::get('/object/{id}',[ObjectsController::class, 'getObject']);

/*
 * Tests Routers
 */
Route::get('/testscat/{id}', [TestsController::class, 'getTests']);
Route::get('/test/{id}', [TestsController::class, 'getTest']);

/*
 * Question Routers
 */

Route::get('/questions/{id}', [QuestionsController::class, 'getQuestions']);
Route::get('/answers/{id}', [QuestionsController::class, 'getAnswers']);
