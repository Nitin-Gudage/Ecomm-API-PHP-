<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PayslipController;
use App\Models\invoice;
use Illuminate\Support\Facades\Route;

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
    // return view('welcome');
    return "<h1>Welcome</h1>";
});

Route::get('/invoice',[InvoiceController::class,'index']);
Route::get('/download-invoice',[InvoiceController::class,'downloadpdf']);

