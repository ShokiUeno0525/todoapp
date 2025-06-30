<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Services\PasswordResetService;

class PasswordResetController extends Controller
{
    public function __construct(private PasswordResetRequest $passwordResetRequest, private PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function reset(PasswordResetRequest $request)
    {
        $data = $request->validated();
        return $this->passwordResetService->resetPassword($data);
    }
}
