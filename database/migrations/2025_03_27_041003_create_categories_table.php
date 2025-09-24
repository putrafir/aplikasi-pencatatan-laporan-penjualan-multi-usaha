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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->unsignedBigInteger('business_id');
            // $table->unsignedBigInteger('super_kategori_id')->nullable();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            // $table->foreign('super_kategori_id')->references('id')->on('super_categories')->onDelete('cascade');
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
