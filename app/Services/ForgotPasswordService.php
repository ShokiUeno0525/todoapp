<?php 

namespace App\Services;

use App\Repositories\ForgotPasswordRepository;

class ForgotPasswordService
{
    public function __construct(private ForgotPasswordRepository $forgotPasswordRepository)
    {
    }

    /**
     * パスワードリセット用リンクを送信
     */
    public function sendResetLink(string $email): string
    {
        return $this->forgotPasswordRepository->sendResetLink($email);
    }
}