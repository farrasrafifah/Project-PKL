<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            // Penulis (akun User yang sama, fungsi Penulis)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Genre buku
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('synopsis')->nullable();

            // Status mengikuti Flowchart bagian 6 (STATUS NASKAH / EBOOK)
            $table->enum('status', [
                'draft',                 // Naskah baru dibuat, belum dikirim
                'dikirim_redaksi',       // Sudah dikirim, menunggu masuk antrian
                'menunggu_review',       // Ada di antrian review redaksi
                'revisi',                // Redaksi minta revisi ke penulis
                'editing',               // Redaksi sedang edit/format naskah
                'finalisasi',            // Proses finalisasi sebelum terbit
                'siap_terbit',           // Sudah difinalisasi, siap dipublish
                'terbit',                // Sudah terbit & masuk marketplace
            ])->default('draft');

            $table->decimal('price', 10, 2)->nullable();

            // Redaksi yang menangani review (nullable, diisi saat masuk proses review)
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};