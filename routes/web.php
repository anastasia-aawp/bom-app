<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MstMaterialController;
use App\Http\Controllers\MstProductController;
use App\Http\Controllers\StockMaterialController;
use App\Http\Controllers\TransProductController;

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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('mst-material', MstMaterialController::class);      
    Route::get('mst-material-api', [MstMaterialController::class, 'indexApi'])->name('mst-material.listapi');
    Route::get('mst-material-export-pdf-default', [MstMaterialController::class, 'exportPdf'])->name('mst-material.export-pdf-default');    
    Route::get('mst-material-export-excel-default', [MstMaterialController::class, 'exportExcel'])->name('mst-material.export-excel-default');
    Route::post('mst-material-import-excel-default', [MstMaterialController::class, 'importExcel'])->name('mst-material.import-excel-default');
    //MVC Mst Product
    Route::resource('mst-product', MstProductController::class);
    Route::get('mst-product-api', [MstProductController::class, 'indexApi'])->name('mst-product.listapi');    
    Route::get('mst-product-export-pdf-default', [MstProductController::class, 'exportPdf'])->name('mst-product.export-pdf-default');
    Route::get('mst-product-export-excel-default', [MstProductController::class, 'exportExcel'])->name('mst-product.export-excel-default');
    Route::post('mst-product-import-excel-default', [MstProductController::class, 'importExcel'])->name('mst-product.import-excel-default');
    
    Route::resource('stock-material', StockMaterialController::class);
    Route::get('stock-material-api', [StockMaterialController::class, 'indexApi'])->name('stock-material.listapi');
    Route::get('stock-material-export-pdf-default', [StockMaterialController::class, 'exportPdf'])->name('stock-material.export-pdf-default');
    Route::get('stock-material-export-excel-default', [StockMaterialController::class, 'exportExcel'])->name('stock-material.export-excel-default');
    Route::post('stock-material-import-excel-default', [StockMaterialController::class, 'importExcel'])->name('stock-material.import-excel-default');
    //MVC Trans Product
    Route::resource('trans-product', TransProductController::class);
    Route::get('trans-product-api', [TransProductController::class, 'indexApi'])->name('trans-product.listapi');
    Route::get('trans-product-export-pdf-default', [TransProductController::class, 'exportPdf'])->name('trans-product.export-pdf-default');
    Route::get('trans-product-export-excel-default', [TransProductController::class, 'exportExcel'])->name('trans-product.export-excel-default');
    Route::post('trans-product-import-excel-default', [TransProductController::class, 'importExcel'])->name('trans-product.import-excel-default');
    
   });