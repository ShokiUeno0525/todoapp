<?php 

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class LoginService
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * ログイン処理
     */
    public function login(array $data): string
    {
        $user = $this->users->findByEmail($data['email']);
    
        if (! $user) {
            return '';
        }
    
        // キャスト済みオブジェクトではなく、生の文字列を取得
        $rawHash = $user->getRawOriginal('password');
    
        if (! Hash::check($data['password'], $rawHash)) {
            return '';
        }
    
        return $user->createToken('api-token')->plainTextToken;
    }
}