<?php

use Illuminate\Support\Facades\Route;
use App\Models\BlogPost;
use App\Models\Project;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\QuoteWebController;
use App\Http\Controllers\LeadController;

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
    return view('marketing.home');
})->name('home')->middleware('guest');

// Ruta del blog
Route::get('/blog', function () {
    $seoPosts = BlogPost::query()
        ->indexable()
        ->select(['id', 'title', 'slug', 'excerpt', 'meta_description', 'published_at', 'updated_at'])
        ->latest()
        ->take(30)
        ->get();

    $blogLastModified = $seoPosts
        ->map(fn (BlogPost $post) => $post->updated_at ?? $post->published_at)
        ->filter()
        ->max();

    return view('marketing.blog', [
        'seoPosts' => $seoPosts,
        'blogLastModified' => $blogLastModified?->toIso8601String(),
    ]);
})->name('blog')->middleware('guest');

// Ruta de post individual del blog
Route::get('/blog/{slug}', function ($slug) {
    $post = \App\Models\BlogPost::with(['categories', 'author', 'featuredImage'])
        ->where('slug', $slug)
        ->published()
        ->first();
    
    if (!$post) {
        abort(404);
    }
    
    // Posts relacionados (mismas categorías, excluyendo el actual)
    $categoryIds = $post->categories->pluck('id')->toArray();
    $relatedPosts = \App\Models\BlogPost::with('featuredImage')
        ->where('id', '!=', $post->id)
        ->published()
        ->whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('blog_categories.id', $categoryIds);
        })
        ->latest()
        ->take(3)
        ->get();
    
    return view('marketing.blog-post', compact('post', 'relatedPosts'));
})->name('blog.post')->middleware('guest');

// Página de gracias (lectura única por token)
Route::get('/gracias/{token}', [LeadController::class, 'thankYou'])
    ->name('leads.thankyou')
    ->middleware('guest');

// Páginas legales (requeridas para Google Ads)
Route::get('/privacidad', function () {
    return view('marketing.privacidad');
})->name('privacidad')->middleware('guest');

Route::get('/terminos', function () {
    return view('marketing.terminos');
})->name('terminos')->middleware('guest');

Route::get('/cookies', function () {
    return view('marketing.cookies');
})->name('cookies')->middleware('guest');

// Sitemaps
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemaps/static.xml', [SitemapController::class, 'staticPages'])->name('sitemap.static');
Route::get('/sitemaps/blog-posts/{chunk}.xml', [SitemapController::class, 'blogPosts'])
    ->whereNumber('chunk')
    ->name('sitemap.blog-posts');

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

        Route::get('/leads', function () {
            return view('leads.manage');
        })->name('leads');

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

        // ========================= Blog (Vista) =========================
        Route::get('/blog/posts', function () {
            return view('admin.blog-posts');
        })->name('blog.posts');

        // ========================= SMTP Settings (Vista) =========================
        Route::get('/smtp-settings', function () {
            return view('smtp.settings');
        })->name('smtp-settings');

        // ========================= Email Templates (Vista) =========================
        Route::get('/email-templates', function () {
            return view('email-templates.manage');
        })->name('email-templates');

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

        // ========================= Cotizaciones (Vistas) =========================
        Route::get('/quotes', function () {
            return view('quotes.index');
        })->name('quotes');

        Route::get('/quotes/settings', function () {
            return view('quotes.settings');
        })->name('quotes.settings');

        // PDF Downloads (using web session auth)
        Route::get('/quotes/{id}/pdf/download', [QuoteWebController::class, 'downloadPdf'])->name('quotes.pdf.download');
        Route::get('/quotes/{id}/pdf/preview', [QuoteWebController::class, 'previewPdf'])->name('quotes.pdf.preview');
    });
});
