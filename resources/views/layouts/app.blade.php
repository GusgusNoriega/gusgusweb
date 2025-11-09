<!doctype html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Dashboard Base • Tailwind + Dark Mode')</title>

  @if(session('passport_token'))
    <meta name="api-token" content="{{ session('passport_token') }}">
  @endif

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tailwind CSS (CDN) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // Tailwind config (opcional): habilita clases arbitrarias sin tema extra
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ["Inter var", "Inter", "system-ui", "-apple-system", "Segoe UI", "Roboto", "Ubuntu", "Cantarell", "Noto Sans", "Helvetica Neue", "Arial", "\"Apple Color Emoji\"", "\"Segoe UI Emoji\"", "\"Segoe UI Symbol\""]
          },
          boxShadow: {
            soft: "0 1px 2px rgba(0,0,0,.04), 0 2px 12px rgba(0,0,0,.06)"
          }
        }
      }
    }
  </script>
  <!-- Alpine.js para tabs y pequeños estados en vistas -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Variables de color dinámicas del tema del usuario -->
  <style>
    @php
      $colorThemeService = app(\App\Services\ColorThemeService::class);
      $userTheme = $colorThemeService->getUserTheme();
    @endphp

    :root {
      /* Variables dinámicas del tema del usuario */
      @if($userTheme)
        @foreach($userTheme->colors as $key => $value)
          --c-{{ $key }}: {{ $value }};
        @endforeach
      @else
        /* Fallback por defecto (oscuro) */
        --c-bg: oklch(0.17 0.02 255);
        --c-surface: oklch(0.21 0.02 255);
        --c-elev: oklch(0.25 0.02 255);
        --c-text: oklch(0.93 0.02 255);
        --c-muted: oklch(0.74 0.02 255);
        --c-border: oklch(0.35 0.02 255);
        --c-primary: oklch(0.72 0.14 260);
        --c-primary-ink: oklch(0.12 0.02 260);
        --c-accent: oklch(0.75 0.13 170);
        --c-danger: oklch(0.68 0.21 25);
      @endif
      --radius: 14px;
      color-scheme: dark; /* hint al navegador */
    }

    /* Oculta elementos hasta que cargue Alpine (x-cloak) */
    [x-cloak] { display: none !important; }
 
    /* Scrollbar sutil */
    ::-webkit-scrollbar{width:10px;height:10px}
    ::-webkit-scrollbar-thumb{background:var(--c-border);border-radius:999px}
    ::-webkit-scrollbar-track{background:transparent}

    /* Estilo para enlace activo */
    #dash-accordion a.active {
      background-color: rgba(0, 0, 0, 0.5);
      font-weight: 600;
    }

    /* Evita saltos al aparecer la barra de scroll */
    html { scrollbar-gutter: stable; }

    /* will-change sólo durante animación del sidebar */
    #dash-sidebar.animating { will-change: transform; }

    /* Pintar sólo lo visible dentro de los paneles del acordeón */
    @supports (content-visibility: auto) {
      .cv-auto { content-visibility: auto; contain-intrinsic-size: 1px 400px; }
    }

    /* Animación ligera para abrir/cerrar acordeón (barata) */
    .acc-enter { transition: opacity .18s ease, transform .18s ease; opacity: 0; transform: scaleY(.98); }
    .acc-enter.act { opacity: 1; transform: scaleY(1); }
  </style>
