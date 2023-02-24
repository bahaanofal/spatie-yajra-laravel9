<?php

use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth', 'role:super_admin|admin'])
    ->name('admin.')
    ->prefix('/admin')
    ->group(function(){
        Route::resource('/users', UsersController::class);
        Route::resource('/roles', RolesController::class);
        Route::resource('/permissions', PermissionsController::class);
        Route::get('/filemanager', [FileManagerController::class, 'index'])->name('filemanager');
    });
// Route::resource('/admin/users', UsersController::class)->middleware(['auth', 'role:super_admin|admin']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
