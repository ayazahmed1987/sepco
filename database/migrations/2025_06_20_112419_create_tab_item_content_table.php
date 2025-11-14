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
        Schema::create('tab_item_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tab_item_id')->constrained('tab_items')->onDelete('cascade');
            $table->string('image');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->tinyInteger('is_reversed')->default(2)->comment('1 = Yes, 2 = No');
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
        Schema::dropIfExists('tab_item_content');
    }
};
