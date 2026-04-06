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
        if (Schema::hasColumn('employees', 'employee_type')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->string('employee_type', 50)->nullable()->after('empl_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('employees', 'employee_type')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('employee_type');
        });
    }
};
