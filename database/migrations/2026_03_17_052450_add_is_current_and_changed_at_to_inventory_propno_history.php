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
        Schema::table('inventory_propno_history', function (Blueprint $table) {
            if (! Schema::hasColumn('inventory_propno_history', 'is_current')) {
                $table->boolean('is_current')->default(true)->after('prop_no');
            }
            if (! Schema::hasColumn('inventory_propno_history', 'changed_at')) {
                $table->timestamp('changed_at')->nullable()->after('is_current');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_propno_history', function (Blueprint $table) {
            $table->dropColumn(['is_current', 'changed_at']);
        });
    }
};
