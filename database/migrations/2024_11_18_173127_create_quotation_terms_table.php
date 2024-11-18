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
        Schema::create('quotation_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->tinyInteger('term_is_latest')->default(1)->comment("0:No,1:Yes");
            $table->string('term_discount')->nullable();
            $table->string('term_tax')->nullable();
            $table->string('term_inspection')->nullable();
            $table->string('term_price')->nullable();
            $table->string('term_dispatch')->nullable();
            $table->string('term_payment')->nullable();
            $table->string('term_warranty')->nullable();
            $table->string('term_validity')->nullable();
            $table->string('term_forwarding')->nullable();
            $table->text('term_note_1')->nullable();
            $table->text('term_note_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_terms');
    }
};
