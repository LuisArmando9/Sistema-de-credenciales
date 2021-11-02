<?php

use App\Http\Controllers\Admin\CredentialController;
use App\Http\Controllers\Admin\DenominationController;
use App\Http\Controllers\Admin\DepartamentController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\ResetTablesController;
use App\Http\Controllers\Admin\TinturasController;
use App\Http\Controllers\Admin\ToalleraController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorkerController;
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
Route::middleware(['role:ADMIN', 'auth'])->group(function () {
    Route::post("/resetall", [ResetTablesController::class, "resetAll"]);
    Route::post("/resettintura", [ResetTablesController::class, "resetTintura"]);
    Route::post("/resettoallera", [ResetTablesController::class, "resetToallera"]);
    Route::post("/resetdepartament", [ResetTablesController::class, "resetDepartament"]);
    Route::post("/resetdenomination", [ResetTablesController::class, "resetDenomination"]);
    Route::resource('/credential', CredentialController::class);
    /**upload methods */
    Route::post("/tintura/upload", [TinturasController::class, "upload"]);
    Route::post("/toallera/upload", [ToalleraController::class, "upload"]);
    Route::post("/denomination/upload", [DenominationController::class, "upload"]);
    Route::post("/departament/upload", [DepartamentController::class, "upload"]);
    /**end */
    Route::resource('/toallera', ToalleraController::class);
    Route::resource('/tintura', TinturasController::class);
    Route::resource('/departament', DepartamentController::class);
    Route::resource('/denomination', DenominationController::class);
    Route::resource('/useradmin', UserController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/Pdf', PdfController::class);
    Route::resource('/Worker', WorkerController::class);
    /************/

    

});

Auth::routes();
