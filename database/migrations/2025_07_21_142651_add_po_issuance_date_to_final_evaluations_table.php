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
        Schema::table('final_evaluations', function (Blueprint $table) {
            $table->date('po_issuance_date')->nullable()->after('published_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_evaluations', function (Blueprint $table) {
            $table->dropColumn('po_issuance_date');
        });
    }
};
