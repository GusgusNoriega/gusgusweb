<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DGustoYSaborTiendaPersonalizadosQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Shirley Mosquera - D'gusto y sabor srl)
     * - Lead de empresa (D'gusto y sabor srl)
     * - Cotización en PEN (S/ 4,000 + IGV 18% = S/ 4,720) para nueva tienda online de
     *   productos personalizados (ropa, tazas y otros con diseños personalizados).
     *
     * Ítems:
     *   1. Análisis y Planificación del Proyecto                            S/ 150
     *   2. Diseño UI/UX de la Tienda                                      S/ 250
     *   3. Desarrollo de Homepage (Inicio)                                 S/ 200
     *   4. Desarrollo de Catálogo de Productos                            S/ 250
     *   5. Desarrollo de Ficha de Producto                                 S/ 220
     *   6. Sistema de Personalización de Productos                       S/ 350
     *   7. Desarrollo de Carrito de Compras                              S/ 180
     *   8. Desarrollo de Checkout (Proceso de Compra)                    S/ 220
     *   9. Sistema de Gestión de Pedidos                                  S/ 180
     *  10. Gestión de Usuarios y Cuentas                                  S/ 120
     *  11. Sistema de Descuentos y Promociones                           S/ 100
     *  12. Blog y Gestión de Contenido                                   S/ 120
     *  13. SEO Avanzado (Posicionamiento)                                S/ 250
     *  14. Optimización de Performance                                    S/ 150
     *  15. Panel de Administración + Capacitación + Manual               S/ 200
     *  16. Carga de Productos (100 productos adicionales)                S/ 500
     *  17. Hosting y Dominio (primer año)                                S/ 100
     *                                                          Subtotal: S/ 4,000
     *                                                       IGV (18%):  S/   720
     *                                                            Total:  S/ 4,720
     *
     * Tiempo estimado: 2 meses (8 semanas / 40 días hábiles).
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente
            // =========================
            $clientName    = 'Shirley Mosquera';
            $clientEmail   = 'Shirleymosquera2502@gmail.com';
            $clientPhone   = null;
            $clientAddress = null;

            $companyName     = "D'gusto y sabor srl";
            $companyRuc      = 'IT04487770168';
            $companyIndustry = 'Tienda online de productos personalizados (ropa, tazas, regalos)';

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
                    'project_type' => 'Nueva tienda online de productos personalizados (ropa, tazas, regalos)',
                    'budget_up_to' => 4000,
                    'message'      => "Cotización solicitada para: {$companyName} ({$clientName}). Rubro: {$companyIndustry}. Proyecto: Nueva tienda online completa para venta de productos personalizados (ropa, tazas, accesorios) con sistema de personalización, SEO avanzado, carrito de compras, checkout, panel de administración y 100 productos.",
                    'status'       => 'new',
                    'source'       => 'seed',
                    'notes'        => 'Lead creado automáticamente desde seeder para generar cotización formal de nueva tienda online D\'gusto y sabor - Productos Personalizados.',
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
            $quoteNumber = 'COT-DGUSTO-TIENDA-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id'              => $clientUser->id,
                    'created_by'           => $createdBy?->id,
                    'title'                => "Cotización: Nueva Tienda Online D'gusto y sabor - Productos Personalizados (Ropa, Tazas, Regalos)",
                    'description'          => "Desarrollo de una nueva tienda online completa para {$companyName}.\n\n" .
                        "El proyecto incluye:\n" .
                        "- Tienda online completa para venta de productos personalizados.\n" .
                        "- Catálogo de productos: ropa (camisetas, polos, chamarras), tazas, termos,石碑, accesorios y más.\n" .
                        "- Sistema de personalización de productos: los clientes pueden agregar textos, imágenes y diseños personalizados.\n" .
                        "- Formulario de contacto para solicitudes de personalización detallada.\n" .
                        "- Carrito de compras y proceso de compra completo.\n" .
                        "- SEO avanzado para posicionamiento en buscadores.\n" .
                        "- Panel de administración completo.\n" .
                        "- 100 productos cargados inicialmente.\n\n" .
                        "Vistas del sitio:\n" .
                        "- Homepage (Inicio)\n" .
                        "- Catálogo de Productos\n" .
                        "- Ficha de Producto con Personalización\n" .
                        "- Carrito de Compras\n" .
                        "- Checkout (Proceso de compra)\n" .
                        "- Mi Cuenta / Login\n" .
                        "- Blog\n" .
                        "- Contacto\n\n" .
                        "Funcionalidades principales:\n" .
                        "- Sistema de personalización de productos (textos, imágenes, colores).\n" .
                        "- Formulario de solicitud de personalización detallada.\n" .
                        "- Carrito de compras persistente.\n" .
                        "- Múltiples métodos de pago.\n" .
                        "- Gestión de pedidos y clientes.\n" .
                        "- SEO avanzado con schemas y optimización completa.\n" .
                        "- Panel de administración.\n" .
                        "- Capacitación y manual.\n\n" .
                        "Tiempo estimado de entrega: 2 meses (8 semanas / 40 días hábiles, sin imprevistos y con entrega oportuna de contenido/accesos).",
                    'currency_id'          => $pen->id,
                    'tax_rate'             => 18,
                    'discount_amount'      => 0,
                    'status'               => 'draft',
                    'valid_until'          => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes'                => "Requisitos para iniciar:\n" .
                        "- Definición del nombre de dominio deseado (2-3 opciones).\n" .
                        "- Logo y branding de la empresa.\n" .
                        "- Catálogo de productos a vender (lista con categorías).\n" .
                        "- Imágenes de productos (fotos de productos base sin personalización).\n" .
                        "- Diseños y gráficos para los productos (si se tienen).\n" .
                        "- Información de la empresa: historia, misión, datos de contacto.\n" .
                        "- Referencias de tiendas online de productos personalizados que les gusten.\n" .
                        "- Preferencias de colores y estilo visual.\n\n" .
                        "Entregables:\n" .
                        "- Tienda online completa publicada.\n" .
                        "- Sistema de personalización funcionando.\n" .
                        "- 100 productos cargados.\n" .
                        "- Carrito de compras y checkout funcionando.\n" .
                        "- SEO avanzado implementado.\n" .
                        "- Panel de administración completo.\n" .
                        "- Manual (PDF) + capacitación remota.\n\n" .
                        "Costos adicionales:\n" .
                        "- Hosting y dominio primer año: incluido en esta cotización.\n" .
                        "- Renovación anual de hosting y dominio: aproximadamente S/ 350 anuales.",
                    'terms_conditions'     => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 4,000.00\n" .
                        "- IGV (18%): S/ 720.00\n" .
                        "- Total: S/ 4,720.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto (S/ 2,360.00) / 50% al culminar el proyecto (S/ 2,360.00).\n" .
                        "- Hosting + dominio: se incluye el costo del primer año; renovaciones anuales corren por cuenta del cliente (S/ 350 anuales).\n" .
                        "- Propiedad del código: 100% del código fuente y entregables serán del cliente.\n" .
                        "- Alcance: incluye todas las vistas, sistema de personalización, SEO avanzado, panel admin, capacitación y 100 productos. Cambios fuera del alcance se cotizan por separado.\n" .
                        "- Plazo estimado: 2 meses (8 semanas), sujeto a entrega de información y aprobaciones sin demoras.",
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
                // ─── 1. ANÁLISIS Y PLANIFICACIÓN ────────────────────────
                [
                    'name'        => 'Análisis y Planificación del Proyecto',
                    'description' => 'Análisis detallado del proyecto: estudio de requisitos, análisis de competidores, definición de arquitectura del sitio, planificación de funcionalidades, cronograma detallado, y documentación técnica.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Reunión de kickoff + Levantamiento de requisitos',
                            'description'    => 'Reunión inicial con el cliente para levantar requisitos: objetivos del proyecto, productos a vender, categorías, funcionalidades requeridas, personalización, métodos de pago, envío, timeline esperado, presupuesto.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Análisis de mercado y competidores',
                            'description'    => 'Análisis de tiendas online de productos personalizados en Perú y Latinoamérica: estudio de funcionalidades, precios, UX, fortalezas y debilidades. Identificación de oportunidades差异化.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Definición de arquitectura del sitio',
                            'description'    => 'Definir arquitectura de información: estructura de URLs, jerarquía de categorías,taxonomías de productos, páginas principales, sitemap preliminar.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Elaboración del plan de proyecto',
                            'description'    => 'Crear documento de plan de proyecto: alcance, fases, entregables, cronograma detallado, hitos, responsables, criterios de aceptación.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Documentación técnica',
                            'description'    => 'Documentar especificaciones técnicas: stack tecnológico, integraciones requeridas (pasarelas de pago, envío), requisitos de hosting, seguridad, backup.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 2. DISEÑO UI/UX ────────────────────────────────────
                [
                    'name'        => 'Diseño UI/UX de la Tienda',
                    'description' => 'Diseño de interfaz de usuario y experiencia de usuario: wireframes, mockups, prototipos, guía de estilos, diseño responsive para todos los dispositivos.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 250,
                    'tasks'       => [
                        [
                            'name'           => 'Wireframes de páginas principales',
                            'description'    => 'Crear wireframes de todas las páginas principales: homepage, catálogo, producto, carrito, checkout, mi cuenta, contacto, blog. Estructura de información y layout.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño de mockups de alta fidelidad',
                            'description'    => 'Crear mockups de alta fidelidad para todas las vistas: diseño visual completo, tipografías, colores, espaciados, componentes UI, estados (hover, active, disabled).',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño del sistema de personalización',
                            'description'    => 'Diseñar interfaz del sistema de personalización: selector de colors, upload de imágenes, editor de texto, previsualización en tiempo real del producto personalizado.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Guía de estilos y design system',
                            'description'    => 'Crear guía de estilos: paleta de colores, tipografías, botones, formularios, cards, modales, componentes reutilizables, spacing, iconografía.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Prototipo interactivo',
                            'description'    => 'Crear prototipo interactivo para validar flujos de usuario: navegación, proceso de compra, personalización, checkout. Tests de usabilidad preliminares.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 3. DESARROLLO DE HOMEPAGE ───────────────────────────
                [
                    'name'        => 'Desarrollo de Homepage (Inicio)',
                    'description' => 'Desarrollo de la página de inicio: hero con banners promocionales, productos destacados, categorías principales, newsletter signup, y llamada a la acción.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Maquetación del homepage',
                            'description'    => 'Maquetar homepage: hero con slider de promociones, sección de productos destacados (bestsellers), sección de categorías con imágenes, productos en oferta, newsletter signup, footer.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Componentes dinámicos',
                            'description'    => 'Desarrollar componentes dinámicos: slider de promociones configurable desde admin, productos destacados dinámicos, contador de ofertas, animación de elementos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con catálogo',
                            'description'    => 'Integrar homepage con catálogo de productos: productos destacados, productos nuevos, productos en oferta, categorías principales con enlaces.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización y QA',
                            'description'    => 'Optimizar rendimiento del homepage, pruebas responsive en múltiples dispositivos, verificación de enlaces, pruebas de velocidad.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 4. DESARROLLO DE CATÁLOGO ───────────────────────────
                [
                    'name'        => 'Desarrollo de Catálogo de Productos',
                    'description' => 'Desarrollo del catálogo de productos: listados, categorías, filtros, búsqueda, ordenamiento, paginación.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 250,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura de categorías',
                            'description'    => 'Definir estructura de categorías: categorías principales (Ropa, Tazas, Accesorios), subcategorías, tags, atributos de productos (talla, color, material).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Listado de productos',
                            'description'    => 'Desarrollar listado de productos: grid/listado, paginación o infinite scroll, ordenamiento (precio, nombre, popularidad, newest), visualización de disponibilidad.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de filtros',
                            'description'    => 'Desarrollar filtros avanzados: filtro por categoría, precio, color, talla, material, personalización disponible. Filtros AJAX sin recarga.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Búsqueda de productos',
                            'description'    => 'Desarrollar búsqueda: búsqueda en tiempo real con sugerencias, búsqueda avanzada, búsqueda por SKU, autocompletado.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA del catálogo',
                            'description'    => 'Pruebas completas: navegación, filtros, búsqueda, ordenamiento, paginación, responsive, rendimiento.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 5. DESARROLLO DE FICHA DE PRODUCTO ──────────────────
                [
                    'name'        => 'Desarrollo de Ficha de Producto',
                    'description' => 'Desarrollo de la ficha de producto: galería de imágenes, información del producto, selección de variantes, agregar al carrito, productos relacionados.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 220,
                    'tasks'       => [
                        [
                            'name'           => 'Galería de imágenes',
                            'description'    => 'Desarrollar galería: zoom en hover, slider principal, thumbnails, lightbox, soporte para múltiples imágenes, lazy loading.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Información del producto',
                            'description'    => 'Mostrar información: nombre, precio, precio anterior (si hay oferta), descripción corta, disponibilidad, sku, weighs, dimensiones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Selección de variantes',
                            'description'    => 'Desarrollar selector de variantes: tallas, colores, materiales. Mostrar precio según variante, disponibilidad por variante, actualizar imagen al seleccionar.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Botón agregar al carrito',
                            'description'    => 'Desarrollar botón agregar al carrito: selector de cantidad, validación de stock, feedback visual, agregar con personalización si aplica.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Productos relacionados',
                            'description'    => 'Desarrollar sección de productos relacionados: productos de la misma categoría, "otros clientes también compraron", upsell.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de ficha de producto',
                            'description'    => 'Pruebas: galería, variantes, stock, agregar al carrito, productos relacionados, responsive, rendimiento.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 6. SISTEMA DE PERSONALIZACIÓN ───────────────────────
                [
                    'name'        => 'Sistema de Personalización de Productos',
                    'description' => 'Sistema completo de personalización: editor visual, carga de imágenes, selección de colores, texto personalizado, previsualización en tiempo real, opción de solicitud detallada por formulario.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 350,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura del sistema de personalización',
                            'description'    => 'Diseñar arquitectura: tipos de personalización (texto, imagen, color), niveles de personalización por categoría de producto, guardado de configuraciones.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Editor visual de personalización',
                            'description'    => 'Desarrollar editor visual: canvas interactivo para posicionar texto e imágenes, herramientas (mover, rotar, escalar), selector de fonts y colors, capas.',
                            'duration_value' => 8,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Carga de imágenes del cliente',
                            'description'    => 'Sistema de upload de imágenes: upload de fotos del cliente, recorte de imagen, validación de formato y tamaño, previsualización.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Previsualización en tiempo real',
                            'description'    => 'Desarrollar previsualización: mostrar el producto con la personalización aplicada en tiempo real, renderizado de alta calidad para el pedido final.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Formulario de solicitud de personalización detallada',
                            'description'    => 'Crear formulario de contacto para solicitudes especiales: descripción detallada de la personalización deseada, adjuntar archivos de referencia, campo de comentarios, envío al admin.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Guardado de configuraciones',
                            'description'    => 'Funcionalidad para guardar personalización: guardar diseño en cuenta de usuario, compartir diseño, guardar como borrador para continuar después.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA del sistema de personalización',
                            'description'    => 'Pruebas: editor visual, upload de imágenes, previsualización, guardado, formulario de solicitud, responsive, rendimiento.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 7. DESARROLLO DE CARRITO ─────────────────────────────
                [
                    'name'        => 'Desarrollo de Carrito de Compras',
                    'description' => 'Desarrollo del carrito de compras: visualización de productos, edición de cantidades, eliminación, cálculo de envío, cupones de descuento.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Interfaz del carrito',
                            'description'    => 'Desarrollar interfaz: lista de productos con miniaturas, nombres, precios, personalización aplicada, selector de cantidad, botón eliminar, subtotal, igv, total.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Edición de cantidades',
                            'description'    => 'Funcionalidad de edición: cambiar cantidad directamente en el carrito, recalculo automático de precios, validación de stock, actualización en tiempo real.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Cálculo de envío',
                            'description'    => 'Sistema de cálculo de envío: estimación por zona/peso, mostrar opciones de envío con costos, actualizar total al seleccionar envío.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Cupones de descuento',
                            'description'    => 'Sistema de cupones: aplicar código de descuento, validación de cupón (existencia, validez, mínimo de compra), mostrar descuento aplicado.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Persistencia del carrito',
                            'description'    => 'Guardar carrito: persistencia en localStorage y base de datos para usuarios logueados, recuperar carrito al volver.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA del carrito',
                            'description'    => 'Pruebas: agregar/eliminar productos, cambio de cantidades, cupones, cálculo de envío, persistencia, responsive.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 8. DESARROLLO DE CHECKOUT ────────────────────────────
                [
                    'name'        => 'Desarrollo de Checkout (Proceso de Compra)',
                    'description' => 'Desarrollo del checkout: información de envío, métodos de pago, confirmación del pedido, validación completa.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 220,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño del checkout',
                            'description'    => 'Diseñar checkout optimizado: proceso de una página o multi-paso reducido, resumen del pedido siempre visible, progress indicator.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Información de envío',
                            'description'    => 'Formulario de envío: datos del cliente, dirección de entrega, autocompletado de direcciones, guardar direcciones frecuentes, validación de campos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Métodos de envío',
                            'description'    => 'Opciones de envío: tarifas por zona, opciones de entrega (estándar, express, recojo en tienda), tiempos de entrega estimados.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Métodos de pago',
                            'description'    => 'Integrar métodos de pago: tarjetas de crédito/débito (Stripe/PayU), pagos en efectivo (Pago Efectivo), transferencia bancaria, Yape/Plin.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Confirmación del pedido',
                            'description'    => 'Página de confirmación: resumen del pedido, número de orden, instrucciones de pago, email de confirmación, tracking.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA del checkout',
                            'description'    => 'Pruebas completas: proceso de compra completo, todos los métodos de pago, validaciones, emails, responsive.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 9. SISTEMA DE GESTIÓN DE PEDIDOS ─────────────────────
                [
                    'name'        => 'Sistema de Gestión de Pedidos',
                    'description' => 'Sistema completo de gestión de pedidos: listado, estados, detalles, notas, notificaciones, facturación.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Listado de pedidos',
                            'description'    => 'Desarrollar listado: tabla de pedidos con filtros (fecha, estado, cliente), búsqueda, paginación, exportación a Excel/CSV.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Detalle del pedido',
                            'description'    => 'Ver detalle: productos comprados, personalización aplicada, datos del cliente, dirección, método de pago, historial de estados.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de estados',
                            'description'    => 'Cambiar estados: pendiente, confirmado, en preparación, enviado, entregado, cancelado, reembolso. Notificaciones automáticas al cliente.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Notas internas',
                            'description'    => 'Sistema de notas: notas internas del admin, notas visibles para el cliente, historial de comunicaciones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Facturación',
                            'description'    => 'Sistema de facturas: generación de facturas electrónicas (si aplica), boleta, nota de crédito/débito, datos fiscales configurables.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 10. GESTIÓN DE USUARIOS ──────────────────────────────
                [
                    'name'        => 'Gestión de Usuarios y Cuentas',
                    'description' => 'Sistema de usuarios: registro, login, Mi Cuenta, historial de pedidos, direcciones guardadas, wishlist.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Registro y Login',
                            'description'    => 'Sistema de autenticación: registro con email, login, recuperar contraseña, validación de email, protección de rutas.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Mi Cuenta',
                            'description'    => 'Dashboard de cuenta: overview, información de perfil, cambiar contraseña, configuración de notificaciones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Historial de pedidos',
                            'description'    => 'Ver pedidos: historial de pedidos con estado, возможность de ver detalles, возможность de repetir pedido, descargar facturas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de direcciones',
                            'description'    => 'Direcciones: guardar múltiples direcciones, editar, eliminar, seleccionar dirección predeterminada.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Wishlist',
                            'description'    => 'Lista de deseos: guardar productos para después, mover al carrito, compartir wishlist.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 11. SISTEMA DE DESCUENTOS ────────────────────────────
                [
                    'name'        => 'Sistema de Descuentos y Promociones',
                    'description' => 'Sistema de promociones: cupones, descuentos por cantidad, ofertas especiales, productos en oferta.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Cupones de descuento',
                            'description'    => 'Crear cupones: código, tipo (porcentaje o fijo), valor, mínimo de compra, fecha de validez, uso único/múltiple, productos aplicable.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Ofertas y promociones',
                            'description'    => 'Ofertas: producto en oferta con precio rebajado, promoción por tiempo, oferta de envío gratis, 2x1, descuento por cantidad.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Banner promocional',
                            'description'    => 'Banners: gestionar banners promocionales en homepage, banners emergentes (popup), notificaciones de cookies.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 12. BLOG ─────────────────────────────────────────────
                [
                    'name'        => 'Blog y Gestión de Contenido',
                    'description' => 'Blog para contenido de marketing: artículos sobre productos personalizados, guías, noticias, SEO content.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura del blog',
                            'description'    => 'Definir estructura: categorías de artículos, tags, estructura de URLs amigable para SEO.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Listado de artículos',
                            'description'    => 'Desarrollar blog listing: grid de artículos, filtros por categoría, paginación, buscador, post destacado.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Artículo individual',
                            'description'    => 'Desarrollar post: diseño de lectura, imagen destacada, contenido rico, compartir en redes, artículos relacionados.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión desde admin',
                            'description'    => 'Panel de gestión: CRUD de artículos, editor de contenido, categorías, tags, scheduled publishing.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 13. SEO AVANZADO ─────────────────────────────────────
                [
                    'name'        => 'SEO Avanzado (Posicionamiento)',
                    'description' => 'SEO avanzado completo: investigación de keywords, metadatos, schema markup, sitemap, optimización técnica.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 250,
                    'tasks'       => [
                        [
                            'name'           => 'Investigación de keywords',
                            'description'    => 'Keywords: investigar palabras clave para productos personalizados, ropa personalizada, tazas con foto, regalos corporativos, SEO local.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización on-page',
                            'description'    => 'On-page: metadatos únicos por página, títulos y descriptions optimizados, estructura H1/H2/H3, URLs amigables, canonical tags.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Schema markup',
                            'description'    => 'Schemas: Product, Organization, BreadcrumbList, FAQPage, Article, Review, SearchAction. Validación en Google.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sitemap y robots',
                            'description'    => 'Técnico: sitemap.xml dinámico, robots.txt, configuración en Google Search Console, indexación de imágenes.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SEO local',
                            'description'    => 'Google My Business: perfil de empresa, reseñas, mapas, NAP consistente, schema LocalBusiness.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Contenido SEO',
                            'description'    => 'Contenido: guías de compra, preguntas frecuentes (FAQ),-blog posts optimizados para keywords long-tail.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 14. OPTIMIZACIÓN DE PERFORMANCE ─────────────────────
                [
                    'name'        => 'Optimización de Performance',
                    'description' => 'Optimización de velocidad: Core Web Vitals, optimización de imágenes, caching, minificación.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Auditoría de rendimiento',
                            'description'    => 'Auditoría inicial: PageSpeed Insights, GTmetrix, Lighthouse. Métricas baseline de LCP, FID, CLS.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de imágenes',
                            'description'    => 'Imágenes: WebP, lazy loading, responsive images, optimización de miniaturas, compression.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de assets',
                            'description'    => 'Assets: minificar CSS, JS, HTML, combine files, defer/async scripts, optimize fonts.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Caching y CDN',
                            'description'    => 'Caching: browser caching, server caching, object caching, CDN para estáticos (Cloudflare).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Verificación final',
                            'description'    => 'Pruebas finales: nuevo análisis de rendimiento, comparison, ajustes finales para alcanzar scores > 80 mobile, > 90 desktop.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 15. PANEL DE ADMINISTRACIÓN ─────────────────────────
                [
                    'name'        => 'Panel de Administración + Capacitación + Manual',
                    'description' => 'Panel completo: gestión de productos, pedidos, clientes, inventario, reportes, configuración. Incluye capacitación y manual.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Gestión de productos',
                            'description'    => 'Productos: CRUD completo, bulk import/export, variantes, atributos, categorías, tags, images, SEO fields.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de pedidos',
                            'description'    => 'Pedidos: listado, estados, detalles, notas, facturación, exportación.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de clientes',
                            'description'    => 'Clientes: listado, datos, historial de pedidos, direcciones, status, banned.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de inventario',
                            'description'    => 'Inventario: stock por variante, alertas de stock bajo, control de disponibilidad.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Reportes y analytics',
                            'description'    => 'Reportes: ventas por periodo, productos más vendidos, clientes top, ingresos, reportes exportables.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración general',
                            'description'    => 'Config: tienda (nombre, logo), impuestos, shipping, pagos, email templates, SEO settings.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación + manual',
                            'description'    => 'Capacitación remota (2 horas) + manual PDF completo con capturas de pantalla.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 16. CARGA DE PRODUCTOS ──────────────────────────────
                [
                    'name'        => 'Carga de Productos (100 productos adicionales)',
                    'description' => 'Carga de 100 productos iniciales: imágenes, descripciones, precios, categorías, variantes, personalización habilitada.',
                    'quantity'    => 100,
                    'unit'        => 'producto',
                    'unit_price'  => 5,
                    'tasks'       => [
                        [
                            'name'           => 'Preparación de datos',
                            'description'    => 'Recibir y organizar datos: lista de productos, categorías, precios, descripciones, imágenes del cliente.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Creación de categorías',
                            'description'    => 'Crear estructura: categorías principales y subcategorías, atributos (talla, color, material), tags.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Carga masiva de productos',
                            'description'    => 'Importar productos: CSV o entrada manual de 100 productos con todos los campos.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de imágenes',
                            'description'    => 'Procesar imágenes: redimensionar, comprimir, WebP, lazy loading.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de variantes',
                            'description'    => 'Variantes: crear variantes de cada producto (tallas, colors), precios, stock.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Habilitar personalización',
                            'description'    => 'Configurar personalización: habilitar opción de personalización por producto, definir opciones disponibles.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SEO de productos',
                            'description'    => 'Optimizar SEO: titles, descriptions, URLs, schema product, alt tags.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de productos',
                            'description'    => 'Verificar: todos los productos cargados, imágenes, precios, variantes, stock, personalización, responsive.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 17. HOSTING Y DOMINIO ────────────────────────────────
                [
                    'name'        => 'Hosting y Dominio (primer año)',
                    'description' => 'Hosting y dominio: compra, configuración, SSL, publicación.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Selección y compra',
                            'description'    => 'Seleccionar hosting adecuado para e-commerce, comprar dominio, configurar DNS.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración del servidor',
                            'description'    => 'Configurar: PHP, MySQL, SSL (Let\'s Encrypt), email, firewall.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Publicación',
                            'description'    => 'Deploy: subir archivos, configurar base de datos, testing completo.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pruebas finales',
                            'description'    => 'Verificar: sitio completo, checkout, pagos, emails, SEO, performance.',
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
