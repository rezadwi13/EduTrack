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
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            if (Schema::hasColumn('mata_pelajarans', 'sks')) {
                $table->dropColumn('sks');
            }
            if (Schema::hasColumn('mata_pelajarans', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->integer('sks')->nullable();
            $table->text('deskripsi')->nullable();
        });
    }
};
