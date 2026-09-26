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
        Schema::create('project_parcels', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->index()->constrained()->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->string('parcel_label', 60)->nullable();
            $table->string('subject_pin', 80)->nullable()->index();
            $table->string('current_owner_name', 220)->nullable();
            $table->string('subdivision_name', 190)->nullable();
            $table->string('lot_number', 40)->nullable();
            $table->decimal('site_area_acres', 10, 4)->nullable();
            $table->string('deed_book', 20)->nullable();
            $table->string('deed_page', 20)->nullable();
            $table->string('plat_book', 20)->nullable();
            $table->string('plat_page', 20)->nullable();
            $table->timestamps();

            $table->index(['deed_book', 'deed_page']);
            $table->index(['plat_book', 'plat_page']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_parcels');
    }
};
