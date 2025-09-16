<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Livewire\Page\Dashboard;
use App\Livewire\Page\Welcome;
use Illuminate\Support\Facades\Route;

Route::get("/", Welcome::class)->name("home");

Route::middleware("auth")->group(function () {
    Route::get("dashboard", Dashboard::class)->name('dashboard');
    Route::get("logout", function (){
        auth()->logout();
        return redirect()->route("home");
    })->name('logout');
    Route::resource("projects", ProjectController::class);
    Route::resource("projects.tasks", TaskController::class);
});

require __DIR__ . "/auth.php";
