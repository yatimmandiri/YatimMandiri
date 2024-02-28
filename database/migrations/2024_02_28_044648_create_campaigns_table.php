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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_name');
            $table->string('campaign_title');
            $table->string('campaign_slug');
            $table->text('campaign_excerpt');
            $table->text('campaign_description');
            $table->enum('campaign_template', ['T1', 'T2', 'T3', 'T4'])->default('T1');
            $table->integer('campaign_nominal')->default(0);
            $table->integer('campaign_nominal_min')->default(0);
            $table->integer('paket_id')->default(0);
            $table->text('campaign_featureimage')->nullable();
            $table->enum('campaign_status', ['Y', 'N'])->default('Y');
            $table->enum('campaign_populer', ['Y', 'N'])->default('N');
            $table->enum('campaign_recomendation', ['Y', 'N'])->default('N');
            $table->foreignId('categories_id')->constrained('categories')->cascadeOnUpdate('cascade')->cascadeOnDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
