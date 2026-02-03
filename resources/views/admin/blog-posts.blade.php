@extends('layouts.app')

@section('title', 'Gestionar Posts del Blog - Admin')

@section('content')
<div x-data="blogPostsManager()" x-init="init()" class="space-y-6">
  <!-- Encabezado -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-[var(--c-text)]">Posts del Blog</h1>
      <p class="text-sm text-[var(--c-muted)] mt-1">Administra todos los artículos del blog</p>
    </div>
    <button 
      @click="openModal()"
      class="inline-flex items-center gap-2 px-4 py-2 bg-[var(--c-primary)] text-white rounded-xl hover:bg-[var(--c-primary)]/90 transition font-medium text-sm">
      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
      Nuevo Post
    </button>
  </div>

  <!-- Filtros y Búsqueda -->
  <div class="bg-[var(--c-surface)] rounded-2xl p-4 ring-1 ring-[var(--c-border)]">
    <div class="flex flex-col sm:flex-row gap-4">
      <div class="flex-1">
        <label class="sr-only">Buscar</label>
        <div class="relative">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 size-5 text-[var(--c-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
          <input 
            type="search" 
            x-model="search"
            @input.debounce.300ms="loadPosts()"
            placeholder="Buscar posts..." 
            class="w-full pl-10 pr-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] placeholder:text-[var(--c-muted)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)]"
          />
        </div>
      </div>
      <div class="flex gap-2">
        <select 
          x-model="filterStatus"
          @change="loadPosts()"
          class="px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)]">
          <option value="all">Todos los estados</option>
          <option value="published">Publicados</option>
          <option value="draft">Borradores</option>
        </select>
        <select 
          x-model="perPage"
          @change="loadPosts()"
          class="px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)]">
          <option value="10">10 por página</option>
          <option value="25">25 por página</option>
          <option value="50">50 por página</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Loading State -->
  <div x-show="loading" class="flex justify-center py-12">
    <div class="animate-spin rounded-full size-10 border-4 border-[var(--c-primary)] border-t-transparent"></div>
  </div>

  <!-- Tabla de Posts -->
  <div x-show="!loading" class="bg-[var(--c-surface)] rounded-2xl ring-1 ring-[var(--c-border)] overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-[var(--c-border)]">
            <th class="px-6 py-4 text-left text-xs font-semibold text-[var(--c-muted)] uppercase tracking-wider">Post</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-[var(--c-muted)] uppercase tracking-wider">Categorías</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-[var(--c-muted)] uppercase tracking-wider">Autor</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-[var(--c-muted)] uppercase tracking-wider">Estado</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-[var(--c-muted)] uppercase tracking-wider">Fecha</th>
            <th class="px-6 py-4 text-right text-xs font-semibold text-[var(--c-muted)] uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[var(--c-border)]">
          <template x-for="post in posts" :key="post.id">
            <tr class="hover:bg-[var(--c-elev)] transition">
              <td class="px-6 py-4">
                <div class="flex items-center gap-4">
                  <div class="size-14 rounded-xl overflow-hidden bg-[var(--c-elev)] flex-shrink-0">
                    <img 
                      x-show="post.featured_image"
                      :src="post.featured_image.url" 
                      :alt="post.title"
                      class="w-full h-full object-cover"
                    />
                    <div x-show="!post.featured_image" class="w-full h-full flex items-center justify-center">
                      <svg class="size-6 text-[var(--c-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    </div>
                  </div>
                  <div class="min-w-0">
                    <p class="text-sm font-medium text-[var(--c-text)] truncate" x-text="post.title"></p>
                    <p class="text-xs text-[var(--c-muted)] truncate mt-0.5" x-text="post.excerpt || 'Sin excerpt'"></p>
                    <div class="flex items-center gap-2 mt-1">
                      <span x-show="post.is_featured" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 text-[10px] font-medium">
                        ⭐ Destacado
                      </span>
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="flex flex-wrap gap-1">
                  <template x-for="cat in post.categories" :key="cat.id">
                    <span 
                      class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium text-white"
                      :style="`background-color: ${cat.color || '#6366f1'}`"
                      x-text="cat.name">
                    </span>
                  </template>
                  <span x-show="post.categories.length === 0" class="text-xs text-[var(--c-muted)]">Sin categorías</span>
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                  <div class="size-7 rounded-full bg-[var(--c-primary)] flex items-center justify-center text-xs font-semibold text-white">
                    <span x-text="getAuthorInitials(post.author)"></span>
                  </div>
                  <span class="text-sm text-[var(--c-text)]" x-text="post.author?.name || 'Desconocido'"></span>
                </div>
              </td>
              <td class="px-6 py-4">
                <button 
                  @click="togglePublish(post)"
                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium transition"
                  :class="post.is_published ? 'bg-emerald-500/20 text-emerald-400' : 'bg-gray-500/20 text-gray-400'">
                  <span class="size-2 rounded-full"
                    :class="post.is_published ? 'bg-emerald-400' : 'bg-gray-400'"></span>
                  <span x-text="post.is_published ? 'Publicado' : 'Borrador'"></span>
                </button>
              </td>
              <td class="px-6 py-4">
                <p class="text-xs text-[var(--c-muted)]" x-text="formatDate(post.published_at || post.created_at)"></p>
                <p class="text-xs text-[var(--c-muted)] mt-0.5" x-text="post.view_count + ' vistas'"></p>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a 
                    :href="'/blog/' + post.slug"
                    target="_blank"
                    class="p-2 rounded-lg text-[var(--c-muted)] hover:text-[var(--c-text)] hover:bg-[var(--c-elev)] transition"
                    title="Ver post">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                  </a>
                  <button 
                    @click="editPost(post)"
                    class="p-2 rounded-lg text-[var(--c-muted)] hover:text-[var(--c-text)] hover:bg-[var(--c-elev)] transition"
                    title="Editar">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                  </button>
                  <button 
                    @click="confirmDelete(post)"
                    class="p-2 rounded-lg text-[var(--c-muted)] hover:text-[var(--c-danger)] hover:bg-[var(--c-elev)] transition"
                    title="Eliminar">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                  </button>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- Empty State -->
    <div x-show="posts.length === 0 && !loading" class="py-12 text-center">
      <svg class="mx-auto size-12 text-[var(--c-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z"/></svg>
      <p class="mt-4 text-sm text-[var(--c-muted)]">No se encontraron posts</p>
    </div>

    <!-- Paginación -->
    <div x-show="pagination.last_page > 1" class="px-6 py-4 border-t border-[var(--c-border)]">
      <div class="flex items-center justify-between">
        <p class="text-xs text-[var(--c-muted)]">
          Mostrando <span x-text="pagination.from || 0"></span> - <span x-text="pagination.to || 0"></span> de <span x-text="pagination.total"></span> posts
        </p>
        <div class="flex items-center gap-2">
          <button 
            @click="changePage(pagination.current_page - 1)"
            :disabled="pagination.current_page === 1"
            class="px-3 py-1.5 rounded-lg text-xs font-medium bg-[var(--c-elev)] text-[var(--c-text)] hover:bg-[var(--c-border)] transition disabled:opacity-50 disabled:cursor-not-allowed">
            Anterior
          </button>
          <template x-for="page in getPageNumbers()" :key="page">
            <button 
              @click="changePage(page)"
              :class="page === pagination.current_page ? 'bg-[var(--c-primary)] text-white' : 'bg-[var(--c-elev)] text-[var(--c-text)] hover:bg-[var(--c-border)]'"
              class="px-3 py-1.5 rounded-lg text-xs font-medium transition"
              x-text="page">
            </button>
          </template>
          <button 
            @click="changePage(pagination.current_page + 1)"
            :disabled="pagination.current_page === pagination.last_page"
            class="px-3 py-1.5 rounded-lg text-xs font-medium bg-[var(--c-elev)] text-[var(--c-text)] hover:bg-[var(--c-border)] transition disabled:opacity-50 disabled:cursor-not-allowed">
            Siguiente
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Crear/Editar Post -->
  <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
      <div class="fixed inset-0 bg-black/50" @click="closeModal()"></div>
      <div class="relative bg-[var(--c-surface)] rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden ring-1 ring-[var(--c-border)]">
        <!-- Header del Modal -->
        <div class="px-6 py-4 border-b border-[var(--c-border)] flex items-center justify-between">
          <h2 class="text-lg font-semibold text-[var(--c-text)]" x-text="editingPost ? 'Editar Post' : 'Nuevo Post'"></h2>
          <button @click="closeModal()" class="p-2 rounded-lg text-[var(--c-muted)] hover:text-[var(--c-text)] hover:bg-[var(--c-elev)] transition">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
          </button>
        </div>
        
        <!-- Contenido del Modal -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
          <form @submit.prevent="savePost" class="space-y-6">
            <!-- Información básica -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Título *</label>
                <input 
                  type="text" 
                  x-model="form.title"
                  required
                  class="w-full px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)]"
                  placeholder="Título del post"
                />
              </div>
              
              <div>
                <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Slug</label>
                <input 
                  type="text" 
                  x-model="form.slug"
                  class="w-full px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)]"
                  placeholder="Se genera automáticamente"
                />
              </div>
              
              <div>
                <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Tiempo de lectura (minutos)</label>
                <input 
                  type="number" 
                  x-model="form.reading_time"
                  min="1"
                  class="w-full px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)]"
                  placeholder="5"
                />
              </div>
              
              <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Excerpt</label>
                <textarea 
                  x-model="form.excerpt"
                  rows="3"
                  maxlength="1000"
                  class="w-full px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)] resize-none"
                  placeholder="Breve descripción del post..."
                ></textarea>
                <p class="text-xs text-[var(--c-muted)] mt-1"><span x-text="(form.excerpt || '').length"></span>/1000</p>
              </div>
              
              <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Contenido *</label>
                <textarea 
                  x-model="form.content"
                  required
                  rows="10"
                  class="w-full px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)] resize-none font-mono"
                  placeholder="Contenido del post en HTML o Markdown..."
                ></textarea>
              </div>
              
              <!-- Categorías -->
              <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Categorías</label>
                <div class="flex flex-wrap gap-2">
                  <template x-for="cat in allCategories" :key="cat.id">
                    <button 
                      type="button"
                      @click="toggleCategory(cat.id)"
                      class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium transition"
                      :class="form.categories.includes(cat.id) ? 'text-white' : 'bg-[var(--c-elev)] text-[var(--c-text)] hover:bg-[var(--c-border)]'"
                      :style="form.categories.includes(cat.id) ? `background-color: ${cat.color || '#6366f1'}` : ''">
                      <span 
                        class="size-3 rounded-full"
                        :style="`background-color: ${cat.color || '#6366f1'}`"></span>
                      <span x-text="cat.name"></span>
                    </button>
                  </template>
                </div>
              </div>
              
              <!-- Opciones de publicación -->
              <div>
                <label class="flex items-center gap-3 cursor-pointer">
                  <input 
                    type="checkbox" 
                    x-model="form.is_published"
                    class="size-5 rounded border-[var(--c-border)] bg-[var(--c-elev)] text-[var(--c-primary)] focus:ring-[var(--c-primary)]"
                  />
                  <span class="text-sm font-medium text-[var(--c-text)]">Publicado</span>
                </label>
              </div>
              
              <div>
                <label class="flex items-center gap-3 cursor-pointer">
                  <input 
                    type="checkbox" 
                    x-model="form.is_featured"
                    class="size-5 rounded border-[var(--c-border)] bg-[var(--c-elev)] text-[var(--c-primary)] focus:ring-[var(--c-primary)]"
                  />
                  <span class="text-sm font-medium text-[var(--c-text)]">Destacado</span>
                </label>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Fecha de publicación</label>
                <input 
                  type="datetime-local" 
                  x-model="form.published_at"
                  class="w-full px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)]"
                />
              </div>
              
              <!-- Imagen destacada -->
              <div>
                <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Imagen destacada</label>
                <div class="flex items-center gap-3">
                  <div class="size-20 rounded-xl overflow-hidden bg-[var(--c-elev)] flex-shrink-0">
                    <img 
                      x-show="featuredImagePreview"
                      :src="featuredImagePreview" 
                      class="w-full h-full object-cover"
                    />
                    <div x-show="!featuredImagePreview" class="w-full h-full flex items-center justify-center">
                      <svg class="size-8 text-[var(--c-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    </div>
                  </div>
                  <button 
                    type="button"
                    @click="openMediaPicker()"
                    class="px-4 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] hover:bg-[var(--c-border)] transition">
                    Seleccionar imagen
                  </button>
                  <button 
                    x-show="form.featured_image_id"
                    type="button"
                    @click="clearFeaturedImage()"
                    class="p-2 text-[var(--c-danger)] hover:bg-[var(--c-elev)] rounded-lg transition">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                  </button>
                </div>
                <input type="hidden" x-model="form.featured_image_id" />
              </div>
            </div>
            
            <!-- SEO -->
            <div class="border-t border-[var(--c-border)] pt-6">
              <h3 class="text-sm font-semibold text-[var(--c-text)] mb-4">SEO</h3>
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Meta Título</label>
                  <input 
                    type="text" 
                    x-model="form.meta_title"
                    maxlength="200"
                    class="w-full px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)]"
                    placeholder="Título para SEO (opcional)"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-[var(--c-text)] mb-2">URL Canónica</label>
                  <input 
                    type="url" 
                    x-model="form.canonical_url"
                    class="w-full px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)]"
                    placeholder="https://..."
                  />
                </div>
                
                <div class="lg:col-span-2">
                  <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Meta Descripción</label>
                  <textarea 
                    x-model="form.meta_description"
                    rows="3"
                    maxlength="500"
                    class="w-full px-4 py-2.5 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm text-[var(--c-text)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)] resize-none"
                    placeholder="Descripción para SEO..."
                  ></textarea>
                  <p class="text-xs text-[var(--c-muted)] mt-1"><span x-text="(form.meta_description || '').length"></span>/500</p>
                </div>
                
                <div>
                  <label class="flex items-center gap-3 cursor-pointer">
                    <input 
                      type="checkbox" 
                      x-model="form.no_index"
                      class="size-5 rounded border-[var(--c-border)] bg-[var(--c-elev)] text-[var(--c-primary)] focus:ring-[var(--c-primary)]"
                    />
                    <span class="text-sm font-medium text-[var(--c-text)]">No indexar (nofollow)</span>
                  </label>
                </div>
              </div>
            </div>
            
            <!-- Errores -->
            <div x-show="errors.length > 0" class="p-4 bg-[var(--c-danger)]/20 border border-[var(--c-danger)] rounded-xl">
              <ul class="text-sm text-[var(--c-danger)] space-y-1">
                <template x-for="error in errors" :key="error">
                  <li x-text="error"></li>
                </template>
              </ul>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end gap-3 pt-4 border-t border-[var(--c-border)]">
              <button 
                type="button"
                @click="closeModal()"
                class="px-4 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm font-medium text-[var(--c-text)] hover:bg-[var(--c-border)] transition">
                Cancelar
              </button>
              <button 
                type="submit"
                :disabled="saving"
                class="px-4 py-2 bg-[var(--c-primary)] text-white rounded-xl text-sm font-medium hover:bg-[var(--c-primary)]/90 transition disabled:opacity-50">
                <span x-show="!saving" x-text="editingPost ? 'Actualizar' : 'Crear'"></span>
                <span x-show="saving" class="flex items-center gap-2">
                  <svg class="animate-spin size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"/></svg>
                  Guardando...
                </span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Confirmación de Eliminación -->
  <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
      <div class="fixed inset-0 bg-black/50" @click="showDeleteModal = false"></div>
      <div class="relative bg-[var(--c-surface)] rounded-2xl shadow-xl max-w-md w-full ring-1 ring-[var(--c-border)]">
        <div class="p-6 text-center">
          <svg class="mx-auto size-12 text-[var(--c-danger)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
          <h3 class="mt-4 text-lg font-semibold text-[var(--c-text)]">Eliminar Post</h3>
          <p class="mt-2 text-sm text-[var(--c-muted)]">¿Estás seguro de que deseas eliminar "<span x-text="deletingPost?.title"></span>"? Esta acción no se puede deshacer.</p>
          <div class="flex justify-center gap-3 mt-6">
            <button 
              @click="showDeleteModal = false"
              class="px-4 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-xl text-sm font-medium text-[var(--c-text)] hover:bg-[var(--c-border)] transition">
              Cancelar
            </button>
            <button 
              @click="deletePost()"
              :disabled="deleting"
              class="px-4 py-2 bg-[var(--c-danger)] text-white rounded-xl text-sm font-medium hover:bg-[var(--c-danger)]/90 transition disabled:opacity-50">
              <span x-show="!deleting">Eliminar</span>
              <span x-show="deleting" class="flex items-center gap-2">
                <svg class="animate-spin size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"/></svg>
                Eliminando...
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div 
    x-show="toast.show" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-4"
    class="fixed bottom-4 right-4 z-50 px-4 py-3 rounded-xl shadow-lg text-sm font-medium"
    :class="toast.type === 'success' ? 'bg-emerald-500/90 text-white' : 'bg-red-500/90 text-white'"
    style="display: none;"
    x-cloak>
    <span x-text="toast.message"></span>
  </div>
</div>

<script>
function blogPostsManager() {
  return {
    loading: true,
    saving: false,
    deleting: false,
    posts: [],
    allCategories: [],
    search: '',
    filterStatus: 'all',
    perPage: 10,
    pagination: {
      current_page: 1,
      last_page: 1,
      per_page: 10,
      total: 0,
      from: 0,
      to: 0
    },
    
    showModal: false,
    showDeleteModal: false,
    editingPost: null,
    deletingPost: null,
    errors: [],
    
    form: {
      title: '',
      slug: '',
      excerpt: '',
      content: '',
      reading_time: 5,
      is_published: false,
      is_featured: false,
      published_at: '',
      featured_image_id: null,
      meta_title: '',
      meta_description: '',
      canonical_url: '',
      no_index: false,
      categories: []
    },
    
    featuredImagePreview: null,
    
    toast: {
      show: false,
      message: '',
      type: 'success'
    },
    
    async init() {
      await this.loadCategories();
      await this.loadPosts();
    },
    
    async loadCategories() {
      try {
        const response = await fetch('/api/blog/categories');
        const data = await response.json();
        if (data.success) {
          this.allCategories = data.data.data || [];
        }
      } catch (error) {
        console.error('Error cargando categorías:', error);
      }
    },
    
    async loadPosts(page = 1) {
      this.loading = true;
      try {
        let url = `/api/blog/posts?page=${page}&per_page=${this.perPage}`;
        
        if (this.search) {
          url += `&search=${encodeURIComponent(this.search)}`;
        }
        
        if (this.filterStatus === 'published') {
          url += '&published=1';
        } else if (this.filterStatus === 'draft') {
          url += '&published=0';
        }
        
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.success) {
          this.posts = data.data.data || [];
          this.pagination = {
            current_page: data.data.current_page,
            last_page: data.data.last_page,
            per_page: data.data.per_page,
            total: data.data.total,
            from: data.data.from,
            to: data.data.to
          };
        }
      } catch (error) {
        console.error('Error cargando posts:', error);
        this.showToast('Error al cargar los posts', 'error');
      } finally {
        this.loading = false;
      }
    },
    
    changePage(page) {
      if (page < 1 || page > this.pagination.last_page) return;
      this.loadPosts(page);
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
    
    openModal() {
      this.resetForm();
      this.showModal = true;
    },
    
    closeModal() {
      this.showModal = false;
      this.editingPost = null;
      this.errors = [];
      this.resetForm();
    },
    
    resetForm() {
      this.form = {
        title: '',
        slug: '',
        excerpt: '',
        content: '',
        reading_time: 5,
        is_published: false,
        is_featured: false,
        published_at: '',
        featured_image_id: null,
        meta_title: '',
        meta_description: '',
        canonical_url: '',
        no_index: false,
        categories: []
      };
      this.featuredImagePreview = null;
    },
    
    editPost(post) {
      this.editingPost = post;
      this.form = {
        title: post.title || '',
        slug: post.slug || '',
        excerpt: post.excerpt || '',
        content: post.content || '',
        reading_time: post.reading_time || 5,
        is_published: post.is_published || false,
        is_featured: post.is_featured || false,
        published_at: post.published_at ? post.published_at.substring(0, 16) : '',
        featured_image_id: post.featured_image?.id || null,
        meta_title: post.meta_title || '',
        meta_description: post.meta_description || '',
        canonical_url: post.canonical_url || '',
        no_index: post.no_index || false,
        categories: post.categories?.map(c => c.id) || []
      };
      this.featuredImagePreview = post.featured_image?.url || null;
      this.showModal = true;
    },
    
    async savePost() {
      this.saving = true;
      this.errors = [];
      
      try {
        const isUpdate = !!this.editingPost;
        const url = isUpdate ? `/api/blog/posts/${this.editingPost.id}` : '/api/blog/posts';
        const method = isUpdate ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
          method: method,
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(this.form)
        });
        
        const data = await response.json();
        
        if (data.success) {
          this.showToast(isUpdate ? 'Post actualizado correctamente' : 'Post creado correctamente', 'success');
          this.closeModal();
          await this.loadPosts();
        } else {
          if (data.errors) {
            this.errors = Object.values(data.errors).flat();
          } else {
            this.errors = [data.message || 'Error al guardar el post'];
          }
        }
      } catch (error) {
        console.error('Error guardando post:', error);
        this.errors = ['Error de conexión. Por favor intenta de nuevo.'];
      } finally {
        this.saving = false;
      }
    },
    
    togglePublish(post) {
      fetch(`/api/blog/posts/${post.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ is_published: !post.is_published })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          post.is_published = !post.is_published;
          this.showToast(post.is_published ? 'Post publicado' : 'Post convertido en borrador', 'success');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        this.showToast('Error al actualizar el estado', 'error');
      });
    },
    
    confirmDelete(post) {
      this.deletingPost = post;
      this.showDeleteModal = true;
    },
    
    async deletePost() {
      if (!this.deletingPost) return;
      
      this.deleting = true;
      
      try {
        const response = await fetch(`/api/blog/posts/${this.deletingPost.id}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json'
          }
        });
        
        const data = await response.json();
        
        if (data.success) {
          this.showToast('Post eliminado correctamente', 'success');
          this.showDeleteModal = false;
          this.deletingPost = null;
          await this.loadPosts();
        } else {
          this.showToast(data.message || 'Error al eliminar el post', 'error');
        }
      } catch (error) {
        console.error('Error eliminando post:', error);
        this.showToast('Error de conexión', 'error');
      } finally {
        this.deleting = false;
      }
    },
    
    toggleCategory(categoryId) {
      const index = this.form.categories.indexOf(categoryId);
      if (index > -1) {
        this.form.categories.splice(index, 1);
      } else {
        this.form.categories.push(categoryId);
      }
    },
    
    openMediaPicker() {
      // Implementar según el Media Picker existente
      this.showToast('Media picker no implementado aún', 'error');
    },
    
    clearFeaturedImage() {
      this.form.featured_image_id = null;
      this.featuredImagePreview = null;
    },
    
    formatDate(dateString) {
      if (!dateString) return '-';
      const date = new Date(dateString);
      return date.toLocaleDateString('es-PE', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
      });
    },
    
    getAuthorInitials(author) {
      if (!author || !author.name) return '??';
      return author.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
    },
    
    showToast(message, type = 'success') {
      this.toast = { show: true, message, type };
      setTimeout(() => {
        this.toast.show = false;
      }, 3000);
    }
  }
}
</script>
@endsection
