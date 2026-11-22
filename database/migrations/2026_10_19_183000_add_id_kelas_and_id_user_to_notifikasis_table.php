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
        Schema::table('notifikasis', function (Blueprint $table) {
            if (!Schema::hasColumn('notifikasis', 'id_kelas')) {
                $table->unsignedBigInteger('id_kelas')->nullable()->after('id_konseling');
            }
            if (!Schema::hasColumn('notifikasis', 'id_user')) {
                $table->unsignedBigInteger('id_user')->nullable()->after('id_kelas');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifikasis', function (Blueprint $table) {
            if (Schema::hasColumn('notifikasis', 'id_user')) {
                $table->dropColumn('id_user');
            }
            if (Schema::hasColumn('notifikasis', 'id_kelas')) {
                $table->dropColumn('id_kelas');
            }
        });
    }
};
