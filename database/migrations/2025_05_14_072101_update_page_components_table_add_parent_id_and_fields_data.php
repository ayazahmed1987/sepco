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
        Schema::table('page_components', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->foreign('parent_id')->references('id')->on('page_components')->nullOnDelete();
            $table->json('fields_data')->nullable()->after('related_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_components', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['fields_data', 'parent_id']);
        });
    }
};
