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
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // bigint unsigned, auto-incrementing
            $table->string('name', 255); // varchar(255)
            $table->string('user_code', 50)->nullable(); // varchar(50), nullable
            $table->string('email', 255)->unique(); // varchar(255), unique
            $table->timestamp('email_verified_at')->nullable(); // timestamp, nullable
            $table->string('password', 255); // varchar(255)
            $table->string('remember_token', 100)->nullable(); // varchar(100), nullable
            $table->string('last_session', 255)->nullable(); // varchar(255), nullable
            $table->boolean('isactive')->default(true); // tinyint(1), default 1
            $table->boolean('is_admin')->default(false); // tinyint(1), default 0
            $table->softDeletes(); // timestamp, for deleted_at
            $table->integer('deleted_by')->nullable(); // int, nullable
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
