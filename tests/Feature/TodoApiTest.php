<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Todo;
use Laravel\Sanctum\Sanctum;

class TodoApiTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function todo_list_returns_authenticated_users_todos()
    {
        // 1) テスト用ユーザーを用意し、認証状態にする
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        // 2) 他ユーザーのタスクを作成（除外対象）
        Todo::factory()->count(3)->create();

        // 3) ログインユーザーのタスクを作成
        Todo::factory()->count(2)->for($user)->create();

        // 4) GET /api/todos を実行
        $response = $this->getJson('/api/todos');

        // 5) ステータスと返却件数を検証
        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }
}
