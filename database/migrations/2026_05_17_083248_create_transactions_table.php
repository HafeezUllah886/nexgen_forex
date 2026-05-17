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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('location')->nullable();
            $table->string('number')->nullable();
            $table->decimal('credit', 15, 2)->default(0);
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('toman_credit', 15, 2)->default(0);
            $table->decimal('toman_debit', 15, 2)->default(0);
            $table->decimal('dollar_credit', 15, 2)->default(0);
            $table->decimal('dollar_debit', 15, 2)->default(0);
            $table->decimal('afg_credit', 15, 2)->default(0);
            $table->decimal('afg_debit', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
