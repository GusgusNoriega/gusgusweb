@extends('layouts.marketing')

@section('title', $post->meta_title ?: $post->title . ' | Blog SystemsGG')
@section('og_title', $post->meta_title ?: $post->title)
@if($post->meta_description)
@section('meta_description', $post->meta_description)
@endif
@section('canonical', url('/blog/' . $post->slug))

@if($post->featuredImage)
@section('head')
  <meta property="og:image" content="{{ $post->featuredImage->url }}" />
  <meta name="twitter:image" content="{{ $post->featuredImage->url }}" />
@endsection
@endif

@section('content')
  <!-- ARTÍCULO COMPLETO -->
  <article>
    <!-- HERO DEL ARTÍCULO -->
    <section class="relative overflow-hidden">
      <div class="absolute inset-0 -z-10">
        <div class="absolute -top-32 left-1/2 h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-[radial-gradient(circle_at_center,rgba(99,102,241,0.35),transparent_60%)] blur-2xl"></div>
      </div>

      <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="py-14 sm:py-18 lg:py-24">
          <!-- Categorías -->
          <div class="flex flex-wrap gap-2 mb-6">
            @foreach($post->categories as $category)
              <a href="/blog?category={{ $category->slug }}" 
                 class="rounded-full px-3 py-1 text-xs font-medium text-white transition hover:opacity-90"
                 style="background-color: {{ $category->color ?: '#6366f1' }}">
                {{ $category->name }}
              </a>
            @endforeach
          </div>

          <!-- Título -->
          <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl lg:text-5xl leading-tight">
            {{ $post->title }}
          </h1>

          <!-- Meta información -->
          <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-[var(--c-muted)]">
            <!-- Autor -->
            <div class="flex items-center gap-2">
              <div class="size-8 rounded-full bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-2)] flex items-center justify-center text-xs font-semibold text-white">
                @if($post->author)
                  {{ strtoupper(substr($post->author->name, 0, 2)) }}
                @else
                  GG
                @endif
              </div>
              <span class="text-[var(--c-text)]">{{ $post->author?->name ?: 'SystemsGG' }}</span>
            </div>

            <!-- Fecha -->
            <div class="flex items-center gap-1">
              <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span>{{ $post->published_at->format('d M, Y') }}</span>
            </div>

            <!-- Tiempo de lectura -->
            @if($post->reading_time)
            <div class="flex items-center gap-1">
              <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>{{ $post->reading_time }} min de lectura</span>
            </div>
            @endif

            <!-- Vistas -->
            <div class="flex items-center gap-1">
              <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <span>{{ number_format($post->view_count) }} vistas</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- IMAGEN DESTACADA -->
    @if($post->featuredImage)
    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
      <div class="rounded-3xl overflow-hidden ring-1 ring-[var(--c-border)]">
        <img 
          src="{{ $post->featuredImage->url }}" 
          alt="{{ $post->featuredImage->alt ?: $post->title }}"
          class="w-full h-auto"
        />
      </div>
      @if($post->featuredImage->alt)
      <p class="mt-2 text-xs text-[var(--c-muted)] text-center">{{ $post->featuredImage->alt }}</p>
      @endif
    </section>
    @endif

    <!-- CONTENIDO DEL ARTÍCULO -->
    <section class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
      <!-- Excerpt -->
      @if($post->excerpt)
      <div class="text-xl text-[var(--c-muted)] leading-relaxed border-l-4 border-[var(--c-primary)] pl-6 mb-8">
        {{ $post->excerpt }}
      </div>
      @endif

      <!-- Contenido -->
      <div class="prose prose-invert prose-lg max-w-none prose-headings:font-semibold prose-a:text-[var(--c-primary)] prose-img:rounded-2xl">
        {!! $post->content !!}
      </div>

      <!-- Etiquetas -->
      @if(false)
      <div class="mt-12 pt-8 border-t border-white/10">
        <h3 class="text-sm font-medium text-[var(--c-muted)] mb-4">Etiquetas</h3>
        <div class="flex flex-wrap gap-2">
          @foreach([] as $tag)
          <span class="rounded-full bg-white/5 px-3 py-1 text-xs text-[var(--c-text)] ring-1 ring-white/10">
            {{ $tag }}
          </span>
          @endforeach
        </div>
      </div>
      @endif
    </section>

    <!-- COMPARTIR -->
    <section class="border-t border-white/10">
      <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between">
          <h3 class="text-sm font-medium text-[var(--c-muted)]">Compartir artículo</h3>
          <div class="flex items-center gap-3">
            <!-- WhatsApp -->
            <a 
              href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url('/blog/' . $post->slug)) }}"
              target="_blank"
              class="size-10 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 ring-1 ring-green-500/30 hover:bg-green-500/30 transition">
              <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
            </a>
            <!-- Facebook -->
            <a 
              href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/blog/' . $post->slug)) }}"
              target="_blank"
              class="size-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 ring-1 ring-blue-500/30 hover:bg-blue-500/30 transition">
              <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
            </a>
            <!-- Twitter/X -->
            <a 
              href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url('/blog/' . $post->slug)) }}"
              target="_blank"
              class="size-10 rounded-full bg-slate-500/20 flex items-center justify-center text-slate-400 ring-1 ring-slate-500/30 hover:bg-slate-500/30 transition">
              <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
              </svg>
            </a>
            <!-- LinkedIn -->
            <a 
              href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url('/blog/' . $post->slug)) }}"
              target="_blank"
              class="size-10 rounded-full bg-blue-600/20 flex items-center justify-center text-blue-400 ring-1 ring-blue-600/30 hover:bg-blue-600/30 transition">
              <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- ARTÍCULOS RELACIONADOS -->
    @if($relatedPosts->isNotEmpty())
    <section class="border-t border-white/10">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="py-14 lg:py-20">
          <h2 class="text-2xl font-semibold tracking-tight sm:text-3xl mb-10">Artículos relacionados</h2>
          
          <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($relatedPosts as $relatedPost)
            <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)] transition hover:ring-[var(--c-primary)]/50 cursor-pointer" onclick="window.location.href='/blog/{{ $relatedPost->slug }}'">
              <div class="aspect-video overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-500 relative">
                @if($relatedPost->featuredImage)
                <img 
                  src="{{ $relatedPost->featuredImage->url }}" 
                  alt="{{ $relatedPost->title }}"
                  class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" 
                />
                @else
                <div class="absolute inset-0 flex items-center justify-center bg-[var(--c-elev)]">
                  <svg class="size-12 text-[var(--c-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                @endif
              </div>
              <div class="p-5">
                <div class="flex items-center gap-2 mb-3">
                  <span class="text-[10px] text-[var(--c-muted)]" x-text="({{ $relatedPost->reading_time ?: 3 }}) + ' min lectura'"></span>
                </div>
                <h3 class="text-base font-semibold hover:text-[var(--c-primary)] transition line-clamp-2">{{ $relatedPost->title }}</h3>
                <div class="mt-4 flex items-center justify-between">
                  <span class="text-xs text-[var(--c-muted)]">{{ $relatedPost->published_at->format('d M, Y') }}</span>
                  <span class="text-xs text-[var(--c-primary)] font-medium hover:underline">Leer más →</span>
                </div>
              </div>
            </article>
            @endforeach
          </div>
        </div>
      </div>
    </section>
    @endif

    <!-- VOLVER AL BLOG -->
    <section class="border-t border-white/10">
      <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12 text-center">
        <a href="/blog" class="inline-flex items-center gap-2 rounded-xl bg-white/5 px-6 py-3 text-sm font-semibold text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">
          <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Volver al blog
        </a>
      </div>
    </section>
  </article>

  <script>
    // Incrementar vistas al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
      fetch('/api/blog/posts/{{ $post->id }}/increment-views', {
        method: 'POST',
        headers: {
          'Accept': 'application/json'
        }
      }).catch(function(e) {
        console.log('Error incrementando vistas:', e);
      });
    });
  </script>
@endsection
