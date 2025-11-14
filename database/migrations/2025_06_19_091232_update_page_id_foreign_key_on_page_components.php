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
        Schema::table('page_components', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->foreign('page_id')
            ->references('id')
            ->on('pages')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_components', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->foreign('page_id')
            ->references('id')
            ->on('pages');
        });
    }
};
