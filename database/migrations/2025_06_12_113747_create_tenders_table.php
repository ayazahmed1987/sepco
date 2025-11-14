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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->nullable();
            $table->string('title'); // heading can be long
            $table->text('description')->nullable(); // long description
            $table->date('participation_closing_date');
            $table->time('participation_closing_time');
            $table->date('bids_opening_date');
            $table->time('bids_opening_time');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
