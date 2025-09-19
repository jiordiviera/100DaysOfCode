<?php

use App\Livewire\Page\{Dashboard, ProjectManager, TaskManager};
use App\Livewire\Page\Welcome;
use Illuminate\Support\Facades\Route;

Route::get("/", Welcome::class)->name("home");

Route::middleware("auth")->group(function () {
    Route::get("dashboard", Dashboard::class)->name('dashboard');
    Route::get("logout", function (){
        auth()->logout();
        return redirect()->route("home");
    })->name('logout');
    // Routes Livewire pour la gestion des projets et des tâches
    Route::get('projects', ProjectManager::class)->name('projects.index');
    Route::get('projects/{project}/tasks', TaskManager::class)->name('projects.tasks.index');
});

require __DIR__ . "/auth.php";
