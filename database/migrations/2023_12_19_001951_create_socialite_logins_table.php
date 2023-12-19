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
        Schema::create('socialite_logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable(false)
                ->constrained()
                ->cascadeOnDelete()
                ->references('id')->on('users');
            $table->enum('provider', ['google', 'facebook']);
            $table->string('provider_user_id')->nullable(false);
            $table->string('access_token')->nullable(false);
            $table->string('refresh_token')
                ->nullable()
                ->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socialite_logins');
    }
};
