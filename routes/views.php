<?php

use Illuminate\Support\Facades\Route;
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| View Routes
|--------------------------------------------------------------------------
|
| Aquí se definen todas las rutas relacionadas con las vistas web.
| Estas rutas están separadas de las rutas API para mantener el orden.
|
*/

// Ruta principal
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

// Rutas de autenticación (vistas)
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login')->middleware('guest');

// Rutas protegidas por autenticación (vistas)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/funnel', function () {
            return view('funnel');
        })->name('funnel');

        Route::get('/users', function () {
            return view('users.manage');
        })->name('users');

        Route::get('/rbac', function () {
            return view('rbac.manage');
        })->name('rbac');

        Route::get('/currencies', function () {
            return view('currencies.manage');
        })->name('currencies');

        Route::get('/color-themes', function () {
            return view('color-themes.manage');
        })->name('color-themes');

        // ========================= Projects (Vistas) =========================
        Route::get('/projects', function () {
            return view('projects.index');
        })->name('projects');

        // Show: sólo Overview
        Route::get('/projects/{id}', function ($id) {
            $project = Project::find($id);
            if (!$project) abort(404);
            return view('projects.show', ['projectId' => (int)$id, 'project' => $project]);
        })->name('projects.show');

        // Vistas dedicadas
        Route::get('/projects/{id}/backlog', function ($id) {
            $project = Project::find($id);
            if (!$project) abort(404);
            return view('projects.backlog', ['projectId' => (int)$id, 'project' => $project]);
        })->name('projects.backlog');

        Route::get('/projects/{id}/gantt', function ($id) {
            $project = Project::find($id);
            if (!$project) abort(404);
            return view('projects.gantt', ['projectId' => (int)$id, 'project' => $project]);
        })->name('projects.gantt');

        Route::get('/projects/{id}/files', function ($id) {
            $project = Project::find($id);
            if (!$project) abort(404);
            return view('projects.files', ['projectId' => (int)$id, 'project' => $project]);
        })->name('projects.files');

        // ========================= Catálogos (Vistas) =========================
        Route::prefix('catalogs')->group(function () {
            Route::get('/task-status', function () {
                return view('catalogs.task-status');
            })->name('catalogs.task-status');

            Route::get('/file-categories', function () {
                return view('catalogs.file-categories');
            })->name('catalogs.file-categories');
        });
    });
});