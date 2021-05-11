<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
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
/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function(){
    $products=DB::select('select * from help');
    return $products;
});
Route::get('/testhome', function () {
    return view('index');
});
*/
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/admin', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
//Route::get('/admin', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');