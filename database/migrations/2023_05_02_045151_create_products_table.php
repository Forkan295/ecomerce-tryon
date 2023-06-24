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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->index();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title_en');
            $table->string('title_bn')->nullable();
            $table->string('slug')->index();
            $table->string('sku')->index();
            $table->text('content_en')->nullable();
            $table->text('content_bn')->nullable();
            $table->decimal('cost_price')->default(0);
            $table->decimal('sales_price')->default(0);
            $table->decimal('compare_price')->default(0);
            $table->decimal('profit')->default(0);
            $table->decimal('profit_margin')->default(0);
            $table->integer('order')->default(0);
            $table->unsignedBigInteger('tax_id')->nullable()->index();
            $table->boolean('is_featured')->default(0)->index();
            $table->boolean('is_variation')->default(0)->index();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
