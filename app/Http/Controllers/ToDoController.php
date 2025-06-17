<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;   // モデルの名前空間に合わせて修正

class TodoController extends Controller
{
    // タスクを一覧表示
    public function index()
    {
        $todos = Todo::orderBy('id', 'asc')->get();
        return view('todos.index', compact('todos'));
    }


    public function create()
    {
        return view('todos.create'); // resources/views/todos/create.blade.php を想定
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'nullable|date',
    ]);

    Todo::create($validated);

    return redirect()->route('todos.index')->with('success', 'タスクを作成しました');
    }
}