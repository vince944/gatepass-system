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
            if (! Schema::hasColumn('inventory', 'pn_old')) {
                $table->string('pn_old', 6)->nullable()->after('acct_code');
            }

            if (! Schema::hasColumn('inventory', 'pn_code_old')) {
                $table->string('pn_code_old', 6)->nullable()->after('pn_old');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
            if (Schema::hasColumn('inventory', 'pn_code_old')) {
                $table->dropColumn('pn_code_old');
            }

            if (Schema::hasColumn('inventory', 'pn_old')) {
                $table->dropColumn('pn_old');
            }
        });
    }
};
