<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EMRGrupoConstructorQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Esau Garcia)
     * - Lead de empresa (EMR GRUPO CONSTRUCTOR SAC / RUC: 20526351950)
     * - Cotización en PEN (S/ 2,500 + IGV 18% = S/ 2,950) para una web empresarial
     *   del rubro de construcción que incluye:
     *   - Hosting y Dominio (S/ 400):
     *     - Dominio .com/.pe anual
     *     - Hosting profesional anual
     *     - Certificado SSL
     *     - Configuración DNS y publicación
     *   - Desarrollo Web Empresarial (S/ 2,100):
     *     - 8 vistas (Inicio, Nosotros, Servicios, Proyectos, Blog, Contacto, FAQ, Testimonios)
     *     - SEO avanzado + Google Analytics
     *     - Galería de proyectos
     *     - Integración redes sociales
     *     - Formularios personalizados
     *     - Optimización de velocidad
     *     - Panel de administración
     * Tiempo máximo: 2 meses (8 semanas).
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente/empresa
            // =========================
            $clientName = 'Esau Garcia';
            $clientEmail = 'esau.garcia@emr.com.pe';
            $clientPhone = '';
            $clientAddress = null;

            $companyName = 'EMR GRUPO CONSTRUCTOR SAC';
            $companyRuc = '20526351950';
            $companyIndustry = 'Sector construcción';

            // =========================
            // Moneda: PEN
            // =========================
            $pen = Currency::firstOrCreate(
                ['code' => 'PEN'],
                [
                    'name' => 'Sol Peruano',
                    'symbol' => 'S/',
                    'exchange_rate' => 1.000000,
                    'is_base' => true,
                ]
            );

            // =========================
            // Usuario cliente
            // =========================
            $clientUser = User::updateOrCreate(
                ['email' => $clientEmail],
                [
                    'name' => $clientName,
                    'password' => Hash::make('12345678'),
                    'email_verified_at' => now(),
                ]
            );

            // =========================
            // Lead (empresa)
            // =========================
            Lead::updateOrCreate(
                [
                    'email' => $clientEmail,
                    'company_name' => $companyName,
                ],
                [
                    'name' => $clientName,
                    'phone' => $clientPhone,
                    'is_company' => true,
                    'company_ruc' => $companyRuc,
                    'project_type' => 'Página web empresarial + Hosting y Dominio + SEO + Panel de administración',
                    'budget_up_to' => 2500,
                    'message' => "Cotización solicitada para: {$companyName} (RUC: {$companyRuc}). Rubro: {$companyIndustry}. Plan: Web empresarial + Hosting y Dominio.",
                    'status' => 'new',
                    'source' => 'seed',
                    'notes' => 'Lead creado automáticamente desde seeder para generar cotización del plan empresarial con hosting y dominio.',
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
            $quoteNumber = 'COT-20526351950-WEBEMP-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id' => $clientUser->id,
                    'created_by' => $createdBy?->id,
                    'title' => 'Cotización: Página web empresarial + Hosting/Dominio + SEO + Panel admin (EMR GRUPO CONSTRUCTOR SAC)',
                    'description' => "Desarrollo de una página web empresarial profesional para {$companyName} ({$companyIndustry}).\n\n" .
                        "PLAN EMPRESARIAL - Vistas incluidas:\n" .
                        "- Inicio (Home)\n" .
                        "- Nosotros\n" .
                        "- Servicios\n" .
                        "- Proyectos/Galería\n" .
                        "- Blog\n" .
                        "- Contacto\n" .
                        "- FAQ (Preguntas frecuentes)\n" .
                        "- Testimonios\n\n" .
                        "Características del Plan Empresarial:\n" .
                        "- Diseño responsive (móvil/tablet/desktop)\n" .
                        "- SEO avanzado + Google Analytics\n" .
                        "- Galería avanzada de proyectos de construcción\n" .
                        "- Integración con redes sociales\n" .
                        "- Formularios personalizados\n" .
                        "- Optimización de velocidad\n" .
                        "- Panel de administración para editar contenido\n" .
                        "- Hosting + Dominio + SSL\n" .
                        "- Soporte prioritario 30 días\n\n" .
                        "Tiempo estimado de entrega: 2 meses (8 semanas) (sin imprevistos y con entrega oportuna de accesos/contenido).",
                    'currency_id' => $pen->id,
                    'tax_rate' => 18,
                    'discount_amount' => 0,
                    'status' => 'draft',
                    'valid_until' => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes' => "Requisitos para iniciar:\n" .
                        "- Definición del nombre de dominio deseado (2-3 opciones) y datos para compra/registro.\n" .
                        "- Contenido base: textos para Inicio/Nosotros/Servicios, datos de contacto, imágenes del sector construcción.\n" .
                        "- Portafolio: lista de proyectos o trabajos realizados (títulos, descripciones, fotos, ubicación).\n" .
                        "- Información para el blog: temas iniciales o artículos que se desean publicar.\n" .
                        "- Testimonios de clientes: nombres, fotos (si aplica), textos de recomendación.\n" .
                        "- Palabras clave objetivo para SEO (si existen) y competidores a considerar.\n\n" .
                        "Entregables:\n" .
                        "- Sitio web publicado con certificado SSL, sitemap y robots configurado.\n" .
                        "- Panel admin para actualizar contenido, proyectos y posts.\n" .
                        "- Manual + capacitación de uso del sitio web.\n" .
                        "- Acceso a hosting y dominio por el primer año.\n",
                    'terms_conditions' => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 2,500.00\n" .
                        "  • Hosting y Dominio (anual): S/ 400.00\n" .
                        "  • Desarrollo web empresarial: S/ 2,100.00\n" .
                        "- IGV (18%): S/ 450.00\n" .
                        "- Total: S/ 2,950.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto (S/ 1,475.00) / 50% al culminar el proyecto y previo a la publicación final (S/ 1,475.00).\n" .
                        "- Hosting + dominio: se incluye la gestión y el costo estimado dentro de esta cotización; el pago anual de hosting y dominio puede ascender a renovaciones posteriores. Renovaciones anuales posteriores corren por cuenta del cliente.\n" .
                        "- Propiedad del código y diseños: 100% del código fuente y material gráfico serán del cliente.\n" .
                        "- Alcance: incluye panel de administración, capacitación, manual de uso. Cambios mayores o nuevos módulos fuera del alcance se cotizan por separado.\n" .
                        "- Plazo estimado: 2 meses (8 semanas), sujeto a entrega de contenido y aprobaciones sin demoras.",
                    'client_name' => $clientName,
                    'client_ruc' => $companyRuc,
                    'client_email' => $clientEmail,
                    'client_phone' => $clientPhone,
                    'client_address' => $clientAddress,
                ]
            );

            if (method_exists($quote, 'trashed') && $quote->trashed()) {
                $quote->restore();
            }

            // Reemplazar items y tareas (idempotente)
            $quote->items()->delete();

            // Total items (subtotal) = 2500.00
            // Hosting y Dominio = 400.00
            // Desarrollo web = 2100.00
            // IGV (18%) = 450.00
            // Total con IGV = 2950.00
            $items = [
                // =============================================
                // HOSTING Y DOMINIO (S/ 400)
                // =============================================
                [
                    'name' => 'Hosting y Dominio (Anual)',
                    'description' => "Servicio de hosting profesional y registro de dominio para {$companyName}. Incluye configuración DNS, certificado SSL y publicación del sitio web.",
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 400,
                    'tasks' => [
                        [
                            'name' => 'Registro de dominio',
                            'description' => 'Búsqueda y registro del dominio (.com, .com.pe o similar) para la empresa constructora. Incluye gestión de DNS.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Configuración de hosting',
                            'description' => 'Configuración del servidor hosting con los recursos necesarios para un sitio web empresarial de construcción.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Certificado SSL (Let\'s Encrypt)',
                            'description' => 'Instalación y configuración de certificado SSL gratuito para garantizar conexiones seguras (HTTPS).',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Configuración de DNS y correo',
                            'description' => 'Configuración de registros DNS, MX para correo profesional y redirecciones necesarias.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Publicación del sitio',
                            'description' => 'Despliegue final del sitio web en producción, verificación de funcionamiento y configuración de estadísticas.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Soporte técnico inicial',
                            'description' => 'Soporte técnico durante el primer mes para cualquier incidencia relacionada con hosting y dominio.',
                            'duration_value' => 4,
                            'duration_unit' => 'hours',
                        ],
                    ],
                ],
                // =============================================
                // DESARROLLO WEB EMPRESARIAL - VISTAS
                // =============================================
                [
                    'name' => 'Vista: Inicio (Home)',
                    'description' => "Diseño e implementación de la vista de Inicio orientada al sector construcción: propuesta de valor, proyectos destacados, servicios, testimonios y secciones clave para {$companyName}.",
                    'quantity' => 1,
                    'unit' => 'vista',
                    'unit_price' => 280,
                    'tasks' => [
                        ['name' => 'Arquitectura de secciones + UI kit', 'description' => 'Definir estructura (hero con imágenes de proyectos de construcción, servicios, proyectos destacados, beneficios, testimonios, CTA) y componentes reutilizables.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Maquetación responsive', 'description' => 'Implementar layout responsive (móvil/tablet/desktop) con diseño profesional para empresa constructora.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Integración con contenido editable (panel)', 'description' => 'Conectar secciones a campos editables: textos, imágenes, enlaces, sliders y orden de secciones.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'SEO on-page + metatags', 'description' => 'Implementar títulos, descripciones, Open Graph, keywords enfocadas al sector construcción.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'QA + performance', 'description' => 'Verificar navegación, enlaces, pesos de imágenes y pruebas cross-device.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Vista: Nosotros',
                    'description' => 'Vista institucional para presentar la empresa constructora, su historia, misión, visión, valores, equipo y certificaciones.',
                    'quantity' => 1,
                    'unit' => 'vista',
                    'unit_price' => 180,
                    'tasks' => [
                        ['name' => 'Estructura de contenido institucional', 'description' => 'Definir secciones: historia de la empresa, misión/visión/valores, equipo directivo, certificaciones, alianzas y 为什么 elegirnos.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Maquetación + estilos profesionales', 'description' => 'Implementación UI con diseño profesional para empresa de construcción, incluyendo secciones de equipo y certificaciones.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Integración con panel', 'description' => 'Vincular contenido a administración (edición de textos, imágenes, certificados).', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'SEO on-page', 'description' => 'Metatags, títulos y descripciones optimizadas para buscadores.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'QA', 'description' => 'Revisión de contenido, enlaces y accesibilidad básica.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Vista: Servicios',
                    'description' => 'Página para presentar los servicios de construcción: construcción civil, remodelaciones, proyectos residenciales, comerciales, supervisión de obras, consultoría, etc.',
                    'quantity' => 1,
                    'unit' => 'vista',
                    'unit_price' => 200,
                    'tasks' => [
                        ['name' => 'Definición de estructura de servicios', 'description' => 'Organizar servicios de construcción con descripciones detalladas, íconos representativos, beneficios y CTAs.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Maquetación con cards/servicios', 'description' => 'Diseño de tarjetas de servicios con imágenes representativas, descripciones, tiempo estimado y precios de referencia.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Integración con panel admin', 'description' => 'Campos editables para cada servicio (nombre, descripción, imagen, orden, precio).', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'SEO on-page', 'description' => 'Optimización de títulos y descripciones para servicios de construcción.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'QA', 'description' => 'Pruebas de navegación y visualización responsive.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Vista: Proyectos/Galería',
                    'description' => 'Galería avanzada de proyectos de construcción realizados, con filtros por tipo de proyecto (residencial, comercial, industrial), ubicación, año y vista de detalle.',
                    'quantity' => 1,
                    'unit' => 'vista',
                    'unit_price' => 280,
                    'tasks' => [
                        ['name' => 'Definición de categorías/filtros', 'description' => 'Definir taxonomías para proyectos de construcción (tipo de proyecto, ubicación, año, estado: terminado/en proceso).', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Maquetación de galería + grid responsive', 'description' => 'Grid de proyectos con imágenes de alta calidad, overlay con información resumida, filtros interactivos y paginación.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Vista detalle de proyecto', 'description' => 'Página individual con galería de imágenes (antes/después), descripción completa, datos técnicos, ubicación, cliente y CTA a contacto.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Integración con panel (CRUD proyectos)', 'description' => 'Crear/editar/eliminar proyectos, subir múltiples imágenes, asignar categorías, ordenar y destacar proyectos.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'SEO + optimización de imágenes', 'description' => 'Alt texts, lazy loading, compresión de imágenes para performance, schema Project.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'QA', 'description' => 'Pruebas de filtros, navegación, carga de imágenes y responsive.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Vista: Blog (listado + post individual)',
                    'description' => 'Blog para publicar artículos sobre construcción, consejos, tendencias, noticias del sector y proyectos destacados.',
                    'quantity' => 1,
                    'unit' => 'vista',
                    'unit_price' => 200,
                    'tasks' => [
                        ['name' => 'Modelo de contenido (categorías/etiquetas)', 'description' => 'Definir estructura de categorías y tags para artículos de construcción (tips, proyectos, tendencias, normativas).', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'Maquetación listado de posts', 'description' => 'Cards de artículos con imagen destacada, título, extracto, fecha, categoría y paginación.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'Filtros por categoría/etiqueta', 'description' => 'Implementación de filtros laterales o superiores para navegación del blog.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Vista de post individual', 'description' => 'Diseño de lectura optimizado con imagen destacada, contenido enriquecido, autor, fecha, posts relacionados y CTAs.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'Integración con panel (CRUD posts)', 'description' => 'Crear/editar/eliminar posts, gestión de categorías/etiquetas, borradores y publicación.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'SEO avanzado para blog', 'description' => 'Schema Article, breadcrumbs, Open Graph por post, titles/descriptions dinámicos.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'QA', 'description' => 'Pruebas de navegación, filtros, paginación y legibilidad.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Vista: Contacto',
                    'description' => 'Vista de contacto con datos de la empresa constructora, mapa de ubicación de oficina/obra, formulario personalizado de cotización y redes sociales.',
                    'quantity' => 1,
                    'unit' => 'vista',
                    'unit_price' => 180,
                    'tasks' => [
                        ['name' => 'Maquetación de contacto', 'description' => 'Layout con datos de contacto, horarios, ubicación con mapa interactivo y redes sociales de la empresa.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Formulario de cotización personalizado', 'description' => 'Formulario con campos específicos para construcción (tipo de proyecto, presupuesto aproximado, ubicación, fecha deseada, descripción), validaciones y anti-spam.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'Integración con redes sociales', 'description' => 'Enlaces/íconos destacados a perfiles de redes sociales de la empresa constructora (Facebook, Instagram, LinkedIn).', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'Notificaciones por email', 'description' => 'Configuración de envío de solicitudes de cotización por email + confirmación al visitante + notificación a administrador.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Contenido editable desde panel', 'description' => 'Datos de contacto, horarios, enlaces a redes y texto de contactanos editables desde el panel.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'QA + pruebas end-to-end', 'description' => 'Verificar envío de formulario, validaciones y confirmaciones.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Vista: FAQ (Preguntas Frecuentes)',
                    'description' => 'Página de preguntas frecuentes sobre servicios de construcción, procesos, garantías, tiempos de entrega y presupuestos.',
                    'quantity' => 1,
                    'unit' => 'vista',
                    'unit_price' => 140,
                    'tasks' => [
                        ['name' => 'Estructura de FAQ (categorías)', 'description' => 'Organizar preguntas por categorías (servicios, presupuestos, procesos, garantías, permisos).', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'Maquetación acordeón/expandible', 'description' => 'Diseño de FAQ con acordeones expandibles, buscador de preguntas y categorías.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'Integración con panel (CRUD FAQ)', 'description' => 'Gestión de preguntas/respuestas desde el panel: crear, editar, ordenar y activar/desactivar.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Schema FAQ para SEO', 'description' => 'Implementar structured data FAQPage para rich snippets en Google.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'QA', 'description' => 'Pruebas de interacción acordeón y responsive.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Vista: Testimonios',
                    'description' => 'Página dedicada a mostrar testimonios y reseñas de clientes satisfechos con los proyectos de construcción realizados.',
                    'quantity' => 1,
                    'unit' => 'vista',
                    'unit_price' => 150,
                    'tasks' => [
                        ['name' => 'Estructura de testimonios', 'description' => 'Definir formato de testimonios: nombre del cliente, empresa (si aplica), proyecto realizado, foto, texto de recomendación, calificación.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'Maquetación de testimonios', 'description' => 'Diseño de grid/carrusel de testimonios con foto, nombre, proyecto, texto y estrellas de calificación.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'Integración con panel (CRUD testimonios)', 'description' => 'Gestión de testimonios: agregar, editar, eliminar, aprobar/desaprobar y ordenar.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'SEO local', 'description' => 'Optimización para búsquedas locales y schema Review.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'QA', 'description' => 'Pruebas de visualización, responsive y carga.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                    ],
                ],
                // =============================================
                // SEO AVANZADO + GOOGLE ANALYTICS
                // =============================================
                [
                    'name' => 'SEO Avanzado + Google Analytics',
                    'description' => 'Optimización SEO técnica completa para posicionamiento en buscadores enfocado al sector construcción + configuración de Google Analytics y Search Console.',
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 200,
                    'tasks' => [
                        ['name' => 'Estrategia SEO (keywords + arquitectura)', 'description' => 'Definir keywords principales del sector construcción (constructora, строительство,remodelacion, presupuesto construcción), arquitectura de información y jerarquía H1/H2 por vista.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'Metadatos avanzados + OpenGraph', 'description' => 'Titles/descriptions por vista, canonical, OG/Twitter cards, imagen social por defecto de la marca.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Schema.org (structured data)', 'description' => 'Implementar schema Organization, LocalBusiness, Article para blog, FAQPage, BreadcrumbList, Project.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Sitemap + robots + Search Console', 'description' => 'Configurar sitemap.xml, robots.txt y verificación en Google Search Console.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Configuración de Google Analytics 4', 'description' => 'Implementación de GA4, configuración de eventos básicos (conversiones de formulario, clicks de teléfono), y dashboard inicial.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Optimización de velocidad', 'description' => 'Core Web Vitals: lazy loading, compresión de imágenes, minificación CSS/JS, caché básico y optimización de servidor.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                    ],
                ],
                // =============================================
                // PANEL DE ADMINISTRACIÓN + CAPACITACIÓN
                // =============================================
                [
                    'name' => 'Panel de Administración + Capacitación + Manual',
                    'description' => 'Panel completo para gestionar todo el contenido del sitio web: páginas, proyectos, blog, FAQ, testimonios, contactos. Incluye capacitación y manual de uso.',
                    'quantity' => 1,
                    'unit' => 'módulo',
                    'unit_price' => 250,
                    'tasks' => [
                        ['name' => 'Accesos y seguridad del panel', 'description' => 'Configuración de usuarios, credenciales seguras, protección de rutas administrativas y intentos de acceso.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Gestión de contenido general', 'description' => 'Módulos para editar contenido de todas las vistas: Inicio, Nosotros, Servicios, Contacto, FAQ, Testimonios.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de proyectos/galería', 'description' => 'CRUD de proyectos con galería de múltiples imágenes, categorización, ordenamiento y proyectos destacados.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de blog', 'description' => 'CRUD de posts, categorías, etiquetas, borradores y publicación programada.', 'duration_value' => 5, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de testimonios', 'description' => 'Gestión de testimonios: agregar, editar, eliminar, aprobar y ordenar reseñas de clientes.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Gestión de media (imágenes)', 'description' => 'Biblioteca de medios para subir, organizar y seleccionar imágenes con recomendaciones de tamaños optimizados.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de contactos/leads', 'description' => 'Registro y gestión de solicitudes de cotización recibidas desde el formulario de contacto.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Capacitación (sesión remota)', 'description' => 'Sesión de capacitación sobre uso completo del panel: edición de contenido, proyectos, blog, FAQ, testimonios.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Manual de uso (PDF)', 'description' => 'Documento paso a paso con capturas de pantalla para gestionar todo el contenido del sitio.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'QA final del panel', 'description' => 'Pruebas de todos los flujos: editar página, crear proyecto, publicar post, agregar FAQ, gestionar testimonios.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                    ],
                ],
            ];

            foreach ($items as $index => $itemData) {
                $tasks = $itemData['tasks'] ?? [];
                unset($itemData['tasks']);

                $item = $quote->items()->create(array_merge($itemData, [
                    'sort_order' => $index,
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
