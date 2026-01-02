<!doctype html>
<html lang="es-PE" class="dark scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'SystemsGG • Desarrollo de software a medida y páginas web en Lima')</title>

  @php
    $siteName = 'SystemsGG';
    $siteUrl = url('/');
    $canonical = trim((string)($__env->yieldContent('canonical') ?: $siteUrl));
    $metaDescription = trim((string)($__env->yieldContent('meta_description') ?: 'Desarrollo de páginas web en Lima y desarrollo de software a medida. +11 años creando soluciones para empresas: web, APIs, automatización e integraciones.'));
    $ogImage = url(asset('img/logo-systems-gg.png'));
  @endphp

  <meta name="description" content="{{ $metaDescription }}" />
  <link rel="canonical" href="{{ $canonical }}" />
  <link rel="alternate" hreflang="es-PE" href="{{ $siteUrl }}" />

  <!-- Indexación (por defecto indexable; páginas específicas pueden sobreescribirlo) -->
  <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')" />
  <meta name="googlebot" content="@yield('googlebot', 'index, follow')" />

  <!-- Open Graph / Social -->
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="{{ $siteName }}" />
  <meta property="og:title" content="@yield('og_title', $__env->yieldContent('title', 'SystemsGG'))" />
  <meta property="og:description" content="{{ $metaDescription }}" />
  <meta property="og:url" content="{{ $canonical }}" />
  <meta property="og:locale" content="es_PE" />
  <meta property="og:image" content="{{ $ogImage }}" />

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="@yield('og_title', $__env->yieldContent('title', 'SystemsGG'))" />
  <meta name="twitter:description" content="{{ $metaDescription }}" />
  <meta name="twitter:image" content="{{ $ogImage }}" />

  <meta name="color-scheme" content="dark" />
  <meta name="theme-color" content="#0a0f1f" />

  {{-- Tailwind compilado (Vite) --}}
  @vite(['resources/css/app.css'])

  <!-- Alpine.js (menú responsive) -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Variables base del modo oscuro (marketing) -->
  <style>
    :root {
      --c-bg: oklch(0.15 0.02 255);
      --c-surface: oklch(0.19 0.02 255);
      --c-elev: oklch(0.23 0.02 255);
      --c-text: oklch(0.93 0.02 255);
      --c-muted: oklch(0.74 0.02 255);
      --c-border: oklch(0.35 0.02 255);
      --c-primary: oklch(0.72 0.14 260);
      --c-primary-2: oklch(0.66 0.16 285);
      --c-accent: oklch(0.76 0.12 165);

      /* Mantiene el look del `shadow-soft` que antes venía del config del CDN */
      --shadow-soft: 0 1px 2px rgba(0,0,0,.10), 0 12px 40px rgba(0,0,0,.35);

      --radius: 18px;
      color-scheme: dark;
    }
    [x-cloak] { display: none !important; }
    html { scrollbar-gutter: stable; }
  </style>

  <!-- Datos estructurados (SEO) -->
  @php
    $jsonLd = [
      '@context' => 'https://schema.org',
      '@graph' => [
        [
          '@type' => 'Organization',
          '@id' => $siteUrl.'#organization',
          'name' => $siteName,
          'url' => $siteUrl,
          'logo' => $ogImage,
          'sameAs' => [],
        ],
        [
          '@type' => 'WebSite',
          '@id' => $siteUrl.'#website',
          'url' => $siteUrl,
          'name' => $siteName,
          'publisher' => ['@id' => $siteUrl.'#organization'],
          'inLanguage' => 'es-PE',
        ],
        [
          '@type' => 'LocalBusiness',
          '@id' => $siteUrl.'#localbusiness',
          'name' => $siteName,
          'image' => $ogImage,
          'url' => $siteUrl,
          'telephone' => '+57 300 000 0000',
          'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Lima',
            'addressCountry' => 'PE',
          ],
          'areaServed' => [
            ['@type' => 'City', 'name' => 'Lima'],
            ['@type' => 'Country', 'name' => 'Perú'],
          ],
          'knowsAbout' => [
            'desarrollo de páginas web en Lima',
            'desarrollo web',
            'desarrollo de software a medida',
            'integraciones y APIs',
          ],
        ],
        [
          '@type' => 'Service',
          '@id' => $siteUrl.'#service-web',
          'serviceType' => 'Desarrollo de páginas web en Lima',
          'provider' => ['@id' => $siteUrl.'#localbusiness'],
          'areaServed' => ['@type' => 'City', 'name' => 'Lima'],
        ],
        [
          '@type' => 'Service',
          '@id' => $siteUrl.'#service-software',
          'serviceType' => 'Desarrollo de software a medida',
          'provider' => ['@id' => $siteUrl.'#localbusiness'],
          'areaServed' => ['@type' => 'Country', 'name' => 'Perú'],
        ],
      ],
    ];
  @endphp
  <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</head>
<body class="min-h-screen bg-[var(--c-bg)] text-[var(--c-text)] font-sans">
  {{-- Preloader reutilizable (en marketing inicia oculto; se usa al enviar el formulario) --}}
  @include('components.preloader', ['startVisible' => false])

  @include('components.marketing.header')

  <main>
    @yield('content')
  </main>

  @include('components.marketing.footer')
</body>
</html>

