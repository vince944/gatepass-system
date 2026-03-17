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
            if (! Schema::hasColumn('inventory_propno_history', 'created_at')) {
                $table->timestamp('created_at')->nullable()->after('changed_at');
            }

            if (! Schema::hasColumn('inventory_propno_history', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_propno_history', function (Blueprint $table) {
            $columns = [];
            foreach (['created_at', 'updated_at'] as $column) {
                if (Schema::hasColumn('inventory_propno_history', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
