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
        Schema::create('gatepass_rejection_missing_items', function (Blueprint $table) {
            $table->id();
            $table->string('gatepass_no', 50);
            $table->unsignedBigInteger('gatepass_item_id');
            $table->timestamps();

            $table->index('gatepass_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gatepass_rejection_missing_items');
    }
};
