<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

// Rute untuk mengambil data user yang sedang login (dengan middleware Sanctum untuk autentikasi)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute untuk mengambil semua data berita
Route::get('/news', [NewsController::class, 'index']);

// Rute untuk menambahkan data berita baru
Route::post('/news', [NewsController::class, 'store']);

// Rute untuk mengambil data berita berdasarkan ID
Route::get('/news/{id}', [NewsController::class, 'show']);

// Rute untuk memperbarui data berita berdasarkan ID (menggunakan metode PUT)
Route::put('/news/{id}', [NewsController::class, 'update']);

// Rute untuk menghapus data berita berdasarkan ID
Route::delete('/news/{id}', [NewsController::class, 'destroy']);

// Rute untuk memperbarui sebagian data berita berdasarkan ID (menggunakan metode PATCH)
Route::patch('/news/{id}', [NewsController::class, 'partialUpdate']);

// Rute untuk mencari data berita berdasarkan ID (alternatif)
Route::get('/news/search/{id}', [NewsController::class, 'search']);

// Rute untuk mengambil data berita berdasarkan kategori
Route::get('/news/category/{category}', [NewsController::class, 'getByCategory']);
