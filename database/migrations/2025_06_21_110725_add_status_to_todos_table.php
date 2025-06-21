<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            // pending／done の enum で status を追加。不要なら string('status')->default('pending') でも OK
          if (! Schema::hasColumn('todos', 'status')) {              
                $table->enum('status', ['pending', 'done'])
                  ->default('pending')
                  ->after('due_date');
           }
        });
    }

    public function down(): void
{
    Schema::table('todos', function (Blueprint $table) {
        if (Schema::hasColumn('todos', 'status')) {
            $table->dropColumn('status');
        }
    });
}
};
