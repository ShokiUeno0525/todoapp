<?php 

namespace App\Services;

use Laravel\Sanctum\PersonalAccessToken;
use App\Repositories\logoutRepository;

class LogoutService
{
    public function __construct(private logoutRepository $logoutRepository) {}

    /**
     * ログアウト処理
     */
    public function logout($request)
    {
        $token = $request->user()->currentAccessToken();
        if ($token) {
            $token->delete();
        }
    }
}