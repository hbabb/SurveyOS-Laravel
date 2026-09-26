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
        Schema::create('projects', static function (Blueprint $table) {
            $table->id();
            $table->string('project_no', 6)->unique();
            $table->string('project_name', 220);
            $table->foreignId('proposal_id')->index()->unique()->constrained()->restrictOnDelete();
            $table->enum('status', [
                'research',
                'ready_for_schedule',
                'scheduled',
                'ready_for_drafting',
                'ready_for_review',
                'ready_for_invoice',
                'awaiting_payment',
                'ready_to_deliver',
                'delivered',
            ])->default('research')->index();
            $table->timestamp('status_changed_at')->nullable();
            $table->enum('priority', [
                'high',
                'urgent',
            ])->nullable();
            $table->date('field_scheduled_date')->nullable();
            $table->timestamp('invoiced_at')->nullable();
            $table->timestamp('last_followed_up_at')->nullable();
            $table->string('customer_status', 120)->default('Project started');
            $table->date('target_delivery')->nullable();
            $table->foreignId('project_manager_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();
            $table->foreignId('researcher_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'last_followed_up_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
