<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('source_url'); // e.g. s3://fake/vid.mp4
            $table->enum('status', ['UPLOADED','PROCESSING','READY','FAILED'])->default('UPLOADED');
            $table->integer('duration_seconds')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('videos'); }
};
