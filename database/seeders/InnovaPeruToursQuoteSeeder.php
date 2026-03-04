<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InnovaPeruToursQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Giancarlo Gallegos Peralta - INNOVA PERU TOURS)
     * - Lead de empresa (INNOVA PERU TOURS)
     * - Cotización en PEN (S/ 1,700 + IGV 18% = S/ 2,006) para página web de agencia turística.
     *
     * Ítems:
     *   1. Análisis y Planificación                                           S/ 100
     *   2. Diseño UI/UX Profesional                                           S/ 180
     *   3. Vista: Homepage (Inicio)                                          S/ 150
     *   4. Vista: Nosotros                                                    S/ 120
     *   5. Vista: Destinos Turísticos                                         S/ 150
     *   6. Vista: Tours y Paquetes                                           S/ 180
     *   7. Vista: Tour Individual (Detalle)                                  S/ 120
     *   8. Vista: Blog / Notas de Viaje                                      S/ 100
     *   9. Vista: Galería de Fotos/Videos                                   S/  80
     *  10. Vista: Contacto + Formulario + Google Maps                       S/ 150
     *  11. Sistema de WhatsApp Flotante                                      S/  60
     *  12. Formulario de Contacto para Leads                                S/ 100
     *  13. Integración con Redes Sociales                                    S/  60
     *  14. SEO Básico + Optimización                                         S/ 120
     *  15. Panel de Administración + Capacitación + Manual                 S/ 150
     *  16. Dominio y Hosting (primer año) + Recuperación dominio existente S/ 100
     *                                                          Subtotal: S/ 1,700
     *                                                       IGV (18%):  S/   306
     *                                                            Total:  S/ 2,006
     *
     * Tiempo estimado: 1 mes y medio (6 semanas / 30 días hábiles).
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente
            // =========================
            $clientName    = 'Giancarlo Gallegos Peralta';
            $clientEmail   = 'innovaperutours@gmail.com'; // Email propuesto
            $clientPhone   = null;
            $clientAddress = null;

            $companyName     = 'INNOVA PERU TOURS';
            $companyRuc      = '10402200966';
            $companyIndustry = 'Agencia de viajes y turismo';

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
                    'project_type' => 'Página web empresarial para agencia de turismo - 10 vistas',
                    'budget_up_to' => 1700,
                    'message'      => "Cotización solicitada para: {$companyName} ({$clientName}). Rubro: {$companyIndustry}. Proyecto: Página web profesional para agencia de turismo con 10 vistas, tours y paquetes turísticos, botón WhatsApp, formulario de contacto, Google Maps, integración redes sociales.",
                    'status'       => 'new',
                    'source'       => 'seed',
                    'notes'        => 'Lead creado automáticamente desde seeder para generar cotización formal de página web para INNOVA PERU TOURS.',
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
            $quoteNumber = 'COT-INNOVAPERU-WEB-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id'              => $clientUser->id,
                    'created_by'           => $createdBy?->id,
                    'title'                => 'Cotización: Página Web Profesional para INNOVA PERU TOURS – Agencia de Turismo',
                    'description'          => "Desarrollo de una página web profesional para {$companyName}, agencia de viajes y turismo especializada en tours por Perú.\n\n" .
                        "El sitio web incluirá:\n" .
                        "- Diseño profesional y moderno adaptado al sector turismo.\n" .
                        "- Presentación de destinos turísticos principales (Cusco, Machu Picchu, Valle Sagrado, Lago Titicaca, etc.).\n" .
                        "- Catálogo de tours y paquetes turísticos con información detallada.\n" .
                        "- Blog de notas de viaje y consejos para turistas.\n" .
                        "- Galería de fotos y videos de tours anteriores.\n" .
                        "- Formulario de contacto para solicitudes de información y cotizaciones.\n" .
                        "- Botón flotante de WhatsApp para contacto directo.\n" .
                        "- Geolocalización con Google Maps de la oficina/ubicación.\n" .
                        "- Integración con redes sociales (Facebook, Instagram, TripAdvisor).\n" .
                        "- Dominio gratuito (se intentará recuperar el dominio existente).\n\n" .
                        "Vistas del sitio (10 vistas):\n" .
                        "1. Inicio (Home)\n" .
                        "2. Nosotros\n" .
                        "3. Destinos Turísticos\n" .
                        "4. Tours y Paquetes\n" .
                        "5. Tour Individual (página detalle)\n" .
                        "6. Blog / Notas de Viaje\n" .
                        "7. Galería de Fotos/Videos\n" .
                        "8. Contacto\n" .
                        "9. Página adicional (Testimonios o FAQ)\n" .
                        "10. Política de Privacidad/Términos\n\n" .
                        "Incluye:\n" .
                        "- Panel de administración para gestionar contenido.\n" .
                        "- Dominio gratuito + intento de recuperación del dominio existente.\n" .
                        "- Hosting del primer año.\n" .
                        "- SEO básico.\n" .
                        "- Capacitación y manual de uso.\n\n" .
                        "Tiempo estimado de entrega: 1 mes y medio (6 semanas / 30 días hábiles).",
                    'currency_id'          => $pen->id,
                    'tax_rate'             => 18,
                    'discount_amount'      => 0,
                    'status'               => 'draft',
                    'valid_until'          => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes'                => "Requisitos para iniciar:\n" .
                        "- Acceso a dominio existente (si lo tienen) para intentar recuperación.\n" .
                        "- Datos de contacto: teléfonos, correo, dirección, horarios.\n" .
                        "- Logo de la agencia (si lo tienen).\n" .
                        "- Contenido: textos para cada sección, historia de la agencia.\n" .
                        "- Lista de tours y paquetes turísticos ofrecidos.\n" .
                        "- Imágenes y videos de destinos y tours.\n" .
                        "- Cuentas de redes sociales para integración.\n" .
                        "- Referencias de diseño (sitios de agencias de turismo que les gusten).\n\n" .
                        "Entregables:\n" .
                        "- Sitio web publicado con SSL.\n" .
                        "- 10 vistas desarrolladas y configuradas.\n" .
                        "- Panel de administración.\n" .
                        "- Botón WhatsApp funcionando.\n" .
                        "- Formulario de contacto con sistema de leads.\n" .
                        "- Google Maps configurado.\n" .
                        "- Integración con redes sociales.\n" .
                        "- Manual PDF + capacitación remota.\n\n" .
                        "Costos adicionales:\n" .
                        "- Dominio y hosting primer año: incluido.\n" .
                        "- Renovación anual: aproximadamente S/ 350.",
                    'terms_conditions'     => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 1,700.00\n" .
                        "- IGV (18%): S/ 306.00\n" .
                        "- Total: S/ 2,006.00\n" .
                        "- Forma de pago: 50% al iniciar (S/ 1,003.00) / 50% al culminar (S/ 1,003.00).\n" .
                        "- Dominio: se incluirá dominio gratuito; se intentará recuperar el dominio existente del cliente.\n" .
                        "- Hosting primer año incluido; renovaciones anuales S/ 350.\n" .
                        "- Propiedad del código 100% del cliente.\n" .
                        "- Alcance: 10 vistas, tours, WhatsApp, formulario, Google Maps, redes, panel admin, capacitación.\n" .
                        "- Plazo: 1 mes y medio (6 semanas).",
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
            // Ítems de la cotización  (subtotal = S/ 1,700.00)
            // =========================================================
            $items = [
                // ─── 1. ANÁLISIS Y PLANIFICACIÓN ─────────────────────────
                [
                    'name'        => 'Análisis y Planificación',
                    'description' => 'Análisis del proyecto y planificación: reunión de requirements, análisis de la competencia, definición de estructura del sitio, planificación de funcionalidades y cronograma.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Reunión de requirements + briefing',
                            'description'    => 'Reunión con el cliente para levantar requisitos: objetivos del proyecto, servicios ofrecidos, destinos principales, público objetivo, funcionalidades requeridas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Análisis de mercado y competencia',
                            'description'    => 'Análisis de agencias de turismo competidoras en Perú: estudio de sus webs, funcionalidades, fortalezas, oportunidades de diferenciación.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Arquitectura del sitio',
                            'description'    => 'Definir estructura de las 10 vistas: sitemap, jerarquía de páginas, navegación principal y secundario, URLs amigables.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Planificación y cronograma',
                            'description'    => 'Elaborar cronograma del proyecto: fases, entregables, hitos, timeline de 6 semanas, responsables.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 2. DISEÑO UI/UX ─────────────────────────────────────
                [
                    'name'        => 'Diseño UI/UX Profesional',
                    'description' => 'Diseño de interfaz y experiencia de usuario: mockups, guía de estilos, diseño responsive para todos los dispositivos.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Wireframes de las 10 vistas',
                            'description'    => 'Crear wireframes de todas las páginas: estructura de información, layout, componentes, distribución de contenido.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Mockups de alta fidelidad',
                            'description'    => 'Diseñar mockups visuales: tipografías, colores, espaciados, componentes UI, estados, animations.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Guía de estilos',
                            'description'    => 'Crear guía de estilos: paleta de colores turísticos, tipografías, botones, cards, modales, iconografía.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño responsive',
                            'description'    => 'Adaptar diseño para móvil, tablet y desktop: layouts fluidos, navegación móvil, touch-friendly.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 3. HOMEPAGE ─────────────────────────────────────────
                [
                    'name'        => 'Vista: Homepage (Inicio)',
                    'description' => 'Desarrollo de página de inicio: hero con video/banner de destinos, propuesta de valor, tours destacados, destinos populares, testimonios, newsletter y CTA.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Maquetación del homepage',
                            'description'    => 'Maquetar homepage: hero con slider de imágenes de destinos icónicos (Machu Picchu, Cusco, Titicaca), mensaje de bienvenida, why choose us, tours destacados, destinos populares, testimonios, newsletter, footer.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Componentes dinámicos',
                            'description'    => 'Desarrollar componentes: slider de destinos, cards de tours, contador de experiencias, animación de elementos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con contenido',
                            'description'    => 'Conectar con base de datos: tours destacados dinámicos, destinos populares, testimonios desde admin.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización y QA',
                            'description'    => 'Optimizar rendimiento, pruebas responsive, verificación de enlaces, velocidad de carga.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 4. NOSOTROS ───────────────────────────────────────
                [
                    'name'        => 'Vista: Nosotros',
                    'description' => 'Página institucional: historia de la agencia, misión, visión, valores, equipo de guías, certificaciones,为什么不 elegirnos.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Estructura de contenido',
                            'description'    => 'Definir secciones: historia de la agencia, años de experiencia, misión/visión/valores, equipo de guías y staff, certificaciones, why choose us, cifras destacadas.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación responsive',
                            'description'    => 'Maquetar página: layout limpio, timeline de historia, grid de equipo, icons de beneficios, diseño coherente con homepage.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con admin',
                            'description'    => 'Vincular contenido al panel: textos editables, fotos de equipo, certificaciones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA y ajustes',
                            'description'    => 'Verificar responsividad, ortografía, enlaces, consistencia visual.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 5. DESTINOS TURÍSTICOS ──────────────────────────────
                [
                    'name'        => 'Vista: Destinos Turísticos',
                    'description' => 'Catálogo de destinos: Cusco, Machu Picchu, Valle Sagrado, Lago Titicaca, Arequipa, Lima, etc. Con filtros por región, tipo de turismo y duración.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura de destinos',
                            'description'    => 'Definir taxonomías: por región (Norte, Centro, Sur), por tipo (aventura, cultural, naturaleza), por duración.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Listado de destinos',
                            'description'    => 'Desarrollar grid de destinos: cards con imagen, nombre, ubicación, breve descripción, tours relacionados.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Filtros y búsqueda',
                            'description'    => 'Implementar filtros: por región, tipo, duración. Actualización dinámica sin recarga.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de destinos',
                            'description'    => 'Pruebas: filtros, navegación, responsive, velocidad.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 6. TOURS Y PAQUETES ────────────────────────────────
                [
                    'name'        => 'Vista: Tours y Paquetes',
                    'description' => 'Catálogo de tours y paquetes turísticos: información de cada tour, precio, duración, nivel de dificultad, incluye/no incluye, galería.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Estructura de tours',
                            'description'    => 'Definir modelo: nombre, slug, descripción, precio, duración, nivel dificultad, grupo mínimo/máximo, incluye, no incluye, galería, destino relacionado.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Listado de tours',
                            'description'    => 'Desarrollar grid de tours: cards con imagen, nombre, destino, duración, precio desde, nivel, botón "Ver más".',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Filtros de tours',
                            'description'    => 'Implementar filtros: por destino, duración, precio, nivel de dificultad, tipo de tour.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión desde admin',
                            'description'    => 'Crear CRUD de tours en panel: crear, editar, eliminar tours con todos los campos, editor de itinerario.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de tours',
                            'description'    => 'Pruebas: listing, filtros, CRUD, responsive.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 7. TOUR INDIVIDUAL ─────────────────────────────────
                [
                    'name'        => 'Vista: Tour Individual (Detalle)',
                    'description' => 'Página de detalle de cada tour: galería, itinerario día a día, incluye/no incluye, precio, reserva, tours relacionados.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Layout de ficha de tour',
                            'description'    => 'Maquetar ficha: hero con galería, información general, precio, duración, nivel, grupo, CTA de reserva.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Itinerario día a día',
                            'description'    => 'Desarrollar sección de itinerary: cronograma día a día con actividades, comidas, alojamiento.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Incluye / No incluye',
                            'description'    => 'Sección de incluye/no incluye: tabla o lista de servicios incluidos y exclusiones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Tours relacionados',
                            'description'    => 'Mostrar tours relacionados: destinos similares, mismos días, recomendaciones.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 8. BLOG / NOTAS DE VIAJE ────────────────────────────
                [
                    'name'        => 'Vista: Blog / Notas de Viaje',
                    'description' => 'Blog para contenido de marketing: guías de viaje, consejos, destinos, cultura. SEO content para atraer tráfico orgánico.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura del blog',
                            'description'    => 'Definir estructura: categorías (Guías, Consejos, Destinos, Cultura), tags, URLs amigables SEO.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Listado de artículos',
                            'description'    => 'Desarrollar blog listing: grid de posts, imagen destacada, título, extracto, categoría, fecha, paginación.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Artículo individual',
                            'description'    => 'Diseñar post: lectura optimizada, contenido rico, imágenes, compartir en redes.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión desde admin',
                            'description'    => 'CRUD de posts: editor de contenido, categorías, tags, featured image.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 9. GALERÍA DE FOTOS/VIDEOS ─────────────────────────
                [
                    'name'        => 'Vista: Galería de Fotos/Videos',
                    'description' => 'Galería visual de experiencias: fotos de tours, videos de destinos, lightbox para ver enlarge.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 80,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño de galería',
                            'description'    => 'Diseñar galería: grid de fotos/videos, masonry o grid clásico, filtros por tour/destino.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Lightbox y video',
                            'description'    => 'Desarrollar lightbox: ver imagen grande, navegación, video player para videos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de media',
                            'description'    => 'Subir y organizar medios: organizar por carpetas, gestionar desde admin.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 10. CONTACTO + FORMULARIO + GOOGLE MAPS ────────────
                [
                    'name'        => 'Vista: Contacto + Formulario + Google Maps',
                    'description' => 'Página de contacto: formulario de contacto, datos de la agencia, horarios, Google Maps embed, redes sociales.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Layout de contacto',
                            'description'    => 'Maquetar página: formulario a un lado, información de contacto al otro, horarios, redes sociales, mapa.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Formulario de contacto',
                            'description'    => 'Desarrollar formulario: nombre, email, teléfono, tour de interés, mensaje, validación, antispam.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Google Maps',
                            'description'    => 'Integrar Google Maps: embed de ubicación de la oficina, marker personalizado.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de leads',
                            'description'    => 'Guardar submissions como leads, notificación por email, página de agradecimiento.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de contacto',
                            'description'    => 'Pruebas: formulario, mapa, emails, responsive.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 11. WHATSAPP FLOTANTE ───────────────────────────────
                [
                    'name'        => 'Sistema de WhatsApp Flotante',
                    'description' => 'Botón flotante de WhatsApp visible en todas las páginas para contacto directo.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 60,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño del botón',
                            'description'    => 'Crear botón flotante: ícono de WhatsApp, posición esquina inferior, diseño adaptativo, animación.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración',
                            'description'    => 'Configurar número, mensaje inicial, formato wa.me, funcionamiento en móvil y desktop.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA',
                            'description'    => 'Probar en dispositivos, verificar que no interfiera con otros elementos.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 12. FORMULARIO DE LEADS ─────────────────────────────
                [
                    'name'        => 'Formulario de Contacto para Leads',
                    'description' => 'Sistema de captación de leads: guardado en DB, notificaciones, dashboard en admin.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Backend del formulario',
                            'description'    => 'Desarrollar backend: validación, sanitización, guardado en tabla leads con todos los campos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Notificaciones',
                            'description'    => 'Sistema de emails: notificación al admin con datos del lead, email de confirmación al cliente.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Dashboard de leads',
                            'description'    => 'Ver leads en admin: listado, filtros, ver detalles, marcar como atendido.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Página de agradecimiento',
                            'description'    => 'Crear thank you page: mensaje de confirmación, siguiente paso sugerido.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 13. INTEGRACIÓN REDES SOCIALES ────────────────────
                [
                    'name'        => 'Integración con Redes Sociales',
                    'description' => 'Integración con redes sociales: links en footer, botones compartir, feed de Instagram (opcional), botones de seguimiento.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 60,
                    'tasks'       => [
                        [
                            'name'           => 'Links y botones',
                            'description'    => 'Agregar links a redes: Facebook, Instagram, TripAdvisor, YouTube. Buttons de compartir en tours/blog.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Iconos y footer',
                            'description'    => 'Redes en footer: icons profesionales, links correctos, apertura en nueva pestaña.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Open Graph',
                            'description'    => 'Configurar Open Graph: meta tags para compartir correctamente en Facebook, WhatsApp.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 14. SEO BÁSICO ──────────────────────────────────────
                [
                    'name'        => 'SEO Básico + Optimización',
                    'description' => 'SEO técnico: metadatos, sitemap, robots, URLs amigables, optimización de imágenes, schema tourism.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Metadatos',
                            'description'    => 'Configurar title y meta description únicos para cada página, keywords relevantes.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sitemap y robots',
                            'description'    => 'Generar sitemap.xml dinámico, configurar robots.txt, Submit a Google Search Console.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Schema markup',
                            'description'    => 'Implementar schemas: TravelAgency, TouristAttraction, TouristTrip, BreadcrumbList.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización técnica',
                            'description'    => 'URLs amigables, H1/H2 correctos, alt tags en imágenes, velocidad básica.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 15. PANEL DE ADMINISTRACIÓN ────────────────────────
                [
                    'name'        => 'Panel de Administración + Capacitación + Manual',
                    'description' => 'Panel para gestionar contenido: tours, destinos, posts, leads, configuración. Incluye capacitación y manual.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Gestión de tours',
                            'description'    => 'CRUD de tours: crear, editar, eliminar tours con todos los campos, itinerario, galería.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de destinos',
                            'description'    => 'CRUD de destinos: crear, editar, eliminar destinos, imágenes, descripciones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de blog',
                            'description'    => 'CRUD de posts: editor de contenido, categorías, imágenes destacadas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de leads',
                            'description'    => 'Ver leads: listado, filtrar por fecha/estado, ver detalles, exportar.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración',
                            'description'    => 'Config general: datos de empresa, contacto, redes, SEO settings.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación + manual',
                            'description'    => 'Capacitación remota (1.5h) + manual PDF con capturas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 16. DOMINIO Y HOSTING ──────────────────────────────
                [
                    'name'        => 'Dominio y Hosting (primer año) + Recuperación dominio existente',
                    'description' => 'Dominio gratuito + hosting primer año + intento de recuperación del dominio existente.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Intento de recuperación de dominio',
                            'description'    => 'Verificar disponibilidad del dominio actual de INNOVA PERU TOURS, intentar transferencia o recuperación si está disponible.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Compra de dominio',
                            'description'    => 'Si no se puede recuperar el actual, comprar nuevo dominio (.com, .pe, .travel u otra extensión apropiada).',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de hosting',
                            'description'    => 'Configurar hosting: cuenta, SSL (Let\'s Encrypt), base de datos, email.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Publicación',
                            'description'    => 'Deploy: subir archivos, configurar DNS, verificar funcionamiento.',
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
