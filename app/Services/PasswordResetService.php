<?php 
namespace App\Services;

use App\Repositories\PasswordResetRepository;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetService
{
    public function __construct(private PasswordResetRepository $passwordResetRepository)
    {
        // Constructor can be used to inject dependencies if needed
    }

    public function sendResetLink(string $email,): string
    {
       return $this->passwordResetRepository->sendResetLink(['email' => $email]);
    }

    public function resetPassword(array $data)
    {
        return $this->passwordResetRepository->resetPassword($data);
    }
}