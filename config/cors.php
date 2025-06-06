<?php

return [

    //どのパスでCORSを許可するか
'paths' => ['api/*', 'sanctum/csrf-cookie'],
    //どのHTTPメソッドを許可するか
'allowed_methods' => ['*'],
    //どのオリジン(domain:port)からのリクエストを許可するか
'allowed_origins' => ['http://localhost:5173'],  // React:Vite の URL
    //オリジン中でどのヘッダーを許可するか
'allowed_headers' => ['*'],
    //ブラウザにさらす(Exposeする)ヘッダー
'exposed_headers' => [],
    //プリフライトリクエストのキャッシュ有効期限
'max_age' => 0,
    //Cookie(認証情報)を含むリクエストを受け付けるか
'supports_credentials' => true,

];
