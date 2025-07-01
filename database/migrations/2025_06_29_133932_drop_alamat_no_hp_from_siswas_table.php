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
        Schema::table('siswas', function (Blueprint $table) {
            if (Schema::hasColumn('siswas', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('siswas', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('alamat')->nullable();
            $table->string('no_hp')->nullable();
        });
    }
};
