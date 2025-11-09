<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('video_assets', function (Blueprint $table) {
            $table->id();
            $table->uuid('video_id');
            $table->foreign('video_id')->references('id')->on('videos')->cascadeOnDelete();
            $table->enum('type', ['ORIGINAL','TRANSCODED_1080P','TRANSCODED_720P','THUMBNAIL']);
            $table->string('url');
            $table->bigInteger('size_bytes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('video_assets'); }
};
