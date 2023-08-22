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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('sessionID');
            $table->date('date');
            $table->time('time');
            $table->string('user')->default('Guest');
            $table->string('role')->default('Guest');
            $table->string('ipAddress');
            $table->string('method');
            $table->string('referer')->nullable(true)->default(null);
            $table->string('path');
            $table->unsignedBigInteger('totalHit')->default(1);
            $table->string('description');
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
        Schema::dropIfExists('activity_logs');
    }
};
