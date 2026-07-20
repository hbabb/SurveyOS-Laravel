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
        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(); // NOTE: Added nullable here for client contact setup. See docs/adr/0001_Users.md for more details.
            $table->enum('type', ['employee', 'contact']);
            $table->rememberToken();
            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('type');
        });

        Schema::create('password_reset_tokens', static function (Blueprint $table) {
            /**
             * NOTE: Stock Fortify/Laravel table. Framework-owned, no custom fields planned.
             * There is no need for a foreign key here. The email is the primary key and used in a search function between this table and the user's table.
             */
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', static function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity');

            // Indexes
            $table->index('last_activity');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
