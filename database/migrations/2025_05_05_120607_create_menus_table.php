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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title', 1000);
            $table->string('title_ur', 1000);
            $table->tinyInteger('redirection_type')->comment('1 = Redirect to Page, 2 = Redirect to Route, 3 = Redirect to External Link');
            $table->unsignedBigInteger('page_id')->nullable();
            $table->string('route')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
