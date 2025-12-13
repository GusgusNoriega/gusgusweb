@extends('layouts.marketing')

@section('title', 'Desarrollo de páginas web en Lima | Desarrollo de software a medida - SystemsGG')
@section('og_title', 'Desarrollo de páginas web en Lima y software a medida | SystemsGG')
@section('canonical', url('/'))
@section('meta_description', 'Empresa de desarrollo de páginas web en Lima y desarrollo de software a medida. +11 años de experiencia creando soluciones para empresas: web, APIs, automatización e integraciones.')

@section('content')
  <!-- HERO -->
  <section id="inicio" class="relative overflow-hidden">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -top-32 left-1/2 h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-[radial-gradient(circle_at_center,rgba(99,102,241,0.35),transparent_60%)] blur-2xl"></div>
      <div class="absolute -bottom-40 left-10 h-[520px] w-[520px] rounded-full bg-[radial-gradient(circle_at_center,rgba(168,85,247,0.28),transparent_60%)] blur-2xl"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-14 sm:py-18 lg:py-24">
        <div class="grid items-center gap-10 lg:grid-cols-12">
          <div class="lg:col-span-7">
            <div class="inline-flex items-center gap-2 rounded-full bg-white/5 px-3 py-1 text-xs text-[var(--c-muted)] ring-1 ring-white/10">
              <span class="inline-flex size-2 rounded-full bg-[var(--c-accent)]"></span>
              +11 años creando soluciones para empresas (demo)
            </div>

            <h1 class="mt-5 text-3xl font-semibold tracking-tight sm:text-4xl lg:text-5xl">
              <span class="bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-2)] bg-clip-text text-transparent">Desarrollo de páginas web en Lima</span>
              y <span class="text-white">software a medida</span> para impulsar tu negocio
            </h1>

            <p class="mt-4 text-base text-[var(--c-muted)] leading-relaxed sm:text-lg">
              Construimos plataformas internas, integraciones y productos web con enfoque en rendimiento, seguridad y escalabilidad.
              Atendemos proyectos en <span class="text-[var(--c-text)]">Lima, Perú</span> y de forma remota.
              Entregas claras, comunicación directa y un proceso diseñado para avanzar sin fricción.
            </p>

            <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:items-center">
              <a href="#contacto" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-2)] px-5 py-3 text-sm font-semibold text-white shadow-soft ring-1 ring-white/10 hover:opacity-95 transition">
                Solicitar cotización
              </a>
              <a href="#servicios" class="inline-flex items-center justify-center rounded-xl bg-white/5 px-5 py-3 text-sm font-semibold text-[var(--c-text)] ring-1 ring-white/10 hover:bg-white/10 transition">
                Ver servicios
              </a>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
              <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                <p class="text-sm font-semibold">Entrega</p>
                <p class="mt-1 text-xs text-[var(--c-muted)]">Iterativa & medible</p>
              </div>
              <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                <p class="text-sm font-semibold">Stack</p>
                <p class="mt-1 text-xs text-[var(--c-muted)]">Web & APIs</p>
              </div>
              <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                <p class="text-sm font-semibold">Calidad</p>
                <p class="mt-1 text-xs text-[var(--c-muted)]">Buenas prácticas</p>
              </div>
              <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                <p class="text-sm font-semibold">Soporte</p>
                <p class="mt-1 text-xs text-[var(--c-muted)]">Post-lanzamiento</p>
              </div>
            </div>
          </div>

          <!-- Panel visual -->
          <div class="lg:col-span-5">
            <div class="relative overflow-hidden rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)] shadow-soft">
              <div class="absolute -right-24 -top-24 size-64 rounded-full bg-[radial-gradient(circle_at_center,rgba(99,102,241,0.35),transparent_60%)] blur-2xl"></div>
              <div class="absolute -left-28 -bottom-28 size-64 rounded-full bg-[radial-gradient(circle_at_center,rgba(20,184,166,0.24),transparent_60%)] blur-2xl"></div>

              <div class="relative">
                <p class="text-xs text-[var(--c-muted)]">Vista previa (demo)</p>
                <h2 class="mt-1 text-lg font-semibold">Dashboard + API + Automatización</h2>
                <p class="mt-2 text-sm text-[var(--c-muted)]">
                  Desde una idea hasta una solución lista para operar, con un diseño moderno y optimizado para móviles.
                </p>

                <div class="mt-6 grid gap-3">
                  <div class="rounded-2xl bg-[var(--c-elev)] p-4 ring-1 ring-[var(--c-border)]">
                    <div class="flex items-center justify-between">
                      <p class="text-sm font-semibold">Módulo: Ventas</p>
                      <span class="rounded-full bg-white/5 px-2 py-1 text-[11px] text-[var(--c-muted)] ring-1 ring-white/10">Listo</span>
                    </div>
                    <p class="mt-2 text-xs text-[var(--c-muted)]">Embudo, cotizaciones, reportes y KPIs.</p>
                  </div>
                  <div class="rounded-2xl bg-[var(--c-elev)] p-4 ring-1 ring-[var(--c-border)]">
                    <div class="flex items-center justify-between">
                      <p class="text-sm font-semibold">Módulo: Operaciones</p>
                      <span class="rounded-full bg-white/5 px-2 py-1 text-[11px] text-[var(--c-muted)] ring-1 ring-white/10">En progreso</span>
                    </div>
                    <p class="mt-2 text-xs text-[var(--c-muted)]">Tareas, estados, responsables y trazabilidad.</p>
                  </div>
                  <div class="rounded-2xl bg-[var(--c-elev)] p-4 ring-1 ring-[var(--c-border)]">
                    <div class="flex items-center justify-between">
                      <p class="text-sm font-semibold">Integraciones</p>
                      <span class="rounded-full bg-white/5 px-2 py-1 text-[11px] text-[var(--c-muted)] ring-1 ring-white/10">API</span>
                    </div>
                    <p class="mt-2 text-xs text-[var(--c-muted)]">ERP / CRM, pasarelas de pago y mensajería.</p>
                  </div>
                </div>

                <div class="mt-6 rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                  <p class="text-xs text-[var(--c-muted)]">Tiempo estimado</p>
                  <p class="mt-1 text-sm font-semibold">MVP en 4–8 semanas</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICIOS -->
  <section id="servicios" class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-14 lg:py-20">
        <div class="max-w-2xl">
          <h2 class="text-2xl font-semibold tracking-tight sm:text-3xl">Servicios</h2>
          <p class="mt-3 text-sm text-[var(--c-muted)] leading-relaxed">
            Creamos soluciones de punta a punta: desde el análisis hasta el despliegue, con acompañamiento y soporte.
          </p>
        </div>

        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)] shadow-soft">
            <div class="flex items-center gap-3">
              <span class="inline-flex size-11 items-center justify-center rounded-2xl bg-white/5 ring-1 ring-white/10">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-9" /><path d="M14 17H5" /><circle cx="17" cy="17" r="3" /><circle cx="7" cy="7" r="3" /></svg>
              </span>
              <h3 class="text-base font-semibold">Software a medida</h3>
            </div>
            <p class="mt-3 text-sm text-[var(--c-muted)]">
              Sistemas internos, automatización, gestión de procesos, permisos/roles y paneles administrativos.
            </p>
          </div>

          <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)] shadow-soft">
            <div class="flex items-center gap-3">
              <span class="inline-flex size-11 items-center justify-center rounded-2xl bg-white/5 ring-1 ring-white/10">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z" /><path d="M4 9h16" /><path d="M9 20V9" /></svg>
              </span>
              <h3 class="text-base font-semibold">Desarrollo web</h3>
            </div>
            <p class="mt-3 text-sm text-[var(--c-muted)]">
              Landing pages, sitios corporativos y webapps con diseño moderno, rápido y 100% responsive.
            </p>
          </div>

          <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)] shadow-soft">
            <div class="flex items-center gap-3">
              <span class="inline-flex size-11 items-center justify-center rounded-2xl bg-white/5 ring-1 ring-white/10">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 18a4 4 0 0 0 0-8H5" /><path d="M8 6h11a4 4 0 0 1 0 8" /><path d="M12 14v7" /><path d="M9 18h6" /></svg>
              </span>
              <h3 class="text-base font-semibold">Integraciones & APIs</h3>
            </div>
            <p class="mt-3 text-sm text-[var(--c-muted)]">
              Conectamos servicios externos, pasarelas de pago, WhatsApp/Email, CRMs y ERPs.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PROCESO -->
  <section id="proceso" class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-14 lg:py-20">
        <div class="grid gap-10 lg:grid-cols-12">
          <div class="lg:col-span-5">
            <h2 class="text-2xl font-semibold tracking-tight sm:text-3xl">Un proceso claro, sin sorpresas</h2>
            <p class="mt-3 text-sm text-[var(--c-muted)] leading-relaxed">
              Priorizamos comunicación, entregas frecuentes y control de alcance. Ideal para proyectos corporativos.
            </p>
          </div>
          <div class="lg:col-span-7">
            <div class="grid gap-4">
              <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)]">
                <p class="text-sm font-semibold">1) Descubrimiento & alcance</p>
                <p class="mt-2 text-sm text-[var(--c-muted)]">Requerimientos, objetivos y mapa de funcionalidades.</p>
              </div>
              <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)]">
                <p class="text-sm font-semibold">2) Diseño UX/UI</p>
                <p class="mt-2 text-sm text-[var(--c-muted)]">Prototipos, estilo visual en modo oscuro y experiencia móvil primero.</p>
              </div>
              <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)]">
                <p class="text-sm font-semibold">3) Desarrollo iterativo</p>
                <p class="mt-2 text-sm text-[var(--c-muted)]">Sprints, revisiones y entregas incrementales.</p>
              </div>
              <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)]">
                <p class="text-sm font-semibold">4) Despliegue & soporte</p>
                <p class="mt-2 text-sm text-[var(--c-muted)]">Monitoreo, mejoras continuas y mantenimiento.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CASOS -->
  <section id="casos" class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-14 lg:py-20">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
          <div class="max-w-2xl">
            <h2 class="text-2xl font-semibold tracking-tight sm:text-3xl">Casos (ficticios)</h2>
            <p class="mt-2 text-sm text-[var(--c-muted)]">Ejemplos de proyectos típicos que entregamos para distintas industrias.</p>
          </div>
          <a href="#contacto" class="text-sm font-semibold text-[var(--c-text)] hover:opacity-90">Hablemos →</a>
        </div>

        <div class="mt-10 grid gap-4 lg:grid-cols-3">
          <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)]">
            <p class="text-xs text-[var(--c-muted)]">Retail</p>
            <p class="mt-1 text-base font-semibold">Sistema de inventario + POS</p>
            <p class="mt-2 text-sm text-[var(--c-muted)]">Sincronización multi-sucursal, roles, reportes y alertas.</p>
          </div>
          <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)]">
            <p class="text-xs text-[var(--c-muted)]">Servicios</p>
            <p class="mt-1 text-base font-semibold">Portal de clientes & tickets</p>
            <p class="mt-2 text-sm text-[var(--c-muted)]">Autoservicio, SLA, notificaciones y panel de métricas.</p>
          </div>
          <div class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)]">
            <p class="text-xs text-[var(--c-muted)]">Logística</p>
            <p class="mt-1 text-base font-semibold">Tracking + integraciones</p>
            <p class="mt-2 text-sm text-[var(--c-muted)]">API con terceros, eventos y trazabilidad por estado.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTACTO -->
  <section id="contacto" class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="py-14 lg:py-20">
        <div class="grid gap-10 lg:grid-cols-12">
          <div class="lg:col-span-5">
            <h2 class="text-2xl font-semibold tracking-tight sm:text-3xl">Cuéntanos tu proyecto</h2>
            <p class="mt-3 text-sm text-[var(--c-muted)] leading-relaxed">
              Te respondemos con una propuesta inicial y próximos pasos.
              (Formulario demostrativo; no guarda datos.)
            </p>
          </div>
          <div class="lg:col-span-7">
            <form id="lead-capture-form" x-data="{ isCompany: false, sending: false, sent: false, ok: false, err: '' }" class="rounded-3xl bg-[var(--c-surface)] p-6 ring-1 ring-[var(--c-border)]">
              <div class="grid gap-4 sm:grid-cols-2">
                <!-- Honeypot anti-spam -->
                <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true" />
                <div>
                  <label for="contact_name" class="text-xs text-[var(--c-muted)]">Nombre</label>
                  <input id="contact_name" name="name" type="text" autocomplete="name" class="mt-1 w-full rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm outline-none ring-1 ring-[var(--c-border)] focus:ring-2 focus:ring-[var(--c-primary)]" placeholder="Tu nombre" />
                </div>
                <div>
                  <label for="contact_email" class="text-xs text-[var(--c-muted)]">Email</label>
                  <input id="contact_email" name="email" type="email" autocomplete="email" required class="mt-1 w-full rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm outline-none ring-1 ring-[var(--c-border)] focus:ring-2 focus:ring-[var(--c-primary)]" placeholder="nombre@empresa.com" />
                </div>

                <div>
                  <label for="contact_phone" class="text-xs text-[var(--c-muted)]">Teléfono</label>
                  <input id="contact_phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" required class="mt-1 w-full rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm outline-none ring-1 ring-[var(--c-border)] focus:ring-2 focus:ring-[var(--c-primary)]" placeholder="+51 999 999 999" />
                </div>

                <div class="flex items-end">
                  <label for="contact_is_company" class="flex w-full cursor-pointer items-center gap-3 rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm ring-1 ring-[var(--c-border)]">
                    <input id="contact_is_company" name="is_company" type="checkbox" x-model="isCompany" class="size-4 rounded border-white/20 bg-transparent text-[var(--c-primary)] focus:ring-[var(--c-primary)]" />
                    <span class="text-[var(--c-text)]">Es una empresa</span>
                  </label>
                </div>

                <div x-cloak x-show="isCompany" class="sm:col-span-1">
                  <label for="contact_company_name" class="text-xs text-[var(--c-muted)]">Nombre de la empresa</label>
                  <input id="contact_company_name" name="company_name" type="text" autocomplete="organization" class="mt-1 w-full rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm outline-none ring-1 ring-[var(--c-border)] focus:ring-2 focus:ring-[var(--c-primary)]" placeholder="Razón social" />
                </div>
                <div x-cloak x-show="isCompany" class="sm:col-span-1">
                  <label for="contact_company_ruc" class="text-xs text-[var(--c-muted)]">RUC</label>
                  <input id="contact_company_ruc" name="company_ruc" type="text" inputmode="numeric" autocomplete="off" x-bind:required="isCompany" class="mt-1 w-full rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm outline-none ring-1 ring-[var(--c-border)] focus:ring-2 focus:ring-[var(--c-primary)]" placeholder="20123456789" />
                </div>

                <div class="sm:col-span-1">
                  <label for="contact_project_type" class="text-xs text-[var(--c-muted)]">Tipo de proyecto</label>
                  <select id="contact_project_type" name="project_type" class="mt-1 w-full rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm outline-none ring-1 ring-[var(--c-border)] focus:ring-2 focus:ring-[var(--c-primary)]">
                    <option value="" selected disabled>Selecciona una opción</option>
                    <option value="pagina_web">Página web</option>
                    <option value="pagina_web_corporativa">Página web corporativa</option>
                    <option value="landing_page">Landing page</option>
                    <option value="crm">CRM</option>
                    <option value="erp">ERP</option>
                    <option value="software_a_medida">Software a medida</option>
                    <option value="otros">Otros</option>
                  </select>
                </div>

                <div class="sm:col-span-1">
                  <label for="contact_budget" class="text-xs text-[var(--c-muted)]">Presupuesto (hasta) — S/</label>
                  <select id="contact_budget" name="budget_up_to" class="mt-1 w-full rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm outline-none ring-1 ring-[var(--c-border)] focus:ring-2 focus:ring-[var(--c-primary)]">
                    <option value="" selected disabled>Selecciona un rango</option>
                    @for ($i = 1000; $i <= 10000; $i += 1000)
                      <option value="{{ $i }}">Hasta S/ {{ number_format($i, 0, ',', '.') }}</option>
                    @endfor
                  </select>
                </div>

                <div class="sm:col-span-2">
                  <label for="contact_message" class="text-xs text-[var(--c-muted)]">¿Qué necesitas?</label>
                  <textarea id="contact_message" name="message" rows="4" class="mt-1 w-full rounded-2xl bg-[var(--c-elev)] px-4 py-3 text-sm outline-none ring-1 ring-[var(--c-border)] focus:ring-2 focus:ring-[var(--c-primary)]" placeholder="Describe el objetivo, tiempos y alcance aproximado..."></textarea>
                </div>
              </div>

              <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="space-y-1">
                  <p class="text-xs text-[var(--c-muted)]">Al enviar aceptas términos y privacidad.</p>
                  <p x-cloak x-show="ok" class="text-xs text-[var(--c-accent)]">Mensaje enviado. Te contactaremos pronto.</p>
                  <p x-cloak x-show="err" class="text-xs text-red-300" x-text="err"></p>
                </div>
                <button type="submit" :disabled="sending || sent" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-2)] px-5 py-3 text-sm font-semibold text-white shadow-soft ring-1 ring-white/10 hover:opacity-95 transition disabled:opacity-60">
                  <span x-text="sent ? 'Enviado' : (sending ? 'Enviando…' : 'Enviar')"></span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('lead-capture-form');
      if (!form) return;

      let locked = false; // evita doble envío incluso si Alpine tarda en actualizar

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (locked) return;
        locked = true;

        let navigating = false;

        // Alpine state helper
        const alpine = form.__x;
        const setState = (k, v) => {
          try { alpine && alpine.$data && (alpine.$data[k] = v); } catch (_) {}
        };

        setState('sending', true);
        setState('ok', false);
        setState('err', '');
        setState('sent', false);

        // Validación HTML5 (required, type=email, etc.)
        if (typeof form.reportValidity === 'function' && !form.reportValidity()) {
          setState('sending', false);
          locked = false;
          return;
        }

        // Preloader global (reutilizado del admin)
        try { window.showPreloader && window.showPreloader(); } catch (_) {}

        const fd = new FormData(form);

        // Validaciones adicionales:
        // - phone: mínimo 9 dígitos (aceptando +, espacios, etc.)
        // - company_ruc requerido si es empresa
        const phoneRaw = String(fd.get('phone') || '');
        const phoneDigits = phoneRaw.replace(/\D/g, '');
        if (phoneDigits.length < 9) {
          setState('sending', false);
          setState('err', 'El teléfono debe tener al menos 9 dígitos.');
          locked = false;
          try { window.hidePreloader && window.hidePreloader(); } catch (_) {}
          return;
        }

        const isCompany = !!fd.get('is_company');
        const companyRuc = String(fd.get('company_ruc') || '').trim();
        if (isCompany && !companyRuc) {
          setState('sending', false);
          setState('err', 'Si seleccionas empresa, el RUC es obligatorio.');
          locked = false;
          try { window.hidePreloader && window.hidePreloader(); } catch (_) {}
          return;
        }

        const payload = {
          name: fd.get('name') || null,
          email: fd.get('email') || null,
          phone: fd.get('phone') || null,
          is_company: isCompany,
          company_name: fd.get('company_name') || null,
          company_ruc: fd.get('company_ruc') || null,
          project_type: fd.get('project_type') || null,
          budget_up_to: fd.get('budget_up_to') ? parseInt(fd.get('budget_up_to'), 10) : null,
          message: fd.get('message') || null,
          source: 'marketing_home',
          website: fd.get('website') || null,
        };

        try {
          const res = await fetch('/api/leads', {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload)
          });

          const data = await res.json().catch(() => null);

          if (res.ok && data && data.success) {
            // Bloquea re-envío en esta sesión de página
            setState('sent', true);

            const token = data && data.data ? data.data.thank_you_token : null;
            if (token) {
              // Mantén preloader activo durante la navegación
              navigating = true;
              window.location.href = `/gracias/${encodeURIComponent(token)}`;
              return;
            }

            // Fallback: si por alguna razón no viene token
            form.reset();
            setState('ok', true);
          } else {
            const msg = (data && data.message) ? data.message : 'No se pudo enviar el mensaje.';
            setState('err', msg);
          }
        } catch (err) {
          setState('err', 'Error de conexión. Intenta nuevamente.');
        } finally {
          setState('sending', false);
          // Si vamos a redirigir, no ocultamos el preloader (lo manejará la siguiente página)
          if (!navigating) {
            locked = false;
            try { window.hidePreloader && window.hidePreloader(); } catch (_) {}
          }
        }
      });
    });
  </script>
@endsection

