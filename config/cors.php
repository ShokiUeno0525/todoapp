<?php
return [
  'paths' => [
    'api/*',
    'register',          // ← 追加（テスト用）
    'login',
    'forgot-password',
    'reset-password',
    'sanctum/csrf-cookie',
  ],
  'allowed_origins'   => ['http://localhost:5173'],
  'allowed_methods'   => ['*'],
  'allowed_headers'   => ['*'],
  'supports_credentials' => true,
];
