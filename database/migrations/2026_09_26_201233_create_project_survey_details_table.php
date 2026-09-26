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
        Schema::create('project_survey_details', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('drawing_title', 220)->nullable();
            $table->string('ordered_by_name', 190)->nullable();
            $table->string('zoning_district', 60)->nullable();
            $table->decimal('setback_front_ft', 6, 2)->nullable();
            $table->decimal('setback_side_ft', 6, 2)->nullable();
            $table->decimal('setback_rear_ft', 6, 2)->nullable();
            $table->text('setback_notes')->nullable();
            $table->string('ngs_monument_name', 80)->nullable();
            $table->decimal('ngs_combined_scale_factor', 10, 8)->nullable();
            $table->string('horizontal_datum', 60)->nullable();
            $table->string('vertical_datum', 60)->nullable();
            $table->text('basis_of_bearing')->nullable();
            $table->string('benchmark_description', 190)->nullable();
            $table->foreignId('certifying_surveyor_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();
            $table->date('field_date')->nullable();
            $table->date('survey_date')->nullable();
            $table->date('draft_date')->nullable();
            $table->date('checked_date')->nullable();
            $table->foreignId('drafter_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();
            $table->foreignId('checker_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();
            $table->string('revision', 20)->nullable();
            $table->integer('sheet_no')->nullable();
            $table->integer('total_sheets')->nullable();
            $table->string('scale_text', 40)->nullable();
            $table->boolean('field_draft_started')->default(false);
            $table->boolean('recording_requested')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_survey_details');
    }
};
