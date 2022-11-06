<?php

use App\Http\Controllers\S3\S3DownloadController;
use App\Http\Controllers\S3\S3IndexController;
use App\Http\Controllers\S3\S3UploadController;
use Illuminate\Support\Facades\Route;

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

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::get('/dashboard', S3IndexController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('/s3')->name('s3.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', S3IndexController::class)->name('index');
    Route::post('/upload', S3UploadController::class)->name('upload');
    Route::get('/download', S3DownloadController::class)->name('download');
});

require __DIR__ . '/auth.php';
