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
        Schema::create('tab_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tab_id')->constrained('product_tabs')->onDelete('cascade');
            $table->string('item_name');
            $table->text('image')->nullable();
            $table->text('content')->nullable();
            $table->integer('sorting')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_items');
    }
};
