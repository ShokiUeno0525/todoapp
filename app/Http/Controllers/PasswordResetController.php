<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    public function __construct(private PasswordResetRequest $passwordResetRequest, private PasswordResetService $passwordResetService)
    {
        // Middleware can be applied here if needed
    }
    public function reset(PasswordResetRequest $request): JsonResponse
    {
        $data = $request->validated();
        $status = $this->passwordResetService->resetPassword($data);

            if ($status === Password::PASSWORD_RESET) {
                return response()->json(['message' => __('passwords.reset')], 200);
            }
        return response()->json(['message' => __('passwords.user')], 400);  

        // Handle the password reset logic
    }
}
