<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
    Event - egy esemény egy mérkőzésen belül
        id
        type (enum - eseménytípusok: gól, öngól, sárga lap, piros lap)
        minute (integer, hanyadik percben történt az esemény)
        időbélyegek
    */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['goal', 'owngoal', 'yellowcard', 'redcard']);
            $table->integer('minute');
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
