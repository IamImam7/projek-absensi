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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->enum('status_kehadiran', ['Tepat Waktu', 'Terlambat', 'Absen'])->default('Absen');
            $table->string('lokasi_check_in')->nullable();
            $table->string('lokasi_check_out')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Membuat tanggal dan employee_id unik untuk mencegah check-in ganda di hari yang sama
            $table->unique(['employee_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
