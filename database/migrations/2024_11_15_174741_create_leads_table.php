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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('lead_source_id')->constrained('lead_sources')->cascadeOnDelete();
            $table->foreignId('lead_category_id')->constrained('lead_categories')->cascadeOnDelete();
            $table->text('lead_remarks')->nullable();
            $table->date('lead_estimate_closure_date')->nullable();
            $table->decimal('lead_total_amount', 15, 2);
            $table->foreignId('lead_stage_id')->default(1)->constrained('lead_stages')->cascadeOnDelete();
            $table->foreignId('admin_id')->comment('lead creator')->constrained('admins')->cascadeOnDelete();
            $table->foreignId('lead_assigned_to')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->foreignId('lead_stage_id')->constrained('lead_stages')->cascadeOnDelete();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
