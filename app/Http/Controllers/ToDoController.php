<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;   // モデルの名前空間に合わせて修正

class TodoController extends Controller
{

    /**
     * タスク一覧取得
     * クエリパラメータで絞り込み・ソートが可能
     * GET /api/todos?status=done&sort_by=due_date&order=desc
     */
    public function index(Request $request)
    {
        $query = Todo::where('user_id', $request->user()->id);

        //ステータス絞り込み
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        //ソートキー・順序
        $sortBy = $request->get('sort_by', 'due_date');
        $order  = $request->get('order', 'asc');
        $allowedSorts = ['due_date', 'title', 'status', 'created_at'];
        if(in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $order === 'desc' ? 'desc' : 'asc');
        }

        $todos = $query->get();
        return response()->json($todos);
    }
    
    /**
     * タスク新規作成
     * POST /api/todos
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'status'      => 'required|in:pending,done',
        ]);

         $todo = Todo::create(array_merge(
        $validated,
        ['user_id' => $request->user()->id]
    ));

        //作成したリソースを返す(ステータスコード201)
        return response()->json($todo, 201);
    } 

    /**
     * タスク詳細取得
     * GET /api/todos/{id}
     */
    public function show(string $id)
    {
        $todo = Todo::findOrFail($id);
        return response()->json($todo);
    }

     /**
     * タスク更新
     * PUT/PATCH /api/todos/{id}
     */
    public function update(Request $request, string $id)
    {
        $todo = Todo::findOrFail($id);

        $validated = $request->validate([
            'title'       =>'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'status'      => 'sometimes|in:pending,done',
        ]);

        $todo->fill($validated);
        $todo->save();

        return response()->json($todo);
    }

    /**
     * タスク削除
     * DELETE /api/todos/{id}
     */
    public function destroy(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        //204 No Content を返してフロントにはボディレスにする
        return response()->noContent();
    }
}

