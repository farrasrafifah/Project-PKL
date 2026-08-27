<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();

            // Referensi order yang membuat buku ini masuk ke library (nullable, jaga-jaga jika ada cara lain dapat buku)
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();

            $table->timestamps();

            // Satu user tidak bisa punya buku yang sama dua kali di library
            $table->unique(['user_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};