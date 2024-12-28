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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->foreignId('product_sub_category_id')->nullable()->constrained('product_sub_categories')->cascadeOnDelete();
            $table->string('product_name');
            $table->string('product_code')->unique();
            $table->decimal('product_price', 15, 2);
            $table->foreignId('measuring_unit_id')->constrained('measuring_units')->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnDelete();
            $table->longText('product_tech_spec')->nullable();
            $table->longText('product_marketing_spec')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
