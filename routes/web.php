<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Redirect;
use App\Exports\ProductExport;
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

Auth::routes();
Route:: redirect('/', '/login');
Route::get('logout', function ()
{
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('Product', ProductController::class);
Route::resource('customer', CustomerController::class);
Route::get('/order', [App\Http\Controllers\OrderController::class, 'index'])->name('order');
Route::get('exportExcel', [CustomerController::class, 'exportExcel'])->name('customer.exportExcel');