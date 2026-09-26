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
        Schema::create('site_intakes', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->index()->constrained()->restrictOnDelete();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city', 120);
            $table->string('county', 120);
            $table->string('state', 2);
            $table->string('zip', 10)->nullable();
            $table->string('township', 120)->nullable();
            $table->string('pin', 60)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_intakes');
    }
};
