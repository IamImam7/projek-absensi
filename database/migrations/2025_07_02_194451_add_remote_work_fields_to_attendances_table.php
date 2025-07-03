<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('tipe_absensi', ['Di Kantor', 'Luar Kantor'])->default('Di Kantor')->after('status_kehadiran');
            $table->string('foto_bukti')->nullable()->after('tipe_absensi');
            $table->text('catatan_pekerjaan')->nullable()->after('foto_bukti');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['tipe_absensi', 'foto_bukti', 'catatan_pekerjaan']);
        });
    }
};
