<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;


class AuthService
{
    public function __construct(private UserRepository $users){}

    /**
     * ユーザー登録
     */
    public function register(array $data): User
    {

        $data['password'] = Hash::make($data['password']);

        return $this->users->create($data);

    }

}
