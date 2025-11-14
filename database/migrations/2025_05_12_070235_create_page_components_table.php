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
        Schema::create('page_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('type');
            // For type = 1
            $table->foreignId('component_id')->nullable()->constrained()->nullOnDelete();
            // For type = 2
            $table->string('related_type')->nullable(); // Fully-qualified model class
            $table->unsignedBigInteger('related_id')->nullable(); // For polymorphic relation
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_components');
    }
};
