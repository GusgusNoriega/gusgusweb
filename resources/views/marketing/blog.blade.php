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

  <!-- FILTROS DE CATEGORÍAS -->
  <section class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-6">
        <div class="flex flex-wrap gap-2 justify-center">
          <button class="rounded-full bg-[var(--c-primary)] px-4 py-2 text-sm font-semibold text-white transition hover:opacity-95">
            Todos
          </button>
          <button class="rounded-full bg-white/5 px-4 py-2 text-sm font-semibold text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">
            Desarrollo Web
          </button>
          <button class="rounded-full bg-white/5 px-4 py-2 text-sm font-semibold text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">
            Software a Medida
          </button>
          <button class="rounded-full bg-white/5 px-4 py-2 text-sm font-semibold text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">
            SEO
          </button>
          <button class="rounded-full bg-white/5 px-4 py-2 text-sm font-semibold text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">
            Tutoriales
          </button>
          <button class="rounded-full bg-white/5 px-4 py-2 text-sm font-semibold text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">
            Noticias
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- ARTÍCULOS DESTACADOS -->
  <section class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-14 lg:py-20">
        <div class="flex items-center justify-between">
          <h2 class="text-2xl font-semibold tracking-tight sm:text-3xl">Artículos destacados</h2>
        </div>

        <!-- Artículo destacado (principal) -->
        <div class="mt-10">
          <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)]">
            <div class="grid lg:grid-cols-2">
              <div class="aspect-video lg:aspect-auto lg:h-full overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-500">
                <img src="{{ asset('img/blog/articulo-destacado.jpg') }}" alt="Artículo destacado" class="h-full w-full object-cover" />
              </div>
              <div class="p-6 lg:p-8 flex flex-col justify-center">
                <div class="flex items-center gap-2 mb-4">
                  <span class="rounded-full bg-[var(--c-primary)]/10 px-3 py-1 text-xs text-[var(--c-primary)] ring-1 ring-[var(--c-primary)]/30">
                    Destacado
                  </span>
                  <span class="text-xs text-[var(--c-muted)]">5 min de lectura</span>
                </div>
                <h3 class="text-xl font-semibold lg:text-2xl">
                  <a href="#" class="hover:text-[var(--c-primary)] transition">
                    Cómo elegir la mejor tecnología para tu proyecto web en 2024
                  </a>
                </h3>
                <p class="mt-3 text-sm text-[var(--c-muted)] leading-relaxed">
                  Descubre las tecnologías más modernas y eficientes para desarrollar tu página web o sistema. Comparamos Laravel, React, Vue y otras opciones para que tomes la mejor decisión para tu negocio.
                </p>
                <div class="mt-5 flex items-center gap-3">
                  <div class="size-8 rounded-full bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-2)] flex items-center justify-center text-xs font-semibold text-white">
                    GG
                  </div>
                  <div>
                    <p class="text-sm font-medium">SystemsGG</p>
                    <p class="text-xs text-[var(--c-muted)]">2 de febrero, 2026</p>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </div>

        <!-- Grid de artículos recientes -->
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <!-- Artículo 1 -->
          <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)] transition hover:ring-[var(--c-primary)]/50">
            <div class="aspect-video overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-500">
              <img src="{{ asset('img/blog/articulo-1.jpg') }}" alt="SEO para páginas web" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
            </div>
            <div class="p-5">
              <div class="flex items-center gap-2 mb-3">
                <span class="rounded-full bg-white/5 px-2 py-1 text-[10px] text-[var(--c-muted)] ring-1 ring-white/10">
                  SEO
                </span>
                <span class="text-[10px] text-[var(--c-muted)]">3 min lectura</span>
              </div>
              <h3 class="text-base font-semibold">
                <a href="#" class="hover:text-[var(--c-primary)] transition">
                  10 técnicas SEO esenciales para posicionar tu página web en Google
                </a>
              </h3>
              <p class="mt-2 text-xs text-[var(--c-muted)] leading-relaxed">
                Aprende las mejores prácticas de SEO técnico y on-page para mejorar el posicionamiento de tu sitio web y atraer más visitantes orgánicos.
              </p>
              <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-[var(--c-muted)]">28 Ene, 2026</span>
                <span class="text-xs text-[var(--c-primary)] font-medium hover:underline">Leer más →</span>
              </div>
            </div>
          </article>

          <!-- Artículo 2 -->
          <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)] transition hover:ring-[var(--c-primary)]/50">
            <div class="aspect-video overflow-hidden bg-gradient-to-br from-amber-600 to-orange-500">
              <img src="{{ asset('img/blog/articulo-2.jpg') }}" alt="Laravel vs otros frameworks" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
            </div>
            <div class="p-5">
              <div class="flex items-center gap-2 mb-3">
                <span class="rounded-full bg-white/5 px-2 py-1 text-[10px] text-[var(--c-muted)] ring-1 ring-white/10">
                  Desarrollo Web
                </span>
                <span class="text-[10px] text-[var(--c-muted)]">6 min lectura</span>
              </div>
              <h3 class="text-base font-semibold">
                <a href="#" class="hover:text-[var(--c-primary)] transition">
                  Laravel vs Node.js: ¿Cuál elegir para tu proyecto backend?
                </a>
              </h3>
              <p class="mt-2 text-xs text-[var(--c-muted)] leading-relaxed">
                Comparamos dos de las tecnologías más populares para desarrollo backend. Conoce las ventajas y desventajas de cada una.
              </p>
              <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-[var(--c-muted)]">25 Ene, 2026</span>
                <span class="text-xs text-[var(--c-primary)] font-medium hover:underline">Leer más →</span>
            </div>
              </div>
          </article>

          <!-- Artículo 3 -->
          <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)] transition hover:ring-[var(--c-primary)]/50">
            <div class="aspect-video overflow-hidden bg-gradient-to-br from-rose-600 to-pink-500">
              <img src="{{ asset('img/blog/articulo-3.jpg') }}" alt="UX/UI Design" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
            </div>
            <div class="p-5">
              <div class="flex items-center gap-2 mb-3">
                <span class="rounded-full bg-white/5 px-2 py-1 text-[10px] text-[var(--c-muted)] ring-1 ring-white/10">
                  Diseño UX/UI
                </span>
                <span class="text-[10px] text-[var(--c-muted)]">4 min lectura</span>
              </div>
              <h3 class="text-base font-semibold">
                <a href="#" class="hover:text-[var(--c-primary)] transition">
                  La importancia del diseño UX/UI en el éxito de tu página web
                </a>
              </h3>
              <p class="mt-2 text-xs text-[var(--c-muted)] leading-relaxed">
                Un buen diseño no es solo estética. Descubre cómo la experiencia de usuario impacta en las conversiones y la retención de visitantes.
              </p>
              <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-[var(--c-muted)]">20 Ene, 2026</span>
                <span class="text-xs text-[var(--c-primary)] font-medium hover:underline">Leer más →</span>
              </div>
            </div>
          </article>

          <!-- Artículo 4 -->
          <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)] transition hover:ring-[var(--c-primary)]/50">
            <div class="aspect-video overflow-hidden bg-gradient-to-br from-cyan-600 to-blue-500">
              <img src="{{ asset('img/blog/articulo-4.jpg') }}" alt="Integración WhatsApp" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
            </div>
            <div class="p-5">
              <div class="flex items-center gap-2 mb-3">
                <span class="rounded-full bg-white/5 px-2 py-1 text-[10px] text-[var(--c-muted)] ring-1 ring-white/10">
                  Integraciones
                </span>
                <span class="text-[10px] text-[var(--c-muted)]">5 min lectura</span>
              </div>
              <h3 class="text-base font-semibold">
                <a href="#" class="hover:text-[var(--c-primary)] transition">
                  Cómo integrar WhatsApp Business en tu sistema de atención al cliente
                </a>
              </h3>
              <p class="mt-2 text-xs text-[var(--c-muted)] leading-relaxed">
                Automatiza tus respuestas y mejora la atención al cliente integrando WhatsApp Business API en tu sitio web o sistema.
              </p>
              <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-[var(--c-muted)]">15 Ene, 2026</span>
                <span class="text-xs text-[var(--c-primary)] font-medium hover:underline">Leer más →</span>
              </div>
            </div>
          </article>

          <!-- Artículo 5 -->
          <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)] transition hover:ring-[var(--c-primary)]/50">
            <div class="aspect-video overflow-hidden bg-gradient-to-br from-violet-600 to-purple-500">
              <img src="{{ asset('img/blog/articulo-5.jpg') }}" alt="Seguridad web" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
            </div>
            <div class="p-5">
              <div class="flex items-center gap-2 mb-3">
                <span class="rounded-full bg-white/5 px-2 py-1 text-[10px] text-[var(--c-muted)] ring-1 ring-white/10">
                  Seguridad
                </span>
                <span class="text-[10px] text-[var(--c-muted)]">7 min lectura</span>
              </div>
              <h3 class="text-base font-semibold">
                <a href="#" class="hover:text-[var(--c-primary)] transition">
                  Guía completa de seguridad para tu página web: SSL, firewalls y más
                </a>
              </h3>
              <p class="mt-2 text-xs text-[var(--c-muted)] leading-relaxed">
                Protege tu sitio web de amenazas cibernéticas con estas prácticas esenciales de seguridad que todo propietario debe conocer.
              </p>
              <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-[var(--c-muted)]">10 Ene, 2026</span>
                <span class="text-xs text-[var(--c-primary)] font-medium hover:underline">Leer más →</span>
              </div>
            </div>
          </article>

          <!-- Artículo 6 -->
          <article class="overflow-hidden rounded-3xl bg-[var(--c-surface)] ring-1 ring-[var(--c-border)] transition hover:ring-[var(--c-primary)]/50">
            <div class="aspect-video overflow-hidden bg-gradient-to-br from-red-600 to-orange-500">
              <img src="{{ asset('img/blog/articulo-6.jpg') }}" alt="Velocidad web" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
            </div>
            <div class="p-5">
              <div class="flex items-center gap-2 mb-3">
                <span class="rounded-full bg-white/5 px-2 py-1 text-[10px] text-[var(--c-muted)] ring-1 ring-white/10">
                  Rendimiento
                </span>
                <span class="text-[10px] text-[var(--c-muted)]">4 min lectura</span>
              </div>
              <h3 class="text-base font-semibold">
                <a href="#" class="hover:text-[var(--c-primary)] transition">
                  7 formas de mejorar la velocidad de tu sitio web y el Core Web Vitals
                </a>
              </h3>
              <p class="mt-2 text-xs text-[var(--c-muted)] leading-relaxed">
                La velocidad afecta el SEO y la experiencia del usuario. Aprende técnicas prácticas para optimizar el rendimiento de tu web.
              </p>
              <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-[var(--c-muted)]">5 Ene, 2026</span>
                <span class="text-xs text-[var(--c-primary)] font-medium hover:underline">Leer más →</span>
              </div>
            </div>
          </article>
        </div>

        <!-- Paginación -->
        <div class="mt-12 flex items-center justify-center gap-2">
          <button class="rounded-xl bg-white/5 px-4 py-2 text-sm text-[var(--c-muted)] ring-1 ring-white/10 hover:bg-white/10 transition disabled:opacity-50" disabled>
            ← Anterior
          </button>
          <button class="rounded-xl bg-[var(--c-primary)] px-4 py-2 text-sm font-semibold text-white">1</button>
          <button class="rounded-xl bg-white/5 px-4 py-2 text-sm text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">2</button>
          <button class="rounded-xl bg-white/5 px-4 py-2 text-sm text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">3</button>
          <span class="text-sm text-[var(--c-muted)]">...</span>
          <button class="rounded-xl bg-white/5 px-4 py-2 text-sm text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">10</button>
          <button class="rounded-xl bg-white/5 px-4 py-2 text-sm text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">
            Siguiente →
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- NEWSLETTER -->
  <section class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-14 lg:py-20">
        <div class="rounded-3xl bg-gradient-to-r from-[var(--c-primary)]/10 to-[var(--c-primary-2)]/10 p-8 ring-1 ring-[var(--c-primary)]/20 lg:p-12">
          <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
            <div>
              <h2 class="text-2xl font-semibold tracking-tight sm:text-3xl">
                ¿Quieres recibir<span class="text-[var(--c-primary)]"> artículos exclusivos</span> en tu email?
              </h2>
              <p class="mt-3 text-sm text-[var(--c-muted)] leading-relaxed">
                Suscríbete a nuestro newsletter y recibe las últimas noticias, tutoriales y consejos sobre desarrollo web directamente en tu bandeja de entrada.
              </p>
              <form class="mt-6 flex flex-col gap-3 sm:flex-row">
                <input 
                  type="email" 
                  placeholder="Tu correo electrónico" 
                  class="w-full rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm outline-none ring-1 ring-[var(--c-border)] focus:ring-2 focus:ring-[var(--c-primary)] transition-all"
                />
                <button type="submit" class="rounded-2xl bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-2)] px-6 py-3 text-sm font-semibold text-white shadow-soft hover:opacity-95 transition">
                  Suscribirse
                </button>
              </form>
              <p class="mt-3 text-xs text-[var(--c-muted)]">
                Sin spam. Solo contenido valioso. Puedes darte de baja cuando quieras.
              </p>
            </div>
            <div class="hidden lg:block">
              <div class="flex items-center justify-center">
                <div class="relative">
                  <div class="absolute -inset-4 rounded-full bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-2)] opacity-20 blur-2xl"></div>
                  <svg class="relative size-32 text-[var(--c-primary)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-9-2 2-2z1.1."/>
                    <polyline points="22,6 12,13 2,6"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
