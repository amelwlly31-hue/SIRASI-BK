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
        if (!Schema::hasTable('jadwal_mengajar_bk')) {
            Schema::create('jadwal_mengajar_bk', function (Blueprint $table) {
                $table->id('id_jadwal_mengajar');
                $table->integer('id_guru_bk')->nullable();
                $table->string('hari', 20);
                $table->date('tanggal')->nullable();
                $table->time('waktu_mulai');
                $table->time('waktu_selesai');
                $table->integer('id_kelas')->nullable();
                $table->string('mata_pelajaran', 150)->default('Bimbingan Klasikal BK');
                $table->text('catatan')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->foreign('id_guru_bk')
                    ->references('id_user')
                    ->on('users')
                    ->nullOnDelete();

                $table->foreign('id_kelas')
                    ->references('id_kelas')
                    ->on('kelas')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasTable('slot_konseling')) {
            Schema::create('slot_konseling', function (Blueprint $table) {
                $table->id('id_slot');
                $table->integer('id_guru_bk')->nullable();
                $table->date('tanggal');
                $table->time('waktu_mulai');
                $table->time('waktu_selesai');
                $table->integer('durasi_menit')->default(60);
                $table->enum('status_slot', ['Tersedia', 'Menunggu_Diproses', 'Dipesan', 'Tidak_Tersedia'])
                    ->default('Tersedia');
                $table->text('catatan')->nullable();
                $table->timestamps();

                $table->foreign('id_guru_bk')
                    ->references('id_user')
                    ->on('users')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('penjadwalan', 'id_slot')) {
            Schema::table('penjadwalan', function (Blueprint $table) {
                $table->unsignedBigInteger('id_slot')->nullable()->after('id_siswa');

                $table->foreign('id_slot')
                    ->references('id_slot')
                    ->on('slot_konseling')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('penjadwalan', 'id_slot')) {
            Schema::table('penjadwalan', function (Blueprint $table) {
                $table->dropForeign(['id_slot']);
                $table->dropColumn('id_slot');
            });
        }

        Schema::dropIfExists('slot_konseling');
        Schema::dropIfExists('jadwal_mengajar_bk');
    }
};
