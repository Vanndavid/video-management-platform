<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AnalyticsController;

// Health check
Route::get('/health', [AnalyticsController::class, 'health']);

// Video lifecycle
Route::post('/videos', [VideoController::class, 'store']);
Route::get('/videos/{id}', [VideoController::class, 'show']);
Route::get('/listings', [VideoController::class, 'index']);
Route::get('/listings/{id}/videos', [VideoController::class, 'byListing']);

// Optional manual triggers
Route::post('/videos/{id}/transcode', [VideoController::class, 'transcode']);
Route::patch('/videos/{id}/status', [VideoController::class, 'patchStatus']);

// Analytics
Route::post('/videos/{id}/events', [AnalyticsController::class, 'store']);
Route::get('/analytics/top-videos', [AnalyticsController::class, 'topVideos']);
