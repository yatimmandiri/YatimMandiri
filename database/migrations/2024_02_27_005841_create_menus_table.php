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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->string('menu_icon')->default('fas fa-chevron-right nav-icons');
            $table->string('menu_link')->default('#');
            $table->integer('menu_parent');
            $table->integer('menu_order')->default(0);
            $table->timestamps();
        });

        Schema::create('role_has_menus', function (Blueprint $table) {
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnUpdate('cascade')->cascadeOnDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->cascadeOnUpdate('cascade')->cascadeOnDelete('cascade');
            $table->primary(['menu_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('role_has_menus');
    }
};
