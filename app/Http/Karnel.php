<?php

protected $middlewareGroups = [
    'web' => [
        // 既存のミドルウェア群...
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
        
    'api' => [
        // 認証されたAPIを利用したい場合
        \Illuminate\Routing\Middleware\SubstituteBindings::class, 
    ],
 ];
