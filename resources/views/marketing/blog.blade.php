@extends('layouts.marketing')

@section('title', 'Blog | Desarrollo de software, páginas web y tecnología - SystemsGG')
@section('og_title', 'Blog de SystemsGG | Artículos sobre desarrollo web y software')
@section('canonical', url('/blog'))
@section('meta_description', 'Explora nuestro blog sobre desarrollo de páginas web, software a medida, SEO, tecnología y consejos para impulsar tu negocio digital.')

@section('content')
  <!-- HERO DEL BLOG -->
  <section class="relative overflow-hidden">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -top-32 left-1/2 h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-[radial-gradient(circle_at_center,rgba(99,102,241,0.35),transparent_60%)] blur-2xl"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-14 sm:py-18 lg:py-24">
        <div class="text-center max-w-3xl mx-auto">
          <div class="inline-flex items-center gap-2 rounded-full bg-white/5 px-3 py-1 text-xs text-[var(--c-muted)] ring-1 ring-white/10">
            <span class="inline-flex size-2 rounded-full bg-[var(--c-accent)]"></span>
            Blog de SystemsGG
          </div>
          <h1 class="mt-5 text-3xl font-semibold tracking-tight sm:text-4xl lg:text-5xl">
            <span class="bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-2)] bg-clip-text text-transparent">Artículos</span>
            sobre tecnología, desarrollo y negocios digitales
          </h1>
          <p class="mt-4 text-base text-[var(--c-muted)] leading-relaxed sm:text-lg">
            Encuentra guías, tutoriales, consejos y las últimas tendencias en desarrollo de software, páginas web y marketing digital para impulsar tu negocio.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTENIDO DEL BLOG CON ALPINE.JS -->
  <section x-data="blogManager()" x-init="initBlog()" class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-14 lg:py-20">
        
        <!-- FILTROS DE CATEGORÍAS -->
        <div class="py-6">
          <div class="flex flex-wrap gap-2 justify-center">
            <button 
              @click="filterCategory(null)"
              :class="currentCategory === null ? 'bg-[var(--c-primary)]' : 'bg-white/5'"
              class="rounded-full px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/10 hover:bg-[var(--c-primary)] transition">
              Todos
            </button>
            <template x-for="category in categories" :key="category.id">
              <button 
                @click="filterCategory(category.slug)"
                :class="currentCategory === category.slug ? 'bg-[var(--c-primary)]' : 'bg-white/5'"
                class="rounded-full px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/10 hover:bg-[var(--c-primary)] transition"
                :style="currentCategory === category.slug ? '' : `border-left: 3px solid ${category.color}`"
                x-text="category.name">
              </button>
            </template>
          </div>
        </div>

        <!-- LOADING STATE -->
        <div x-show="loading" class="flex justify-center py-20">
          <div class="animate-spin rounded-full size-12 border-4 border-[var(--c-primary)] border-t-transparent"></div>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div x-show="!loading">
          <!-- ARTÍCULO DESTACADO -->
          <div x-show="featuredPost" class="mt-10">
            <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)] cursor-pointer" @click="viewPost(featuredPost.id)">
              <div class="grid lg:grid-cols-2">
                <div class="aspect-video lg:aspect-auto lg:h-full overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-500 relative">
                  <img 
                    x-show="featuredPost.featured_image"
                    :src="featuredPost.featured_image.url" 
                    :alt="featuredPost.title"
                    class="h-full w-full object-cover" 
                  />
                  <div x-show="!featuredPost.featured_image" class="absolute inset-0 flex items-center justify-center bg-[var(--c-elev)]">
                    <svg class="size-16 text-[var(--c-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                </div>
                <div class="p-6 lg:p-8 flex flex-col justify-center">
                  <div class="flex items-center gap-2 mb-4">
                    <span class="rounded-full bg-[var(--c-primary)]/10 px-3 py-1 text-xs text-[var(--c-primary)] ring-1 ring-[var(--c-primary)]/30">
                      Destacado
                    </span>
                    <span class="text-xs text-[var(--c-muted)]" x-text="featuredPost.reading_time + ' min lectura'"></span>
                  </div>
                  <h3 class="text-xl font-semibold lg:text-2xl hover:text-[var(--c-primary)] transition" x-text="featuredPost.title"></h3>
                  <p class="mt-3 text-sm text-[var(--c-muted)] leading-relaxed" x-text="featuredPost.excerpt"></p>
                  <div class="mt-5 flex items-center gap-3">
                    <div class="size-8 rounded-full bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-2)] flex items-center justify-center text-xs font-semibold text-white">
                      <span x-text="getAuthorInitials(featuredPost.author)"></span>
                    </div>
                    <div>
                      <p class="text-sm font-medium" x-text="featuredPost.author?.name || 'SystemsGG'"></p>
                      <p class="text-xs text-[var(--c-muted)]" x-text="formatDate(featuredPost.published_at)"></p>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          </div>

          <!-- GRID DE ARTÍCULOS RECIENTES -->
          <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <template x-for="post in posts" :key="post.id">
              <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)] transition hover:ring-[var(--c-primary)]/50 cursor-pointer" @click="viewPost(post.id)">
                <div class="aspect-video overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-500 relative">
                  <img 
                    x-show="post.featured_image"
                    :src="post.featured_image.url" 
                    :alt="post.title"
                    class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" 
                  />
                  <div x-show="!post.featured_image" class="absolute inset-0 flex items-center justify-center bg-[var(--c-elev)]">
                    <svg class="size-12 text-[var(--c-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <!-- Categorías overlay -->
                  <div class="absolute top-2 left-2 flex flex-wrap gap-1">
                    <template x-for="cat in post.categories.slice(0, 2)" :key="cat.id">
                      <span 
                        class="rounded-full px-2 py-0.5 text-[10px] font-medium text-white"
                        :style="`background-color: ${cat.color || '#6366f1'}`"
                        x-text="cat.name">
                      </span>
                    </template>
                  </div>
                </div>
                <div class="p-5">
                  <div class="flex items-center gap-2 mb-3">
                    <span class="text-[10px] text-[var(--c-muted)]" x-text="(post.reading_time || 3) + ' min lectura'"></span>
                    <span class="text-[10px] text-[var(--c-muted)]">·</span>
                    <span class="text-[10px] text-[var(--c-muted)]" x-text="post.view_count + ' vistas'"></span>
                  </div>
                  <h3 class="text-base font-semibold hover:text-[var(--c-primary)] transition" x-text="post.title"></h3>
                  <p class="mt-2 text-xs text-[var(--c-muted)] leading-relaxed line-clamp-3" x-text="post.excerpt"></p>
                  <div class="mt-4 flex items-center justify-between">
                    <span class="text-xs text-[var(--c-muted)]" x-text="formatDate(post.published_at)"></span>
                    <span class="text-xs text-[var(--c-primary)] font-medium hover:underline">Leer más →</span>
                  </div>
                </div>
              </article>
            </template>
          </div>

          <!-- MENSAJE CUANDO NO HAY POSTS -->
          <div x-show="posts.length === 0 && !loading" class="mt-20 text-center py-10">
            <svg class="mx-auto size-16 text-[var(--c-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            <h3 class="mt-4 text-lg font-semibold">No se encontraron artículos</h3>
            <p class="mt-2 text-sm text-[var(--c-muted)]">Intenta con otra categoría o vuelve más tarde.</p>
          </div>

          <!-- PAGINACIÓN -->
          <div x-show="pagination.last_page > 1" class="mt-12 flex items-center justify-center gap-2">
            <button 
              @click="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="rounded-xl bg-white/5 px-4 py-2 text-sm text-[var(--c-muted)] ring-1 ring-white/10 hover:bg-white/10 transition disabled:opacity-50">
              ← Anterior
            </button>
            
            <template x-for="page in getPageNumbers()" :key="page">
              <button 
                @click="changePage(page)"
                :class="page === pagination.current_page ? 'bg-[var(--c-primary)]' : 'bg-white/5'"
                class="rounded-xl px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/10 hover:bg-[var(--c-primary)] transition"
                x-text="page">
              </button>
            </template>
            
            <button 
              @click="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="rounded-xl bg-white/5 px-4 py-2 text-sm text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition disabled:opacity-50">
              Siguiente →
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>


  <script>
    function blogManager() {
      return {
        loading: true,
        posts: [],
        featuredPost: null,
        categories: [],
        pagination: {
          current_page: 1,
          last_page: 1,
          per_page: 9,
          total: 0
        },
        currentCategory: null,
        searchQuery: '',
        
        async initBlog() {
          await this.loadCategories();
          await this.loadPosts();
        },
        
        async loadCategories() {
          try {
            const response = await fetch('/api/blog/categories');
            const data = await response.json();
            if (data.success) {
              this.categories = data.data.data || [];
            }
          } catch (error) {
            console.error('Error cargando categorías:', error);
          }
        },
        
        async loadPosts(page = 1) {
          this.loading = true;
          try {
            let url = `/api/blog/posts?page=${page}&per_page=${this.pagination.per_page}`;
            
            if (this.currentCategory) {
              url += `&category=${this.currentCategory}`;
            }
            
            if (this.searchQuery) {
              url += `&search=${encodeURIComponent(this.searchQuery)}`;
            }
            
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.success) {
              const postsData = data.data.data || [];
              
              // Separar post destacado
              this.featuredPost = postsData.find(p => p.is_featured) || null;
              this.posts = postsData.filter(p => !p.is_featured || this.featuredPost?.id !== p.id);
              
              // Actualizar paginación
              this.pagination = {
                current_page: data.data.current_page,
                last_page: data.data.last_page,
                per_page: data.data.per_page,
                total: data.data.total
              };
            }
          } catch (error) {
            console.error('Error cargando posts:', error);
          } finally {
            this.loading = false;
          }
        },
        
        filterCategory(slug) {
          this.currentCategory = slug;
          this.pagination.current_page = 1;
          this.loadPosts(1);
        },
        
        changePage(page) {
          if (page < 1 || page > this.pagination.last_page) return;
          this.loadPosts(page);
          
          // Scroll suave al contenido
          document.querySelector('section.border-t.border-white\\/10').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        },
        
        getPageNumbers() {
          const current = this.pagination.current_page;
          const last = this.pagination.last_page;
          const delta = 2;
          const range = [];
          const rangeWithDots = [];
          
          for (let i = 1; i <= last; i++) {
            if (i === 1 || i === last || (i >= current - delta && i <= current + delta)) {
              range.push(i);
            }
          }
          
          let prev = 0;
          for (const i of range) {
            if (prev) {
              if (i - prev === 2) {
                rangeWithDots.push(prev + 1);
              } else if (i - prev !== 1) {
                rangeWithDots.push('...');
              }
            }
            rangeWithDots.push(i);
            prev = i;
          }
          
          return rangeWithDots;
        },
        
        viewPost(id) {
          window.location.href = `/blog/${id}`;
        },
        
        formatDate(dateString) {
          if (!dateString) return '';
          const date = new Date(dateString);
          return date.toLocaleDateString('es-PE', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
          });
        },
        
        getAuthorInitials(author) {
          if (!author || !author.name) return 'GG';
          return author.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        }
      }
    }
  </script>
@endsection
