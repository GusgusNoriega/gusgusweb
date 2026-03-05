<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RomaxTecnologiaStoreQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Jhermosa - Corporación Tecnológica Romax)
     * - Lead de empresa (Corporación Tecnológica Romax)
     * - Cotización en PEN (S/ 4,000 + IGV 18% = S/ 4,720) para tienda virtual de tecnología.
     *
     * Ítems:
     *   1. Análisis y Planificación                                           S/ 150
     *   2. Diseño UI/UX Tienda Online                                       S/ 250
     *   3. Desarrollo Backend Laravel                                       S/ 350
     *   4. Sistema de Gestión de Productos (10,000 productos)             S/ 400
     *   5. Sistema de Categorías y Etiquetas                              S/ 180
     *   6. Catálogo de Productos con Filtros                               S/ 200
     *   7. Ficha de Producto Detallada                                     S/ 150
     *   8. Carrito de Compras                                               S/ 150
     *   9. Checkout y Proceso de Pedido                                    S/ 200
     *  10. Integración de Métodos de Pago                                  S/ 250
     *  11. Sistema de Pedidos y Estados                                     S/ 180
     *  12. Panel de Cliente (Mi Cuenta)                                    S/ 150
     *  13. Panel de Administración Completo                                S/ 300
     *  14. Optimización SEO y Performance                                   S/ 150
     *  15. Capacitación y Manual de Uso                                    S/ 100
     *                                                         Subtotal:  S/ 4,000
     *                                                            IGV:     S/   720
     *                                                            Total:   S/ 4,720
     *
     * Tiempo estimado: 2 meses (8 semanas / 40 días hábiles).
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente
            // =========================
            $clientName    = 'Jhermosa';
            $clientEmail   = 'jhermosa@romaxstore.com';
            $clientPhone   = '+51 992 529 152';
            $clientAddress = null;

            $companyName     = 'Corporación Tecnológica Romax';
            $companyRuc      = '20612400190';
            $companyIndustry = 'Tienda online de productos tecnológicos';

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
                    'project_type' => 'Tienda virtual de tecnología con 10,000 productos en Laravel',
                    'budget_up_to' => 4000,
                    'message'      => "Cotización solicitada para: {$companyName} ({$clientName}). Rubro: {$companyIndustry}. Proyecto: Tienda virtual completa en Laravel para vender productos tecnológicos, con capacidad para 10,000 productos, categorías, etiquetas, carrito de compras, panel de administración, integración de pagos y panel de clientes.",
                    'status'       => 'new',
                    'source'       => 'seed',
                    'notes'        => 'Lead creado automáticamente desde seeder para generar cotización formal de tienda virtual de tecnología para Corporación Tecnológica Romax.',
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
            $quoteNumber = 'COT-ROMAX-TIENDA-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id'              => $clientUser->id,
                    'created_by'           => $createdBy?->id,
                    'title'                => 'Cotización: Tienda Virtual de Tecnología - Corporación Tecnológica Romax (10,000 Productos)',
                    'description'          => "Desarrollo de una tienda virtual completa en Laravel para {$companyName}, especializada en productos tecnológicos.\n\n" .
                        "El proyecto incluye:\n" .
                        "- Plataforma de comercio electrónico robusta y escalable.\n" .
                        "- Capacidad para gestionar hasta 10,000 productos.\n" .
                        "- Sistema completo de categorías y etiquetas.\n" .
                        "- Gestión de fechas de subida/publicación de productos.\n" .
                        "- Carrito de compras funcional.\n" .
                        "- Proceso de checkout optimizado.\n" .
                        "- Integración con métodos de pago.\n" .
                        "- Sistema de pedidos con seguimiento de estados.\n" .
                        "- Panel de administración completo.\n" .
                        "- Panel de cliente para seguimiento de pedidos.\n\n" .
                        "Tiempo estimado de entrega: 2 meses (8 semanas / 40 días hábiles).\n\n" .
                        "Nota: Esta cotización NO incluye hosting ni dominio, ya que el cliente cuenta con estos servicios.",
                    'currency_id'          => $pen->id,
                    'tax_rate'             => 18,
                    'discount_amount'      => 0,
                    'status'               => 'draft',
                    'valid_until'          => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes'                => "Requisitos para iniciar:\n" .
                        "- Acceso al servidor/hosting donde se instalará la tienda.\n" .
                        "- Base de datos MySQL configurada.\n" .
                        "- Lista de productos a cargar (pueden ser en Excel/CSV).\n" .
                        "- Imágenes de productos (nombre de archivo coincidente con SKU).\n" .
                        "- Categorías y subcategorías deseadas.\n" .
                        "- Logo y branding de la empresa.\n" .
                        "- Información de métodos de pago a integrar.\n" .
                        "- Datos de contacto y políticas de la tienda.\n\n" .
                        "Entregables:\n" .
                        "- Tienda virtual completa funcionando.\n" .
                        "- Panel de administración para gestionar productos, pedidos y clientes.\n" .
                        "- Panel de cliente para seguimiento de pedidos.\n" .
                        "- Sistema de carrito y checkout funcional.\n" .
                        "- Integración de métodos de pago configurada.\n" .
                        "- Manual de uso en PDF.\n" .
                        "- Capacitación remota.\n\n" .
                        "Costos adicionales:\n" .
                        "- Hosting y dominio: NO incluidos (el cliente ya cuenta con estos servicios).\n" .
                        "- Mantenimiento posterior: cotizado por separado.",
                    'terms_conditions'     => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 4,000.00\n" .
                        "- IGV (18%): S/ 720.00\n" .
                        "- Total: S/ 4,720.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto (S/ 2,360.00) / 50% al culminar el proyecto y previo a la publicación final (S/ 2,360.00).\n" .
                        "- Hosting y dominio: NO incluidos en esta cotización (el cliente ya cuenta con estos servicios).\n" .
                        "- Propiedad del código: 100% del código fuente y entregables serán del cliente.\n" .
                        "- Alcance: incluye desarrollo completo de la tienda, panel admin, panel cliente, integración de pagos, capacitación y manual. Cambios mayores, nuevas funcionalidades o módulos fuera del alcance se cotizan por separado.\n" .
                        "- Plazo estimado: 2 meses (8 semanas / 40 días hábiles), sujeto a entrega de información y aprobaciones sin demoras.",
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
            // =========================================================
            $items = [
                // ─── 1. ANÁLISIS Y PLANIFICACIÓN ─────────────────────────
                [
                    'name'        => 'Análisis y Planificación',
                    'description' => 'Análisis completo del proyecto y planificación detallada: reunión de requisitos, análisis de competencia en tecnología, definición de estructura de la tienda, planificación de funcionalidades, arquitectura técnica y cronograma de desarrollo.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Reunión de requirements + briefing',
                            'description'    => 'Reunión con el cliente para levantar requisitos: objetivos del proyecto, catálogo de productos tecnológicos, público objetivo, funcionalidades requeridas, competidores principales.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Análisis de mercado tecnológico',
                            'description'    => 'Análisis de tiendas online de tecnología competidoras en Perú y Latinoamérica: estudio de funcionalidades, precios, experiencias de usuario, oportunidades de diferenciación.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Arquitectura de la tienda',
                            'description'    => 'Definir estructura técnica: arquitectura Laravel, base de datos, modelos de datos para productos/categorías/pedidos, sitemap, jerarquía de navegación.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Planificación y cronograma',
                            'description'    => 'Elaborar cronograma del proyecto: fases de desarrollo, entregables, hitos, timeline de 8 semanas, responsables, fechas de revisión.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 2. DISEÑO UI/UX ─────────────────────────────────────
                [
                    'name'        => 'Diseño UI/UX Tienda Online',
                    'description' => 'Diseño de interfaz y experiencia de usuario profesional para tienda tecnológica: mockups, prototipos, guía de estilos moderna, diseño responsive para todos los dispositivos.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 250,
                    'tasks'       => [
                        [
                            'name'           => 'Wireframes de vistas principales',
                            'description'    => 'Crear wireframes de las páginas principales: homepage, catálogo, producto, carrito, checkout, cuenta de usuario, admin.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Mockups de alta fidelidad',
                            'description'    => 'Diseñar mockups visuales completos: tipografías tecnológicas, colores modernos (azules, grises, acentos), componentes UI, estados, animaciones.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Guía de estilos',
                            'description'    => 'Crear guía de estilos: paleta de colores tecnológicos, tipografías, botones, cards de producto, modales, iconografía, badges.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño responsive',
                            'description'    => 'Adaptar diseño para móvil, tablet y desktop: layouts fluidos, navegación móvil, touch-friendly, optimización para conversion.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 3. DESARROLLO BACKEND LARAVEL ────────────────────────
                [
                    'name'        => 'Desarrollo Backend Laravel',
                    'description' => 'Desarrollo del backend completo en Laravel: configuración del proyecto, modelos, migraciones, controladores, rutas, autenticación, API REST para funcionalidades.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 350,
                    'tasks'       => [
                        [
                            'name'           => 'Configuración del proyecto Laravel',
                            'description'    => 'Instalar y configurar Laravel: composer create-project, configuración de entorno, setup de base de datos, dependencias necesarias.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño de base de datos',
                            'description'    => 'Crear migraciones: usuarios, productos, categorías, etiquetas, pedidos, items de pedido, métodos de pago, configuración de tienda.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Modelos y relaciones',
                            'description'    => 'Crear modelos Eloquent: Product, Category, Tag, Order, OrderItem, User, con relaciones (hasMany, belongsTo, many-to-many).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Controladores y rutas',
                            'description'    => 'Crear controladores RESTful: ProductController, CategoryController, OrderController, CartController, con métodos CRUD completos.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de autenticación',
                            'description'    => 'Implementar autenticación: login, registro, logout, recuperación de contraseña, verificación de email, sesiones seguras.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 4. SISTEMA DE GESTIÓN DE PRODUCTOS ─────────────────
                [
                    'name'        => 'Sistema de Gestión de Productos (10,000 productos)',
                    'description' => 'Sistema completo para gestionar gran volumen de productos: CRUD, carga masiva, importación/exportación CSV, gestión de inventario, fechas de publicación, atributos.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 400,
                    'tasks'       => [
                        [
                            'name'           => 'CRUD de productos',
                            'description'    => 'Crear sistema completo: crear, editar, eliminar productos con todos los campos (nombre, descripción, precio, SKU, stock, imágenes, especificaciones técnicas).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de inventario',
                            'description'    => 'Sistema de stock: control de inventario, alertas de stock bajo, reserva de stock en carrito, actualización automática de disponibilidad.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Fechas de publicación',
                            'description'    => 'Sistema de scheduling: fecha de publicación, fecha de vencimiento de oferta, productos programados, visibilidad por fecha.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Carga masiva de productos',
                            'description'    => 'Importación masiva: subir productos desde Excel/CSV, validación de datos, mapeo de campos, carga de imágenes por SKU.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de imágenes',
                            'description'    => 'Subir y gestionar imágenes: múltiples imágenes por producto, reorder, galería, compresión automática, generación de thumbnails.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización para 10,000 productos',
                            'description'    => 'Optimización de rendimiento: paginación eficiente, lazy loading, caché de consultas, índices en base de datos para velocidad.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 5. SISTEMA DE CATEGORÍAS Y ETIQUETAS ────────────────
                [
                    'name'        => 'Sistema de Categorías y Etiquetas',
                    'description' => 'Sistema de organización de productos: categorías jerárquicas, subcategorías, etiquetas/tags, filtros, breadcrumbs, SEO para categorías.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Gestión de categorías',
                            'description'    => 'CRUD de categorías: crear, editar, eliminar, reordenar, categorías padre/hijo (jerarquía), imágenes de categoría.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de etiquetas',
                            'description'    => 'Sistema de tags: crear, editar, eliminar etiquetas, asignar múltiples etiquetas a productos, nube de etiquetas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Filtros en catálogo',
                            'description'    => 'Implementar filtros: por categoría, precio, marca, especificaciones técnicas, etiquetas. Filtros AJAX sin recarga.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Breadcrumbs y navegación',
                            'description'    => 'Sistema de migas de pan: navegación jerárquica, breadcrumbs dinámicos, mejora de SEO.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 6. CATÁLOGO DE PRODUCTOS ────────────────────────────
                [
                    'name'        => 'Catálogo de Productos con Filtros',
                    'description' => 'Desarrollo del catálogo público: grid/listado de productos, paginación, ordenamiento, filtros avanzados, búsqueda, optimización SEO.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Listado de productos',
                            'description'    => 'Desarrollar vista de catálogo: grid de productos con imágenes, nombres, precios, badges (novedad, oferta), paginación optimizada.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de filtros',
                            'description'    => 'Filtros avanzados: por categoría, precio (rango), marca, disponibilidad, etiquetas. Actualización en tiempo real AJAX.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Búsqueda de productos',
                            'description'    => 'Sistema de búsqueda: búsqueda por nombre, SKU, descripción, autocompletado, búsqueda avanzada con filtros.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Ordenamiento',
                            'description'    => 'Opciones de ordenamiento: precio menor/mayor, más recientes, más vendidos, nombre A-Z. Sin recarga de página.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SEO del catálogo',
                            'description'    => 'Optimización SEO: metadatos dinámicos por categoría, URLs amigables, schema markup, sitemap.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 7. FICHA DE PRODUCTO ─────────────────────────────────
                [
                    'name'        => 'Ficha de Producto Detallada',
                    'description' => 'Desarrollo de página de detalle de producto: galería de imágenes, información completa, especificaciones técnicas, productos relacionados, reseñas.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Galería de imágenes',
                            'description'    => 'Desarrollar galería: zoom al hacer hover, slider principal, thumbnails, lightbox para vista completa, múltiples imágenes.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Información del producto',
                            'description'    => 'Mostrar información: nombre, precio, precio anterior (si hay oferta), SKU, disponibilidad, selector de cantidad, botón agregar al carrito.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Especificaciones técnicas',
                            'description'    => 'Sección de specs: tabla de especificaciones técnicas, características del producto, información adicional en tabs.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Productos relacionados',
                            'description'    => 'Mostrar relacionados: productos de la misma categoría, productos complementarios, "otros clientes también compraron".',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 8. CARRITO DE COMPRAS ────────────────────────────────
                [
                    'name'        => 'Carrito de Compras',
                    'description' => 'Sistema de carrito de compras funcional: agregar productos, actualizar cantidades, eliminar items, cálculo de totales, persistencia de sesión.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Funcionalidad del carrito',
                            'description'    => 'Desarrollar carrito: agregar producto con cantidad, actualizar cantidad, eliminar items, guardar en sesión/base de datos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Cálculo de totales',
                            'description'    => 'Cálculos: subtotal, IGV, descuento por cupón, costo de envío (estimado), total. Actualización en tiempo real.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Validaciones',
                            'description'    => 'Validar disponibilidad: verificar stock al agregar, advertencia si producto ya no disponible,提示 para productos fuera de stock.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Carrito sidebar/header',
                            'description'    => 'Mini carrito: mostrar en header/sidebar, actualizar sin recarga, acceso rápido al carrito completo.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 9. CHECKOUT Y PROCESO DE PEDIDO ─────────────────────
                [
                    'name'        => 'Checkout y Proceso de Pedido',
                    'description' => 'Desarrollo del proceso de checkout: información de envío, datos de facturación, revisión del pedido, confirmación, generación de orden.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Flujo de checkout',
                            'description'    => 'Diseñar checkout: pasos claros (envío > pago > confirmación), diseño limpio, resumen del pedido siempre visible.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Información de envío',
                            'description'    => 'Formulario de envío: datos del cliente, dirección de entrega, validación de campos, guardar dirección para futuras compras.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Datos de facturación',
                            'description'    => 'Datos de facturación: opción de factura/boleta, datos fiscales (RUC, razón social), validación de RUC.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Revisión y confirmación',
                            'description'    => 'Revisión del pedido: mostrar todos los items, totales, datos de envío, opción de aplicar cupón de descuento.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Generación de orden',
                            'description'    => 'Crear orden: guardar pedido en base de datos, generar número de pedido, enviar email de confirmación.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 10. INTEGRACIÓN DE MÉTODOS DE PAGO ─────────────────
                [
                    'name'        => 'Integración de Métodos de Pago',
                    'description' => 'Integración con pasarelas de pago: tarjetas de crédito/débito, pagos en efectivo, transferencias bancarias. Configuración de webhook.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 250,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura de pagos',
                            'description'    => 'Diseñar sistema: abstracción de pasarelas de pago, estructura modular para agregar más métodos, configuración flexible.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración Stripe/PayPal',
                            'description'    => 'Integrar Stripe o PayPal: SDK, checkout, procesamiento de tarjetas, manejo de respuestas, webhooks, refunds.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pagos locales',
                            'description'    => 'Integrar pagos locales: Yape, Plin, transferencia bancaria, depósito. Mostrar instrucciones de pago.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Webhooks y notificaciones',
                            'description'    => 'Sistema de webhooks: recibir notificaciones de pago, actualizar estado del pedido automáticamente, emails de confirmación.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pruebas de pago',
                            'description'    => 'Testing: pruebas en sandbox/modo prueba, verificar flujos completos, manejo de errores, confirmaciones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 11. SISTEMA DE PEDIDOS Y ESTADOS ───────────────────
                [
                    'name'        => 'Sistema de Pedidos y Estados',
                    'description' => 'Sistema completo de gestión de pedidos: estados del pedido, seguimiento, notificaciones, historial, gestión desde admin.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Estados de pedido',
                            'description'    => 'Definir estados: pendiente, pagado, en preparación, enviado, entregado, cancelado, reembolso. Workflow de estados.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Seguimiento de pedido',
                            'description'    => 'Sistema de tracking: mostrar estado actual, historial de cambios, timeline visual, notificaciones por email.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión en admin',
                            'description'    => 'Panel admin: ver pedidos, cambiar estado, agregar notas, ver detalles completos, exportar a Excel/CSV.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Notificaciones',
                            'description'    => 'Sistema de emails: confirmación de pedido, cambio de estado, notificación de envío, entregado.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 12. PANEL DE CLIENTE ─────────────────────────────────
                [
                    'name'        => 'Panel de Cliente (Mi Cuenta)',
                    'description' => 'Panel de cuenta de cliente: registro/login, historial de pedidos, seguimiento de pedidos, direcciones guardadas, datos de perfil.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Autenticación de clientes',
                            'description'    => 'Sistema de auth: registro, login, logout, recuperación de contraseña, verificación de email.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Dashboard del cliente',
                            'description'    => 'Mi cuenta: overview con información de perfil, pedidos recientes, direcciones guardadas, puntos de recompensa (si aplica).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Historial de pedidos',
                            'description'    => 'Ver pedidos: lista de pedidos con estado, detalles de cada pedido, descargar factura/boleta, realizar-devolución.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de direcciones',
                            'description'    => 'Direcciones: guardar múltiples direcciones, editar, eliminar, seleccionar dirección predeterminada.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Datos de perfil',
                            'description'    => 'Editar perfil: actualizar nombre, email, teléfono, cambiar contraseña, preferencias.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 13. PANEL DE ADMINISTRACIÓN ──────────────────────────
                [
                    'name'        => 'Panel de Administración Completo',
                    'description' => 'Panel administrativo completo: gestión de productos, pedidos, clientes, categorías, reportes, configuración de la tienda.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 300,
                    'tasks'       => [
                        [
                            'name'           => 'Gestión de productos',
                            'description'    => 'CRUD completo productos: crear, editar, eliminar, bulk actions, búsqueda avanzada, filtros, importar/exportar.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de pedidos',
                            'description'    => 'Gestión de pedidos: ver todos, filtrar por estado/fecha/cliente, cambiar estado, agregar notas internas, exportar.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de clientes',
                            'description'    => 'CRUD de clientes: ver clientes registrados, datos de contacto, historial de pedidos, bloquear clientes.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de categorías y etiquetas',
                            'description'    => 'Administrar taxonomy: crear, editar, eliminar categorías y etiquetas, reordenar, jerarquía.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Cupones y descuentos',
                            'description'    => 'Sistema de cupones: crear cupones (porcentaje, monto fijo), validar uso, limitar usos, fecha de vigencia.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Reportes básicos',
                            'description'    => 'Dashboard con métricas: pedidos hoy, ingresos, productos más vendidos, pedidos por estado, gráficos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de tienda',
                            'description'    => 'Configuración: datos de empresa, políticas (términos, privacidad), zonas de envío, métodos de pago activos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 14. OPTIMIZACIÓN SEO Y PERFORMANCE ───────────────────
                [
                    'name'        => 'Optimización SEO y Performance',
                    'description' => 'Optimización técnica: velocidad de carga, Core Web Vitals, SEO técnico, schema markup, optimización de imágenes.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Auditoría de performance',
                            'description'    => 'Medir rendimiento actual: PageSpeed Insights, GTmetrix, Lighthouse, identificar problemas de velocidad.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de imágenes',
                            'description'    => 'Compresión: imágenes WebP, lazy loading, responsive images, optimización de miniaturas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Caché y optimización',
                            'description'    => 'Configurar caché: Laravel cache, route cache, config cache, minificación de assets.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SEO técnico',
                            'description'    => 'Optimización SEO: sitemap XML, robots.txt, metadatos dinámicos, schema Product/Organization/BreadcrumbList.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 15. CAPACITACIÓN Y MANUAL ───────────────────────────
                [
                    'name'        => 'Capacitación y Manual de Uso',
                    'description' => 'Capacitación remota y manual de usuario: uso del panel admin, gestión de productos, pedidos, configuración. Manual en PDF.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Manual de usuario PDF',
                            'description'    => 'Crear manual: documentación completa con capturas de pantalla, guías paso a paso para cada sección del admin.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación remota',
                            'description'    => 'Sesión de capacitación: vía videollamada, explicar uso del panel, gestión de productos, pedidos, preguntas. Duración 1.5-2 horas.',
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
