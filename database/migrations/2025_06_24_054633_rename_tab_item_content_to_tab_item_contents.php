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
        Schema::rename('tab_item_content', 'tab_item_contents');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('tab_item_contents', 'tab_item_content');
    }
};
