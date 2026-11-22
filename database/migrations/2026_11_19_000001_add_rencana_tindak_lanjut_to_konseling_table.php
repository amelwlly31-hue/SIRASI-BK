<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('konseling', 'rencana_tindak_lanjut')) {
            Schema::table('konseling', function (Blueprint $table) {
                $table->text('rencana_tindak_lanjut')->nullable()->after('diagnosis');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('konseling', 'rencana_tindak_lanjut')) {
            Schema::table('konseling', function (Blueprint $table) {
                $table->dropColumn('rencana_tindak_lanjut');
            });
        }
    }
};
