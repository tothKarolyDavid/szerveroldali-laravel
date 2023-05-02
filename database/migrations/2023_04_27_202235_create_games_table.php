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
    Game - egy mérkőzés
        id
        start (datetime)
        finished (logikai, alapértelmezetten hamis)
        időbélyegek
    */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->datetime('start');
            $table->boolean('finished')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('away_team_id');

            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
