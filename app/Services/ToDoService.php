<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Todo; 
use App\Repositories\TodoRepository;
use Illuminate\Support\Facades\Auth;
class TodoService
{
    public function __construct(private TodoRepository $todoRepository) {}


    //タスク一覧取得
    public function getAllTodos(Request $request) 
    {
        return $this->todoRepository->getAllTodos(
            $request->user()->id,
            $request->query('status'),
            $request->query('sort_by', 'due_date'),
            $request->query('order', 'asc')
        ); 
    }

    //タスク作成
    // StoreTodoRequestを使用してリクエストのバリデーションを行
    public function createTodo(array $data, Request $request) {
        
        //認証ユーザーのIDをデータに追加
        $data['user_id'] = Auth::id();
        return $this->todoRepository->create($data);
    }


    //タスク詳細取得    
    public function getTodoDetail(string $id) {
        return $this->todoRepository->findById($id);
    }


    //タスク更新
    public function updateTodo(string $id, array $data)
     {
        $todo = $this->todoRepository->findById($id);
        $todo->update($data);
        return $todo;
    }


    //タスク削除
    public function deleteTodo(string $id)
    {
        $todo = $this->todoRepository->findById($id);
        $todo->delete();
        return $todo;
    }
}