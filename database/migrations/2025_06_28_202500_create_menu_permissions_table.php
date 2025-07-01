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
        Schema::create('menu_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->string('menu_route');
            $table->string('menu_icon')->nullable();
            $table->string('menu_label');
            $table->enum('role', ['admin', 'guru', 'siswa']);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->boolean('can_create')->default(true);
            $table->boolean('can_read')->default(true);
            $table->boolean('can_update')->default(true);
            $table->boolean('can_delete')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_permissions');
    }
}; 