</head>
<body class="min-h-screen bg-[var(--c-bg)] text-[var(--c-text)] font-sans">
   <!-- Preloader -->
  @include('components.preloader')
  <!--
    -----------------------------------------------------------
    LAYOUT PRINCIPAL
    - Aside (Barra lateral)
    - Header (Barra superior)
    - Main (Contenido del dashboard)
    - Footer (Pie de página)
    -----------------------------------------------------------
  -->

  <!-- Backdrop móvil para el sidebar -->
  <div id="dash-backdrop" class="lg:hidden fixed inset-0 bg-black/40 hidden"></div>

  <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] h-screen">

    <!-- ========================= ASIDE / SIDEBAR ========================= -->
    <aside id="dash-sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-[80%] max-w-[320px] lg:w-auto translate-x-[-100%] lg:translate-x-0 transition-transform duration-300 ease-out bg-[var(--c-surface)] border-r border-[var(--c-border)]">
      <div class="h-full flex flex-col">
        <!-- Branding -->
        <div class="flex items-center gap-3 px-5 py-4 border-b border-[var(--c-border)]">
          <div class="size-9 rounded-xl grid place-items-center bg-[var(--c-primary)] text-white font-bold shadow-soft">D</div>
          <div>
            <h1 class="text-base font-semibold leading-tight">Dashboard Base</h1>
            <p class="text-xs text-[var(--c-muted)] leading-tight">Layout modular</p>
          </div>
        </div>

        <!-- Buscador en el sidebar -->
        <div class="px-4 py-3 border-b border-[var(--c-border)]">
          <label for="dash-sidebar-search" class="sr-only">Buscar</label>
          <div class="flex items-center gap-2 rounded-2xl bg-[var(--c-elev)] px-3 py-2 ring-1 ring-[var(--c-border)] focus-within:ring-[var(--c-primary)]">
            <svg class="size-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
            <input id="dash-sidebar-search" type="search" placeholder="Buscar…" class="bg-transparent outline-none w-full text-sm placeholder:text-[var(--c-muted)]" />
          </div>
        </div>

        <!-- Menú (Acordeón modular) -->
        <nav id="dash-accordion" class="flex-1 overflow-y-auto p-2 space-y-2">
          <!-- Grupo 1 -->
          <section class="rounded-2xl overflow-hidden ring-1 ring-[var(--c-border)]">
            <button id="dash-acc-btn-1" class="w-full flex items-center justify-between gap-3 px-4 py-3 bg-[var(--c-elev)] hover:bg-[var(--c-elev)]/80 transition" aria-controls="dash-acc-panel-1" aria-expanded="true">
              <span class="flex items-center gap-3">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"></path><path d="M3 6h18"></path><path d="M3 18h18"></path></svg>
                <span class="text-sm font-medium">General</span>
              </span>
              <svg class="size-4 rotate-0 transition-transform" id="dash-acc-icon-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <div id="dash-acc-panel-1" class="hidden cv-auto">
              <div class="p-2 bg-[var(--c-surface)] min-h-0">
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">🏠</span>Inicio</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">📄</span>Reportes</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">📦</span>Productos</a>
              </div>
            </div>
          </section>

          <!-- Grupo 2 -->
          <section class="rounded-2xl overflow-hidden ring-1 ring-[var(--c-border)]">
            <button id="dash-acc-btn-2" class="w-full flex items-center justify-between gap-3 px-4 py-3 bg-[var(--c-elev)] hover:bg-[var(--c-elev)]/80 transition" aria-controls="dash-acc-panel-2" aria-expanded="false">
              <span class="flex items-center gap-3">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 8h10"/><path d="M7 12h10"/><path d="M7 16h10"/></svg>
                <span class="text-sm font-medium">Gestión</span>
              </span>
              <svg class="size-4 -rotate-90 transition-transform" id="dash-acc-icon-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <div id="dash-acc-panel-2" class="hidden cv-auto">
              <div class="p-2 bg-[var(--c-surface)] min-h-0">
                <a href="{{ route('users') }}" data-route="users" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">👥</span>Usuarios</a>
                <a href="{{ route('currencies') }}" data-route="currencies" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">💰</span>Monedas</a>
                <a href="{{ route('color-themes') }}" data-route="color-themes" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">🎨</span>Temas de Color</a>
                <a href="{{ route('rbac') }}" data-route="rbac" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">🛠</span>Roles & Permisos</a>
                <a href="{{ route('projects') }}" data-route="projects" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">📁</span>Proyectos</a>
                <a href="{{ route('catalogs.task-status') }}" data-route="catalogs.task-status" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">📚</span>Catálogos</a>
              </div>
            </div>
          </section>

          <!-- Grupo 3 -->
          <section class="rounded-2xl overflow-hidden ring-1 ring-[var(--c-border)]">
            <button id="dash-acc-btn-3" class="w-full flex items-center justify-between gap-3 px-4 py-3 bg-[var(--c-elev)] hover:bg-[var(--c-elev)]/80 transition" aria-controls="dash-acc-panel-3" aria-expanded="false">
              <span class="flex items-center gap-3">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M2 12h20"/></svg>
                <span class="text-sm font-medium">Ajustes</span>
              </span>
              <svg class="size-4 -rotate-90 transition-transform" id="dash-acc-icon-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <div id="dash-acc-panel-3" class="hidden cv-auto">
              <div class="p-2 bg-[var(--c-surface)] min-h-0">
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">🎨</span>Tema & Marca</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[var(--c-elev)] transition text-sm"><span class="size-6 grid place-items-center rounded-lg ring-1 ring-[var(--c-border)]">🔔</span>Notificaciones</a>
              </div>
            </div>
          </section>
        </nav>

        <!-- Footer del sidebar -->
        <div class="mt-auto px-4 py-3 border-t border-[var(--c-border)] flex items-center justify-between">
          <a href="#" class="text-xs text-[var(--c-muted)] hover:underline">v1.0</a>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-transparent border border-[var(--c-danger)] text-[var(--c-danger)] hover:bg-[var(--c-danger)] hover:text-white transition">
              <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16,17 21,12 16,7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
              </svg>
              <span class="text-sm">Salir</span>
            </button>
          </form>
        </div>
      </div>
    </aside>

    <!-- ========================= CONTENIDO (Header + Main + Footer) ========================= -->
    <div class="lg:col-start-2 flex flex-col h-screen">
      <!-- ===== HEADER / TOPBAR ===== -->
      <header class="h-[10vh]">
        @include('components.header')
      </header>

      <!-- ===== MAIN ===== -->
      <main id="dash-main" class="h-[80vh] overflow-auto px-4 sm:px-6 py-6">
        @yield('content')
      </main>

      <!-- ===== FOOTER ===== -->
      <footer class="h-[10vh]">
        @include('components.footer')
      </footer>
    </div>
  <!-- JSON Response Modal -->
  @include('components.json-response-modal')

  <!-- Media Picker Modal -->
  <x-media-picker />

  </div>


  <!-- ========================= SCRIPTS (IDs únicos prefijados con dash-) ========================= -->
  <script src="{{ asset('js/media-picker.js') }}"></script>
  <script>
    (function(){
      // --- Ruta actual ---
      const currentRoute = '{{ request()->route()->getName() }}';

      // --- Mapa de rutas a grupos ---
      const routeToGroup = {
        'users': 2,
        'currencies': 2,
        'color-themes': 2,
        'rbac': 2,
        'projects': 2,
        'projects.show': 2,
        'projects.backlog': 2,
        'projects.gantt': 2,
        'projects.files': 2,
        'catalogs.task-status': 2,
        'catalogs.file-categories': 2,
      };

      // --- Año del footer ---
      const y = document.getElementById('dash-year');
      if (y) y.textContent = new Date().getFullYear();

      // --- Sidebar responsive ---
      const sidebar  = document.getElementById('dash-sidebar');
      const menuBtn  = document.getElementById('dash-menu-btn');
      const backdrop = document.getElementById('dash-backdrop');

      // Backdrop blur condicional (solo si el navegador soporta)
      const enableBlur = CSS.supports && CSS.supports('backdrop-filter: blur(4px)');
      if (enableBlur) {
        const s = document.createElement('style');
        s.textContent = '#dash-backdrop.blur{backdrop-filter:blur(4px)}';
        document.head.appendChild(s);
      }

      const openSidebar = () => {
        sidebar.classList.add('animating');
        if (enableBlur) backdrop.classList.add('blur');
        sidebar.style.transform = 'translateX(0)';
        backdrop.classList.remove('hidden');
        sidebar.addEventListener('transitionend', () => sidebar.classList.remove('animating'), { once: true });
      };
      const closeSidebar = () => {
        sidebar.classList.add('animating');
        sidebar.style.transform = '';
        sidebar.addEventListener('transitionend', () => sidebar.classList.remove('animating'), { once: true });
        if (enableBlur) backdrop.classList.remove('blur');
        backdrop.classList.add('hidden');
      };
      menuBtn?.addEventListener('click', openSidebar);
      backdrop?.addEventListener('click', closeSidebar);
      window.addEventListener('keydown', (e)=>{ if(e.key==='Escape') closeSidebar(); });

      // --- Acordeón modular optimizado (sin max-height) ---
      const ACCORDION_SINGLE_OPEN = true; // solo un módulo abierto a la vez
      const currentGroup = routeToGroup[currentRoute] || 1;
      const accordionItems = [
        { btn: 'dash-acc-btn-1', panel: 'dash-acc-panel-1', icon: 'dash-acc-icon-1', defaultOpen: currentGroup === 1 },
        { btn: 'dash-acc-btn-2', panel: 'dash-acc-panel-2', icon: 'dash-acc-icon-2', defaultOpen: currentGroup === 2 },
        { btn: 'dash-acc-btn-3', panel: 'dash-acc-panel-3', icon: 'dash-acc-icon-3', defaultOpen: currentGroup === 3 },
      ];

      const openPanel = (panelEl, btnEl, iconEl) => {
        panelEl.classList.remove('hidden');
        panelEl.classList.add('acc-enter');
        // sube a estado visible en el siguiente frame (transición 0 -> 1)
        requestAnimationFrame(() => {
          panelEl.classList.add('act');
        });
        btnEl.setAttribute('aria-expanded', 'true');
        if (iconEl) iconEl.style.transform = 'rotate(0deg)';
      };

      const closePanel = (panelEl, btnEl, iconEl) => {
        // garantiza transición también al cerrar (1 -> 0)
        panelEl.classList.add('acc-enter');
        panelEl.classList.add('act');
        requestAnimationFrame(() => {
          panelEl.classList.remove('act');
        });
        const onEnd = () => {
          panelEl.classList.add('hidden');
          panelEl.classList.remove('acc-enter');
          panelEl.removeEventListener('transitionend', onEnd);
        };
        panelEl.addEventListener('transitionend', onEnd);
        btnEl.setAttribute('aria-expanded', 'false');
        if (iconEl) iconEl.style.transform = 'rotate(-90deg)';
      };

      // Inicialización: abre el grupo correspondiente y cierra otros
      const instances = accordionItems.map(({btn, panel, icon, defaultOpen}) => {
        const btnEl   = document.getElementById(btn);
        const panelEl = document.getElementById(panel);
        const iconEl  = icon ? document.getElementById(icon) : null;
        if(!btnEl || !panelEl) return null;

        if(defaultOpen) {
          panelEl.classList.remove('hidden'); // abierto de inicio (sin animar)
          btnEl.setAttribute('aria-expanded','true');
          if(iconEl) iconEl.style.transform = 'rotate(0deg)';
        } else {
          panelEl.classList.add('hidden');
          btnEl.setAttribute('aria-expanded','false');
          if(iconEl) iconEl.style.transform = 'rotate(-90deg)';
        }

        btnEl.addEventListener('click', () => {
          const isOpen = btnEl.getAttribute('aria-expanded') === 'true';
          if(isOpen){
            closePanel(panelEl, btnEl, iconEl);
          } else {
            if (ACCORDION_SINGLE_OPEN) {
              accordionItems.forEach(({btn, panel, icon}) => {
                const otherBtn   = document.getElementById(btn);
                const otherPanel = document.getElementById(panel);
                const otherIcon  = icon ? document.getElementById(icon) : null;
                if(otherPanel && otherPanel !== panelEl && !otherPanel.classList.contains('hidden')) {
                  closePanel(otherPanel, otherBtn, otherIcon);
                }
              });
            }
            openPanel(panelEl, btnEl, iconEl);
          }
        });

        return { btnEl, panelEl, iconEl };
      }).filter(Boolean);

      // --- Marcar enlace activo ---
      const links = document.querySelectorAll('#dash-accordion a[data-route]');
      links.forEach(link => {
        const route = link.getAttribute('data-route');
        if(route === currentRoute){
          link.classList.add('active');
        }
      });

      // --- Acciones simuladas ---
      document.getElementById('dash-action-new')?.addEventListener('click', ()=>{
        alert('Acción: Crear nuevo registro');
      });
    })();
  </script>
</body>
</html>