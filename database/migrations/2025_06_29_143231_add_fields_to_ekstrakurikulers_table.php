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
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            $table->string('pembina')->nullable();
            $table->string('hari')->nullable();
            $table->string('jam')->nullable();
            $table->string('tempat')->nullable();
            $table->integer('kuota')->nullable();
            $table->string('status')->nullable();
            $table->string('jenis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            $table->dropColumn(['pembina', 'hari', 'jam', 'tempat', 'kuota', 'status', 'jenis']);
        });
    }
};
