<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/books/create', function (Request $request) {
    return BookController::create($request);
});

Route::prefix('search')->group(function () {
    Route::get('/', [SearchController::class, 'getResults']);
    Route::get('/compare', [SearchController::class, 'compareResults']);
});
