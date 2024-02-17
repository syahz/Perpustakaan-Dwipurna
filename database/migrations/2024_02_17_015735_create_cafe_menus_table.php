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
        Schema::create('cafe_menus', function (Blueprint $table) {
            $table->uuid('id_menu')->primary();
            $table->string('nama_menu');
            $table->decimal('price', 8, 2);
            $table->uuid('cafe_id');

            $table->foreign('cafe_id')->references('id_cafe')->on('cafes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cafe_menus');
    }
};
