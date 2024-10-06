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
        Schema::table('tbl_pengajuan', function (Blueprint $table) {
            $table->string('id_penanggung_jawab', 50)->nullable()->after('keterangan');
            $table->string('penanggung_jawab', 50)->nullable()->after('id_penanggung_jawab');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_pengajuan', function (Blueprint $table) {
            //
        });
    }
};
