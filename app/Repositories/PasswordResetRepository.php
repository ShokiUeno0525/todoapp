<?php 

namespace App\Repositories;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetRepository
{
    public function sendResetLink(array $data): string
    {
        $email = $data['email'] ?? null;
        return Password::sendResetLink(['email' => $email]);
    }
    
    public function resetPassword(array $data): string
    {
        $status = Password::reset(
            $data,
            function ($user, $password) use ($data) {
                $user->password = bcrypt($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET ? 'Password reset successfully.' : 'Failed to reset password.';
    }
}
