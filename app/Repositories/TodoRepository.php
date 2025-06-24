<?php

use App\Models\Todo;

class TodoRepository
{
    public function __construct() {}

    public function getAllToDos(
        int $userId, 
        string | null $status, 
        string $sortBy, 
        string $order
    )
    {
        $allowedSorts = ['due_date', 'title', 'status', 'created_at'];
    
        $todos = Todo::query()
            ->where('user_id', $userId)
            ->when(isset($status), function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when(in_array($sortBy, $allowedSorts), function($query) use ($sortBy, $order) {
                return $query->orderBy($sortBy, $order);
            })
            ->get();
    
        return $todos;
    }

    public function create(array $data): Todo
    {
        return Todo::create($data);
    }
}