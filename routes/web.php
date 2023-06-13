<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DownloadController;

Route::get('/files', [FileController::class, 'index'])->name('files.index');
Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');
Route::post('/files/{id}/download', [DownloadController::class, 'download'])->name('files.download');
