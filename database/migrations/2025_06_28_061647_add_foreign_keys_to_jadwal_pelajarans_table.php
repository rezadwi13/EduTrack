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
        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            // Drop existing columns that will be replaced with foreign keys
            $table->dropColumn(['mata_pelajaran', 'guru']);
            
            // Add foreign key columns
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            // Drop foreign key columns
            $table->dropForeign(['mata_pelajaran_id']);
            $table->dropForeign(['guru_id']);
            $table->dropColumn(['mata_pelajaran_id', 'guru_id']);
            
            // Restore original columns
            $table->string('mata_pelajaran');
            $table->string('guru')->nullable();
        });
    }
};
