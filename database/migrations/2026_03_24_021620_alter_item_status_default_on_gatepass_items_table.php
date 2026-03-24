<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('gatepass_items')
            ->where('item_status', 'pending_return')
            ->update(['item_status' => null]);

        Schema::table('gatepass_items', function (Blueprint $table) {
            $table->string('item_status', 32)->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gatepass_items', function (Blueprint $table) {
            $table->string('item_status', 32)->default('pending_return')->change();
        });

        DB::table('gatepass_items')
            ->whereNull('item_status')
            ->update(['item_status' => 'pending_return']);
    }
};
