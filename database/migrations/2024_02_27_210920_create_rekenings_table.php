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
        Schema::create('rekenings', function (Blueprint $table) {
            $table->id();
            $table->string('rekening_name');
            $table->string('rekening_number');
            $table->string('rekening_bank');
            $table->enum('rekening_provider', ['Midtrans', 'Moota', 'Dana'])->default('Midtrans');
            $table->enum('rekening_group', ['bank_transfer', 'e_money', 'direct_debit', 'convenience_store', 'cardless_credit'])->default('bank_transfer');
            $table->string('rekening_token')->default('-');
            $table->text('rekening_icon')->nullable();
            $table->enum('rekening_status', ['Y', 'N'])->default('Y');
            $table->enum('rekening_populer', ['Y', 'N'])->default('N');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekenings');
    }
};
