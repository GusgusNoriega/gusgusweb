<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FernandoRodriguezPatronajeWebQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Fernando Rodríguez)
     * - Lead de empresa (Fernando Rodríguez / RUC: 20604627703)
     * - Cotización en PEN (S/ 4,000 + IGV 18% = S/ 4,720) para una web optimizada para SEO
     *   del rubro de cursos de patronaje, confección y moda, que incluye:
     *
     *   1. Estudio de Palabras Clave y Estrategia SEO del Sector             S/  280
     *   2. Estudio de Mercado y Análisis de Competencia Digital              S/  250
     *   3. Definición de Arquitectura Web y Estructura de Datos              S/  220
     *   4. Vista: Inicio (Home)                                              S/  380
     *   5. Vista: Nosotros / Sobre la Empresa                               S/  200
     *   6. Vista: Catálogo de Productos (Listado + Filtros)                  S/  450
     *   7. Vista: Detalle de Producto                                        S/  200
     *   8. Sistema de Cotización Online (Carrito + Generación PDF)           S/  550
     *   9. Vista: Contacto                                                   S/  170
     *  10. Blog en WordPress (Instalación, Configuración e Integración)      S/  400
     *  11. SEO Avanzado Integral (Posicionamiento en Buscadores)             S/  300
     *  12. Panel de Administración de Productos y Contenido + Capacitación   S/  350
     *  13. Hosting y Dominio (Compra, Configuración, Publicación)            S/  150
     *  14. Integración Visual y Técnica Laravel ↔ WordPress                  S/  100
     *                                                             Subtotal: S/ 4,000
     *                                                          IGV (18%):   S/   720
     *                                                               Total:  S/ 4,720
     *
     * Tecnologías:
     * - Sistema principal: Laravel (catálogo, cotización, panel admin, SEO)
     * - Blog: WordPress (instalado en subdirectorio /blog o subdominio blog.dominio.com)
     *
     * Tiempo estimado: máximo 35 días (sin imprevistos).
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente/empresa
            // =========================
            $clientName    = 'Fernando Rodríguez';
            $clientEmail   = 'cursopatronaje@gmail.com';
            $clientPhone   = null;
            $clientAddress = null;

            $companyName     = 'Fernando Rodríguez';
            $companyRuc      = '20604627703';
            $companyIndustry = 'Cursos de Patronaje, Confección y Moda';

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
            // Lead (empresa)
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
                    'project_type' => 'Página web SEO optimizada + Catálogo de productos con sistema de cotización + Blog WordPress administrable + Panel de administración + Hosting y Dominio',
                    'budget_up_to' => 4000,
                    'message'      => "Cotización solicitada para: {$companyName} (RUC: {$companyRuc}). Rubro: {$companyIndustry}. Proyecto: Web profesional con estructura SEO avanzada, catálogo de productos con sistema de cotizaciones imprimible y blog administrable en WordPress.",
                    'status'       => 'new',
                    'source'       => 'seed',
                    'notes'        => 'Lead creado automáticamente desde seeder para generar cotización de página web SEO con catálogo de productos y sistema de cotización online.',
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
            $quoteNumber = 'COT-20604627703-WEBSEO-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id'              => $clientUser->id,
                    'created_by'           => $createdBy?->id,
                    'title'                => 'Cotización: Página Web SEO Optimizada + Catálogo de Productos con Sistema de Cotización + Blog WordPress + Panel Admin + Hosting/Dominio – Fernando Rodríguez',
                    'description'          => "Desarrollo de una página web profesional optimizada para SEO para {$companyName} (RUC: {$companyRuc}), especializada en {$companyIndustry}.\n\n" .
                        "El proyecto contempla un estudio profundo del sector para definir la estrategia digital:\n" .
                        "- Estudio de palabras clave del rubro de patronaje, confección y moda.\n" .
                        "- Análisis de mercado y competencia digital (competidores posicionados en Google).\n" .
                        "- Definición de arquitectura web y estructura de datos optimizada para SEO.\n\n" .
                        "Funcionalidades principales del sitio web:\n" .
                        "- Catálogo de productos (cursos, materiales, herramientas de patronaje) con filtros por categoría, precio y tipo.\n" .
                        "- Sistema de cotización online: el cliente puede agregar productos a una cotización, ajustar cantidades, ver subtotales y generar/imprimir la cotización en PDF.\n" .
                        "- Blog administrable en WordPress (instalado en subdirectorio /blog) para publicar artículos, tutoriales, noticias y contenido SEO del sector.\n" .
                        "- Formulario de contacto con captura de leads.\n\n" .
                        "Vistas incluidas (Laravel):\n" .
                        "- Inicio (Home con propuesta de valor, productos destacados y CTAs)\n" .
                        "- Nosotros (historia, misión, experiencia en patronaje)\n" .
                        "- Catálogo de Productos (listado con filtros y buscador)\n" .
                        "- Detalle de Producto (ficha individual con galería, precio y botón de cotización)\n" .
                        "- Cotización Online (carrito de cotización con generación PDF)\n" .
                        "- Contacto (formulario + datos de la empresa)\n\n" .
                        "Blog (WordPress):\n" .
                        "- Listado de posts con categorías y buscador\n" .
                        "- Post individual optimizado para SEO\n" .
                        "- Administración completa desde WordPress (crear/editar posts, categorías, etiquetas)\n\n" .
                        "Incluye:\n" .
                        "- Estudio de palabras clave y estrategia SEO del sector.\n" .
                        "- Estudio de mercado y análisis de competencia digital.\n" .
                        "- SEO avanzado integral (técnico, on-page, schema.org, sitemap).\n" .
                        "- Panel de administración Laravel para gestionar productos y contenido.\n" .
                        "- Integración visual y técnica entre Laravel y WordPress.\n" .
                        "- Hosting y dominio (compra, configuración, SSL y publicación).\n" .
                        "- Capacitación y manual de uso.\n\n" .
                        "Tecnologías:\n" .
                        "- Sistema principal: Laravel (catálogo, cotizaciones, panel admin, páginas)\n" .
                        "- Blog: WordPress (instalación independiente en subdirectorio /blog)\n\n" .
                        "Tiempo estimado de entrega: máximo 35 días (sin imprevistos y con entrega oportuna de contenido/accesos).",
                    'currency_id'          => $pen->id,
                    'tax_rate'             => 18,
                    'discount_amount'      => 0,
                    'status'               => 'draft',
                    'valid_until'          => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes'                => "Requisitos para iniciar:\n" .
                        "- Definición del nombre de dominio deseado (2-3 opciones) y datos para compra/registro.\n" .
                        "- Logo de la empresa (si existe) y paleta de colores / estilo visual deseado.\n" .
                        "- Contenido base: textos de Inicio, Nosotros, historia de la empresa, experiencia en patronaje y confección.\n" .
                        "- Catálogo de productos: listado completo de cursos, materiales, herramientas u otros productos con nombres, descripciones, precios, imágenes y categorías.\n" .
                        "- Información de contacto: teléfonos, WhatsApp, correo, dirección, redes sociales.\n" .
                        "- Artículos para el blog (mínimo 3 posts iniciales): títulos, contenido, imágenes.\n" .
                        "- Palabras clave objetivo o temas prioritarios para el posicionamiento SEO.\n" .
                        "- Competidores directos a analizar (URLs de sitios web competidores, si los conoce).\n" .
                        "- Referencias de diseño (sitios web que le gusten del sector).\n\n" .
                        "Entregables:\n" .
                        "- Documento de estudio de palabras clave y estrategia SEO.\n" .
                        "- Documento de análisis de mercado y competencia digital.\n" .
                        "- Documento de arquitectura web y estructura de datos.\n" .
                        "- Sitio web Laravel publicado con certificado SSL, sitemap y robots configurado.\n" .
                        "- Blog WordPress instalado, configurado y personalizado en /blog.\n" .
                        "- Sistema de cotización online funcional (catálogo + carrito + PDF).\n" .
                        "- Panel admin Laravel para gestionar productos, contenido y configuraciones.\n" .
                        "- Mínimo 3 posts del blog cargados y publicados.\n" .
                        "- SEO configurado: metadatos, schema, sitemap, Google Search Console.\n" .
                        "- Manual de uso (PDF) + capacitación remota.\n",
                    'terms_conditions'     => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 4,000.00\n" .
                        "- IGV (18%): S/ 720.00\n" .
                        "- Total: S/ 4,720.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto (S/ 2,360.00) / 50% al culminar el proyecto y previo a la publicación final (S/ 2,360.00).\n" .
                        "- Hosting + dominio: se incluye la gestión y el costo del primer año dentro de esta cotización (costo interno S/ 150); renovaciones anuales posteriores corren por cuenta del cliente (costo estimado S/ 350 anuales según proveedor/plan).\n" .
                        "- Blog WordPress: licencia gratuita (WordPress.org). El tema y plugins necesarios están incluidos en el desarrollo.\n" .
                        "- Propiedad del código: 100% del código fuente (Laravel y WordPress) y entregables serán del cliente.\n" .
                        "- Alcance: incluye estudio SEO, estudio de mercado, desarrollo web Laravel, blog WordPress, sistema de cotización, panel admin, capacitación y manual. Cambios mayores, nuevas funcionalidades o módulos fuera del alcance se cotizan por separado.\n" .
                        "- Sistema de cotización: funciona como catálogo con generación de cotización (NO es e-commerce ni procesamiento de pagos online).\n" .
                        "- Plazo estimado: hasta 35 días, sujeto a entrega de contenido y aprobaciones sin demoras.\n" .
                        "- Soporte post-lanzamiento: 15 días de soporte para corrección de errores reportados dentro del alcance.",
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
            // Ítems de la cotización  (subtotal = S/ 4,000.00)
            // IGV (18%) = S/ 720.00
            // Total = S/ 4,720.00
            // =========================================================
            $items = [
                // ─── 1. ESTUDIO DE PALABRAS CLAVE ────────────────────────
                [
                    'name'        => 'Estudio de Palabras Clave y Estrategia SEO del Sector',
                    'description' => "Investigación exhaustiva de palabras clave del sector de patronaje, confección y moda para definir la estrategia de posicionamiento SEO del sitio web. Incluye análisis de volumen de búsqueda, dificultad de posicionamiento, intención de búsqueda y oportunidades de keywords long-tail. Este estudio es la base para toda la arquitectura web y la estrategia de contenido.",
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 280,
                    'tasks'       => [
                        [
                            'name'           => 'Investigación de keywords principales del sector',
                            'description'    => "Investigación de palabras clave principales relacionadas con el rubro de {$companyIndustry}: \"cursos de patronaje\", \"patronaje industrial\", \"curso de confección\", \"patronaje de moda\", \"moldes de costura\", \"curso de costura profesional\", \"patronaje digital\", \"herramientas de patronaje\", entre otras. Análisis de volumen de búsqueda mensual, dificultad (KD), CPC y tendencia con herramientas profesionales (Google Keyword Planner, Ubersuggest, SEMrush o Ahrefs).",
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Análisis de keywords long-tail y de intención comercial',
                            'description'    => 'Identificar keywords de cola larga con alta intención de conversión: "curso de patronaje online precio", "herramientas de patronaje profesional", "comprar regla de patronaje", "curso de confección para principiantes", "patronaje industrial certificado", etc. Clasificar por intención: informacional (blog), comercial (catálogo) y transaccional (cotización).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Mapeo de keywords por página y cluster de contenido',
                            'description'    => 'Asignar keywords principales y secundarias a cada vista del sitio web (Home, Nosotros, Catálogo, Detalle de producto, Contacto). Definir clusters temáticos para el blog (grupos de artículos interrelacionados que refuercen el posicionamiento de las páginas comerciales). Crear documento de mapeo keyword → URL.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Entrega del documento de estrategia de palabras clave',
                            'description'    => 'Elaboración y entrega del documento final con: listado completo de keywords priorizadas (por volumen, dificultad y oportunidad), mapeo de keywords por página, clusters de contenido para el blog, calendario sugerido de publicación de contenidos SEO y recomendaciones iniciales de títulos/metadescripciones.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 2. ESTUDIO DE MERCADO Y COMPETENCIA ─────────────────
                [
                    'name'        => 'Estudio de Mercado y Análisis de Competencia Digital',
                    'description' => "Análisis profundo de la competencia digital en el sector de {$companyIndustry}. Se estudiarán los principales competidores posicionados en Google para las keywords relevantes, su estrategia de contenido, estructura web, fortalezas y debilidades. Este análisis permite identificar oportunidades de diferenciación y definir una estrategia de posicionamiento efectiva.",
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 250,
                    'tasks'       => [
                        [
                            'name'           => 'Identificación de competidores digitales principales',
                            'description'    => 'Búsqueda y selección de los 5-8 competidores digitales más relevantes del sector (empresas que ofrecen cursos de patronaje, venta de materiales de confección, herramientas de patronaje, etc.) que aparecen posicionados en Google para las keywords identificadas en el estudio previo. Incluir competidores directos (mismo rubro y región) e indirectos (plataformas de cursos online, marketplaces).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Análisis de estructura web y SEO de competidores',
                            'description'    => 'Analizar la estructura de los sitios web competidores: arquitectura de URLs, cantidad de páginas indexadas, estructura de navegación, velocidad de carga, presencia de blog, uso de schema.org, autoridad de dominio (DA/DR), backlinks principales y estrategia de contenido. Identificar qué hacen bien y qué oportunidades dejan vacías.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Análisis de contenido y propuesta de valor de competidores',
                            'description'    => 'Estudiar el contenido de los competidores: tipo de productos/servicios que ofrecen, cómo presentan sus catálogos, si tienen sistema de cotización o carrito, estrategia de precios (si es pública), presencia en redes sociales, blogs, calidad de imágenes y experiencia de usuario. Identificar gaps de contenido que representan oportunidades.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Entrega del documento de análisis de mercado y recomendaciones',
                            'description'    => 'Elaboración y entrega del documento final con: matriz comparativa de competidores, análisis FODA digital, oportunidades de posicionamiento identificadas, recomendaciones de diferenciación, gaps de contenido a explotar en el blog y sugerencias de funcionalidades que aporten ventaja competitiva (como el sistema de cotización online).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 3. ARQUITECTURA WEB Y ESTRUCTURA DE DATOS ──────────
                [
                    'name'        => 'Definición de Arquitectura Web y Estructura de Datos',
                    'description' => 'Planificación y definición de la arquitectura del sitio web basada en los estudios de keywords y competencia. Incluye diseño del sitemap SEO-friendly, estructura de URLs, jerarquía de contenido, estructura de datos (modelos) para productos/categorías/cotizaciones, y planificación de la integración Laravel + WordPress.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 220,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño del sitemap y arquitectura de URLs SEO-friendly',
                            'description'    => 'Crear el mapa del sitio completo con la estructura de navegación: jerarquía de páginas (Home, Nosotros, Catálogo → categorías → productos, Cotización, Contacto, Blog → categorías → posts). Definir la estructura de URLs amigables para SEO: /catalogo/[categoria]/[producto], /blog/[categoria]/[post-slug], etc. Incluir análisis de profundidad de clics (máximo 3 clics a cualquier contenido).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Definición de estructura de datos (modelos y relaciones)',
                            'description'    => 'Diseñar los modelos de datos en Laravel: Producto (nombre, slug, descripción, precio, imágenes, categoría, SKU, atributos), Categoría de producto (nombre, slug, imagen, orden), Cotización temporal (sesión del usuario, productos seleccionados, cantidades, datos del cliente), Sección editable (para contenido dinámico de páginas). Definir relaciones entre modelos y migraciones necesarias.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Planificación de la integración Laravel ↔ WordPress',
                            'description'    => 'Definir el enfoque técnico de integración: WordPress en subdirectorio /blog (o subdominio blog.dominio.com), compartición de cabecera/pie de página visual, manejo de sesiones y cookies, estrategia de CSS/estilos compartidos, enlaces cruzados entre Laravel y WordPress para potenciar el SEO interno.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Entrega del documento de arquitectura web',
                            'description'    => 'Documento final con: sitemap visual, estructura de URLs, diagramas de modelos de datos, wireframes básicos de navegación, plan de integración Laravel-WordPress y especificaciones técnicas de la base de datos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 4. VISTA: INICIO (HOME) ────────────────────────────
                [
                    'name'        => 'Vista: Inicio (Home)',
                    'description' => "Diseño e implementación de la página de inicio optimizada para SEO para {$companyName}: hero con propuesta de valor del sector de patronaje y confección, productos/cursos destacados del catálogo, secciones de beneficios, testimonios de alumnos/clientes, CTA hacia catálogo y cotización, y secciones clave para conversión y posicionamiento.",
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 380,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura de secciones + UI kit base',
                            'description'    => 'Definir estructura completa del Home basada en la estrategia SEO: hero con H1 optimizado y propuesta de valor (cursos de patronaje y confección), sección de categorías de productos/cursos con cards, productos destacados con precios y botón "Agregar a cotización", sección de beneficios/por qué elegirnos (experiencia, calidad, certificación), testimonios de alumnos, CTA prominente hacia catálogo y formulario de contacto, enlace al blog y footer con datos de contacto. Definir componentes reutilizables (cards de producto, botones, badges de precio, iconos).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación responsive (móvil/tablet/desktop)',
                            'description'    => 'Implementación del layout responsive completo: hero con imagen/video de fondo relacionado con patronaje, grid de categorías y productos destacados (adaptable a 1-3 columnas según dispositivo), sección de testimonios (carousel en móvil), sección de beneficios con iconos, CTAs accesibles y footer responsive. Animaciones sutiles de entrada al hacer scroll. Priorizar experiencia móvil para navegación y cotización.',
                            'duration_value' => 8,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con contenido editable (panel admin)',
                            'description'    => 'Conectar todas las secciones del Home a campos editables desde el panel de administración Laravel: textos del hero (título H1, subtítulo, CTA), imágenes de fondo, productos destacados (selección desde catálogo), testimonios (nombre, texto, foto), datos del footer y enlaces rápidos.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SEO on-page del Home (H1, metatags, schema)',
                            'description'    => 'Implementar H1 optimizado con keyword principal, title tag, meta description, Open Graph, Twitter Card, schema Organization y WebSite. Verificar jerarquía de encabezados H1 → H2 → H3. Asegurar que los CTAs y links internos refuercen la arquitectura SEO definida.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + optimización de imágenes y performance',
                            'description'    => 'Compresión y optimización de imágenes (WebP, lazy-load), preload de hero image, pruebas cross-device (móvil/tablet/desktop), verificación de enlaces, CTAs, consistencia visual y tiempos de carga.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 5. VISTA: NOSOTROS ──────────────────────────────────
                [
                    'name'        => 'Vista: Nosotros / Sobre la Empresa',
                    'description' => "Vista institucional para presentar a {$companyName}: historia de la empresa, experiencia en el rubro de patronaje y confección, misión, visión, valores, equipo docente o profesional, certificaciones y trayectoria. Contenido editable desde el panel y optimizado para SEO.",
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Estructura de contenido institucional',
                            'description'    => 'Definir secciones: hero secundario con imagen representativa, historia de la empresa y trayectoria en patronaje/confección, misión/visión/valores, equipo profesional/docente (si aplica), cifras destacadas (años de experiencia, alumnos formados, cursos impartidos), certificaciones del sector y CTA a contacto/catálogo.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación responsive + estilos',
                            'description'    => 'Implementación del layout responsive: hero interno, secciones de texto e imágenes, grid de equipo (si aplica), contadores animados de cifras, sección de certificaciones. Diseño coherente con el Home y con la identidad de marca.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con panel admin + SEO on-page',
                            'description'    => 'Campos editables para textos, imágenes, datos del equipo y cifras. SEO on-page: title tag, meta description, Open Graph, H1 con keyword "sobre nosotros + patronaje", schema AboutPage y breadcrumbs.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + revisión de contenido',
                            'description'    => 'Revisión de ortografía, enlaces, contraste, alt en imágenes, responsive y consistencia visual con el resto del sitio.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 6. CATÁLOGO DE PRODUCTOS ────────────────────────────
                [
                    'name'        => 'Vista: Catálogo de Productos (Listado + Filtros)',
                    'description' => "Catálogo online de productos y servicios de {$companyName} (cursos de patronaje, materiales, herramientas, insumos de confección) con filtros por categoría, rango de precio, tipo de producto y buscador. Cada producto muestra imagen, nombre, precio y botón para agregar a la cotización. Diseño optimizado para SEO con URLs amigables por categoría.",
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 450,
                    'tasks'       => [
                        [
                            'name'           => 'Definición de categorías de productos y filtros',
                            'description'    => 'Definir taxonomías para el catálogo basadas en el estudio de keywords: categorías principales (ej: "Cursos de Patronaje", "Cursos de Confección", "Herramientas de Patronaje", "Materiales e Insumos", "Kits de Inicio"), subcategorías (si aplican), etiquetas y criterios de filtrado (por precio, por tipo, por nivel si son cursos). Crear structure con slugs SEO-friendly.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación del catálogo + UI de filtros + buscador',
                            'description'    => 'Implementar grid de productos con cards profesionales: imagen de producto, nombre, precio (badge), categoría, breve descripción y botón "Agregar a cotización". Barra lateral o superior de filtros (por categoría, rango de precio, tipo). Buscador de productos por nombre/descripción. Paginación, estados vacíos y responsive optimizado (móvil first). Cambio de vista grid/lista (opcional).',
                            'duration_value' => 8,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Lógica de "Agregar a Cotización" (frontend)',
                            'description'    => 'Implementar funcionalidad de agregar productos a la cotización desde el catálogo: botón "Agregar a Cotización" en cada card, contador flotante de productos en cotización (tipo badge en header), selector de cantidad (si aplica), notificación visual de producto agregado (toast/snackbar), persistencia en localStorage o sesión.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SEO on-page del catálogo (metatags, schema, breadcrumbs)',
                            'description'    => 'URLs amigables: /catalogo/[categoria]. Title y meta description dinámicos por categoría (con keyword mappings definidos). Schema Product para cada producto en el listado. Breadcrumbs Inicio > Catálogo > [Categoría]. Canonical URLs para evitar duplicidad en filtros/paginación.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + pruebas de filtros y responsive',
                            'description'    => 'Pruebas exhaustivas de filtros (combinaciones), buscador, paginación, agregar a cotización, responsive en todos los dispositivos y consistencia visual. Verificar performance con muchos productos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 7. DETALLE DE PRODUCTO ──────────────────────────────
                [
                    'name'        => 'Vista: Detalle de Producto',
                    'description' => 'Ficha individual de producto con galería de imágenes, descripción completa, precio, especificaciones técnicas (para herramientas/materiales) o contenido del curso (para cursos), botón prominente "Agregar a Cotización" con selector de cantidad, productos relacionados y CTA a contacto. Optimizada para SEO con schema Product.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Maquetación de la ficha de producto',
                            'description'    => 'Diseño de la vista detalle: galería de imágenes (slider/lightbox con zoom), nombre del producto (H1 con keyword), precio destacado, descripción completa (contenido del curso o especificaciones del producto), tabla de características/atributos, badge de categoría, botón "Agregar a Cotización" con selector de cantidad. Layout responsive (galería arriba en móvil, al lado en desktop).',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Productos relacionados + navegación',
                            'description'    => 'Implementar sección de productos relacionados (misma categoría o complementarios) al final de la ficha. Breadcrumbs (Inicio > Catálogo > Categoría > Producto). Navegación anterior/siguiente entre productos de la misma categoría.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SEO on-page + Schema Product',
                            'description'    => 'URL amigable: /catalogo/[categoria]/[producto-slug]. H1 con keyword del producto. Title tag y meta description dinámicos. Schema Product (name, description, image, price, priceCurrency, availability). Open Graph con imagen del producto para compartir en redes. Breadcrumbs schema BreadcrumbList.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + legibilidad + responsive',
                            'description'    => 'Pruebas de galería de imágenes, botón de cotización, productos relacionados, responsive y performance. Verificar datos estructurados con herramienta de Google.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 8. SISTEMA DE COTIZACIÓN ONLINE ─────────────────────
                [
                    'name'        => 'Sistema de Cotización Online (Carrito de Cotización + Generación PDF)',
                    'description' => "Sistema de cotización online que permite al visitante seleccionar productos del catálogo, agregarlos a una cotización (similar a un carrito de compras pero sin procesamiento de pagos), ajustar cantidades, ver subtotales y total, ingresar sus datos de contacto y generar/imprimir la cotización en formato PDF profesional. NO funciona como e-commerce: es un catálogo con generador de cotizaciones imprimibles.",
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 550,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño y maquetación de la vista de cotización (carrito)',
                            'description'    => 'Implementar la vista del "carrito de cotización": listado de productos agregados con imagen miniatura, nombre, precio unitario, selector de cantidad (editable), subtotal por producto, botón para eliminar producto, subtotal general (suma de todos los productos), campo de observaciones/notas opcionales. Diseño limpio y profesional, responsive.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Lógica de gestión del carrito de cotización (backend + frontend)',
                            'description'    => 'Desarrollar la lógica completa del sistema de cotización: agregar producto (desde catálogo y detalle), actualizar cantidad, eliminar producto, recalcular totales en tiempo real, persistencia en sesión/localStorage (para que no se pierda al navegar), manejo de productos sin stock o descontinuados (si aplica). API endpoints en Laravel para gestión del carrito.',
                            'duration_value' => 8,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Formulario de datos del cliente para la cotización',
                            'description'    => 'Formulario para que el visitante ingrese sus datos antes de generar la cotización: nombre completo / razón social, RUC o DNI (opcional), correo electrónico, teléfono, dirección (opcional), observaciones o requerimientos especiales. Validaciones frontend y backend. Los datos se guardan como lead en el sistema.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Generación de cotización en PDF profesional',
                            'description'    => 'Implementar generación de PDF de la cotización con diseño profesional: logo de la empresa, datos de la empresa (razón social, RUC, dirección, contacto), datos del cliente, fecha de emisión, número de cotización (correlativo), tabla de productos (cantidad, descripción, precio unitario, subtotal), subtotal, IGV (si aplica), total, condiciones comerciales, vigencia de la cotización y pie de página. Usar librería PDF (DomPDF o similar en Laravel).',
                            'duration_value' => 8,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Funcionalidad de impresión y descarga',
                            'description'    => 'Botones de acción: "Descargar PDF", "Imprimir cotización" (print dialog del navegador), "Enviar por correo" (opcional: envía una copia al email ingresado por el cliente). Vista previa de la cotización antes de generar el PDF. Confirmación de generación exitosa.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Registro de cotizaciones generadas (tracking interno)',
                            'description'    => 'Guardar un registro interno de todas las cotizaciones generadas por visitantes: datos del cliente, productos solicitados, cantidades, montos, fecha y hora. Visible desde el panel admin para seguimiento comercial. Exportación básica si aplica.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA completo del sistema de cotización',
                            'description'    => 'Pruebas end-to-end del flujo completo: agregar productos desde catálogo → revisar cotización → ajustar cantidades → ingresar datos → generar PDF → descargar/imprimir. Probar con diferentes cantidades de productos, límites, y en todos los dispositivos. Verificar que el PDF se genera correctamente y con buen diseño.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 9. VISTA: CONTACTO ──────────────────────────────────
                [
                    'name'        => 'Vista: Contacto',
                    'description' => "Vista de contacto con formulario completo para consultas sobre productos, cursos y cotizaciones personalizadas. Incluye datos de la empresa (dirección, teléfonos, correo, horarios), botón de WhatsApp directo, mapa de ubicación (Google Maps embed) e integración con el sistema de leads.",
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 170,
                    'tasks'       => [
                        [
                            'name'           => 'Maquetación de la vista de Contacto',
                            'description'    => 'Layout con formulario y datos de contacto de la empresa: dirección, teléfonos, correo, horarios de atención. Mapa de Google Maps embebido. Botón de WhatsApp directo. Redes sociales. Responsive y consistente con el diseño del sitio.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Formulario de contacto (campos + validaciones + anti-spam)',
                            'description'    => 'Campos: nombre completo, correo electrónico, teléfono (opcional), asunto (dropdown: consulta general, información sobre cursos, cotización de productos, otro), mensaje. Validaciones frontend y backend, protección anti-spam (honeypot). Campo oculto para trackear origen.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con sistema de leads + notificaciones + SEO',
                            'description'    => 'Guardar cada envío como lead. Notificación por email al equipo. Página de agradecimiento. SEO on-page: title, meta description, schema ContactPage y LocalBusiness. Contenido editable desde panel (datos de contacto, horarios, coordenadas del mapa).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + pruebas end-to-end',
                            'description'    => 'Pruebas del formulario (envío, validaciones, anti-spam, notificación), botón WhatsApp en móvil, mapa y responsive.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 10. BLOG EN WORDPRESS ───────────────────────────────
                [
                    'name'        => 'Blog en WordPress (Instalación, Configuración, Personalización e Integración)',
                    'description' => "Instalación y configuración completa de WordPress como plataforma de blog para {$companyName}. El blog se instalará en el subdirectorio /blog del dominio principal para compartir autoridad SEO. Incluye personalización del tema para que sea visualmente consistente con el sitio principal en Laravel, configuración de categorías orientadas a SEO, carga de posts iniciales, plugins esenciales y capacitación para la gestión autónoma del blog.",
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 400,
                    'tasks'       => [
                        [
                            'name'           => 'Instalación de WordPress en subdirectorio /blog',
                            'description'    => 'Instalar WordPress en el subdirectorio /blog del dominio (ej: dominio.com/blog) para que comparta la autoridad del dominio principal. Configuración inicial: idioma español, zona horaria, permalinks amigables (/blog/%category%/%postname%/), usuario administrador y ajustes de privacidad.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Personalización del tema WordPress (consistencia visual con Laravel)',
                            'description'    => 'Seleccionar y personalizar un tema WordPress que permita replicar el estilo visual del sitio principal en Laravel: misma cabecera (header) con logo y menú de navegación que enlace al sitio principal y al blog, mismo pie de página (footer), mismos colores, tipografías y estilo de botones. El visitante debe percibir el blog como parte integral del sitio web.',
                            'duration_value' => 8,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de categorías, etiquetas y plugins esenciales',
                            'description'    => 'Crear categorías del blog basadas en el estudio de keywords: "Patronaje" (tutoriales, técnicas), "Confección" (tips, guías), "Moda y Tendencias" (noticias del sector), "Herramientas y Materiales" (reseñas, recomendaciones), "Noticias" (novedades de la empresa). Instalar y configurar plugins: Yoast SEO (o Rank Math), plugin de caché (LiteSpeed Cache o W3 Total Cache), plugin de seguridad (Wordfence), plugin de formularios (si aplica) y plugin de optimización de imágenes (Smush o ShortPixel).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Carga inicial de 3 posts SEO-optimizados',
                            'description'    => 'Publicación de mínimo 3 artículos iniciales del blog con contenido proporcionado por el cliente (o con apoyo en la redacción). Cada post incluirá: título optimizado con keyword, imagen destacada, contenido con estructura de encabezados H2/H3, enlaces internos al catálogo de productos del sitio principal, meta description optimizada con Yoast/RankMath, categoría y etiquetas asignadas.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación en WordPress para gestión del blog',
                            'description'    => 'Sesión de capacitación remota enfocada exclusivamente en WordPress: cómo crear/editar posts, usar el editor de bloques (Gutenberg), subir imágenes, asignar categorías y etiquetas, optimizar SEO del post con Yoast/RankMath, gestionar comentarios (si aplica) y buenas prácticas de publicación. Entrega de mini-manual del blog.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + verificación de rendimiento del blog',
                            'description'    => 'Pruebas de navegación, visualización de posts, categorías, buscador del blog, responsive, velocidad de carga, plugins funcionando correctamente y consistencia visual con el sitio Laravel principal.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 11. SEO AVANZADO INTEGRAL ───────────────────────────
                [
                    'name'        => 'SEO Avanzado Integral (Posicionamiento en Buscadores)',
                    'description' => "SEO técnico y on-page avanzado para todo el sitio web (Laravel + WordPress). Implementación de datos estructurados (schema.org), metadatos optimizados por página, sitemap XML, robots.txt, integración con Google Search Console, optimización de Core Web Vitals y enlazado interno estratégico entre Laravel y WordPress para maximizar la autoridad del dominio en el sector de {$companyIndustry}.",
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 300,
                    'tasks'       => [
                        [
                            'name'           => 'Implementación de metadatos avanzados + Open Graph',
                            'description'    => 'Configurar title tags y meta descriptions únicos y optimizados con keywords para cada vista (Home, Nosotros, Catálogo, categorías, productos, Contacto). Implementar Open Graph y Twitter Cards con imágenes específicas para cada página/producto. Canonical URLs para evitar contenido duplicado (filtros, paginación). Robots meta tags apropiados.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Schema.org (datos estructurados)',
                            'description'    => 'Implementar schemas específicos del sector: Organization (datos de la empresa), WebSite (buscador del sitio), Product (para cada producto del catálogo con name, description, image, price, offers), BreadcrumbList (navegación en todas las vistas), LocalBusiness (dirección, teléfono, horarios), ItemList (para listado del catálogo), FAQPage (si aplica). Validar con herramienta de datos estructurados de Google.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sitemap XML + robots.txt + Google Search Console',
                            'description'    => 'Generar sitemap.xml dinámico en Laravel (incluye páginas, categorías, productos). Verificar sitemap de WordPress (Yoast/RankMath). Configurar robots.txt para ambos sistemas. Registrar sitio en Google Search Console, enviar sitemaps y verificar indexación inicial. Solicitar indexación de páginas clave.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Enlazado interno estratégico (Laravel ↔ WordPress)',
                            'description'    => 'Implementar estrategia de enlaces internos entre el sitio Laravel y el blog WordPress: productos del catálogo enlazados desde posts relevantes del blog, sidebar del blog con enlaces a categorías del catálogo, artículos relacionados con productos, breadcrumbs cross-platform. Esta estrategia potencia la autoridad SEO de ambas secciones.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de Core Web Vitals y performance',
                            'description'    => 'Revisión y optimización de LCP (largest contentful paint): imágenes optimizadas, preload de recursos críticos. FID/INP: JavaScript mínimo y diferido. CLS: dimensiones de imágenes definidas, fuentes preloaded. Lazy-load de imágenes, compresión de assets (CSS/JS), caché de navegador. Verificar con PageSpeed Insights y GTmetrix en ambos sistemas.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 12. PANEL DE ADMINISTRACIÓN ─────────────────────────
                [
                    'name'        => 'Panel de Administración de Productos y Contenido + Capacitación + Manual',
                    'description' => "Panel de administración en Laravel para gestionar todo el contenido del sitio web: catálogo de productos (CRUD completo con imágenes, precios, categorías), contenido editable de las páginas (Home, Nosotros, Contacto), visualización de cotizaciones generadas por visitantes, gestión de leads/contactos recibidos y configuraciones generales. Incluye capacitación remota y manual de uso.",
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 350,
                    'tasks'       => [
                        [
                            'name'           => 'Accesos y seguridad del panel admin',
                            'description'    => 'Configuración de acceso seguro al panel Laravel: usuario administrador, credenciales, protección de rutas, sesiones seguras, middleware de autenticación. Roles básicos (admin / editor) si se requiere.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Módulo de gestión de productos (CRUD completo)',
                            'description'    => 'CRUD completo de productos: crear/editar/eliminar productos con nombre, slug, descripción corta (para cards del catálogo), descripción completa (para ficha de detalle), precio, imágenes (galería con imagen principal), categoría, SKU (opcional), atributos/especificaciones, orden y estado (publicado/borrador). Gestión masiva de precios si aplica.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Módulo de gestión de categorías de productos',
                            'description'    => 'CRUD de categorías: crear/editar/eliminar categorías con nombre, slug, descripción, imagen y orden. Vista jerárquica (si hay subcategorías). Asignación de productos a categorías.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de contenido de páginas (Home / Nosotros / Contacto)',
                            'description'    => 'Módulo para editar contenido de las páginas del sitio: textos del hero, imágenes de fondo, datos de contacto, horarios, testimonios, secciones editables. Validaciones y previsualización cuando aplique.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Visualización de cotizaciones generadas + leads',
                            'description'    => 'Vista en el panel para que el administrador vea: (1) las cotizaciones generadas por visitantes del sitio (productos, cantidades, montos, datos del cliente, fecha), (2) leads/contactos del formulario de contacto. Filtros por fecha y estado. Exportación básica a Excel/CSV si aplica.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de media (imágenes)',
                            'description'    => 'Módulo de carga y gestión de imágenes: subir, organizar y seleccionar imágenes para productos, categorías y páginas. Recomendaciones de tamaños/peso y optimización automática.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación remota + manual de uso (PDF)',
                            'description'    => 'Sesión de capacitación remota sobre uso del panel Laravel: gestión de productos (crear, editar, eliminar, imágenes, precios), categorías, contenido de páginas, revisión de cotizaciones y leads. Entrega de manual paso a paso con capturas de pantalla.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA final del panel admin',
                            'description'    => 'Pruebas de todos los flujos: crear producto con imágenes, editar precio, crear categoría, asignar producto a categoría, editar contenido del Home, ver cotizaciones generadas, ver leads. Corrección de errores menores y ajustes de usabilidad.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 13. HOSTING Y DOMINIO ───────────────────────────────
                [
                    'name'        => 'Hosting y Dominio (Compra, Configuración, Publicación y Sincronización)',
                    'description' => "Gestión completa de compra/registro de hosting y dominio, configuración técnica del servidor para soportar Laravel + WordPress (dual stack), certificado SSL, sincronización DNS y publicación/deploy de ambos sistemas en producción.",
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Selección de proveedor + compra de hosting y dominio',
                            'description'    => 'Selección del plan de hosting adecuado para soportar Laravel + WordPress simultáneamente (PHP, MySQL, SSL, espacio suficiente para imágenes de productos). Registro del dominio (.com, .pe u otra extensión). Recolección de datos del cliente para titularidad del dominio.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración inicial de hosting + SSL + dual stack',
                            'description'    => 'Preparación del hosting: configuración de SSL (Let\'s Encrypt), bases de datos (una para Laravel, una para WordPress), variables de entorno, PHP adecuado para ambos sistemas, configuración de .htaccess para coexistencia Laravel + WordPress en /blog.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sincronización dominio ↔ hosting (DNS)',
                            'description'    => 'Configuración de registros DNS (A, CNAME), validación de propagación, redirecciones www/no-www, verificación de que el dominio resuelve correctamente tanto al sitio Laravel como al blog WordPress (/blog).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Deploy Laravel + WordPress + verificación final',
                            'description'    => 'Despliegue del sitio Laravel a producción (migración de BD, assets, configuración). Despliegue de WordPress en /blog. Verificación completa: SSL activo, formularios, catálogo, sistema de cotización, blog, rutas, imágenes y performance básica. Smoke tests en ambos sistemas.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 14. INTEGRACIÓN LARAVEL ↔ WORDPRESS ────────────────
                [
                    'name'        => 'Integración Visual y Técnica Laravel ↔ WordPress',
                    'description' => 'Trabajo de integración para que el sitio principal (Laravel) y el blog (WordPress) funcionen como un sitio web unificado visualmente y técnicamente. Incluye menú de navegación compartido, footer compartido, estilos CSS consistentes, enlaces cruzados y experiencia de usuario fluida al navegar entre ambas plataformas.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Menú de navegación y footer compartidos',
                            'description'    => 'Implementar el mismo menú de navegación y footer en ambos sistemas: el menú de WordPress debe incluir enlaces al catálogo, nosotros, contacto (sitio Laravel) y al blog; el menú de Laravel debe incluir enlace al blog (/blog). Footer con mismos datos de contacto, redes y estilo en ambos.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Consistencia de estilos CSS y tipografías',
                            'description'    => 'Asegurar que colores, tipografías, botones, cards y elementos visuales sean idénticos en Laravel y WordPress. Compartir o replicar la hoja de estilos base para que el visitante no note la transición entre plataformas.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de integración cross-platform',
                            'description'    => 'Pruebas de navegación fluida entre Laravel y WordPress: verificar que al hacer clic en "Blog" desde el sitio principal lleva al blog WordPress con el mismo aspecto visual, y viceversa. Probar en móvil/tablet/desktop. Verificar que no haya conflictos de CSS o JavaScript entre ambos sistemas.',
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
