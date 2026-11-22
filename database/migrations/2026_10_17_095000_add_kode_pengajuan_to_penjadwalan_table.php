<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('penjadwalan', 'kode_pengajuan')) {
            Schema::table('penjadwalan', function (Blueprint $table) {
                $table->string('kode_pengajuan', 30)->nullable()->unique()->after('id_penjadwalan');
            });
        }

        // Isi kode_pengajuan untuk data lama yang belum memiliki kode (aman bagi data eksisting)
        $existingRows = DB::table('penjadwalan')->whereNull('kode_pengajuan')->get(['id_penjadwalan']);
        foreach ($existingRows as $row) {
            do {
                $code = 'BK-' . strtoupper(Str::random(6));
            } while (DB::table('penjadwalan')->where('kode_pengajuan', $code)->exists());

            DB::table('penjadwalan')
                ->where('id_penjadwalan', $row->id_penjadwalan)
                ->update(['kode_pengajuan' => $code]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('penjadwalan', 'kode_pengajuan')) {
            Schema::table('penjadwalan', function (Blueprint $table) {
                $table->dropUnique(['kode_pengajuan']);
                $table->dropColumn('kode_pengajuan');
            });
        }
    }
};
