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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 20)->nullable();
            $table->string('serial_no', 30)->nullable();
            $table->string('acct_code', 10)->nullable();
            $table->string('pn_old', 6)->nullable();
            $table->string('pn_code_old', 6)->nullable();
            $table->string('mrr_no', 9)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('center', 20)->nullable();
            $table->string('status', 20)->nullable();
            $table->string('accountability', 20)->nullable();
            $table->timestamps();

            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::create('inventory_propno_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventory')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('prop_no', 8);
            $table->timestamps();

            $table->unique('prop_no');
            $table->index(['inventory_id', 'created_at']);
        });

        Schema::create('inventory_unit_cost_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventory')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->timestamps();

            $table->index(['inventory_id', 'created_at']);
        });

        Schema::create('inventory_end_user_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventory')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('end_user', 20)->nullable();
            $table->timestamps();

            $table->index(['inventory_id', 'created_at']);
        });

        Schema::create('inventory_remarks_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventory')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('remarks', 500)->nullable();
            $table->timestamps();

            $table->index(['inventory_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_remarks_history');
        Schema::dropIfExists('inventory_end_user_history');
        Schema::dropIfExists('inventory_unit_cost_history');
        Schema::dropIfExists('inventory_propno_history');
        Schema::dropIfExists('inventory');
    }
};
