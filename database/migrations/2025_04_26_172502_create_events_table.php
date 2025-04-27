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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('event_name');
            $table->text('event_desc');
            $table->unsignedInteger('event_category_id')->references('id')->on('event_categories')->onDelete('cascade');
            $table->unsignedInteger('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->integer('max_participants')->default(100);
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            // $table->foreign('event_category_id')
            // $table->foreign('company_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
