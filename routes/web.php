<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Main;


Route::get('/', function () {
    return view('welcome');
});


Route::get('student-forum/{user_id}', [Main::class, 'index'])->name('student-forum');
Route::post('/add_question/{user_id}', [Main::class, 'add_question']);
Route::post('/add_like/{user_id}/{post_id}', [Main::class, 'add_like']);