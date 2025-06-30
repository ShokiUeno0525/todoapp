<?php

use Illuminate\Http\Request;
use App\Models\Todo; 
use App\Repositories\TodoRepository;

//ここから

class ToDoService
{

    public function __construct() {}

    public function getAllToDos(Request $request) {
        $repository = new TodoRepository();
        $todos = $repository->getAllToDos(
            $request->user()->id,
            $request->query('status'),
            $request->query('sort_by', 'due_date'),
            $request->query('order', 'asc')
        ); 

        return $todos;
    }

    public function createTodo(array $data) {
        $todo = Todo::create($data);
        return $todo;
    }

    public function getTodoDetail(string $id) {
        $todo = Todo::findOrFail($id);
        return $todo;
    }

    public function updateTodo(string $id, array $data)
     {
        $todo = Todo::findOrFail($id);
        $todo->update($data);
        return $todo;
    }

    public function deleteTodo(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return $todo;
    }
}