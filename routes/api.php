<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;



Route::get('ping', fn() => response('pong'));

// 認証不要
Route::post('register',[RegisterController::class,'register']);


Route::post('login', [LoginController::class, 'login']);


/** パスワードリセット用リンク送信 */
Route::post('forgot-password', function(Request $request) {
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? response()->json(['message'=>__($status)], 200)
        : response()->json(['message'=>__($status)], 400);
});

/** リセット実行 */
Route::post('reset-password', function(Request $request) {
    $request->validate([
        'token'                 => 'required|string',
        'email'                 => 'required|email|exists:users,email',
        'password'              => 'required|string|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email','password','password_confirmation','token'),
        function(User $user, string $password) {
            $user->forceFill([
                'password'       => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? response()->json(['message'=>__($status)], 200)
        : response()->json(['message'=>__($status)], 400);
});

//
// 認証済みルート（sanctumミドルウェア付き）
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    });
    
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

