<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE penjadwalan MODIFY COLUMN status ENUM('Diajukan', 'Disetujui_Wali', 'Ditolak_Wali', 'Terjadwal', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Terjadwal'");

        Schema::table('penjadwalan', function (Blueprint $table) {
            $table->integer('id_wali')->nullable()->after('status');
            $table->timestamp('waktu_persetujuan_wali')->nullable()->after('id_wali');
            $table->text('catatan_wali')->nullable()->after('waktu_persetujuan_wali');

            $table->foreign('id_wali')
                ->references('id_user')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjadwalan', function (Blueprint $table) {
            $table->dropForeign(['id_wali']);
            $table->dropColumn(['id_wali', 'waktu_persetujuan_wali', 'catatan_wali']);
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE penjadwalan MODIFY COLUMN status ENUM('Terjadwal', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Terjadwal'");
    }
};
