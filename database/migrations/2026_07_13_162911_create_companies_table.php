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
        Schema::create('companies', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('account_status', [
                'active',
                'inactive',
                'prospect',
                'suspended',
            ])->default('active');

            // Billing address
            $table->string('billing_address_line_1');
            $table->string('billing_address_line_2')->nullable();
            $table->string('billing_city', 120);
            $table->string('billing_state', 2);
            $table->string('billing_zip', 10);

            // Physical address
            $table->string('physical_address_line_1')->nullable();
            $table->string('physical_address_line_2')->nullable();
            $table->string('physical_city', 120)->nullable();
            $table->string('physical_state', 2)->nullable();
            $table->string('physical_zip', 10)->nullable();

            $table->string('main_phone')->nullable();
            $table->string('main_email')->nullable();
            $table->string('accounting_email')->nullable();
            $table->longText('billing_notes')->nullable();
            $table->longText('notes')->nullable();
            $table->boolean('restrict_contacts_to_assigned_projects')->default(false);
            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('account_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
