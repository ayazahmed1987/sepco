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
            $table->text('title')->nullable()->after('id');
            $table->integer('sorting')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_components', function (Blueprint $table) {
            $table->dropColumn(['title', 'sorting']);
        });
    }
};
