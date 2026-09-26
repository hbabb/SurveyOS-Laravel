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
        Schema::table('proposals', static function (Blueprint $table) {
            $table->foreignId('change_order_project_id')
                ->nullable()
                ->index()
                ->constrained('projects')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('change_order_project_id');
        });
    }
};
