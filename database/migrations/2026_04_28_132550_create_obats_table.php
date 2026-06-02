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
        Schema::create('obats', function (Blueprint $table) {
            $table->id('id_obat'); // Sesuai dengan id_obat di PHP native kamu
            $table->string('nama_obat');
            $table->string('kategori')->nullable();
            $table->integer('stok')->default(0);
            $table->integer('harga'); // Harga Jual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
    
};
