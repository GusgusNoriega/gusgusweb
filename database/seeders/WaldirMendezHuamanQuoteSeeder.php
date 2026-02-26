<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WaldirMendezHuamanQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Waldir Mendez Huaman)
     * - Lead de empresa (Agencia de Viajes y Turismo)
     * - Cotización en PEN (S/ 2 200 + IGV 18% = S/ 2 596) para una web de agencia de viajes
     *   enfocada en turismo en Cusco y Perú, con blog administrable, servicios/paquetes
     *   turísticos administrables, SEO avanzado, formulario de contacto, hosting y dominio
     *   incluidos, y estructura preparada para campañas publicitarias y captación de leads.
     *
     * Ítems:
     *   1. Vista: Inicio (Home)                                          S/ 300
     *   2. Vista: Nosotros / Sobre la Agencia                            S/ 180
     *   3. Vista: Destinos (Cusco y Perú) + filtros                      S/ 280
     *   4. Vista: Servicios / Paquetes Turísticos (administrables)       S/ 300
     *   5. Vista: Blog (listado + filtros)                                S/ 200
     *   6. Vista: Post Individual (artículo de blog)                      S/ 130
     *   7. Vista: Contacto                                                S/ 160
     *   8. Panel de administración + capacitación + manual                S/ 300
     *   9. SEO avanzado (posicionamiento en buscadores)                   S/ 200
     *  10. Hosting y Dominio (compra, configuración, publicación)         S/  80
     *  11. Estructura para campañas publicitarias y captación de leads    S/  70
     *                                                          Subtotal: S/ 2 200
     *                                                       IGV (18%):   S/   396
     *                                                            Total:  S/ 2 596
     *
     * Tiempo estimado: máximo 4 semanas (sin imprevistos).
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente
            // =========================
            $clientName    = 'Waldir Mendez Huaman';
            $clientEmail   = 'waldir.mendez.huaman@gmail.com';
            $clientPhone   = null;
            $clientAddress = null;

            $companyName     = 'Agencia de Viajes y Turismo Mendez';
            $companyRuc      = '10000000000'; // RUC pendiente de confirmar
            $companyIndustry = 'Agencia de viajes y turismo – Cusco y destinos del Perú';

            // =========================
            // Moneda: PEN
            // =========================
            $pen = Currency::firstOrCreate(
                ['code' => 'PEN'],
                [
                    'name'          => 'Sol Peruano',
                    'symbol'        => 'S/',
                    'exchange_rate' => 1.000000,
                    'is_base'       => true,
                ]
            );

            // =========================
            // Usuario cliente
            // =========================
            $clientUser = User::updateOrCreate(
                ['email' => $clientEmail],
                [
                    'name'              => $clientName,
                    'password'          => Hash::make('12345678'),
                    'email_verified_at' => now(),
                ]
            );

            // =========================
            // Lead (persona natural / empresa)
            // =========================
            Lead::updateOrCreate(
                [
                    'email'        => $clientEmail,
                    'company_name' => $companyName,
                ],
                [
                    'name'         => $clientName,
                    'phone'        => $clientPhone,
                    'is_company'   => true,
                    'company_ruc'  => $companyRuc,
                    'project_type' => 'Página web para agencia de viajes y turismo + Blog administrable + Servicios administrables + SEO + Formulario de contacto + Hosting y Dominio',
                    'budget_up_to' => 2200,
                    'message'      => "Cotización solicitada para: {$companyName} ({$clientName}). Rubro: {$companyIndustry}. Proyecto: Web profesional con blog y servicios administrables enfocada en captación de leads.",
                    'status'       => 'new',
                    'source'       => 'seed',
                    'notes'        => 'Lead creado automáticamente desde seeder para generar cotización formal de agencia de viajes y turismo.',
                ]
            );

            // =========================
            // Usuario creador (interno)
            // =========================
            $createdBy = User::where('email', 'gusgusnoriega@gmail.com')->first()
                ?? User::first()
                ?? $clientUser;

            // =========================
            // Cotización (PEN)
            // =========================
            $quoteNumber = 'COT-WALDIRMENDEZ-WEB-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id'              => $clientUser->id,
                    'created_by'           => $createdBy?->id,
                    'title'                => 'Cotización: Página Web para Agencia de Viajes y Turismo + Blog Administrable + Servicios Administrables + SEO + Hosting/Dominio – Waldir Mendez Huaman',
                    'description'          => "Desarrollo de una página web profesional para {$companyName} ({$clientName}), especializada en servicios de viajes a Cusco y diversos destinos del Perú.\n\n" .
                        "El sitio web incluirá:\n" .
                        "- Página de inicio con propuesta de valor, destinos destacados, paquetes turísticos y llamadas a la acción.\n" .
                        "- Sección Nosotros con la historia de la agencia, misión/visión, equipo y certificaciones.\n" .
                        "- Catálogo de destinos turísticos (Cusco, Machu Picchu, Valle Sagrado, Lago Titicaca, Nazca, Arequipa, etc.) con filtros por región, tipo de turismo y duración.\n" .
                        "- Servicios y paquetes turísticos completamente administrables desde el panel (crear, editar, eliminar paquetes con precios, itinerarios, incluye/no incluye, galería).\n" .
                        "- Blog administrable para publicar artículos sobre turismo, guías de viaje, consejos y novedades.\n" .
                        "- Formulario de contacto para que los visitantes soliciten información o reserven servicios.\n" .
                        "- SEO avanzado para posicionamiento en buscadores (Google) con keywords orientadas a turismo en Perú.\n" .
                        "- Estructura preparada para futuras campañas publicitarias (Google Ads, Facebook Ads) y captación de leads.\n\n" .
                        "Vistas incluidas:\n" .
                        "- Inicio (home con destinos destacados, paquetes y CTA)\n" .
                        "- Nosotros (historia, misión, equipo)\n" .
                        "- Destinos (catálogo con filtros por región/tipo)\n" .
                        "- Servicios / Paquetes Turísticos (administrables con itinerarios y precios)\n" .
                        "- Blog (listado con filtros por categoría)\n" .
                        "- Post individual (artículo completo con CTA a contacto)\n" .
                        "- Contacto (formulario + WhatsApp + datos de la agencia)\n\n" .
                        "Incluye:\n" .
                        "- Panel de administración para gestionar todo el contenido del sitio.\n" .
                        "- Hosting y dominio (compra, configuración, SSL y publicación).\n" .
                        "- SEO técnico y on-page avanzado.\n" .
                        "- Estructura para landing pages y campañas publicitarias.\n" .
                        "- Capacitación y manual de uso.\n\n" .
                        "Tiempo estimado de entrega: máximo 4 semanas (sin imprevistos y con entrega oportuna de contenido/accesos).",
                    'currency_id'          => $pen->id,
                    'tax_rate'             => 18,
                    'discount_amount'      => 0,
                    'status'               => 'draft',
                    'valid_until'          => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes'                => "Requisitos para iniciar:\n" .
                        "- Definición del nombre de dominio deseado (2-3 opciones) y datos para compra/registro.\n" .
                        "- Logo de la agencia (si existe) y paleta de colores / estilo visual deseado.\n" .
                        "- Contenido base: textos de Inicio, Nosotros, historia de la agencia, datos del equipo.\n" .
                        "- Listado de destinos turísticos ofrecidos con descripciones, fotos y categorías.\n" .
                        "- Información de paquetes turísticos: nombres, itinerarios, precios, qué incluye/no incluye, galería de fotos.\n" .
                        "- Artículos para el blog (mínimo 3 posts iniciales): títulos, contenido, imágenes.\n" .
                        "- Datos de contacto: teléfonos, WhatsApp, correo, dirección, horarios, redes sociales.\n" .
                        "- Palabras clave objetivo para SEO (destinos principales, servicios, ubicaciones).\n" .
                        "- Referencias de diseño (sitios web de agencias de viajes que le gusten).\n\n" .
                        "Entregables:\n" .
                        "- Sitio web publicado con certificado SSL, sitemap y robots configurado.\n" .
                        "- Panel de administración para gestionar contenido, destinos, servicios/paquetes y blog.\n" .
                        "- Mínimo 3 posts del blog cargados y publicados.\n" .
                        "- SEO configurado: metadatos, schema, sitemap, Search Console.\n" .
                        "- Estructura lista para recibir tráfico de campañas publicitarias.\n" .
                        "- Manual (PDF) + capacitación remota de uso del panel.\n",
                    'terms_conditions'     => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 2,200.00\n" .
                        "- IGV (18%): S/ 396.00\n" .
                        "- Total: S/ 2,596.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto (S/ 1,298.00) / 50% al culminar el proyecto y previo a la publicación final (S/ 1,298.00).\n" .
                        "- Hosting + dominio: se incluye la gestión y el costo del primer año dentro de esta cotización; renovaciones anuales posteriores corren por cuenta del cliente (costo estimado S/ 350 anuales según proveedor/plan).\n" .
                        "- Propiedad del código: 100% del código fuente y entregables serán del cliente.\n" .
                        "- Alcance: incluye panel de administración, SEO, blog, servicios administrables, capacitación y manual. Cambios mayores, nuevas secciones o módulos fuera del alcance se cotizan por separado.\n" .
                        "- Campañas publicitarias: se entrega la estructura técnica lista; la inversión en publicidad (Google Ads, Facebook Ads) y la gestión de campañas NO están incluidas y se cotizan aparte si el cliente lo requiere.\n" .
                        "- Plazo estimado: hasta 4 semanas, sujeto a entrega de contenido y aprobaciones sin demoras.",
                    'client_name'          => $clientName,
                    'client_ruc'           => $companyRuc,
                    'client_email'         => $clientEmail,
                    'client_phone'         => $clientPhone,
                    'client_address'       => $clientAddress,
                ]
            );

            if (method_exists($quote, 'trashed') && $quote->trashed()) {
                $quote->restore();
            }

            // Reemplazar items y tareas (idempotente)
            $quote->items()->delete();

            // =========================================================
            // Ítems de la cotización  (subtotal = S/ 2 200.00)
            // =========================================================
            $items = [
                // ─── 1. INICIO ─────────────────────────────────────────
                [
                    'name'        => 'Vista: Inicio (Home)',
                    'description' => "Diseño e implementación de la página de inicio para la agencia de viajes: hero con imágenes de destinos emblemáticos (Cusco, Machu Picchu), propuesta de valor, destinos destacados, paquetes turísticos populares, testimonios de viajeros, CTA a contacto/reserva y secciones clave para conversión.",
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 300,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura de secciones + UI kit base',
                            'description'    => 'Definir estructura completa del Home: hero con slider/video de destinos (Cusco, Machu Picchu, Valle Sagrado), barra de búsqueda rápida de destinos, sección de destinos destacados con cards, paquetes turísticos populares con precios de referencia, sección de beneficios/por qué elegirnos, testimonios de viajeros, CTA de contacto/reserva y footer con datos de la agencia. Definir componentes reutilizables (cards de destino, cards de paquete, botones, badges de precio, iconos de servicios).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación responsive (móvil/tablet/desktop)',
                            'description'    => 'Implementación del layout responsive completo del Home: hero con superposición de texto sobre imágenes, grid de destinos destacados (2-3 columnas adaptables), carousel de paquetes turísticos (swipe en móvil), sección de testimonios, badges de precio, botones de acción y footer. Asegurar experiencia óptima en dispositivos móviles (principal canal de búsqueda de viajes). Animaciones sutiles de entrada para secciones al hacer scroll.',
                            'duration_value' => 8,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con contenido editable (panel admin)',
                            'description'    => 'Conectar todas las secciones del Home a campos editables desde el panel de administración: textos del hero (título, subtítulo, CTA), imágenes de fondo, destinos destacados (selección desde el catálogo), paquetes populares (selección desde servicios), testimonios y datos de contacto del footer.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de imágenes y performance',
                            'description'    => 'Compresión y optimización de imágenes de destinos turísticos (WebP, lazy-load), preload de hero image, compresión de assets. Asegurar tiempos de carga rápidos considerando que el Home tendrá muchas imágenes de paisajes y destinos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA cross-device y ajustes finales',
                            'description'    => 'Pruebas en dispositivos reales (móvil Android/iOS, tablet, desktop), verificación de enlaces, CTAs, responsividad y consistencia visual. Ajustes de espaciados, tipografías y colores.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 2. NOSOTROS ───────────────────────────────────────
                [
                    'name'        => 'Vista: Nosotros / Sobre la Agencia',
                    'description' => 'Vista institucional para presentar la agencia de viajes: historia, misión, visión, valores, experiencia en el sector turístico, equipo de trabajo, certificaciones y alianzas. Contenido editable desde el panel.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Estructura de contenido institucional',
                            'description'    => 'Definir secciones: historia de la agencia y años de experiencia, misión/visión/valores, equipo de guías y asesores de viaje (fotos, nombres, especialidades), certificaciones de turismo o alianzas con operadores, cifras destacadas (viajeros atendidos, destinos, años de experiencia) y CTA a contacto.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación responsive + estilos',
                            'description'    => 'Implementación del layout: sección hero secundario con imagen de equipo/oficina, timeline de historia (opcional), grid de equipo con fotos y roles, sección de cifras con contadores animados, sección de certificaciones/alianzas con logos. Diseño coherente con el Home y responsive.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con panel admin (textos e imágenes)',
                            'description'    => 'Vincular contenido de Nosotros al panel de administración: textos de historia, misión, visión, datos del equipo (foto, nombre, cargo, descripción), cifras destacadas e imágenes. Validaciones y previsualización básica.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + revisión de contenido',
                            'description'    => 'Revisión de ortografía, enlaces, contraste, accesibilidad básica (alt en imágenes), responsive y consistencia visual con el resto del sitio.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 3. DESTINOS ───────────────────────────────────────
                [
                    'name'        => 'Vista: Destinos Turísticos (Cusco y Perú) + Filtros',
                    'description' => "Catálogo de destinos turísticos ofrecidos por la agencia con filtros personalizados por región (Cusco, Sur del Perú, Norte, Centro), tipo de turismo (aventura, cultural, gastronómico, naturaleza, místico) y duración del viaje. Incluye ficha de detalle por destino con galería, descripción, atractivos principales y CTA a paquetes/contacto.",
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 280,
                    'tasks'       => [
                        [
                            'name'           => 'Definición de taxonomías y criterios de filtro',
                            'description'    => 'Definir categorías para filtros de destinos: por región (Cusco, Puno/Lago Titicaca, Arequipa, Nazca, Lima, Selva, Norte del Perú), por tipo de turismo (aventura, cultural, gastronómico, naturaleza, místico/espiritual, comunitario), por duración (1-3 días, 4-7 días, 8+ días). Crear estructura de datos y slugs amigables para SEO.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación del listado de destinos + UX de filtros',
                            'description'    => 'Implementar grid de destinos con cards atractivas (imagen de fondo, nombre del destino, región, tipo de turismo, breve descripción). Barra lateral o superior de filtros (por región, tipo, duración) con actualización dinámica. Paginación, estados vacíos cuando no hay resultados y responsive optimizado para móvil.',
                            'duration_value' => 7,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Vista detalle de destino',
                            'description'    => 'Ficha completa del destino: galería de imágenes (slider/lightbox), descripción extendida, atractivos principales (lista con íconos), mejor época para visitar, altitud/clima, mapa de ubicación (embed de Google Maps), paquetes relacionados al destino (enlace a Servicios) y CTA a contacto/reserva.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con panel admin (CRUD de destinos + filtros)',
                            'description'    => 'Crear/editar/eliminar destinos desde el panel: nombre, slug, descripción corta y extendida, galería de imágenes, región, tipo de turismo, duración sugerida, atractivos, mejor época, coordenadas para mapa, orden y visibilidad (publicado/borrador). Asignación de categorías para filtros.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + optimización de imágenes de destinos',
                            'description'    => 'Verificar peso de imágenes de paisajes (optimización WebP/lazy-load), funcionamiento de filtros, paginación, detalle de destinos, enlaces y responsividad.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 4. SERVICIOS / PAQUETES TURÍSTICOS ────────────────
                [
                    'name'        => 'Vista: Servicios / Paquetes Turísticos (Administrables)',
                    'description' => "Catálogo de servicios y paquetes turísticos completamente administrables desde el panel. Cada paquete incluye: nombre, descripción, itinerario detallado día por día, precio, galería de fotos, qué incluye/no incluye, duración, nivel de dificultad, número de personas y CTA a formulario de contacto/reserva. Preparado para vender servicios y recibir leads de campañas publicitarias.",
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 300,
                    'tasks'       => [
                        [
                            'name'           => 'Definición de estructura de paquetes turísticos',
                            'description'    => 'Definir modelo de datos para servicios/paquetes: nombre, slug, descripción corta (para cards), descripción completa, itinerario (día a día con título y descripción por día), precio desde (referencia), duración (días/noches), nivel de dificultad (fácil/moderado/avanzado), grupo mínimo/máximo, qué incluye (lista), qué no incluye (lista), galería de fotos, destino relacionado, categoría de servicio y estado (publicado/borrador).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación del listado de servicios/paquetes',
                            'description'    => 'Implementar grid de paquetes turísticos con cards profesionales: imagen de portada, nombre del paquete, destino, duración (ej: 4D/3N), precio desde (badge), nivel de dificultad, breve descripción y botón "Ver más". Filtros por destino y tipo de servicio. Responsive optimizado con especial atención a móvil (búsqueda de viajes).',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Vista detalle de paquete turístico',
                            'description'    => 'Ficha completa del paquete: galería de fotos (slider), descripción, itinerario día por día (acordeón o timeline), tabla de incluye/no incluye, datos del paquete (duración, grupo, dificultad, precio), destino en mapa, recomendaciones y CTA prominente a contacto/reserva con el nombre del paquete prellenado. Sección de paquetes relacionados al final.',
                            'duration_value' => 7,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con panel admin (CRUD completo de paquetes)',
                            'description'    => 'Panel para crear/editar/eliminar paquetes turísticos: todos los campos definidos, editor de itinerario día por día (agregar/quitar días), gestión de listas incluye/no incluye, carga de galería, asignación de destino y categoría, orden y visibilidad. Validaciones y previsualización.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + pruebas de flujo de conversión',
                            'description'    => 'Verificar flujo completo: listado → detalle → CTA contacto (con paquete seleccionado prellenado en formulario). Probar en móvil/tablet/desktop, verificar imágenes, itinerarios, precios y enlaces.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 5. BLOG (LISTADO) ────────────────────────────────
                [
                    'name'        => 'Vista: Blog (Listado + Filtros)',
                    'description' => 'Blog administrable con listado de artículos sobre turismo, guías de viaje, consejos para viajeros, destinos recomendados y novedades de la agencia. Filtros por categoría (ej: Guías de viaje, Consejos, Destinos, Cultura, Gastronomía) y buscador. Diseño optimizado para lectura y SEO.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Modelo de contenido (categorías y etiquetas del blog)',
                            'description'    => 'Definir estructura de categorías de blog orientadas a turismo: "Guías de Viaje", "Consejos para Viajeros", "Destinos", "Cultura y Tradiciones", "Gastronomía", "Aventura y Naturaleza", "Noticias de la Agencia". Crear slugs amigables para SEO y estructura de etiquetas complementarias.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación de listado + cards de posts + paginación',
                            'description'    => 'Implementar listado de blog con cards de posts: imagen destacada, título, extracto, categoría (badge), fecha de publicación, tiempo de lectura estimado. Paginación y responsive. Post destacado/principal con mayor protagonismo visual en la parte superior.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Implementación de filtros por categoría y buscador',
                            'description'    => 'Barra de filtros por categoría (tabs o sidebar), buscador de artículos por título/contenido, estados vacíos cuando no hay resultados y feedback visual de filtros activos. Actualización de URL para compartibilidad y SEO.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + pruebas de navegación del blog',
                            'description'    => 'Verificar filtros, paginación, buscador, enlaces a posts individuales, responsive y consistencia visual. Probar con contenido real (posts de ejemplo cargados).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 6. POST INDIVIDUAL ────────────────────────────────
                [
                    'name'        => 'Vista: Post Individual (Artículo de Blog)',
                    'description' => 'Vista de lectura del artículo individual con diseño optimizado para lectura, imagen destacada, contenido rico (headings, listas, imágenes, citas), breadcrumbs, posts relacionados y CTAs hacia servicios/contacto de la agencia.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 130,
                    'tasks'       => [
                        [
                            'name'           => 'Maquetación del post (lectura optimizada)',
                            'description'    => 'Diseño de la vista de lectura: imagen destacada de ancho completo (o hero), título, metadatos (fecha, categoría, tiempo de lectura), cuerpo del artículo con tipografía optimizada para lectura, soporte para encabezados H2/H3, listas, imágenes inline, citas destacadas y tabla de contenido lateral (opcional para artículos largos).',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Posts relacionados + CTA a servicios',
                            'description'    => 'Implementar sección de posts relacionados (por categoría o etiqueta) al final del artículo. CTA contextual hacia paquetes turísticos o contacto (ej: "¿Te interesa viajar a Cusco? Conoce nuestros paquetes →"). Navegación anterior/siguiente entre posts.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Breadcrumbs + schema Article + meta OG',
                            'description'    => 'Implementar breadcrumbs (Home > Blog > Categoría > Post). Schema.org Article para cada post. Metadatos Open Graph y Twitter Card para compartir en redes sociales con imagen destacada del post.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + legibilidad + responsive',
                            'description'    => 'Revisión de tipografías, contraste, estilos de listas/citas, imágenes, responsive en móvil (lectura cómoda), y pruebas de compartir en redes sociales (vista previa OG).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 7. CONTACTO ───────────────────────────────────────
                [
                    'name'        => 'Vista: Contacto',
                    'description' => 'Vista de contacto con formulario completo (nombre, correo, teléfono, destino de interés, mensaje), datos de la agencia (dirección, teléfonos, correo, horarios), botón de WhatsApp directo, mapa de ubicación (Google Maps embed) e integración con el sistema de leads para captar solicitudes de información y reservas.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 160,
                    'tasks'       => [
                        [
                            'name'           => 'Maquetación de la vista de Contacto',
                            'description'    => 'Layout con dos columnas: formulario a un lado y datos de la agencia al otro (dirección, teléfonos, correo, horarios de atención). Mapa de Google Maps embebido con la ubicación de la agencia. Botón flotante/prominente de WhatsApp. Responsive y consistente con el diseño del sitio.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Formulario de contacto (campos + validaciones + anti-spam)',
                            'description'    => 'Campos del formulario: nombre completo, correo electrónico, teléfono (opcional), destino de interés (dropdown con destinos cargados), tipo de consulta (información general / reserva / cotización personalizada), fecha tentativa de viaje (opcional), número de viajeros (opcional), mensaje. Validaciones frontend y backend, protección anti-spam (honeypot). Campo oculto para trackear origen si viene de campaña publicitaria (UTM params).',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con sistema de leads + notificaciones',
                            'description'    => 'Guardar cada envío como lead en el sistema con toda la información capturada (destino, tipo consulta, fecha, viajeros). Notificación por email al equipo de la agencia. Página de agradecimiento personalizada con siguiente paso sugerido (ej: "Nos comunicaremos contigo en las próximas 24 horas"). Tracking de origen (directo, orgánico, campaña).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Contenido editable desde panel + QA',
                            'description'    => 'Configurar datos editables desde panel: teléfonos, WhatsApp, correo, dirección, horarios, coordenadas del mapa, texto de agradecimiento. Pruebas end-to-end del formulario (envío, recepción de notificación, registro de lead). Verificar botón de WhatsApp en móvil.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 8. PANEL DE ADMINISTRACIÓN ────────────────────────
                [
                    'name'        => 'Panel de Administración (contenido + destinos + servicios + blog) + Capacitación + Manual',
                    'description' => 'Panel de administración completo para gestionar todo el contenido del sitio web: secciones de páginas (Inicio, Nosotros, Contacto), catálogo de destinos turísticos, servicios/paquetes turísticos con itinerarios, blog (posts, categorías, etiquetas), leads recibidos y media (imágenes). Incluye capacitación remota y manual de uso.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 300,
                    'tasks'       => [
                        [
                            'name'           => 'Accesos y seguridad del panel',
                            'description'    => 'Configuración de acceso seguro al panel: creación de usuario(s) administrador(es), credenciales, protección de rutas, sesiones seguras y buenas prácticas de contraseñas. Roles básicos si se requiere (admin / editor).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de contenido de páginas (Inicio / Nosotros / Contacto)',
                            'description'    => 'Módulo para editar contenido de todas las páginas estáticas: textos del hero, imágenes de fondo, secciones de Nosotros (misión, visión, equipo), datos de contacto, horarios, coordenadas del mapa, textos de agradecimiento. Validaciones, previsualización y orden de secciones.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Módulo de gestión de destinos turísticos',
                            'description'    => 'CRUD completo de destinos: crear/editar/eliminar destinos con nombre, slug, descripción, galería, región, tipo de turismo, atractivos, mejor época, coordenadas. Gestión de categorías/filtros de destinos. Orden y visibilidad (publicado/borrador).',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Módulo de gestión de servicios/paquetes turísticos',
                            'description'    => 'CRUD completo de paquetes: crear/editar/eliminar paquetes con todos los campos (nombre, descripción, itinerario día por día, precio, duración, dificultad, incluye/no incluye, galería, destino relacionado, categoría). Editor de itinerario intuitivo (agregar/editar/eliminar días). Gestión de orden y visibilidad.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Módulo Blog: CRUD de posts + categorías/etiquetas',
                            'description'    => 'Gestión completa del blog: crear/editar/eliminar posts con editor de contenido rico, imagen destacada, categorías, etiquetas, slug amigable, extracto, fecha de publicación y estado (borrador/publicado). CRUD de categorías y etiquetas del blog.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Carga inicial de contenido (3 posts + destinos + paquetes ejemplo)',
                            'description'    => 'Publicación de mínimo 3 artículos del blog con imágenes y categorías asignadas (contenido proporcionado por el cliente o redactado con apoyo). Carga de destinos principales y al menos 2-3 paquetes turísticos de ejemplo con itinerarios y fotos.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de leads recibidos (visualización)',
                            'description'    => 'Vista en el panel para que el administrador vea los leads/contactos recibidos: listado con nombre, correo, destino de interés, fecha, estado. Filtros básicos y exportación simple (si aplica).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de media (imágenes)',
                            'description'    => 'Módulo de carga y gestión de imágenes: subir, organizar y seleccionar imágenes para destinos, paquetes, blog y páginas. Recomendaciones de tamaños/peso y soporte de formatos (JPG/PNG/WebP).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación remota + manual de uso',
                            'description'    => 'Sesión de capacitación remota (videoconferencia) sobre uso completo del panel: gestión de contenido, destinos, paquetes turísticos, blog, leads y media. Entrega de manual paso a paso (PDF) con capturas de pantalla y flujos principales.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA final del panel + ajustes de usabilidad',
                            'description'    => 'Pruebas de todos los flujos: editar contenido, crear destino, crear paquete con itinerario, crear post, ver leads, subir imágenes. Ajustes de usabilidad y corrección de errores menores. Verificar permisos y accesos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 9. SEO AVANZADO ──────────────────────────────────
                [
                    'name'        => 'SEO Avanzado (Posicionamiento en Buscadores)',
                    'description' => 'SEO técnico y on-page avanzado orientado al sector turismo: optimización para keywords de viajes a Cusco y Perú, estructura de datos schema.org (TouristAttraction, TravelAgency, TouristTrip, Article), metadatos por vista y post, sitemap, robots, integración con Google Search Console y optimización de Core Web Vitals.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Estrategia SEO base (keywords + arquitectura de información)',
                            'description'    => 'Investigación de keywords orientadas al turismo en Cusco y Perú: "viajes a Cusco", "paquetes turísticos Machu Picchu", "agencia de viajes Cusco", "tours Valle Sagrado", "turismo en Perú", etc. Definir arquitectura de URLs amigables, jerarquía H1/H2/H3 por vista y plan de contenido SEO para el blog. Mapeo de keywords por página.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Metadatos avanzados por vista + Open Graph',
                            'description'    => 'Configurar title tags y meta descriptions únicos y optimizados por cada vista (Home, Nosotros, Destinos, Servicios, Blog, Contacto) y para cada post/destino/paquete individual. Implementar Open Graph y Twitter Cards con imágenes específicas para compartir en redes sociales. Canonical URLs para evitar contenido duplicado.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Schema.org (datos estructurados para turismo)',
                            'description'    => 'Implementar schemas específicos de turismo: TravelAgency (para la agencia), TouristAttraction (para destinos), TouristTrip (para paquetes turísticos), Article (para posts del blog), BreadcrumbList (navegación), LocalBusiness (datos de contacto) y FAQPage (si aplica). Validar con herramienta de datos estructurados de Google.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sitemap XML + robots.txt + Google Search Console',
                            'description'    => 'Generar sitemap.xml dinámico (incluye páginas, destinos, paquetes y posts del blog). Configurar robots.txt adecuado. Registrar sitio en Google Search Console, enviar sitemap y verificar indexación inicial. Configurar indexación de nuevos contenidos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de performance enfocada a SEO (Core Web Vitals)',
                            'description'    => 'Revisión y optimización de Core Web Vitals: LCP (imágenes optimizadas, preload), FID/INP (JavaScript mínimo), CLS (dimensiones de imágenes definidas, fuentes preloaded). Lazy-load de imágenes fuera de viewport, compresión de assets, caché básico. Verificar con PageSpeed Insights y GTmetrix.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 10. HOSTING Y DOMINIO ─────────────────────────────
                [
                    'name'        => 'Hosting y Dominio (Compra, Configuración, Publicación y Sincronización)',
                    'description' => 'Gestión completa de compra/registro de hosting y dominio, configuración técnica del servidor, certificado SSL, sincronización DNS y publicación/deploy del sitio web en producción.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 80,
                    'tasks'       => [
                        [
                            'name'           => 'Selección de proveedor + compra de hosting y dominio',
                            'description'    => 'Selección del plan de hosting adecuado para una web de agencia de viajes (con buen rendimiento para imágenes y tráfico esperado). Compra/registro del dominio (.com, .pe u otra extensión adecuada para turismo). Recolección de datos del cliente para titularidad.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración inicial de hosting + SSL',
                            'description'    => 'Creación del sitio en hosting, configuración de SSL (Let\'s Encrypt o certificado del proveedor), variables de entorno, base de datos y parámetros de PHP/servidor para despliegue óptimo.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sincronización dominio ↔ hosting (DNS)',
                            'description'    => 'Configuración de registros DNS (A/CNAME), validación de propagación, redirecciones www/no-www, y pruebas de resolución correcta del dominio.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Deploy (publicación) + verificación final',
                            'description'    => 'Despliegue del sitio web a producción: subida de archivos, migración de base de datos, configuración de cron jobs si aplica. Verificación de SSL activo, formulario de contacto funcional, rutas, imágenes, performance básica y navegación completa.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 11. ESTRUCTURA PARA CAMPAÑAS PUBLICITARIAS ────────
                [
                    'name'        => 'Estructura para Campañas Publicitarias y Captación de Leads',
                    'description' => 'Preparación técnica del sitio web para recibir tráfico de campañas publicitarias futuras (Google Ads, Facebook/Instagram Ads). Incluye configuración de tracking (Google Analytics, Meta Pixel), estructura de URLs con parámetros UTM, formulario de contacto optimizado para conversión con tracking de origen, y recomendaciones para landing pages de destinos/paquetes específicos.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 70,
                    'tasks'       => [
                        [
                            'name'           => 'Instalación de Google Analytics 4 + configuración de eventos',
                            'description'    => 'Instalar Google Analytics 4 en todas las vistas del sitio. Configurar eventos de conversión: envío de formulario de contacto, clic en WhatsApp, clic en teléfono, visualización de paquete turístico, scroll a CTA. Dashboard básico de métricas clave.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Instalación de Meta Pixel (Facebook/Instagram)',
                            'description'    => 'Instalar pixel de Meta en el sitio para tracking de audiencias y conversiones. Configurar eventos estándar (PageView, Lead, ViewContent) y verificar funcionamiento con Meta Pixel Helper. Esto permitirá crear audiencias de remarketing y medir conversiones de campañas en Facebook/Instagram.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Estructura de URLs con parámetros UTM + tracking de origen en leads',
                            'description'    => 'Configurar el formulario de contacto para capturar automáticamente parámetros UTM (utm_source, utm_medium, utm_campaign) y almacenarlos con el lead. Esto permite identificar de qué campaña proviene cada contacto. Documentar nomenclatura UTM recomendada para futuras campañas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Recomendaciones para landing pages y campañas',
                            'description'    => 'Documento con recomendaciones técnicas para optimizar campañas: mejores vistas del sitio para usar como landing pages (destinos específicos, paquetes populares), configuración de objetivos en Analytics, audiencias sugeridas para remarketing y estructura de campañas por destino/servicio. Entregable: documento PDF de recomendaciones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],
            ];

            foreach ($items as $index => $itemData) {
                $tasks = $itemData['tasks'] ?? [];
                unset($itemData['tasks']);

                $item = $quote->items()->create(array_merge($itemData, [
                    'sort_order'       => $index,
                    'discount_percent' => 0,
                ]));

                foreach ($tasks as $tIndex => $taskData) {
                    $item->tasks()->create(array_merge($taskData, [
                        'sort_order' => $tIndex,
                    ]));
                }
            }

            // Recalcular totales
            $quote->load('items');
            $quote->calculateTotals();
            $quote->save();
        });
    }
}
