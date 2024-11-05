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
        Schema::create('app_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('dev');
            $table->string('dev_url');
            $table->string('registered');
            $table->string('sponsor')->default(null)->nullable(true);
            $table->string('sponsor_url')->default(null)->nullable(true);
            $table->string('sponsor_logo')->default(null)->nullable(true);
            $table->unsignedTinyInteger('is_maintenance')->default(0);
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
        Schema::dropIfExists('app_infos');
    }
};
