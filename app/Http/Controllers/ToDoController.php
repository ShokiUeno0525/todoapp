<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;   // モデルの名前空間に合わせて修正
use ListRequest;
use StoreTodoRequest;
use ToDoService;
use UpdateRequest;


class TodoController extends Controller
{

    /**
     * タスク一覧取得
     * クエリパラメータで絞り込み・ソートが可能
     * GET /api/todos?status=done&sort_by=due_date&order=desc
     */
    public function index(ListRequest $request)
    {
        $service = new ToDoService();
        $todos = $service->getAllToDos($request);
        return response()->json($todos);
    }

    /**
     * タスク新規作成
     * POST /api/todos
     */
    public function store(StoreTodoRequest $request)
    {
        $service = new StoreTodoRequest();
        $todos = $service->getValidatedData($request);
        //作成したリソースを返す(ステータスコード201)
        return response()->json($todos, 201);
    } 

    /**
     * タスク詳細取得
     * GET /api/todos/{id}
     */
    public function show(string $id)
    {
        $service = new ToDoService();
        $todo = $service->getTodoDetail($id);
        return response()->json($todo);
    }

     /**
     * タスク更新
     * PUT/PATCH /api/todos/{id}
     */
    public function update(UpdateRequest $request, string $id)
    {
        $service = new ToDoService();
        $validated = $request->validated();
        $todo = $service->updateTodo($id, $validated); 


        return response()->json($todo);
    }

    /**
     * タスク削除
     * DELETE /api/todos/{id}
     */
    public function destroy(string $id)
    {
        $service = new ToDoService();
        $service->deleteTodo($id);

        return response()->noContent();
    }
}

