<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::table('todos', function (Blueprint $table) {
        $table->foreignId('user_id')
              ->constrained()     // users テーブルへの外部キー制約
              ->cascadeOnDelete() // ユーザー削除時に紐づくタスクも削除
              ->after('id');
    });
    }

    public function down(): void
    {
    Schema::table('todos', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
    }
};
