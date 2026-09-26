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
        Schema::create('project_lot_deliverables', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_lot_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'lot_fit',
                'plot_plan',
                'house_stake',
                'pin_footings',
                'final_mortgage_survey',
            ]);
            $table->date('date_ordered')->nullable();
            $table->date('date_completed')->nullable();
            $table->timestamps();

            $table->unique(['project_lot_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_lot_deliverables');
    }
};
