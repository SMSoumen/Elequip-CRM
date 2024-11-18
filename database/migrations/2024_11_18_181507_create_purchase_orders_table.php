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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->string('po_refer_no', 50)->nullable();
            $table->decimal('po_amount', 15, 2)->default(0.00);
            $table->decimal('po_gross_amount', 15, 2)->default(0.00);
            $table->decimal('po_net_amount', 15, 2)->default(0.00);
            $table->decimal('po_taxable', 15, 2)->default(0.00);
            $table->decimal('po_tax_percent', 15, 2)->default(18.00);
            $table->decimal('po_advance', 15, 2)->nullable()->default(0.00);
            $table->decimal('po_remaining', 15, 2)->nullable()->default(0.00);
            $table->text('po_document')->nullable();
            $table->text('po_remarks')->nullable();
            $table->string('po_order_no')->nullable();
            $table->date('po_order_date')->nullable();
            $table->string('po_et_bill_no')->nullable();
            $table->foreignId('admin_id')->comment('creator')->constrained('admins')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
