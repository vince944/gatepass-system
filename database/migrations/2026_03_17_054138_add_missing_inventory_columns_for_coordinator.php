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
        Schema::table('inventory', function (Blueprint $table) {
            if (! Schema::hasColumn('inventory', 'center')) {
                $table->string('center', 20)->nullable()->after('description');
            }

            if (! Schema::hasColumn('inventory', 'status')) {
                $table->string('status', 20)->nullable()->after('center');
            }

            if (! Schema::hasColumn('inventory', 'accountability')) {
                $table->string('accountability', 20)->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
            foreach (['accountability', 'status', 'center'] as $column) {
                if (Schema::hasColumn('inventory', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
