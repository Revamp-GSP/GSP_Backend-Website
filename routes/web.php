<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\LogResponseTime;
use App\Http\Middleware\LogActivities;
use App\Http\Controllers\ActivityLogController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logActivity', [ActivityLogController::class, 'index'])->name('logActivity');
Route::delete('activity-log/delete', [ActivityLogController::class, 'delete'])->name('activity-log.delete');
Route::delete('activity-log/delete-all', [ActivityLogController::class, 'deleteAll'])->name('activity-log.delete-all');
Route::middleware('auth')->get('/notifications', [NotificationController::class, 'getNotifications']);
Route::middleware(['auth', 'logResponseTime', 'log.activity'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');
    Route::get('/admin/project', [HomeController::class, 'adminProject'])->name('admin.project');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    // Index route untuk menampilkan daftar pelanggan
    Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');

    // Rute untuk menampilkan formulir pembuatan pelanggan
    Route::get('/customers/create', [CustomersController::class, 'create'])->name('customers.create');

    // Rute untuk menyimpan data pelanggan yang baru dibuat
    Route::post('/customers', [CustomersController::class, 'store'])->name('customers.store');

    // Rute untuk menampilkan formulir pengeditan pelanggan
    Route::get('/customers/{id}/edit', [CustomersController::class, 'edit'])->name('customers.edit');

    // Rute untuk menyimpan perubahan yang dilakukan pada data pelanggan yang sedang diedit
    Route::put('/customers/{id}', [CustomersController::class, 'update'])->name('customers.update');

    // Rute untuk menghapus data pelanggan
    Route::delete('/customers/{id}', [CustomersController::class, 'destroy'])->name('customers.destroy');


    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectsController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectsController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectsController::class, 'destroy'])->name('projects.destroy');
    Route::get('/projects/{nama_pekerjaan}', [ProjectsController::class, 'show'])->name('projects.show');
    Route::post('/projects/{nama_pekerjaan}/tasks', [ProjectsController::class, 'storeTask']);
    Route::put('/projects/{nama_pekerjaan}/tasks/{task_id}', [ProjectsController::class, 'updateTask'])->name('projects.updateTask');
    Route::group(['prefix' => 'projects/{nama_pekerjaan}', 'as' => 'projects.'], function () {
        Route::post('/comments', [CommentController::class, 'addComment'])->name('comments.add')->middleware('auth');
    });


    // Users CRUD Routes
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}/update', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}/destroy', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::get('/comments/create', [CommentController::class, 'create'])->name('comments.create');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

});
Route::get('/download/{filename}', function ($filename) {
    $path = public_path('files/' . $filename);

    if (file_exists($path)) {
        return response()->download($path);
    } else {
        abort(404);
    }
})->name('file.download');

