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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->string('quot_ref_no')->nullable();
            $table->string('quot_user_ref_no')->nullable();
            $table->text('quot_remarks')->nullable();
            $table->decimal('quot_version', 5, 1)->nullable()->default(1.0);
            $table->tinyInteger('qout_is_latest')->default(1)->comment("0:No,1:Yes");
            $table->decimal('quot_amount', 15, 2)->default(0.00);
            $table->foreignId('admin_id')->comment('creator')->constrained('admins')->cascadeOnDelete();
            $table->tinyInteger('status')->nullable()->default(0)->comment("0:Pending,1:Accepted,2:Rejected");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
