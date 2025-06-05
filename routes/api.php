<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Vlidaition\ValidationException;
use App\models\User;

Route::middleware('guest')->group(function (){
    //CSRF　Cookieを取得するエンドポイント
    return response()->json(['csrf' => 'ok']);
});

//ユーザー登録
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255' ,
        'email' => 'required|string\email|max:255|unique:users' ,
        'password' => 'required|string|min:8|confirmed' ,
    ]),
});

    $users = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::male($request->password),
    ]);

    return responce()->json(['massage' => 'Registered successfully'], 201);
 });

 //ログイン
 Route::post('/login', function (Request $request) {
    $request->validate([
        'email' =>'required|email',
        'password' => 'required',
    ]),
 });

    $user =User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // セッションにログイン状態をセット
        auth()->login($user);

        return response()->json(['message' => 'Logged in']);
    });
});

// 認証済みユーザーのみアクセス可
Route::middleware('auth:sanctum')->group(function () {
    // ログアウト
    Route::post('/logout', function (Request $request) {
        auth()->logout();
        return response()->json(['message' => 'Logged out']);
    });

    // ユーザー情報取得（例）
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // ここに ToDo CRUD API を追加していく
    // 例：Route::apiResource('todos', TodoController::class);
});