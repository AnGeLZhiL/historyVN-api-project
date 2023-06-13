<?php

use App\Http\Controllers\Api\v1\AnswersController;
use App\Http\Controllers\Api\v1\CategoriesController;
use App\Http\Controllers\Api\v1\CitiesController;
use App\Http\Controllers\Api\v1\CollectionsController;
use App\Http\Controllers\Api\v1\ImageUploadController;
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
Route::middleware('auth:api')->get('/user', [UserController::class, 'getUser']);
Route::middleware('auth:api')->put('/user-update', [UserController::class, 'userUpdate']);
Route::middleware('auth:api')->post('/user-test', [UserController::class, 'userTestCreate']);
// Admin panel
Route::middleware('auth:api')->get('/users', [UserController::class, 'usersGet']);
Route::middleware('auth:api')->put('/admin-user-update', [UserController::class, 'userAdminUpdate']);
Route::middleware('auth:api')->put('/password-update', [UserController::class, 'userPasswordUpdate']);
Route::middleware('auth:api')->post('/admin-user-delete', [UserController::class, 'userAdminDelete']);
Route::middleware('auth:api')->post('/user-delete', [UserController::class, 'userDelete']);

//Route::middleware('auth')->get('/testsuser', [UserController::class, 'userTests']);

/*
 * Collection Routers
 */

Route::get('/collections/{id?}', [CollectionsController::class, 'getAll']);
// Admin panel
Route::middleware('auth:api')->post('/collection-add', [CollectionsController::class, 'collectionAdd']);
Route::middleware('auth:api')->post('/collection-update', [CollectionsController::class, 'collectionUpdate']);
Route::middleware('auth:api')->post('/collection-update-image', [ImageUploadController::class, 'collectionImageUpload']);
Route::middleware('auth:api')->post('/collection-delete', [CollectionsController::class, 'collectionDelete']);
/*
 * Cities Routers
 */

Route::get('/cities', [CitiesController::class, 'getAll']);
// Admin panel
Route::middleware('auth:api')->post('/city-add', [CitiesController::class, 'cityAdd']);
Route::middleware('auth:api')->post('/city-update', [CitiesController::class, 'cityUpdate']);
Route::middleware('auth:api')->post('/city-delete', [CitiesController::class, 'cityDelete']);

/*
 * Categories Routers
 */
Route::get('/categories/{id?}', [CategoriesController::class, 'getAll']);
// Admin panel
Route::middleware('auth:api')->post('/category-add', [CategoriesController::class, 'categoryAdd']);
Route::middleware('auth:api')->post('/category-update', [CategoriesController::class, 'categoryUpdate']);
Route::middleware('auth:api')->post('/category-update-image', [ImageUploadController::class, 'categoryImageUpload']);
Route::middleware('auth:api')->post('/category-delete', [CategoriesController::class, 'categoryDelete']);

/*
 * Objects Routers
 */

Route::get('/objects/{id}',[ObjectsController::class, 'getObjects']);
Route::get('/object/{id}',[ObjectsController::class, 'getObject']);
// Admin panel
Route::middleware('auth:api')->post('/object-add', [ObjectsController::class, 'objectAdd']);
Route::middleware('auth:api')->post('/object-update', [ObjectsController::class, 'objectUpdate']);
Route::middleware('auth:api')->post('/object-delete', [ObjectsController::class, 'objectDelete']);
Route::middleware('auth:api')->post('/object-add-image', [ObjectsController::class, 'objectAddImage']);
Route::middleware('auth:api')->post('/object-delete-image', [ObjectsController::class, 'objectDeleteImage']);

/*
 * Tests Routers
 */
Route::get('/testscat/{id}', [TestsController::class, 'getTests']);
Route::get('/test/{id}', [TestsController::class, 'getTest']);
// Admin panel
Route::middleware('auth:api')->post('/test-add', [TestsController::class, 'testAdd']);
Route::middleware('auth:api')->post('/test-update', [TestsController::class, 'testUpdate']);
Route::middleware('auth:api')->post('/test-delete', [TestsController::class, 'testDelete']);
// Test Object
Route::middleware('auth:api')->post('/test-object-add', [TestsController::class, 'testObjectAdd']);
/*
 * Question Routers
 */

Route::get('/questions/{id}', [QuestionsController::class, 'getQuestions']);
Route::get('/answers/{id}', [QuestionsController::class, 'getAnswers']);
// Admin panel
Route::middleware('auth:api')->post('/question-add', [QuestionsController::class, 'questionAdd']);
Route::middleware('auth:api')->post('/question-update', [QuestionsController::class, 'questiontUpdate']);
Route::middleware('auth:api')->post('/question-delete', [QuestionsController::class, 'questionDelete']);

/*
 * Answer Routers
 */
Route::middleware('auth:api')->post('/answer-add', [AnswersController::class, 'answerAdd']);
Route::middleware('auth:api')->post('/answer-update', [AnswersController::class, 'answerUpdate']);
Route::middleware('auth:api')->post('/answer-delete', [AnswersController::class, 'answerDelete']);

/*
 * File Upload Routers
 */
Route::middleware('auth:api')->post('/user-img-upload', [ImageUploadController::class, 'imageUpload']);
