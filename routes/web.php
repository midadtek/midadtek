<?php

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ReportController;


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
    return redirect('admin/projects');
});


Route::get('/updateCookies/{id}', function($id){ Cookie::queue('office_id', $id); });
Route::get('pdf/preview', [PdfController::class, 'index']);
Route::get('pdf/generate', [PdfController::class, 'create']);
Route::get('/exportpdf','PdfController@exportPDF');
Route::post('report/printPdf', [ReportController::class, 'printPdf']);
Route::get('report/exportExcel', [ReportController::class, 'exportExcel']);





Route::group(['prefix' => 'admin'], function () {
 

    Route::get('reports/print_all','ReportController@print_all')->name('voyager.reports.print_all');
    Route::get('reports/export_all', 'ReportController@export')->name('voyager.reports.export_all');
    Voyager::routes();
    Route::get('checkQuantities', 'ReceiptController@checkQuantities')->name('voyager.checkQuantities');
    Route::get('finishProject/{id}', 'ProjectController@finish')->name('voyager.projects.finish');
    Route::get('cancleProject/{id}', 'ProjectController@cancle')->name('voyager.projects.cancle');
    Route::get('quantity_approved/{id}', 'ProjectController@quantity_approved')->name('voyager.projects.quantity_approved');
     

});
