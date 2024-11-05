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
        Schema::create('module_customs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->default('custom');
            $table->string('icon')->default('fa-list');
            $table->string('description');
            $table->string('url');
            $table->string('navbars')->nullable(true)->default(null);
            $table->string('subnavbars')->nullable(true)->default(null);
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
        Schema::dropIfExists('module_customs');
    }
};
