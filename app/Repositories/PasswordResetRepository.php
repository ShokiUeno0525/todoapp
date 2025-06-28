<?php 

namespace App\Repositories;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetRepository
{
    public function reset(array $data): string
    {
        return Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );
    }
}
