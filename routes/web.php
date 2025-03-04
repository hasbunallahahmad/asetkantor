<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportLaporanController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/export/pdf/bbm', [ExportLaporanController::class, 'exportPdfBbm'])->name('export.pdf.bbm');
Route::get('/export/excel/bbm', [ExportLaporanController::class, 'exportExcelBbm'])->name('export.excel.bbm');

Route::get('/export/pdf/servis', [ExportLaporanController::class, 'exportPdfServis'])->name('export.pdf.servis');
Route::get('/export/excel/servis', [ExportLaporanController::class, 'exportExcelServis'])->name('export.excel.servis');
