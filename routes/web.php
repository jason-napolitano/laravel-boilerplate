<?php

use Illuminate\Support\Facades\Route;

Route::inertia('', 'public/welcome')->name('welcome');
Route::inertia('about', 'public/about')->name('about');
