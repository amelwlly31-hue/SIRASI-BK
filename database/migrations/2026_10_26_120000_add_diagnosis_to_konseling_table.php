<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('konseling', function (Blueprint $table) {
            $table->text('diagnosis')->nullable()->after('hasil_konseling');
        });
    }

    public function down()
    {
        Schema::table('konseling', function (Blueprint $table) {
            $table->dropColumn('diagnosis');
        });
    }
};
