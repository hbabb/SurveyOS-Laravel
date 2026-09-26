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
        Schema::create('parcel_transfers', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_parcel_id')->constrained()->cascadeOnDelete();
            $table->string('grantor', 220);
            $table->string('grantee', 220);
            $table->string('deed_book', 20);
            $table->string('deed_page', 20);
            $table->string('plat_book', 20)->nullable();
            $table->string('plat_page', 20)->nullable();
            $table->date('recorded_date');
            $table->string('instrument_type', 60)->nullable();
            $table->foreignId('project_document_id')->nullable()->constrained()->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['project_parcel_id', 'recorded_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcel_transfers');
    }
};
