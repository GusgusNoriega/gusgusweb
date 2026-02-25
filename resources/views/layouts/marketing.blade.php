<!doctype html>
<html lang="es-PE" class="dark scroll-smooth">
<head>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-QQL7KN3BHN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-QQL7KN3BHN');
</script>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17511185603"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-17511185603');
  </script>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="google-site-verification" content="Qgf4GhHVtZlm6Q0PDuc9p5ReOMWcv1x8GbVbkqbftYg" />
  <title>@yield('title', 'SystemsGG • Desarrollo de software a medida y páginas web en Lima')</title>

  @php
    $siteName = 'SystemsGG';
    // Canonical consistente (NO depende del host del request)
    $siteUrl = rtrim(config('app.url'), '/');

    $defaultTitle = 'SystemsGG • Desarrollo de software a medida y páginas web en Lima';
    $pageTitle = trim((string)($__env->yieldContent('title') ?: $defaultTitle));
    $ogTitle = trim((string)($__env->yieldContent('og_title') ?: $pageTitle));

    // URL actual sin querystring (solo path) sobre el host canónico
    $currentPath = (string) request()->getPathInfo();
    $defaultCanonical = $siteUrl . rtrim($currentPath, '/');
    if ($defaultCanonical === $siteUrl) {
        // root: deja la URL base sin slash final
        $defaultCanonical = $siteUrl;
    }

    // Permite sobreescribir canonical por página, pero normaliza para que siempre use el host canónico
    $canonicalRaw = trim((string)($__env->yieldContent('canonical') ?: ''));
    if ($canonicalRaw !== '') {
        $parsed = @parse_url($canonicalRaw);
        if (is_array($parsed) && isset($parsed['scheme'], $parsed['host'])) {
            $canonical = $siteUrl . rtrim((string)($parsed['path'] ?? ''), '/');
            if ($canonical === $siteUrl) $canonical = $siteUrl;
        } else {
            $canonical = $siteUrl . '/' . ltrim($canonicalRaw, '/');
            $canonical = rtrim($canonical, '/');
            if ($canonical === '') $canonical = $siteUrl;
        }
    } else {
        $canonical = $defaultCanonical;
    }
    $metaDescription = trim((string)($__env->yieldContent('meta_description') ?: 'Desarrollo de páginas web en Lima y desarrollo de software a medida. +11 años creando soluciones para empresas: web, APIs, automatización e integraciones.'));
    // Imagen social sobre el host canónico
    $ogImage = $siteUrl . '/img/logo-systems-gg.png';

    // Contacto (WhatsApp) reutilizado en footer + botón flotante
    $waPhoneDisplay = '+51 949 421 023';
    $waPhoneDigits = preg_replace('/\D+/', '', $waPhoneDisplay);
    $waText = 'Hola, vengo desde la web de SystemsGG. Quisiera una cotización.';
    $waUrl = 'https://wa.me/' . $waPhoneDigits . '?text=' . rawurlencode($waText);
  @endphp

  <meta name="description" content="{{ $metaDescription }}" />
  @hasSection('keywords')
  <meta name="keywords" content="@yield('keywords')">
  @endif
  <meta name="author" content="@yield('author', 'SystemsGG')">
  <link rel="canonical" href="{{ $canonical }}" />
  <link rel="alternate" hreflang="es-PE" href="{{ $siteUrl }}" />

  <!-- Indexación (por defecto indexable; páginas específicas pueden sobreescribirlo) -->
  <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')" />
  <meta name="googlebot" content="@yield('googlebot', 'index, follow')" />

  <!-- Open Graph / Social -->
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="{{ $siteName }}" />
  <meta property="og:title" content="{{ $ogTitle }}" />
  <meta property="og:description" content="{{ $metaDescription }}" />
  <meta property="og:url" content="{{ $canonical }}" />
  <meta property="og:locale" content="es_PE" />
  <meta property="og:image" content="{{ $ogImage }}" />
  <meta property="og:image:width" content="512">
  <meta property="og:image:height" content="512">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:alt" content="@yield('og_image_alt', 'SystemsGG - Desarrollo web y software a medida')">

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="{{ $ogTitle }}" />
  <meta name="twitter:description" content="{{ $metaDescription }}" />
  <meta name="twitter:image" content="{{ $ogImage }}" />

  <meta name="color-scheme" content="dark" />
  <meta name="theme-color" content="#0a0f1f" />

  <!-- ============================================================= -->
  <!-- OPTIMIZACIONES PARA PAGESPEED / GTMETRIX -->
  <!-- ============================================================= -->

  <!-- Preload CSS crítico -->
  @production
  @php
    $manifest = null;
    $cssPath = null;
    $manifestPath = public_path('build/.vite/manifest.json');
    if (!file_exists($manifestPath)) {
        $manifestPath = public_path('build/manifest.json');
    }
    if (file_exists($manifestPath)) {
        $manifest = json_decode(file_get_contents($manifestPath), true);
        if (isset($manifest['resources/css/app.css']['file'])) {
            $cssPath = asset('build/' . $manifest['resources/css/app.css']['file']);
        }
    }
  @endphp
  @if($cssPath)
  <link rel="preload" href="{{ $cssPath }}" as="style" />
  @endif
  @endproduction

  {{-- Assets (Vite) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- CSS crítico inline para evitar FOUC y mejorar FCP -->
  <style>
    /* CSS Crítico - Above the fold */
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
      --shadow-soft: 0 1px 2px rgba(0,0,0,.10), 0 12px 40px rgba(0,0,0,.35);
      --radius: 18px;
      color-scheme: dark;
    }
    
    /* Evitar CLS (Cumulative Layout Shift) */
    html { 
      scrollbar-gutter: stable; 
    }
    
    body {
      background-color: var(--c-bg);
      color: var(--c-text);
      min-height: 100vh;
    }
    
    /* Alpine.js cloak */
    [x-cloak] { display: none !important; }
    
    /* Optimización de fuentes - evitar FOIT */
    @font-face {
      font-family: 'Inter';
      font-style: normal;
      font-weight: 400 700;
      font-display: swap;
      src: local('Inter');
    }
    
    /* Placeholder para contenido mientras carga */
    .skeleton {
      background: linear-gradient(90deg, var(--c-surface) 25%, var(--c-elev) 50%, var(--c-surface) 75%);
      background-size: 200% 100%;
      animation: skeleton-loading 1.5s infinite;
    }
    
    @keyframes skeleton-loading {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }
    
    /* Reducir layout shifts en imágenes */
    img, video {
      max-width: 100%;
      height: auto;
    }
    
    /* Contener tamaño del header para evitar CLS */
    header {
      min-height: 64px;
    }
  </style>

  <!-- Datos estructurados (SEO) -->
  @php
    $logoUrl = $siteUrl . '/img/logo-systems-gg.png';

    $jsonLd = [
      '@context' => 'https://schema.org',
      '@graph' => [
        [
          '@type' => ['Organization', 'LocalBusiness', 'ProfessionalService'],
          '@id' => $siteUrl . '#organization',
          'name' => 'SystemsGG',
          'alternateName' => ['systemsgg', 'systems gg', 'Systems GG'],
          'url' => $siteUrl,
          'logo' => [
            '@type' => 'ImageObject',
            'url' => $logoUrl,
            'width' => 512,
            'height' => 512,
          ],
          'image' => $logoUrl,
          'description' => 'systemsgg (SystemsGG) desarrolla páginas web profesionales y software a medida en Lima, Perú. +11 años creando sistemas, APIs, automatización e integraciones para empresas.',
          'foundingDate' => '2015',
          'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Lima',
            'addressRegion' => 'Lima',
            'addressCountry' => 'PE',
          ],
          'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => -12.0464,
            'longitude' => -77.0428,
          ],
          'contactPoint' => [
            [
              '@type' => 'ContactPoint',
              'telephone' => '+51-949-421-023',
              'contactType' => 'sales',
              'email' => 'hola@systemsgg.com',
              'availableLanguage' => ['Spanish', 'English'],
              'areaServed' => ['PE', 'US', 'MX'],
            ],
          ],
          'areaServed' => [
            ['@type' => 'Country', 'name' => 'Perú'],
            ['@type' => 'Country', 'name' => 'Estados Unidos'],
            ['@type' => 'Country', 'name' => 'México'],
          ],
          'priceRange' => '$$',
          'currenciesAccepted' => 'PEN, USD',
          'paymentAccepted' => 'Transferencia bancaria, PayPal',
          'openingHoursSpecification' => [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'opens' => '09:00',
            'closes' => '20:00',
          ],
          'knowsAbout' => ['Desarrollo web', 'Software a medida', 'APIs', 'CRM', 'ERP', 'Integraciones', 'SEO', 'Laravel', 'Vue.js', 'React'],
          'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'Servicios de desarrollo web y software',
            'itemListElement' => [
              [
                '@type' => 'Offer',
                'itemOffered' => [
                  '@type' => 'Service',
                  'name' => 'Desarrollo de páginas web profesionales',
                  'description' => 'Diseño y desarrollo de páginas web profesionales, landing pages y sitios corporativos optimizados para SEO y conversión.',
                  'provider' => ['@id' => $siteUrl . '#organization'],
                  'areaServed' => ['PE', 'US', 'MX'],
                  'serviceType' => 'Desarrollo web',
                ],
              ],
              [
                '@type' => 'Offer',
                'itemOffered' => [
                  '@type' => 'Service',
                  'name' => 'Software a medida',
                  'description' => 'Desarrollo de sistemas empresariales personalizados: CRM, ERP, plataformas de gestión, facturación electrónica y automatización de procesos.',
                  'provider' => ['@id' => $siteUrl . '#organization'],
                  'areaServed' => ['PE', 'US', 'MX'],
                  'serviceType' => 'Desarrollo de software',
                ],
              ],
              [
                '@type' => 'Offer',
                'itemOffered' => [
                  '@type' => 'Service',
                  'name' => 'Integraciones y APIs',
                  'description' => 'Integración de sistemas, desarrollo de APIs REST, conexión con pasarelas de pago, WhatsApp Business y servicios de terceros.',
                  'provider' => ['@id' => $siteUrl . '#organization'],
                  'areaServed' => ['PE', 'US', 'MX'],
                  'serviceType' => 'Integración de sistemas',
                ],
              ],
            ],
          ],
        ],
        [
          '@type' => 'WebSite',
          '@id' => $siteUrl . '#website',
          'url' => $siteUrl,
          'name' => 'SystemsGG',
          'alternateName' => 'systemsgg',
          'publisher' => ['@id' => $siteUrl . '#organization'],
          'inLanguage' => 'es-PE',
        ],
        [
          '@type' => 'WebPage',
          '@id' => $canonical . '#webpage',
          'url' => $canonical,
          'name' => $pageTitle,
          'description' => $metaDescription,
          'isPartOf' => ['@id' => $siteUrl . '#website'],
          'about' => ['@id' => $siteUrl . '#organization'],
          'inLanguage' => 'es-PE',
          'dateModified' => trim((string)($__env->yieldContent('date_modified') ?: '2025-02-25T00:00:00-05:00')),
        ],
      ],
    ];
  @endphp
  <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>

  <!-- Slot para recursos adicionales específicos de la página -->
  @yield('head')
</head>
<body class="min-h-screen bg-[var(--c-bg)] text-[var(--c-text)] font-sans">
  {{-- Preloader reutilizable (en marketing inicia oculto; se usa al enviar el formulario) --}}
  @include('components.preloader', ['startVisible' => false])

  @include('components.marketing.header')

  <main>
    @yield('content')
  </main>

  @include('components.marketing.footer')

  <!-- Scripts no críticos cargados al final -->
  @yield('scripts')
</body>
</html>
