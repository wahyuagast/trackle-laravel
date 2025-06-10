<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('projects', ProjectController::class);
Route::post('/projects/{project}/comments', [ProjectController::class, 'storeComment'])->name('api.projects.comments.store');

Route::apiResource('projects', ProjectController::class)->names([
    'store' => 'api.projects.store',
    'update' => 'api.projects.update',
]);