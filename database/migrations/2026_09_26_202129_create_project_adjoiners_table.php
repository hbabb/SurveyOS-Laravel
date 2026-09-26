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
        Schema::create('project_adjoiners', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_parcel_id')->index()->constrained()->cascadeOnDelete();
            $table->string('owner_name', 220)->nullable();
            $table->string('pin', 80)->nullable();
            $table->string('deed_book', 20)->nullable();
            $table->string('deed_page', 20)->nullable();
            $table->string('plat_book', 20)->nullable();
            $table->string('plat_page', 20)->nullable();
            $table->string('subdivision_name', 190)->nullable();
            $table->string('lot_number', 40)->nullable();
            $table->string('zoning', 60)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_adjoiners');
    }
};
