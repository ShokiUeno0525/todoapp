<?php

use Illuminate\Http\Request;
use App\Models\Todo; 


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
}