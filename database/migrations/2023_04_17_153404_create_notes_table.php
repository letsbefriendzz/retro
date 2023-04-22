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
        Schema::create('notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('content')->nullable(false);
            $table->enum('retro_column', [
                'wentWell',
                'toImprove',
                'toDiscuss',
            ])->nullable(false);
            $table->unsignedBigInteger('session_idr')->nullable(false);
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retro_notes');
    }
};
