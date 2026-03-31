<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('gatepass_requests', 'qr_code_path')) {
            Schema::table('gatepass_requests', function (Blueprint $table) {
                $table->string('qr_code_path', 500)->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gatepass_requests', function (Blueprint $table) {
            $table->dropColumn(['qr_code_path', 'qr_code_generated_at']);
        });
    }
};
