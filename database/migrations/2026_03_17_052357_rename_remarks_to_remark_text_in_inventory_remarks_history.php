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
        Schema::table('inventory_remarks_history', function (Blueprint $table) {
            if (Schema::hasColumn('inventory_remarks_history', 'remarks') && ! Schema::hasColumn('inventory_remarks_history', 'remark_text')) {
                $table->renameColumn('remarks', 'remark_text');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_remarks_history', function (Blueprint $table) {
            if (Schema::hasColumn('inventory_remarks_history', 'remark_text')) {
                $table->renameColumn('remark_text', 'remarks');
            }
        });
    }
};
