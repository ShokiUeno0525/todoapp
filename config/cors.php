<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | 動作に必要なパス、メソッド、オリジン等を定義します。
    |
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => [
        '*',
    ],

    'allowed_origins' => [
        env('FRONTEND_URL', 'http://localhost:5173'),
    ],

    'allowed_headers' => [
        '*',
    ],

    'exposed_headers' => [
        // 例えば 'Authorization' を明示的に追加したい場合はこちらに
    ],

    // プリフライトリクエストのキャッシュ有効期限（秒）
    'max_age' => 3600,

    // Cookie（認証情報）を含むリクエストを許可するか
    'supports_credentials' => true,

];
