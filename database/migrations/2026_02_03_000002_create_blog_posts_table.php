<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('excerpt')->nullable(); // Resumen del artículo
            $table->longText('content'); // Contenido completo en HTML/Markdown
            $table->foreignId('featured_image_id')->nullable()->constrained('media_assets')->nullOnDelete(); // Imagen destacada (relación 1:1 con media_assets)
            $table->string('meta_title', 200)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url', 500)->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false); // Artículo destacado
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('reading_time')->nullable(); // Tiempo de lectura en minutos
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('source', 100)->nullable(); // Fuente original si es republicación
            $table->boolean('no_index')->default(false); // Para evitar indexación SEO
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index(['is_published', 'published_at']);
            $table->index('is_featured');
            $table->index('author_id');
            $table->index('featured_image_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
