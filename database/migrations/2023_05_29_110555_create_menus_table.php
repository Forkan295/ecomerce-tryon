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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('icon');
            $table->string('route')->nullable();
            $table->unsignedInteger('parent_id')->default(0);
            $table->unsignedBigInteger('permission_id')->nullable();

            $table->foreign('permission_id')->references('id')->on('permissions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
