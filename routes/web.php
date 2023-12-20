<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserdataController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ReverseSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GetdataController;




Route::get('/login', function () {
    return view('welcome');
});


Route::get('/register', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    return view('welcome');
});


Route::get('/header', function () {
    return view('welcome');
});


Route::get('/profile', function () {
    return view('welcome');
});


Route::get('/userdata', function () {
    return view('welcome');
});


Route::post('/register', [RegisterController::class, 'register']);
// Route::post('/profile/{id}', [RegisterController::class, 'profile']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/userdata', [UserdataController::class, 'userdata']);
Route::get('/fetchUserData', [UserdataController::class, 'fetchUserData']);
Route::delete('/deleteUser/{id}', [DeleteController::class, 'deleteUser']);
Route::post('/updateUser/{id}', [UpdateController::class, 'updateUser']);



Route::post('/getUserData/{Email}', [GetdataController::class, 'getUserData']);

Route::post('/updateUserData/{id}', [ProfileController::class, 'updateUserData']);

Route::post('/search', [SearchController::class, 'search']);

Route::post('/generatePDF', [PDFController::class, 'generatePDF']);
Route::post('/generateExcel', [ExcelController::class, 'generateExcel']);
Route::post('/reverseSearch', [ReverseSearchController::class, 'reverseSearch']);

