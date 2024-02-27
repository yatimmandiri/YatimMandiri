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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('categories_name');
            $table->string('categories_title');
            $table->string('categories_slug');
            $table->text('categories_description');
            $table->text('categories_excerpt');
            $table->text('categories_icon')->nullable();
            $table->text('categories_featureimage')->nullable();
            $table->enum('categories_status', ['Y', 'N'])->default('Y');
            $table->enum('categories_populer', ['Y', 'N'])->default('N');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
