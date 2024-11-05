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
            $table->string('session_id');
            $table->date('date');
            $table->time('time');
            $table->string('user')->default('Guest');
            $table->string('role')->default('Guest');
            $table->string('ip_address');
            $table->string('method');
            $table->string('referer')->nullable(true)->default(null);
            $table->string('path');
            $table->unsignedBigInteger('totalHit')->default(1);
            $table->string('description');
            $table->string('created_by')->default('System');
            $table->string('updated_by')->nullable(true)->default(null);
            $table->timestamps();
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
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
