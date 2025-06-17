<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;

//
// ユーザー登録（認証なし）
//
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json(['message' => 'Registered successfully'], 201);
});

//
// ログイン（認証なし）
//
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json(['token' => $token]);
});

//
// 認証済みルート（sanctumミドルウェア付き）
//
Route::middleware('auth:sanctum')->group(function () {
    // ログアウト（アクセストークン削除）
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    });

    // 認証済みユーザー情報取得
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // ToDoリソース管理（認証必須）
    Route::apiResource('todos', TodoController::class);
});
