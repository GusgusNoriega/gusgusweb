<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * GET /api/blog/posts (público para publicados, admin para todos)
     */
    public function index(Request $request): JsonResponse
    {
        $query = BlogPost::with(['categories', 'author:id,name', 'featuredImage']);

        // Filtro público: solo publicados
        if (!$request->user() || !$request->user()->is_admin) {
            $query->published();
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = trim((string)$request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('category')) {
            $categorySlug = (string)$request->input('category');
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filtro por destacado
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // Filtro por autor
        if ($request->filled('author_id')) {
            $query->where('author_id', (int)$request->input('author_id'));
        }

        // Ordenamiento
        $sort = $request->input('sort', 'desc');
        $order = $request->input('order', 'published_at');
        $validOrders = ['created_at', 'updated_at', 'published_at', 'title', 'view_count'];
        if (!in_array($order, $validOrders, true)) {
            $order = 'published_at';
        }
        $sort = $sort === 'asc' ? 'asc' : 'desc';
        $query->orderBy($order, $sort);

        $perPage = (int)$request->input('per_page', 15);
        $perPage = max(1, min(100, $perPage));
        $data = $query->paginate($perPage);

        // Transformar featured_image para cada post
        $data->getCollection()->transform(function ($post) {
            if ($post->featuredImage) {
                $post->featured_image = [
                    'id' => $post->featuredImage->id,
                    'url' => $post->featuredImage->url,
                    'alt' => $post->featuredImage->alt ?? $post->title,
                    'name' => $post->featuredImage->name,
                ];
            } else {
                $post->featured_image = null;
            }
            return $post;
        });

        return $this->apiSuccess('Listado de posts del blog', 'BLOG_POSTS_LIST', $data);
    }

    /**
     * GET /api/blog/posts/{id} (público para publicados, admin para todos)
     */
    public function show(Request $request, $id): JsonResponse
    {
        // Buscar por ID o slug
        $post = BlogPost::with(['categories', 'author:id,name', 'featuredImage'])
            ->where(function ($q) use ($id) {
                $q->where('id', $id)
                    ->orWhere('slug', $id);
            })
            ->first();

        if (!$post) {
            return $this->apiNotFound('Post no encontrado', 'BLOG_POST_NOT_FOUND');
        }

        // Verificar publicación para usuarios no autenticados
        if (!$request->user() || !$request->user()->is_admin) {
            if (!$post->is_published || !$post->published_at || $post->published_at->isFuture()) {
                return $this->apiNotFound('Post no encontrado', 'BLOG_POST_NOT_FOUND');
            }
        }

        // Transformar featured_image para la respuesta
        if ($post->featuredImage) {
            $post->featured_image = [
                'id' => $post->featuredImage->id,
                'url' => $post->featuredImage->url,
                'alt' => $post->featuredImage->alt ?? $post->title,
                'name' => $post->featuredImage->name,
            ];
        }

        // Incrementar contador de vistas (solo para públicos)
        if (!$request->user() || !$request->user()->is_admin) {
            $post->increment('view_count');
        }

        return $this->apiSuccess('Post obtenido', 'BLOG_POST_SHOWN', $post);
    }

    /**
     * POST /api/blog/posts (admin)
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:220|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'featured_image_id' => 'nullable|exists:media_assets,id',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'reading_time' => 'nullable|integer|min:1',
            'author_id' => 'nullable|exists:users,id',
            'source' => 'nullable|string|max:100',
            'no_index' => 'nullable|boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
        ]);

        if ($validator->fails()) {
            return $this->apiValidationError($validator->errors()->toArray());
        }

        $data = $validator->validated();

        // Generar slug si no se proporciona
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
            // Asegurar unicidad del slug
            $originalSlug = $data['slug'];
            $counter = 1;
            while (BlogPost::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        // Establecer fecha de publicación si está publicado
        if (!empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Asignar autor si no se proporciona (usuario actual)
        if (empty($data['author_id']) && $request->user()) {
            $data['author_id'] = $request->user()->id;
        }

        $post = BlogPost::create($data);

        // Asignar categorías si se proporcionan
        if (!empty($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }

        $post->load('categories', 'author:id,name', 'featuredImage');

        Log::info('[BlogPostController] Post creado', ['id' => $post->id, 'title' => $post->title]);

        return $this->apiCreated('Post creado correctamente', 'BLOG_POST_CREATED', $post);
    }

    /**
     * PUT/PATCH /api/blog/posts/{id} (admin)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $post = BlogPost::find($id);

        if (!$post) {
            return $this->apiNotFound('Post no encontrado', 'BLOG_POST_NOT_FOUND');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|nullable|string|max:200',
            'slug' => 'sometimes|nullable|string|max:220|unique:blog_posts,slug,' . $id,
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'sometimes|nullable|string',
            'featured_image_id' => 'nullable|exists:media_assets,id',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'reading_time' => 'nullable|integer|min:1',
            'author_id' => 'nullable|exists:users,id',
            'source' => 'nullable|string|max:100',
            'no_index' => 'nullable|boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
        ]);

        if ($validator->fails()) {
            return $this->apiValidationError($validator->errors()->toArray());
        }

        $data = $validator->validated();

        // Actualizar slug si se proporciona y es diferente
        if (array_key_exists('slug', $data) && $data['slug'] !== $post->slug) {
            $slug = $data['slug'];
            $originalSlug = Str::slug($slug ?: ($data['title'] ?? $post->title));
            $counter = 1;
            while (BlogPost::where('slug', $originalSlug)->where('id', '!=', $id)->exists()) {
                $originalSlug = Str::slug($data['title'] ?? $post->title) . '-' . $counter++;
            }
            $data['slug'] = $originalSlug;
        }

        // Actualizar fecha de publicación si está publicado
        if (isset($data['is_published']) && $data['is_published'] && empty($data['published_at']) && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        // Actualizar categorías si se proporcionan
        if (array_key_exists('categories', $data)) {
            $post->categories()->sync($data['categories']);
        }

        $post->load('categories', 'author:id,name', 'featuredImage');

        Log::info('[BlogPostController] Post actualizado', ['id' => $post->id, 'title' => $post->title]);

        return $this->apiSuccess('Post actualizado correctamente', 'BLOG_POST_UPDATED', $post);
    }

    /**
     * DELETE /api/blog/posts/{id} (admin)
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $post = BlogPost::find($id);

        if (!$post) {
            return $this->apiNotFound('Post no encontrado', 'BLOG_POST_NOT_FOUND');
        }

        // Eliminar relaciones con categorías
        $post->categories()->detach();

        $post->delete();

        Log::info('[BlogPostController] Post eliminado', ['id' => $id]);

        return $this->apiSuccess('Post eliminado correctamente', 'BLOG_POST_DELETED', null);
    }

    /**
     * POST /api/blog/posts/{id}/restore (admin)
     */
    public function restore(Request $request, $id): JsonResponse
    {
        $post = BlogPost::withTrashed()->find($id);

        if (!$post) {
            return $this->apiNotFound('Post no encontrado', 'BLOG_POST_NOT_FOUND');
        }

        $post->restore();

        Log::info('[BlogPostController] Post restaurado', ['id' => $id]);

        return $this->apiSuccess('Post restaurado correctamente', 'BLOG_POST_RESTORED', $post);
    }

    /**
     * POST /api/blog/posts/{id}/categories (admin) - Actualizar categorías de un post
     */
    public function updateCategories(Request $request, $id): JsonResponse
    {
        $post = BlogPost::find($id);

        if (!$post) {
            return $this->apiNotFound('Post no encontrado', 'BLOG_POST_NOT_FOUND');
        }

        $validator = Validator::make($request->all(), [
            'categories' => 'required|array',
            'categories.*' => 'exists:blog_categories,id',
        ]);

        if ($validator->fails()) {
            return $this->apiValidationError($validator->errors()->toArray());
        }

        $post->categories()->sync($validator->validated()['categories']);
        $post->load('categories');

        return $this->apiSuccess('Categorías actualizadas', 'BLOG_POST_CATEGORIES_UPDATED', $post->categories);
    }

    /**
     * POST /api/blog/posts/{id}/increment-views (público) - Incrementar vistas
     */
    public function incrementViews(Request $request, $id): JsonResponse
    {
        $post = BlogPost::where('id', $id)
            ->orWhere('slug', $id)
            ->published()
            ->first();

        if (!$post) {
            return $this->apiNotFound('Post no encontrado', 'BLOG_POST_NOT_FOUND');
        }

        $post->increment('view_count');

        return $this->apiSuccess('Vista registrada', 'BLOG_POST_VIEW_INCREMENTED', ['view_count' => $post->view_count]);
    }
}
