<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Http\Middleware\HandleCors;                                 // ← ①
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance; // ← ②
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;                 // ← ②
use Illuminate\Foundation\Http\Middleware\TrimStrings;                      // ← ②
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;        // ← ②

class Kernel extends HttpKernel
{
    /**
     * グローバルミドルウェアスタック
     */
    protected $middleware = [
        // CORS ヘッダを全リクエストに付与
        HandleCors::class,

        // メンテナンスモード（メンテナンス中は全リクエストを503に）
        PreventRequestsDuringMaintenance::class,

        // POST サイズチェック
        ValidatePostSize::class,

        // 全リクエストの入力文字列を自動トリム
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * ミドルウェアグループ
     */
    protected $middlewareGroups = [
        'web' => [
            // （省略）セッションや CSRF 等
        ],

        'api' => [
            // API グループでも CORS を通し、
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    // ... 省略: $routeMiddleware など
}
