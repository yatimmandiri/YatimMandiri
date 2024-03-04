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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donation_notransaksi');
            $table->integer('donation_quantity');
            $table->integer('donation_nominaldonasi');
            $table->integer('donation_uniknominal')->default(0);
            $table->text('donation_keterangan')->nullable();
            $table->text('donation_billcode')->nullable();
            $table->text('donation_vanumber')->nullable();
            $table->text('donation_qrcode')->nullable();
            $table->text('donation_deeplinks')->nullable();
            $table->string('donation_referals')->nullable()->default('-');
            $table->json('donation_responsedonasi')->nullable();
            $table->json('donation_shohibul')->nullable();
            $table->enum('donation_status', ['Pending', 'Success', 'Expired'])->default('Pending');
            $table->enum('donation_hambaallah', ['Y', 'N'])->default('N');
            $table->enum('donation_sync', ['Y', 'N'])->default('N');
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate('cascade')->cascadeOnDelete('cascade');
            $table->foreignId('campaign_id')->constrained('campaigns')->cascadeOnUpdate('cascade')->cascadeOnDelete('cascade');
            $table->foreignId('rekening_id')->constrained('rekenings')->cascadeOnUpdate('cascade')->cascadeOnDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
