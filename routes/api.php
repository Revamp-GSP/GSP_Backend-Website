<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CustomersAPIController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\UsersAPIController;
use App\Http\Controllers\API\ProjectsAPIController;
use App\Http\Controllers\API\TaskAPIController;
use App\Http\Controllers\NotificationController;


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

Route::get('/tasks', [TaskAPIController::class, 'index']);
Route::get('/tasks/{id}', [TaskAPIController::class, 'show']);
Route::post('/tasks', [TaskAPIController::class, 'store']);
Route::put('/tasks/{id}', [TaskAPIController::class, 'update']);
Route::delete('/tasks/{id}', [TaskAPIController::class, 'destroy']);

Route::get('/projects/{nama_pekerjaan}/tasks', [TaskAPIController::class, 'getTasksByNamaPekerjaan']);
Route::post('/projects/{nama_pekerjaan}/tasks', [TaskAPIController::class, 'storeTask'])->name('projects.storeTask');
Route::get('/projects/{nama_pekerjaan}/tasks/{task_id}', [TaskAPIController::class, 'showTask'])->name('projects.showTask');
Route::put('/projects/{nama_pekerjaan}/tasks/{task_id}', [TaskAPIController::class, 'updateTask'])->name('projects.updateTask');
Route::delete('/projects/{nama_pekerjaan}/tasks/{task_id}', [TaskAPIController::class, 'deleteTask'])->name('tasks.deleteTask');
Route::post('/projects/{nama_pekerjaan}/tasks/comments/add', [TaskAPIController::class, 'addComment'])->name('task.addComment');

Route::get('/notifications', [NotificationController::class, 'getAllNotifications']);

Route::get('/download/{filename}', function ($filename) {
    $path = public_path('files/' . $filename);

    if (file_exists($path)) {
        return response()->download($path);
    } else {
        abort(404);
    }
})->name('file.download');