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
        Schema::create('project_documents', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->restrictOnDelete();
            $table->enum('type', [
                'research',
                'final_deliverable',
            ]);
            $table->string('path', 500);
            $table->string('original_filename');
            $table->string('mime_type', 120)->nullable();
            $table->bigInteger('size_bytes')->nullable();
            $table->foreignId('uploaded_by_employee_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();
            $table->timestamps();

            $table->index(['project_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_documents');
    }
};
