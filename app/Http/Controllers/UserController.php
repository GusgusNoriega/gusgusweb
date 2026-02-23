<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * GET /api/users
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::with(['profileImage', 'roles']);

        if ($request->filled('search')) {
            $search = trim((string)$request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'desc');
        $order = $request->input('order', 'created_at');
        $validOrders = ['created_at', 'updated_at', 'name', 'email'];
        if (!in_array($order, $validOrders, true)) {
            $order = 'created_at';
        }
        $sort = $sort === 'asc' ? 'asc' : 'desc';
        $query->orderBy($order, $sort);

        $perPage = (int)$request->input('per_page', 15);
        $perPage = max(1, min(100, $perPage));
        $data = $query->paginate($perPage);

        return $this->apiSuccess('Listado de usuarios', 'USERS_LIST', $data);
    }

    /**
     * POST /api/users
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'profile_image_id' => 'nullable|exists:media_assets,id',
            // roles: IDs de roles (guard web por defecto)
            'roles' => 'sometimes|array',
            'roles.*' => 'integer|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return $this->apiValidationError($validator->errors()->toArray());
        }

        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'profile_image_id' => $request->input('profile_image_id'),
        ];

        $user = User::create($userData);

        // Asignación de roles (opcional)
        if ($request->has('roles')) {
            $roleIds = (array) $request->input('roles', []);
            $roleIds = array_values(array_unique(array_map('intval', $roleIds)));

            $guard = $user->getDefaultGuardName();
            $roles = Role::query()
                ->where('guard_name', $guard)
                ->whereIn('id', $roleIds)
                ->get();

            if (count($roleIds) !== $roles->count()) {
                return $this->apiValidationError([
                    'roles' => ['Uno o más roles no existen o no pertenecen al guard requerido.'],
                ]);
            }

            $user->syncRoles($roles);
        }

        // Cargar la relación de imagen de perfil
        $user->load(['profileImage', 'roles']);

        return $this->apiCreated('Usuario creado exitosamente', 'USER_CREATED', $user);
    }

    /**
     * GET /api/users/{id}
     */
    public function show(Request $request, $id): JsonResponse
    {
        $user = User::with(['profileImage', 'roles'])->find($id);

        if (!$user) {
            return $this->apiNotFound('Usuario no encontrado', 'USER_NOT_FOUND');
        }

        return $this->apiSuccess('Usuario obtenido', 'USER_SHOWN', $user);
    }

    /**
     * PATCH /api/users/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->apiNotFound('Usuario no encontrado', 'USER_NOT_FOUND');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'password' => 'sometimes|nullable|string|min:8',
            'profile_image_id' => 'nullable|exists:media_assets,id',
            // roles: IDs de roles (si viene, se sincroniza)
            'roles' => 'sometimes|array',
            'roles.*' => 'integer|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return $this->apiValidationError($validator->errors()->toArray());
        }

        $updateData = $validator->validated();
        $rolesToSync = null;
        if (array_key_exists('roles', $updateData)) {
            $rolesToSync = (array) ($updateData['roles'] ?? []);
            unset($updateData['roles']);
        }

        // Hash password if provided
        if (isset($updateData['password']) && !empty($updateData['password'])) {
            $updateData['password'] = Hash::make($updateData['password']);
        } elseif (isset($updateData['password']) && empty($updateData['password'])) {
            unset($updateData['password']); // Don't update if empty
        }

        $user->update($updateData);

        // Sincronizar roles sólo si vinieron en el payload
        if (is_array($rolesToSync)) {
            $roleIds = array_values(array_unique(array_map('intval', $rolesToSync)));
            $guard = $user->getDefaultGuardName();
            $roles = Role::query()
                ->where('guard_name', $guard)
                ->whereIn('id', $roleIds)
                ->get();

            if (count($roleIds) !== $roles->count()) {
                return $this->apiValidationError([
                    'roles' => ['Uno o más roles no existen o no pertenecen al guard requerido.'],
                ]);
            }

            $user->syncRoles($roles);
        }

        // Cargar la relación de imagen de perfil
        $user->load(['profileImage', 'roles']);

        return $this->apiSuccess('Usuario actualizado', 'USER_UPDATED', $user);
    }

    /**
     * DELETE /api/users/{id}
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->apiNotFound('Usuario no encontrado', 'USER_NOT_FOUND');
        }

        // No permitir eliminar al usuario actual (si está autenticado)
        if (auth()->check() && auth()->id() === $user->id) {
            return $this->apiForbidden('No puedes eliminar tu propio usuario', 'SELF_DELETE_FORBIDDEN');
        }

        $user->delete();

        return $this->apiSuccess('Usuario eliminado', 'USER_DELETED', null);
    }

    /**
     * GET /api/users/{id}/roles
     */
    public function getUserRoles($userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return $this->apiNotFound('Usuario no encontrado', 'USER_NOT_FOUND');
        }

        $roles = $user->roles;

        return $this->apiSuccess('Roles del usuario obtenidos', 'USER_ROLES', $roles);
    }

    /**
     * GET /api/users/{id}/permissions
     */
    public function getUserPermissions($userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return $this->apiNotFound('Usuario no encontrado', 'USER_NOT_FOUND');
        }

        $permissions = $user->getAllPermissions();

        return $this->apiSuccess('Permisos del usuario obtenidos', 'USER_PERMISSIONS', $permissions);
    }

    /**
     * POST /api/users/{userId}/roles/assign
     */
    public function assignRoles(Request $request, $userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return $this->apiNotFound('Usuario no encontrado', 'USER_NOT_FOUND');
        }

        $validator = Validator::make($request->all(), [
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return $this->apiValidationError($validator->errors()->toArray());
        }

        $roleIds = (array) $request->input('roles', []);
        $roleIds = array_values(array_unique(array_map('intval', $roleIds)));

        $guard = $user->getDefaultGuardName();
        $roles = Role::query()
            ->where('guard_name', $guard)
            ->whereIn('id', $roleIds)
            ->get();

        if (count($roleIds) !== $roles->count()) {
            return $this->apiValidationError([
                'roles' => ['Uno o más roles no existen o no pertenecen al guard requerido.'],
            ]);
        }

        $user->syncRoles($roles);
        $user->load('roles');

        return $this->apiSuccess('Roles asignados al usuario', 'USER_ROLES_ASSIGNED', $user->roles);
    }

    /**
     * POST /api/users/{userId}/roles/revoke
     */
    public function revokeRoles(Request $request, $userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return $this->apiNotFound('Usuario no encontrado', 'USER_NOT_FOUND');
        }

        $validator = Validator::make($request->all(), [
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return $this->apiValidationError($validator->errors()->toArray());
        }

        $roleIds = (array) $request->input('roles', []);
        $roleIds = array_values(array_unique(array_map('intval', $roleIds)));

        $guard = $user->getDefaultGuardName();
        $roles = Role::query()
            ->where('guard_name', $guard)
            ->whereIn('id', $roleIds)
            ->get();

        if (count($roleIds) !== $roles->count()) {
            return $this->apiValidationError([
                'roles' => ['Uno o más roles no existen o no pertenecen al guard requerido.'],
            ]);
        }

        foreach ($roles as $role) {
            $user->removeRole($role);
        }

        $user->load('roles');

        return $this->apiSuccess('Roles revocados del usuario', 'USER_ROLES_REVOKED', $user->roles);
    }
}
