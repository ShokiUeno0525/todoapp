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


Route::get('ping', fn() => response('pong'));

// 認証不要
Route::post('register', function (Request $request) {

    $request->validate([
        'name'                  => 'required|string|max:255',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|string|min:8|confirmed',
    ]);

    // ★ ここで必ず INSERT
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),   // ← Hash 化
    ]);

    return response()->json(['message'=>'Registered successfully'], 201);
});

Route::post('login', function (Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

        // ユーザー取得
    $user = User::where('email', $request->email)->first();

    // 認証チェック
    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // トークン発行
    $token = $user->createToken('api-token')->plainTextToken;

    // トークンを返却
    return response()->json(['token' => $token], 200);
});

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

