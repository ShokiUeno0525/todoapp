<?php 
namespace App\Services;

use App\Repositories\PasswordResetRepository;

class PasswordResetService
{
    public function __construct(private PasswordResetRepository $passwordResetRepository)
    {
        // Constructor can be used to inject dependencies if needed
    }

    public function resetPassword(array $data): string
    {
        return $this->passwordResetRepository->reset($data);
    }
}