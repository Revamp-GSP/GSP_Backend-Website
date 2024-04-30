<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CustomersAPIController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\UsersAPIController;
use App\Http\Controllers\API\ProjectsAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::get('/products', [ProductAPIController::class, 'index']);
Route::get('/products/{id}', [ProductAPIController::class, 'show']);
Route::post('/products', [ProductAPIController::class, 'store']);
Route::put('/products/{id}', [ProductAPIController::class, 'update']);
Route::delete('/products/{id}', [ProductAPIController::class, 'destroy']);


Route::get('/customers', [CustomersApiController::class, 'index']);
Route::post('/customers', [CustomersApiController::class, 'store']);
Route::get('/customers/{id}', [CustomersApiController::class, 'show']);
Route::put('/customers/{id}', [CustomersApiController::class, 'update']);
Route::delete('/customers/{id}', [CustomersApiController::class, 'destroy']);



Route::get('/users', [UsersAPIController::class, 'index']);
Route::post('/users', [UsersAPIController::class, 'store']);
Route::get('/users/{id}', [UsersAPIController::class, 'show']);
Route::put('/users/{id}', [UsersAPIController::class, 'update']);
Route::delete('/users/{id}', [UsersAPIController::class, 'destroy']);


Route::get('/projects', [ProjectsAPIController::class, 'index']);
Route::get('/projects/{id}', [ProjectsAPIController::class, 'show']);
Route::post('/projects', [ProjectsAPIController::class, 'store']);
Route::put('/projects/{id}', [ProjectsAPIController::class, 'update']);
Route::delete('/projects/{id}', [ProjectsAPIController::class, 'destroy']);
