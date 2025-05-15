<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SectionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the AppServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Pages API routes
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{id}', [PageController::class, 'show'])->where('id', '[0-9]+');
Route::get('/pages/slug/{slug}', [PageController::class, 'showBySlug']);

// Projects API routes
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/featured', [ProjectController::class, 'featured']);
Route::get('/projects/{id}', [ProjectController::class, 'show'])->where('id', '[0-9]+');
Route::get('/projects/slug/{slug}', [ProjectController::class, 'showBySlug']);

// Sections API routes
Route::get('/sections', [SectionController::class, 'index']);
Route::get('/sections/{id}', [SectionController::class, 'show'])->where('id', '[0-9]+');
Route::get('/sections/page/{pageId}', [SectionController::class, 'byPage'])->where('pageId', '[0-9]+');
