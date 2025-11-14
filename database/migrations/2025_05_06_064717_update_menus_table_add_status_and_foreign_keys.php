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
        Schema::table('menus', function (Blueprint $table) {
            $table->boolean('status')->default(0)->after('route');
            $table->foreign('parent_id')->references('id')->on('menus')->nullOnDelete();
            $table->foreign('page_id')->references('id')->on('pages')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['page_id']);
            $table->dropColumn('status');
        });
    }
};
