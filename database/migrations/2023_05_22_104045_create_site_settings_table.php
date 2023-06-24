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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedInteger('parent_id')->nullable();
            $table->integer('order')->default(0);
            $table->string('description')->nullable();
            $table->string('input_type')->nullable();
            $table->text('default_value')->nullable();
            $table->text('input_options')->nullable();
            $table->boolean('status')->default(true);
            $table->text('setting_value')->nullable();
            $table->unsignedInteger('saved_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
