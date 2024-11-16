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
        Schema::create('lead_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('lead_product_name');
            $table->string('lead_product_code');
            $table->decimal('lead_product_qty', 15, 2);
            $table->decimal('lead_product_price', 15, 2);
            $table->longText('lead_product_tech_spec');
            $table->longText('lead_product_m_spec');
            $table->string('lead_product_unit');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_details');
    }
};
