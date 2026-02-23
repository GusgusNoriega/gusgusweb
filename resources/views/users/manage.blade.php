@extends('layouts.app')

@section('title', 'Administrar Usuarios')

@section('content')
<div class="">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-[var(--c-text)]">Administrar Usuarios</h1>
      <p class="text-[var(--c-muted)] mt-1">Gestiona los usuarios del sistema</p>
    </div>
    <div class="flex gap-3">
      <button id="btn-create-user" class="inline-flex items-center gap-2 px-4 py-2 bg-[var(--c-primary)] text-[var(--c-primary-ink)] rounded-xl hover:opacity-95 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Nuevo Usuario
      </button>
    </div>
  </div>

  <!-- Search and Filters -->
  <div class="bg-[var(--c-surface)] rounded-2xl border border-[var(--c-border)] p-6">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-lg font-semibold text-[var(--c-text)]">Usuarios del Sistema</h2>
      <div class="flex items-center gap-2">
        <input type="text" id="search-users" placeholder="Buscar usuarios..." class="px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg text-sm">
        <button id="btn-refresh-users" class="p-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg hover:bg-[var(--c-surface)] transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Users List -->
    <div id="users-list" class="space-y-3">
      <!-- Users will be loaded here -->
    </div>

    <!-- Pagination -->
    <div id="users-pagination" class="flex justify-between items-center mt-6">
      <!-- Pagination will be loaded here -->
    </div>
  </div>
</div>

