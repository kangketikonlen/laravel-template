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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->string('name', 128);
            $table->string('picture')->default('/storage/images/profile/default.png');
            $table->string('username', 128)->unique();
            $table->string('password');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('created_by')->default('System');
            $table->string('updated_by')->nullable(true)->default(null);
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
