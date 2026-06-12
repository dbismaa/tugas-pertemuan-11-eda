<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrafikMahasiswaController;

Route::get('/', function () {
    return redirect('/praktikum-eda');
});

Route::get('/praktikum-eda', [GrafikMahasiswaController::class, 'index']);