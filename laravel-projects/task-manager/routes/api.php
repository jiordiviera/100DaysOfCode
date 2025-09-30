<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix("api:")->apiResource('projects', ProjectController::class);
Route::prefix("api:")->apiResource('projects.tasks', TaskController::class);
