<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\Admin\AlbumController;

Route::get('/', function () {
    return redirect()->route('admin.products.index');
});

// 驗證碼路由
Route::get('/captcha', [CaptchaController::class, 'generate'])->name('captcha.generate');
Route::post('/captcha/refresh', [CaptchaController::class, 'generate'])->name('captcha.refresh');

