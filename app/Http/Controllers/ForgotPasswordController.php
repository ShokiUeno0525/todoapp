<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{
    public function __construct(private PasswordResetService $passwordResetService)
    {
    }

    public function sendLink(ForgotPasswordRequest $request): JsonResponse
    {
            $email =  $request->validated()['email'];
            $status = $this->passwordResetService->sendResetLink($email);

    if ($status === Password::RESET_LINK_SENT) {
        // パスワードリセット用リンクが正常に送信された場合
        return response()->json(['message' => __($status)], 200);
    } else {
        // リンク送信に失敗した場合
        return response()->json(['message' => __($status)], 400);
    }   
}
}
