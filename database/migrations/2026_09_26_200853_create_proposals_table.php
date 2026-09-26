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
        Schema::create('proposals', static function (Blueprint $table) {
            $table->id();
            $table->string('proposal_no', 8)->unique();
            $table->foreignId('site_intake_id')->index()->constrained()->restrictOnDelete();
            $table->string('service_type', 140)->nullable();
            $table->text('scope_description')->nullable();
            $table->text('exclusions_description')->nullable();
            $table->decimal('fee_amount', 10, 2)->nullable();
            $table->enum('status', [
                'draft',
                'sent',
                'viewed',
                'accepted',
                'declined',
                'expired',
            ])->default('draft')->index();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->enum('accepted_via', [
                'portal',
                'employee_entry',
            ])->nullable();
            $table->foreignId('accepted_by_employee_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();
            $table->text('accepted_note')->nullable();
            $table->string('accepted_ip_address', 45)->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->text('declined_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
