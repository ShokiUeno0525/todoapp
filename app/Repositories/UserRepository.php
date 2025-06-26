<?php 
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * ユーザーを作成
     */
    public function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => ($data['password']),
        ]);
    }

    /**
     * ユーザーを取得
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * ユーザーを更新
     */
    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    /**
     * ユーザーを削除
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }
}