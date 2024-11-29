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
        Schema::create('order_and_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('order_product_name')->nullable();
            $table->string('order_product_code')->nullable();
            $table->string('measuring_unit')->nullable();
            // $table->foreignId('measuring_unit_id')->constrained('measuring_units')->cascadeOnDelete();
            $table->decimal('order_product_qty', 15, 2)->default(0.00);
            $table->longText('order_product_spec')->nullable();
            $table->decimal('order_product_unit_price', 15, 2)->default(0.00)->nullable();
            $table->decimal('order_product_total_price', 15, 2)->default(0.00)->nullable();
            $table->date('order_product_delivery_date')->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment("0:Pending,1:Dispatched,2:Delivered");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_and_deliveries');
    }
};
