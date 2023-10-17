<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::controller(PostController::class)
    ->prefix('post')
    ->group(function () {
    Route::get('/',  'index')->name('post.index');
    Route::get('/add',  'add')->name('post.add');
    Route::post('/add',  'store')->name('post.store');
    Route::get('/edit/{id}',  'edit')->name('post.edit');
    Route::post('/edit/{id}',  'store')->name('post.update');
    Route::delete('/delete/{id}',  'destroy')->name('post.destroy');
});
