<!-- ===== HEADER / TOPBAR ===== -->
@php
  $currentRoute = Route::currentRouteName();
  $breadcrumbs = [
    // Dashboard
    'dashboard' => [['Inicio', route('dashboard')], ['Dashboard', '#']],

    // Proyectos
    'projects' => [['Inicio', route('dashboard')], ['Proyectos', '#'], ['Todos los Proyectos', '#']],
    'projects.show' => [['Inicio', route('dashboard')], ['Proyectos', route('projects')], ['Detalle', '#']],
    'projects.backlog' => [['Inicio', route('dashboard')], ['Proyectos', route('projects')], ['Detalle', '#'], ['Backlog', '#']],
    'projects.gantt' => [['Inicio', route('dashboard')], ['Proyectos', route('projects')], ['Detalle', '#'], ['Gantt', '#']],
    'projects.files' => [['Inicio', route('dashboard')], ['Proyectos', route('projects')], ['Detalle', '#'], ['Archivos', '#']],

    // AdministraciÃ³n
    'users' => [['Inicio', route('dashboard')], ['AdministraciÃ³n', '#'], ['Usuarios', '#']],
    'rbac' => [['Inicio', route('dashboard')], ['AdministraciÃ³n', '#'], ['Roles & Permisos', '#']],

    // CatÃ¡logos
    'catalogs.task-status' => [['Inicio', route('dashboard')], ['CatÃ¡logos', '#'], ['Estados de Tarea', '#']],
    'catalogs.file-categories' => [['Inicio', route('dashboard')], ['CatÃ¡logos', '#'], ['CategorÃ­as de Archivo', '#']],
    'currencies' => [['Inicio', route('dashboard')], ['CatÃ¡logos', '#'], ['Monedas', '#']],
    'color-themes' => [['Inicio', route('dashboard')], ['CatÃ¡logos', '#'], ['Temas de Color', '#']],

    // ConfiguraciÃ³n
    'smtp-settings' => [['Inicio', route('dashboard')], ['ConfiguraciÃ³n', '#'], ['ConfiguraciÃ³n SMTP', '#']],
    'email-templates' => [['Inicio', route('dashboard')], ['ConfiguraciÃ³n', '#'], ['Plantillas de Email', '#']],

    // Cotizaciones
    'quotes' => [['Inicio', route('dashboard')], ['Cotizaciones', '#'], ['Todas las Cotizaciones', '#']],
    'quotes.settings' => [['Inicio', route('dashboard')], ['Cotizaciones', route('quotes')], ['ConfiguraciÃ³n', '#']],

    // Herramientas
    'funnel' => [['Inicio', route('dashboard')], ['Herramientas', '#'], ['Funnel', '#']],
    'leads' => [['Inicio', route('dashboard')], ['Herramientas', '#'], ['Leads', '#']],
  ];
  $crumbs = $breadcrumbs[$currentRoute] ?? [['Inicio', '/'], ['PÃ¡gina', '#']];
  $pageTitle = $crumbs[count($crumbs) - 1][0] ?? 'Panel';
  $user = auth()->user()?->load('profileImage');
@endphp

<header id="dash-header" class="sticky top-0 z-30 border-b border-[var(--c-border)] bg-[var(--c-bg)]/90 backdrop-blur">
  <div class="flex flex-wrap items-center gap-3 px-4 py-3 sm:px-6 lg:px-8">
    <div class="flex min-w-0 flex-1 items-center gap-3">
      <button
        id="dash-menu-btn"
        type="button"
        aria-controls="dash-sidebar"
        aria-expanded="false"
        class="xl:hidden inline-flex items-center gap-2 rounded-xl px-3 py-2 ring-1 ring-[var(--c-border)]"
      >
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M3 12h18"/><path d="M3 18h18"/></svg>
        <span class="text-sm">MenÃº</span>
      </button>

      <div class="min-w-0">
        <p class="truncate text-sm font-semibold md:hidden">{{ $pageTitle }}</p>

        <div class="hidden min-w-0 flex-wrap items-center gap-2 text-sm md:flex">
          @foreach($crumbs as $index => $crumb)
            @if($index > 0)
              <span class="opacity-50">/</span>
            @endif
            @if($crumb[1] !== '#')
              <a href="{{ $crumb[1] }}" class="truncate text-[var(--c-muted)] hover:text-[var(--c-text)]">{{ $crumb[0] }}</a>
            @else
              <span class="truncate font-medium">{{ $crumb[0] }}</span>
            @endif
          @endforeach
        </div>
      </div>
    </div>

    <div class="ml-auto flex w-full flex-wrap items-center justify-end gap-2 sm:w-auto sm:flex-nowrap sm:gap-3">
      <div class="hidden items-center gap-2 rounded-2xl bg-[var(--c-elev)] px-3 py-2 ring-1 ring-[var(--c-border)] focus-within:ring-[var(--c-primary)] lg:flex">
        <svg class="size-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input id="dash-top-search" type="search" placeholder="Buscar en todoâ€¦" class="w-44 bg-transparent text-sm outline-none placeholder:text-[var(--c-muted)] xl:w-64" />
      </div>

      <button id="dash-action-new" type="button" class="hidden items-center gap-2 rounded-xl bg-[var(--c-primary)] px-3 py-2 text-sm text-white shadow-soft hover:opacity-95 md:inline-flex">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
        Nuevo
      </button>

      <button id="dash-bell" type="button" class="inline-flex size-10 items-center justify-center rounded-xl ring-1 ring-[var(--c-border)] hover:ring-[var(--c-primary)]">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.7 1.7 0 0 0 3.4 0"/></svg>
      </button>

      <button id="dash-avatar" type="button" class="inline-flex max-w-full items-center gap-3 rounded-xl px-2 py-1 ring-1 ring-[var(--c-border)] hover:ring-[var(--c-primary)]">
        @if($user && $user->profileImage)
          <img alt="avatar" src="{{ $user->profileImage->url }}" class="size-8 rounded-lg object-cover"/>
        @else
          <svg class="size-8 text-[var(--c-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
        @endif
        <span class="hidden max-w-32 truncate text-sm lg:block">{{ $user ? $user->name : 'Usuario' }}</span>
      </button>
    </div>
  </div>
</header>
