<?php

use App\Http\Controllers\PlaceController;
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
Route::group(['middleware' => ['auth', 'verified']], function(){
    Route::get('/establecimiento/create', [PlaceController::class, 'create'])->name('establecimiento.create');
    Route::post('/establecimiento', [PlaceController::class, 'store'])->name('establecimiento.store');
    Route::get('/establecimiento/edit', [PlaceController::class, 'edit'])->name('establecimiento.edit');

    //images
    Route::post('images/store', [\App\Http\Controllers\ImageController::class, 'store'])->name('images.store');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

