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
        Schema::create('register_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->references('id')->on('users')->onDelete(null);
            $table->unsignedInteger('event_id')->references('id')->on('events')->onDelete(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_events');
    }
};
