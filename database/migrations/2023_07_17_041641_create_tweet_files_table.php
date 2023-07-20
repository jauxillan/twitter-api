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
        Schema::create('tweet_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tweet_id');

            $table->foreign('tweet_id')->references('id')->on('tweets')->onDelete('cascade');

            $table->text('file');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweet_files');
    }
};
