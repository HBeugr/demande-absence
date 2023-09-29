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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('statut_absence_id');
            $table->unsignedBigInteger('motif_absence_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('statut_absence_id')->references('id')->on('statut_absences');
            $table->foreign('motif_absence_id')->references('id')->on('motif_absences');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
