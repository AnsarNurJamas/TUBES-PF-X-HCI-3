<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Redirect;
use App\Exports\ProductExport;
use App\Http\Controllers\ProductCategories;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SaleController;



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
Route::resource('ProductCategories', ProductCategoriesController::class);
Route::resource('customer', CustomerController::class);
Route::get('/order', [App\Http\Controllers\OrderController::class, 'index'])->name('order');
Route::get('/penjualan',[App\Http\Controllers\PenjualanController::class, 'index'])->name('penjualan');
Route::get('/company', 'CompanyProfileController@index')->name('company.index');
Route::post('/company', 'CompanyProfileController@save')->name('CompanyProfile.save');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::post('/sale/getCoupon', 'SaleController@getCoupon')->name('sale.getCoupon');
    Route::resource('sale', 'SaleController');
    Route::post('/transaction/storeTransaction', 'TransactionController@storeTransaction')->name('transaction.storeTransaction');
    Route::post('/transaction/report', 'TransactionController@report')->name('transaction.report');
    Route::get('/struk/{transaction_code?}', 'TransactionController@struk')->name('transaction.struk');
    Route::resource('transaction', 'TransactionController')->except([
        'create'
    ]);
    Route::get('/transaction/create/{transaction_code?}', 'TransactionController@create')->name('transaction.create');

});


Route::get('export1Excel', [CustomerController::class, 'export1Excel'])->name('customer.export1Excel');
Route::get('exportExcel', [ProductController::class, 'exportExcel'])->name('Product.exportexcel');
Route::get('exportPdf', [CustomerController::class, 'exportPdf'])->name('customer.exportPdf');
Route::get('export1Pdf', [ProductController::class, 'export1Pdf'])->name('Product.export1Pdf');
