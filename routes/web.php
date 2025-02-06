<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Frontend\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// 驗證碼路由
Route::get('/captcha', [CaptchaController::class, 'generate'])->name('captcha.generate');
Route::post('/captcha/refresh', [CaptchaController::class, 'generate'])->name('captcha.refresh');
