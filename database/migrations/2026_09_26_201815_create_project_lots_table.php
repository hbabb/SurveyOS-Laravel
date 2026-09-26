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
        Schema::create('project_lots', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->index()->constrained()->cascadeOnDelete();
            $table->string('lot_number', 40);
            $table->string('house_plan', 120)->nullable();
            $table->string('homeowner_name', 220)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_lots');
    }
};
