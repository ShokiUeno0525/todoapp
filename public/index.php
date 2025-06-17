<?php

declare(strict_types=1);

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// メンテナンスモード判定
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer のオートローダー登録
require __DIR__ . '/../vendor/autoload.php';

// アプリケーションブートストラップ
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// HTTP カーネルを解決
$kernel = $app->make(Kernel::class);

// リクエスト取得
$request = Request::capture();

try {
    // リクエスト処理
    $response = $kernel->handle($request);

    // レスポンス送信
    $response->send();

    // 終了処理（ミドルウェアの terminate など）
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    // 例外発生時のログ出力やカスタムエラーページ処理
    report($e);

    $response = $kernel->handle(Request::capture());
    $response->send();
    $kernel->terminate($request, $response);
}
