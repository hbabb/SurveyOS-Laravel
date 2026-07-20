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
        Schema::create('contacts', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->string('phone', 10);
            $table->string('title', 160)->nullable();
            $table->enum('contact_role', [
                'project_manager',
                'accounting',
                'title_agent',
                'realtor',
                'attorney',
                'lender',
            ])->nullable();
            $table->enum('account_status', [
                'active',
                'inactive',
                'prospect',
                'suspended',
            ])->nullable();
            $table->boolean('portal_enabled')->default(false);
            $table->string('notification_email')->nullable();
            $table->boolean('can_view_accounting')->default(false);
            $table->boolean('can_view_all_company_projects')->default(false);
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip', 10)->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