<!-- Create/Edit User Modal -->
<div id="user-modal" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
  <div class="relative mx-auto mt-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
    <div class="bg-[var(--c-surface)] rounded-2xl border border-[var(--c-border)] overflow-hidden">
      <div class="px-6 py-4 border-b border-[var(--c-border)]">
        <h3 id="user-modal-title" class="text-lg font-semibold text-[var(--c-text)]">Crear Usuario</h3>
      </div>
      <form id="user-form" class="p-6">
        <input type="hidden" id="user-id" name="id">

        <!-- Profile Image -->
        <div>
          <label class="block text-sm font-medium text-[var(--c-text)] mb-2">Imagen de Perfil</label>
          <x-media-input
            name="profile_image_id"
            mode="single"
            :max="1"
            placeholder="Seleccionar imagen de perfil"
            button="Seleccionar Imagen"
            preview="true"
            value="{{ old('profile_image_id', '') }}"
          />
        </div>

        <!-- Name -->
        <div>
          <label for="user-name" class="block text-sm font-medium text-[var(--c-text)] mb-1">Nombre</label>
          <input type="text" id="user-name" name="name" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent" required>
        </div>

        <!-- Email -->
        <div>
          <label for="user-email" class="block text-sm font-medium text-[var(--c-text)] mb-1">Correo Electrónico</label>
          <input type="email" id="user-email" name="email" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent" required>
        </div>

        <!-- Roles -->
        <div>
          <label for="user-roles" class="block text-sm font-medium text-[var(--c-text)] mb-1">Roles</label>
          <select id="user-roles" name="roles" multiple
            class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent">
            <!-- options cargadas por JS -->
          </select>
          <p class="text-xs text-[var(--c-muted)] mt-1">Puedes seleccionar múltiples roles (Ctrl/⌘ + click)</p>
        </div>

        <!-- Password -->
        <div>
          <label for="user-password" class="block text-sm font-medium text-[var(--c-text)] mb-1">Contraseña</label>
          <input type="password" id="user-password" name="password" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent" required>
          <p class="text-xs text-[var(--c-muted)] mt-1">Mínimo 8 caracteres</p>
        </div>

        <!-- Password Confirmation (only for create) -->
        <div id="password-confirm-container" style="display: none;">
          <label for="user-password-confirm" class="block text-sm font-medium text-[var(--c-text)] mb-1">Confirmar Contraseña</label>
          <input type="password" id="user-password-confirm" name="password_confirmation" class="w-full px-3 py-2 bg-[var(--c-elev)] border border-[var(--c-border)] rounded-lg focus:ring-2 focus:ring-[var(--c-primary)] focus:border-transparent">
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3 pt-4 border-t border-[var(--c-border)]">
          <button type="button" id="btn-cancel-user" class="px-4 py-2 text-[var(--c-muted)] hover:text-[var(--c-text)] transition">Cancelar</button>
          <button type="submit" class="px-4 py-2 bg-[var(--c-primary)] text-[var(--c-primary-ink)] rounded-lg hover:opacity-95 transition">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const API_BASE = '/api';
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const API_TOKEN = document.querySelector('meta[name="api-token"]')?.getAttribute('content') || null;

  // Roles cache
  let rolesCache = [];
  let rolesLoaded = false;
  let rolesLoadingPromise = null;
  let rolesLoadSucceeded = false;

  function escapeHtml(str) {
    if (str == null) return '';
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(String(str)));
    return div.innerHTML;
  }

  // Verificar token antes de cargar datos
  if (!API_TOKEN) {
    showError('Autenticación requerida', 'No se encontró un token de acceso válido. Por favor, inicia sesión nuevamente.');
    return;
  }

  // Load initial data
  loadRoles();
  loadUsers();

  // Event listeners
  document.getElementById('btn-create-user').addEventListener('click', () => openUserModal());
  document.getElementById('btn-refresh-users').addEventListener('click', loadUsers);
  document.getElementById('search-users').addEventListener('input', debounce(() => loadUsers(1), 300));

  // Form submissions
  document.getElementById('user-form').addEventListener('submit', saveUser);

  // Modal close buttons
  document.getElementById('btn-cancel-user').addEventListener('click', () => closeUserModal());

  // Functions
  async function loadUsers(page = 1) {
    const search = document.getElementById('search-users').value;
    const url = `${API_BASE}/users?page=${page}&per_page=15&search=${encodeURIComponent(search)}`;

    try {
      const response = await fetch(url, {
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (response.ok && data.success) {
        renderUsers(data.data);
        renderPagination(data.data);
      } else {
        showApiError('Error al cargar usuarios', data);
      }
    } catch (error) {
      showError('Error de conexión', 'No se pudieron cargar los usuarios. Verifica tu conexión a internet.');
    }
  }

  function renderUsers(usersData) {
    const container = document.getElementById('users-list');
    container.innerHTML = '';

    if (usersData.data.length === 0) {
      container.innerHTML = '<p class="text-[var(--c-muted)] text-center py-8">No se encontraron usuarios</p>';
      return;
    }

    usersData.data.forEach(user => {
      const userEl = document.createElement('div');
      userEl.className = 'flex items-center justify-between p-4 bg-[var(--c-elev)] rounded-xl border border-[var(--c-border)]';

      // Profile image
      let profileImageHtml = '';
      if (user.profile_image) {
        profileImageHtml = `<img src="${escapeHtml(user.profile_image.url)}" alt="${escapeHtml(user.profile_image.alt || user.name)}" class="w-10 h-10 rounded-full object-cover">`;
      } else {
        profileImageHtml = `<div class="w-10 h-10 rounded-full bg-[var(--c-primary)] flex items-center justify-center text-white font-bold text-lg">${escapeHtml(user.name.charAt(0).toUpperCase())}</div>`;
      }

      const roleNames = Array.isArray(user.roles) ? user.roles.map(r => r?.name).filter(Boolean) : [];
      const roleIds = Array.isArray(user.roles) ? user.roles.map(r => r?.id).filter(Boolean) : [];

      userEl.innerHTML = `
        <div class="flex items-center gap-4">
          ${profileImageHtml}
          <div>
            <h3 class="font-medium text-[var(--c-text)]">${escapeHtml(user.name)}</h3>
            <p class="text-sm text-[var(--c-muted)]">${escapeHtml(user.email)}</p>
            ${roleNames.length ? `<p class="text-xs text-[var(--c-muted)] mt-1">Roles: ${escapeHtml(roleNames.join(', '))}</p>` : `<p class="text-xs text-[var(--c-muted)] mt-1">Roles: (sin roles)</p>`}
          </div>
        </div>
        <div class="flex gap-2">
          <button class="edit-user-btn px-3 py-1 text-sm bg-[var(--c-primary)] text-[var(--c-primary-ink)] rounded-lg hover:opacity-95 transition" data-id="${user.id}">Editar</button>
          <button class="delete-user-btn px-3 py-1 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition" data-id="${user.id}">Eliminar</button>
        </div>
      `;

      const editBtn = userEl.querySelector('.edit-user-btn');
      if (editBtn) {
        editBtn.dataset.name = user.name;
        editBtn.dataset.email = user.email;
        editBtn.dataset.profileImageId = user.profile_image_id || '';
        editBtn.dataset.roleIds = roleIds.join(',');
      }

      container.appendChild(userEl);
    });

    // Add event listeners
    container.querySelectorAll('.edit-user-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = e.target.dataset.id;
        const name = e.target.dataset.name;
        const email = e.target.dataset.email;
        const profileImageId = e.target.dataset.profileImageId;
        const roleIds = (e.target.dataset.roleIds || '')
          .split(',')
          .map(s => parseInt(s, 10))
          .filter(n => Number.isFinite(n));
        openUserModal(id, name, email, profileImageId, roleIds);
      });
    });

    container.querySelectorAll('.delete-user-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = e.target.dataset.id;
        deleteUser(id);
      });
    });
  }

  function renderPagination(usersData) {
    const container = document.getElementById('users-pagination');
    container.innerHTML = '';

    if (usersData.last_page <= 1) return;

    const prevBtn = document.createElement('button');
    prevBtn.textContent = 'Anterior';
    prevBtn.className = 'px-3 py-2 rounded-lg bg-[var(--c-elev)] text-[var(--c-text)] hover:bg-[var(--c-elev)]/80 disabled:opacity-50';
    prevBtn.disabled = !usersData.prev_page_url;
    prevBtn.addEventListener('click', () => loadUsers(usersData.current_page - 1));

    const nextBtn = document.createElement('button');
    nextBtn.textContent = 'Siguiente';
    nextBtn.className = 'px-3 py-2 rounded-lg bg-[var(--c-elev)] text-[var(--c-text)] hover:bg-[var(--c-elev)]/80 disabled:opacity-50';
    nextBtn.disabled = !usersData.next_page_url;
    nextBtn.addEventListener('click', () => loadUsers(usersData.current_page + 1));

    const pageInfo = document.createElement('div');
    pageInfo.textContent = `Página ${usersData.current_page} de ${usersData.last_page}`;
    pageInfo.className = 'text-sm text-[var(--c-muted)]';

    container.appendChild(prevBtn);
    container.appendChild(pageInfo);
    container.appendChild(nextBtn);
  }

  async function openUserModal(id = null, name = '', email = '', profileImageId = '', roleIds = []) {
    const modal = document.getElementById('user-modal');
    const title = document.getElementById('user-modal-title');
    const idField = document.getElementById('user-id');
    const nameField = document.getElementById('user-name');
    const emailField = document.getElementById('user-email');
    const passwordField = document.getElementById('user-password');
    const passwordConfirmContainer = document.getElementById('password-confirm-container');
    const rolesSelect = document.getElementById('user-roles');

    // Asegurar que el select tenga roles cargados antes de setear selección
    await loadRoles();

    if (id) {
      title.textContent = 'Editar Usuario';
      idField.value = id;
      nameField.value = name;
      emailField.value = email;
      passwordField.required = false;
      passwordField.placeholder = 'Dejar vacío para mantener la contraseña actual';
      passwordConfirmContainer.style.display = 'none';
      document.getElementById('user-password-confirm').required = false;
    } else {
      title.textContent = 'Crear Usuario';
      idField.value = '';
      nameField.value = '';
      emailField.value = '';
      passwordField.required = true;
      passwordField.placeholder = '';
      passwordConfirmContainer.style.display = 'block';
      document.getElementById('user-password-confirm').required = true;
    }

    // Selección de roles
    if (rolesSelect && rolesLoadSucceeded) {
      const selected = new Set((roleIds || []).map(n => parseInt(n, 10)).filter(Number.isFinite));
      Array.from(rolesSelect.options).forEach(opt => {
        const id = parseInt(opt.value, 10);
        opt.selected = selected.has(id);
      });
    }

    // Set profile image value
    const mediaInput = modal.querySelector('input[name="profile_image_id"]');
    if (mediaInput) {
      mediaInput.value = profileImageId;
      // Trigger preview update if needed
      setTimeout(() => {
        mediaInput.dispatchEvent(new Event('change', { bubbles: true }));
      }, 100);
    }

    modal.classList.remove('hidden');
  }

  function closeUserModal() {
    document.getElementById('user-modal').classList.add('hidden');
  }

  async function saveUser(e) {
    e.preventDefault();

    const id = document.getElementById('user-id').value;
    const name = document.getElementById('user-name').value;
    const email = document.getElementById('user-email').value;
    const password = document.getElementById('user-password').value;
    const profileImageId = document.querySelector('input[name="profile_image_id"]').value;
    const roles = Array.from(document.getElementById('user-roles')?.selectedOptions || [])
      .map(o => parseInt(o.value, 10))
      .filter(n => Number.isFinite(n));

    const method = id ? 'PUT' : 'POST';
    const url = id ? `${API_BASE}/users/${id}` : `${API_BASE}/users`;

    const formData = {
      name,
      email,
      profile_image_id: profileImageId || null
    };

    // Sólo enviar roles si se pudieron cargar correctamente.
    // Esto evita limpiar roles accidentalmente si falla loadRoles().
    if (rolesLoadSucceeded) {
      formData.roles = roles;
    }

    if (password) {
      formData.password = password;
      // Si estamos creando (no hay id), enviar confirmación
      if (!id) {
        formData.password_confirmation = document.getElementById('user-password-confirm').value;
      }
    }

    try {
      const response = await fetch(url, {
        method: method,
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
      });

      const data = await response.json();

      if (response.ok && data.success) {
        closeUserModal();
        loadUsers();
        // Mostrar respuesta exitosa en el modal JSON
        // Mostrar respuesta exitosa en el modal JSON
        // Mostrar respuesta exitosa en el modal JSON
        window.dispatchEvent(new CustomEvent('api:response', { detail: data }));
      } else {
        showApiError('Error al guardar usuario', data);
      }
    } catch (error) {
      showError('Error de conexión', 'No se pudo guardar el usuario. Verifica tu conexión a internet.');
    }
  }

  async function loadRoles() {
    if (rolesLoaded) return rolesCache;
    if (rolesLoadingPromise) return rolesLoadingPromise;

    const url = `${API_BASE}/rbac/roles?guard=web&per_page=100&sort=name&order=asc`;
    rolesLoadingPromise = (async () => {
      try {
        const response = await fetch(url, {
          headers: {
            'Authorization': `Bearer ${API_TOKEN}`,
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          }
        });

        const data = await response.json();
        if (response.ok && data.success) {
          rolesCache = Array.isArray(data.data) ? data.data : [];
          rolesLoaded = true;
          rolesLoadSucceeded = true;
          renderRolesSelect(rolesCache);
          return rolesCache;
        }

        showApiError('Error al cargar roles', data);
        rolesCache = [];
        rolesLoaded = true; // evita loop infinito; el usuario puede refrescar
        rolesLoadSucceeded = false;
        renderRolesSelect(rolesCache);
        return rolesCache;
      } catch (error) {
        showError('Error de conexión', 'No se pudieron cargar los roles.');
        rolesCache = [];
        rolesLoaded = true;
        rolesLoadSucceeded = false;
        renderRolesSelect(rolesCache);
        return rolesCache;
      } finally {
        rolesLoadingPromise = null;
      }
    })();

    return rolesLoadingPromise;
  }

  function renderRolesSelect(roles) {
    const select = document.getElementById('user-roles');
    if (!select) return;

    select.innerHTML = '';

    if (!Array.isArray(roles) || roles.length === 0) {
      const opt = document.createElement('option');
      opt.value = '';
      opt.textContent = 'No hay roles disponibles';
      opt.disabled = true;
      opt.selected = true;
      select.appendChild(opt);
      return;
    }

    roles.forEach(role => {
      const opt = document.createElement('option');
      opt.value = String(role.id);
      opt.textContent = role.name;
      select.appendChild(opt);
    });
  }

  async function deleteUser(id) {
    if (!confirm('¿Estás seguro de que quieres eliminar este usuario?')) return;

    try {
      const response = await fetch(`${API_BASE}/users/${id}`, {
        method: 'DELETE',
        headers: {
          'Authorization': `Bearer ${API_TOKEN}`,
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (response.ok && data.success) {
        loadUsers();
        window.dispatchEvent(new CustomEvent('api:response', { detail: data }));
      } else {
        showApiError('Error al eliminar usuario', data);
      }
    } catch (error) {
      showError('Error de conexión', 'No se pudo eliminar el usuario. Verifica tu conexión a internet.');
    }
  }

  function showError(title, message) {
    window.dispatchEvent(new CustomEvent('api:response', {
      detail: {
        success: false,
        message: message,
        code: 'CLIENT_ERROR',
        errors: { general: [message] }
      }
    }));
  }

  function showApiError(title, apiResponse) {
    console.error('API Error:', apiResponse);

    window.dispatchEvent(new CustomEvent('api:response', {
      detail: {
        success: false,
        message: apiResponse.message || 'Error desconocido',
        code: apiResponse.code || 'UNKNOWN_ERROR',
        errors: apiResponse.errors || null,
        status: apiResponse.status || null,
        raw: apiResponse
      }
    }));
  }

  function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }
});
</script>
@endsection
