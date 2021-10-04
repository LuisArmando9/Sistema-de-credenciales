<?php

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
    return view('auth.login');
});

Auth::routes();
/**upload methods */
Route::post("/tintura/upload", [App\Http\Controllers\Admin\TinturasController::class, "upload"]);
Route::post("/toallera/upload", [App\Http\Controllers\Admin\ToalleraController::class, "upload"]);
Route::post("/denomination/upload", [App\Http\Controllers\Admin\DenominationController::class, "upload"]);
Route::post("/departament/upload", [App\Http\Controllers\Admin\DepartamentController::class, "upload"]);
/**end */
Route::resource('/toallera',App\Http\Controllers\Admin\ToalleraController::class);
Route::resource('/tintura',App\Http\Controllers\Admin\TinturasController::class);
Route::resource('/departament',App\Http\Controllers\Admin\DepartamentController::class);
Route::resource('/denomination',App\Http\Controllers\Admin\DenominationController::class);
Route::resource('/useradmin',App\Http\Controllers\Admin\UserController::class);
Route::resource('/user',App\Http\Controllers\User\UserController::class);
Route::resource('/Pdf',App\Http\Controllers\Admin\PdfController::class);
