<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * GET /api/blog/categories (público para activas, admin para todas)
     */
    public function index(Request $request): JsonResponse
    {
        $query = BlogCategory::withCount('posts');

        // Filtro público: solo activas
        if (!$request->user() || !$request->user()->is_admin) {
            $query->active();
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = trim((string)$request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Ordenamiento
        $sort = $request->input('sort', 'asc');
        $order = $request->input('order', 'sort_order');
        $validOrders = ['name', 'sort_order', 'created_at'];
        if (!in_array($order, $validOrders, true)) {
            $order = 'sort_order';
        }
        $sort = $sort === 'desc' ? 'desc' : 'asc';
        $query->orderBy($order, $sort);

        $perPage = (int)$request->input('per_page', 50);
        $perPage = max(1, min(100, $perPage));
        $data = $query->paginate($perPage);

        return $this->apiSuccess('Listado de categorías', 'BLOG_CATEGORIES_LIST', $data);
    }

    /**
     * GET /api/blog/categories/{id} (público para activas, admin para todas)
     */
    public function show(Request $request, $id): JsonResponse
    {
        // Buscar por ID o slug
        $category = BlogCategory::withCount('posts')
            ->where(function ($q) use ($id) {
                $q->where('id', $id)
                    ->orWhere('slug', $id);
            })
            ->first();

        if (!$category) {
            return $this->apiNotFound('Categoría no encontrada', 'BLOG_CATEGORY_NOT_FOUND');
        }

        // Verificar estado para usuarios no autenticados
        if (!$request->user() || !$request->user()->is_admin) {
            if (!$category->is_active) {
                return $this->apiNotFound('Categoría no encontrada', 'BLOG_CATEGORY_NOT_FOUND');
            }
        }

        return $this->apiSuccess('Categoría obtenida', 'BLOG_CATEGORY_SHOWN', $category);
    }

    /**
     * POST /api/blog/categories (admin)
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:120|unique:blog_categories,slug',
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->apiValidationError($validator->errors()->toArray());
        }

        $data = $validator->validated();

        // Generar slug si no se proporciona
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
            // Asegurar unicidad del slug
            $originalSlug = $data['slug'];
            $counter = 1;
            while (BlogCategory::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        $category = BlogCategory::create($data);

        Log::info('[BlogCategoryController] Categoría creada', ['id' => $category->id, 'name' => $category->name]);

        return $this->apiCreated('Categoría creada correctamente', 'BLOG_CATEGORY_CREATED', $category);
    }

    /**
     * PUT/PATCH /api/blog/categories/{id} (admin)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $category = BlogCategory::find($id);

        if (!$category) {
            return $this->apiNotFound('Categoría no encontrada', 'BLOG_CATEGORY_NOT_FOUND');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|nullable|string|max:100',
            'slug' => 'sometimes|nullable|string|max:120|unique:blog_categories,slug,' . $id,
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->apiValidationError($validator->errors()->toArray());
        }

        $data = $validator->validated();

        // Actualizar slug si se proporciona y es diferente
        if (array_key_exists('slug', $data) && $data['slug'] !== $category->slug) {
            $slug = $data['slug'];
            $originalSlug = Str::slug($slug ?: ($data['name'] ?? $category->name));
            $counter = 1;
            while (BlogCategory::where('slug', $originalSlug)->where('id', '!=', $id)->exists()) {
                $originalSlug = Str::slug($data['name'] ?? $category->name) . '-' . $counter++;
            }
            $data['slug'] = $originalSlug;
        }

        $category->update($data);

        Log::info('[BlogCategoryController] Categoría actualizada', ['id' => $category->id, 'name' => $category->name]);

        return $this->apiSuccess('Categoría actualizada correctamente', 'BLOG_CATEGORY_UPDATED', $category);
    }

    /**
     * DELETE /api/blog/categories/{id} (admin)
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $category = BlogCategory::find($id);

        if (!$category) {
            return $this->apiNotFound('Categoría no encontrada', 'BLOG_CATEGORY_NOT_FOUND');
        }

        // Eliminar relaciones con posts
        $category->posts()->detach();

        $category->delete();

        Log::info('[BlogCategoryController] Categoría eliminada', ['id' => $id]);

        return $this->apiSuccess('Categoría eliminada correctamente', 'BLOG_CATEGORY_DELETED', null);
    }

    /**
     * POST /api/blog/categories/{id}/restore (admin)
     */
    public function restore(Request $request, $id): JsonResponse
    {
        $category = BlogCategory::withTrashed()->find($id);

        if (!$category) {
            return $this->apiNotFound('Categoría no encontrada', 'BLOG_CATEGORY_NOT_FOUND');
        }

        $category->restore();

        Log::info('[BlogCategoryController] Categoría restaurada', ['id' => $id]);

        return $this->apiSuccess('Categoría restaurada correctamente', 'BLOG_CATEGORY_RESTORED', $category);
    }

    /**
     * GET /api/blog/categories/{id}/posts (público) - Obtener posts de una categoría
     */
    public function getPosts(Request $request, $id): JsonResponse
    {
        $category = BlogCategory::where(function ($q) use ($id) {
                $q->where('id', $id)
                    ->orWhere('slug', $id);
            })
            ->active()
            ->first();

        if (!$category) {
            return $this->apiNotFound('Categoría no encontrada', 'BLOG_CATEGORY_NOT_FOUND');
        }

        $posts = $category->posts()
            ->with('categories', 'author:id,name', 'featuredImage')
            ->published()
            ->latest()
            ->paginate((int)$request->input('per_page', 15));

        return $this->apiSuccess('Posts de la categoría', 'BLOG_CATEGORY_POSTS', [
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}
