<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportLaporanController;
use App\Http\Controllers\ExportServisController;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/export/pdf/bbm', [ExportLaporanController::class, 'exportPdfBbm'])->name('export.pdf.bbm');
// Route::get('/export/excel/bbm', [ExportLaporanController::class, 'exportExcelBbm'])->name('export.excel.bbm');

// Route::get('/export/pdf/servis/{plat_nomor}', [ExportLaporanController::class, 'exportPdfServis'])
//     ->name('export.pdf.servis');
// Route::get('/export/excel/servis/{plat_nomor}', [ExportLaporanController::class, 'exportExcelServis'])
//     ->name('export.excel.servis');

// Route::get('/export-servis', [ExportServisController::class, 'index'])
//     ->name('export-servis.index');
// Route::post('/export-servis', [ExportServisController::class, 'export'])
//     ->name('export-servis.export');
// Route::post('/export-servis/pdf', [ExportServisController::class, 'downloadPdf'])
//     ->name('export-servis.pdf');
// Route::post('/export-servis/excel', [ExportServisController::class, 'downloadExcel'])
//     ->name('export-servis.excel');
