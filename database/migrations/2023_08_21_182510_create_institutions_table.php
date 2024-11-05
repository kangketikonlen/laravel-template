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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->default('/storage/images/logo/default.jpg');
            $table->string('background')->default('/storage/images/background/default.jpg');
            $table->string('name');
            $table->string('address');
            $table->string('email');
            $table->string('website');
            $table->string('appUrl');
            $table->string('contact')->nullable(true)->default(null);
            $table->string('created_by')->default('System');
            $table->string('updated_by')->nullable(true)->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
