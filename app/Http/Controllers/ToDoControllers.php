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
        return view('todo_list', compact('todos'));
    }
}