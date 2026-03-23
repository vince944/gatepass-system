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
        Schema::table('gatepass_items', function (Blueprint $table) {
            $table->string('item_status', 32)->default('pending_return')->after('item_remarks');
            $table->timestamp('returned_at')->nullable()->after('item_status');
            $table->foreignId('last_inspected_by')->nullable()->after('returned_at')->constrained('users')->nullOnDelete();
            $table->text('inspection_remarks')->nullable()->after('last_inspected_by');
        });

        Schema::table('gatepass_requests', function (Blueprint $table) {
            $table->text('incoming_inspection_remarks')->nullable()->after('rejection_reason');
            $table->timestamp('incoming_inspected_at')->nullable()->after('incoming_inspection_remarks');
            $table->foreignId('incoming_inspected_by')->nullable()->after('incoming_inspected_at')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gatepass_items', function (Blueprint $table) {
            $table->dropForeign(['last_inspected_by']);
            $table->dropColumn(['item_status', 'returned_at', 'last_inspected_by', 'inspection_remarks']);
        });

        Schema::table('gatepass_requests', function (Blueprint $table) {
            $table->dropForeign(['incoming_inspected_by']);
            $table->dropColumn(['incoming_inspection_remarks', 'incoming_inspected_at', 'incoming_inspected_by']);
        });
    }
};
