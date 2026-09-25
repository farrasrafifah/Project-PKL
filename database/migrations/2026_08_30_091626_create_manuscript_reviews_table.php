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
    Schema::create('manuscript_reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('book_id')->constrained()->cascadeOnDelete();
        $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
        $table->text('catatan');
        $table->enum('keputusan', ['perlu_revisi', 'lanjut_editing'])->nullable();
        $table->timestamps();
    });
}
};
