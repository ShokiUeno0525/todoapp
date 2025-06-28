<?php 

namespace App\Repositories;

use Faker\Provider\ar_EG\Person;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutRepository
{
    public function delete(PersonalAccessToken $token): void
    {
        // トークンを削除する処理
        $token->delete();
    }
}
