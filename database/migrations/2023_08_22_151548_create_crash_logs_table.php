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
        Schema::create('crash_logs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->string('message');
            $table->string('location');
            $table->string('file');
            $table->string('line');
            $table->unsignedBigInteger('totalHit')->default(1);
            $table->string('createdBy')->default('System');
            $table->timestamp('createdAt');
            $table->string('updatedBy')->nullable(true)->default(null);
            $table->timestamp('updatedAt')->nullable(true)->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crash_logs');
    }
};
