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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Relasi ke user yang mengunggah
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');

            // Relasi ke user yang terakhir mengubah (boleh null)
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->string('name');
            $table->string('original_name')->nullable();
            $table->string('file_path');
            $table->string('file_type');
            $table->timestamp('uploaded_at');

            $table->string('bidang'); // tetap string karena enum-nya kecil dan fleksibel

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
