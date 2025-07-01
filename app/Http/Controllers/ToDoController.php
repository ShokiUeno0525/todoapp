<?php

namespace App\Http\Controllers;
   // モデルの名前空間に合わせて修正
//ここから

   use Illuminate\Http\Request;
   use Illuminate\Http\JsonResponse;
   use App\Http\Controllers\Controller;
   use App\Http\Requests\Todos\ListRequest;
   use App\Http\Requests\Todos\StoreTodoRequest;
   use App\Http\Requests\Todos\UpdateRequest;
   use App\Services\TodoService;

   class TodoController extends Controller
{
    public function __construct(private ToDoService $todoService)
    {
        // ミドルウェアの設定などが必要な場合はここに記述
        // 例: $this->middleware('auth')
    }

    /**
     * タスク一覧取得
     * クエリパラメータで絞り込み・ソートが可能
     * GET /api/todos?status=done&sort_by=due_date&order=desc
     */
    public function index(Request $request): JsonResponse
    {
        $todos = $this->todoService->getAllTodos($request);

        return response()->json($todos);
    }

    /**
     * タスク新規作成
     * POST /api/todos
     */

     public function store(StoreTodoRequest $request): JsonResponse
     {
        $todo = $this->todoService->createTodo($request->validated(), $request);
         // 作成したリソースを返す(ステータスコード201)
         return response()->json($todo, 201);
     }

    /**
     * タスク詳細取得
     * GET /api/todos/{id}
     */
    public function show(string $id)
    {
        $todo = $this->todoService->getTodoDetail($id);
        return response()->json($todo);
    }

     /**
     * タスク更新
     * PUT/PATCH /api/todos/{id}
     */
    public function update(UpdateRequest $request, string $id)
    {
        $todo = $this->todoService->updateTodo($id, $request->validated());
        return response()->json($todo);
    }

    /**
     * タスク削除
     * DELETE /api/todos/{id}
     */
    public function destroy(string $id)
    {
        $this->todoService->deleteTodo($id);
        return response()->noContent();
    }
}

