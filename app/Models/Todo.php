<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    // 必要に応じて fillable や関係を定義
    protected $fillable = ['title', 'description', 'due_date', 'status'];

    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
