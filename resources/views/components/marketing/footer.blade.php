<footer class="border-t border-white/10 bg-[var(--c-bg)]">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="py-12 lg:py-16">
      <div class="grid gap-10 lg:grid-cols-12">
        <!-- Brand / resumen -->
        <div class="lg:col-span-4">
          <div class="flex items-center gap-3">
            <span class="inline-flex size-10 items-center justify-center rounded-2xl bg-gradient-to-br from-[var(--c-primary)] to-[var(--c-primary-2)] shadow-soft ring-1 ring-white/10">
              <img src="{{ asset('img/logo-systems-gg.png') }}" alt="SystemsGG" width="28" height="28" decoding="async" loading="lazy" class="size-7 object-contain" />
            </span>
            <div>
              <p class="text-sm font-semibold">SystemsGG</p>
              <p class="text-xs text-[var(--c-muted)]">+11 años creando software a medida</p>
            </div>
          </div>

          <p class="mt-4 text-sm text-[var(--c-muted)] leading-relaxed">
            Desarrollo de páginas web en Lima y software a medida para empresas: plataformas internas, automatización de procesos, integraciones y productos web listos para escalar.
            (Contenido demostrativo.)
          </p>

          <div class="mt-6 flex items-center gap-2">
            <a href="#" class="inline-flex size-10 items-center justify-center rounded-xl bg-white/5 ring-1 ring-white/10 hover:bg-white/10 transition" aria-label="LinkedIn">
              <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                <rect x="2" y="9" width="4" height="12" />
                <circle cx="4" cy="4" r="2" />
              </svg>
            </a>
            <a href="#" class="inline-flex size-10 items-center justify-center rounded-xl bg-white/5 ring-1 ring-white/10 hover:bg-white/10 transition" aria-label="GitHub">
              <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
              </svg>
            </a>
            <a href="#" class="inline-flex size-10 items-center justify-center rounded-xl bg-white/5 ring-1 ring-white/10 hover:bg-white/10 transition" aria-label="Correo">
              <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="2" />
                <path d="m3 7 9 6 9-6" />
              </svg>
            </a>
          </div>
        </div>

        <!-- Links -->
        <div class="grid gap-10 sm:grid-cols-2 lg:col-span-8 lg:grid-cols-3">
          <div>
            <p class="text-sm font-semibold">Servicios</p>
            <ul class="mt-4 space-y-2 text-sm text-[var(--c-muted)]">
              <li><a href="{{ route('home') }}#servicios" class="hover:text-[var(--c-text)] transition">Desarrollo de software a medida</a></li>
              <li><a href="{{ route('home') }}#servicios" class="hover:text-[var(--c-text)] transition">Desarrollo web</a></li>
              <li><a href="{{ route('home') }}#servicios" class="hover:text-[var(--c-text)] transition">Integraciones & APIs</a></li>
              <li><a href="{{ route('home') }}#servicios" class="hover:text-[var(--c-text)] transition">Mantenimiento & soporte</a></li>
            </ul>
          </div>

          <div>
            <p class="text-sm font-semibold">Empresa</p>
            <ul class="mt-4 space-y-2 text-sm text-[var(--c-muted)]">
              <li><a href="{{ route('home') }}#proceso" class="hover:text-[var(--c-text)] transition">Cómo trabajamos</a></li>
              <li><a href="{{ route('home') }}#proyectos" class="hover:text-[var(--c-text)] transition">Casos de éxito</a></li>
              <li><a href="#" class="hover:text-[var(--c-text)] transition">Blog</a></li>
            </ul>
          </div>

          <div>
            <p class="text-sm font-semibold">Contacto</p>
            <ul class="mt-4 space-y-2 text-sm text-[var(--c-muted)]">
              <li><span class="text-[var(--c-text)]">Email:</span> hola@systemsgg.com</li>
              <li><span class="text-[var(--c-text)]">WhatsApp:</span> +51 949 421 023</li>
              <li><span class="text-[var(--c-text)]">Horario:</span> Lun–Vie 9:00am – 8:00pm</li>
              <li><a href="{{ route('home') }}#contacto" class="hover:text-[var(--c-text)] transition">Formulario de contacto</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="mt-12 flex flex-col gap-3 border-t border-white/10 pt-8 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-xs text-[var(--c-muted)]">© {{ date('Y') }} SystemsGG. Todos los derechos reservados.</p>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-[var(--c-muted)]">
          <a href="{{ route('privacidad') }}" class="hover:text-[var(--c-text)] transition">Privacidad</a>
          <a href="{{ route('terminos') }}" class="hover:text-[var(--c-text)] transition">Términos</a>
          <a href="{{ route('cookies') }}" class="hover:text-[var(--c-text)] transition">Cookies</a>
        </div>
      </div>
    </div>
  </div>
</footer>

