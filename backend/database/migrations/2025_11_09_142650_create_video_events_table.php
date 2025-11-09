<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('video_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('video_id');
            $table->foreign('video_id')->references('id')->on('videos')->cascadeOnDelete();
            $table->enum('event_type', ['PLAY','COMPLETE']);
            $table->string('user_agent')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('video_events'); }
};
