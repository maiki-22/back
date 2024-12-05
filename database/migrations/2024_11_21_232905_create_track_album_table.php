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
        Schema::create('track_album', function (Blueprint $table) {
            $table->foreignId('artist_id')->constrained('artist')->onDelete('cascade');
            $table->foreignId('track_id')->constrained('track')->onDelete('cascade');
            //llave primaria compuesta
            $table->primary(['artist_id', 'track_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_album');
    }
};