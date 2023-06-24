<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title_en')->index();
            $table->string('title_bn')->nullable();
            $table->string('slug')->index();
            $table->text('content_en')->nullable();
            $table->text('content_bn')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedBigInteger('category_type_id')->nullable()->index();
            $table->integer('order')->default(0)->index();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
