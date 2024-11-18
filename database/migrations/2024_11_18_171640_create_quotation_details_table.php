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
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('quot_product_qty', 15, 2);
            $table->string('quot_product_unit');
            $table->decimal('quot_product_unit_price', 15, 2);
            $table->decimal('quot_product_total_price', 15, 2);
            $table->decimal('quot_product_discount', 15, 2)->nullable()->default(0.00);
            $table->decimal('quot_product_discount_amount', 15, 2)->default(0.00);
            $table->string('quot_product_name')->nullable();
            $table->string('quot_product_code')->nullable();
            $table->longText('quot_product_tech_spec')->nullable();
            $table->longText('quot_product_m_spec')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_details');
    }
};
