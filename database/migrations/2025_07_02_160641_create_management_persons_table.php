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
        Schema::create('management_people', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('1 = Board of Directors, 2 = Management Team');
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('designation');
            $table->longText('description')->nullable();
            $table->integer('sorting')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('management_people');
    }
};
