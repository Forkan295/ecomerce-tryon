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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('store_name')->nullable();
            $table->string('slogan')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('legal_business_name')->nullable();
            $table->bigInteger('country_id')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->string('order_id_prefix')->nullable();
            $table->string('order_id_suffix')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
