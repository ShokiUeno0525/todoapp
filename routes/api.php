<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\LogoutController;



Route::get('ping', fn() => response('pong'));

// 認証不要
Route::post('register',[RegisterController::class,'register']);


Route::post('login', [LoginController::class, 'login']);


/** パスワードリセット用リンク送信 */
Route::post('forgot-password', [ForgotPasswordController::class, 'sendLink']);  


/** リセット実行 */
Route::post('reset-password', [PasswordResetController::class, 'reset']);
// パスワードリセットのためのルート

/** 認証済みルート（sanctumミドルウェア付き） */
Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [LogoutController::class, 'logout']);
    Route::apiResource('todos', TodoController::class);
});



Route::middleware('auth:sanctum')->group(function () {
    // プロフィール取得・更新
    Route::get  ('/user',                   [ProfileController::class, 'show']);
    Route::put  ('/user',                   [ProfileController::class, 'update']);

    // 設定取得・更新
    Route::get  ('/user/settings',          [SettingsController::class, 'show']);
    Route::put  ('/user/settings',          [SettingsController::class, 'update']);

    // ダッシュボードデータ
    Route::get  ('/dashboard',              [DashboardController::class, 'data']);
});

