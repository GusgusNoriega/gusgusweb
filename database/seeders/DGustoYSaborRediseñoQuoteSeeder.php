<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DGustoYSaborRediseñoQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Shirley Mosquera - D'gusto y sabor srl)
     * - Lead de empresa (D'gusto y sabor srl)
     * - Cotización en PEN (S/ 2,000 + IGV 18% = S/ 2,360) para rediseño completo de tienda online
     *   existente en WordPress, mejora del proceso de compra y migración de productos.
     *
     * Ítems:
     *   1. Rediseño de Homepage (Inicio)                                  S/ 180
     *   2. Rediseño de Página de Categorías                              S/ 150
     *   3. Rediseño de Página de Producto                                S/ 180
     *   4. Rediseño de Carrito de Compras                               S/ 120
     *   5. Rediseño de Checkout (Proceso de compra)                     S/ 180
     *   6. Rediseño de Mi Cuenta / Login                                S/ 100
     *   7. Sistema de Restricción de Países por Producto               S/ 200
     *   8. Visualización de País de Origen en Productos                S/ 120
     *   9. Migración de Productos (130 productos: 30 existentes + 100 nuevos) S/ 400
     *  10. Optimización de Performance y SEO técnico                     S/ 120
     *  11. Panel de Administración + Capacitación + Manual             S/ 150
     *  12. Hosting y Dominio (primer año)                               S/ 100
     *                                                          Subtotal: S/ 2,000
     *                                                       IGV (18%):  S/   360
     *                                                            Total:  S/ 2,360
     *
     * Tiempo estimado: 1 mes y medio (6 semanas / 30 días hábiles).
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
            $companyIndustry = 'Tienda online de productos gourmet';

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
                    'project_type' => 'Rediseño completo de tienda online WordPress + Mejora de compra + 100 productos nuevos',
                    'budget_up_to' => 2000,
                    'message'      => "Cotización solicitada para: {$companyName} ({$clientName}). Rubro: {$companyIndustry}. Proyecto: Rediseño completo del template actual en WordPress (https://dgustoysabor.com/), mejora del proceso de compra, agregar 100 productos nuevos, sistema de restricción de países y visualización de país de origen.",
                    'status'       => 'new',
                    'source'       => 'seed',
                    'notes'        => 'Lead creado automáticamente desde seeder para generar cotización formal de rediseño de tienda online D\'gusto y sabor.',
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
            $quoteNumber = 'COT-DGUSTO-REDISEÑO-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id'              => $clientUser->id,
                    'created_by'           => $createdBy?->id,
                    'title'                => "Cotización: Rediseño Completo de Tienda Online D'gusto y sabor + Mejora de Proceso de Compra + 100 Productos Nuevos",
                    'description'          => "Rediseño completo de la tienda online existente de {$companyName} (actualmente en WordPress).\n\n" .
                        "El proyecto incluye:\n" .
                        "- Rediseño completo del template de todas las vistas del sitio.\n" .
                        "- Mejora del proceso de compra (carrito y checkout optimizado).\n" .
                        "- Migración de 130 productos (30 existentes + 100 productos nuevos).\n" .
                        "- Sistema de restricción de países por producto (configurar en qué países se puede vender cada producto).\n" .
                        "- Visualización del país de origen de los productos.\n\n" .
                        "Vistas a rediseñar:\n" .
                        "- Homepage (Inicio)\n" .
                        "- Página de Categorías\n" .
                        "- Página de Producto\n" .
                        "- Carrito de Compras\n" .
                        "- Checkout (Proceso de compra)\n" .
                        "- Mi Cuenta / Login\n\n" .
                        "Funcionalidades adicionales:\n" .
                        "- Sistema de restricción de países por producto.\n" .
                        "- Visualización de país de origen.\n" .
                        "- Panel de administración para gestionar productos y restricciones.\n" .
                        "- Capacitación y manual de uso.\n\n" .
                        "Tiempo estimado de entrega: 1 mes y medio (6 semanas / 30 días hábiles, sin imprevistos y con entrega oportuna de contenido/accesos).",
                    'currency_id'          => $pen->id,
                    'tax_rate'             => 18,
                    'discount_amount'      => 0,
                    'status'               => 'draft',
                    'valid_until'          => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes'                => "Requisitos para iniciar:\n" .
                        "- Acceso al panel de WordPress actual (admin).\n" .
                        "- Acceso FTP o cPanel del hosting actual.\n" .
                        "- Base de datos actual (export SQL).\n" .
                        "- Lista completa de los 100 productos nuevos a agregar (nombre, descripción, precio, imágenes, país de origen, categorías).\n" .
                        "- Lista de países donde se permitirá la venta de cada producto actual.\n" .
                        "- Logo actualizado y branding actual de la empresa.\n" .
                        "- Referencias de diseño (otras tiendas online de productos gourmet que les gusten).\n" .
                        "- Preferencias de colores y estilo visual.\n\n" .
                        "Entregables:\n" .
                        "- Sitio web rediseñado con nuevo template.\n" .
                        "- Proceso de compra optimizado y mejorado.\n" .
                        "- 130 productos migrados (30 existentes + 100 nuevos).\n" .
                        "- Sistema de restricción de países funcionando.\n" .
                        "- Visualización de país de origen en cada producto.\n" .
                        "- Panel de administración para gestionar productos y restricciones.\n" .
                        "- Manual (PDF) + capacitación remota.\n\n" .
                        "Costos adicionales:\n" .
                        "- Hosting y dominio primer año: incluido en esta cotización.\n" .
                        "- Renovación anual de hosting y dominio: aproximadamente S/ 350 anuales (cargo por cuenta del cliente).",
                    'terms_conditions'     => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 2,000.00\n" .
                        "- IGV (18%): S/ 360.00\n" .
                        "- Total: S/ 2,360.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto (S/ 1,180.00) / 50% al culminar el proyecto y previo a la publicación final (S/ 1,180.00).\n" .
                        "- Hosting + dominio: se incluye la gestión y el costo del primer año dentro de esta cotización; renovaciones anuales posteriores corren por cuenta del cliente (costo estimado S/ 350 anuales según proveedor/plan).\n" .
                        "- Propiedad del código: 100% del código fuente y entregables serán del cliente.\n" .
                        "- Alcance: incluye rediseño de todas las vistas, mejora del proceso de compra, migración de 130 productos, sistema de restricción de países, visualización de país de origen, panel de administración, capacitación y manual. Cambios mayores, nuevas funcionalidades o módulos fuera del alcance se cotizan por separado.\n" .
                        "- Plazo estimado: 1 mes y medio (6 semanas / 30 días hábiles), sujeto a entrega de información de productos y aprobaciones sin demoras.\n" .
                        "- Nota: El sitio actual está en WordPress; el rediseño se realizará sobre la plataforma actual o se migrará a una solución más robusta según evaluación técnica.",
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
            // Ítems de la cotización  (subtotal = S/ 2,000.00)
            // =========================================================
            $items = [
                // ─── 1. REDISEÑO DE HOMEPAGE ─────────────────────────────
                [
                    'name'        => 'Rediseño de Homepage (Inicio)',
                    'description' => 'Rediseño completo de la página de inicio de la tienda online: nuevo layout del hero con banners promocionales, carrusel de productos destacados, sección de categorías principales, productos en oferta, newsletter signup, y footer optimizado. Todo con diseño responsive y coherencia con la nueva identidad visual.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Análisis del sitio actual + Briefing de diseño',
                            'description'    => 'Revisión detallada del sitio actual (https://dgustoysabor.com/), análisis de usabilidad, identificación de puntos de mejora, reunión con el cliente para definir objetivos del rediseño, paleta de colores, estilo visual y referencias.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño UI/UX del Homepage',
                            'description'    => 'Creación de mockups y prototipos del nuevo homepage: hero con slider de promociones, banner principal, sección de productos destacados (bestsellers), sección de categorías con imágenes, newsletter signup, y footer con enlaces útiles. Diseño centrado en conversión y experiencia de usuario.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación responsive + desarrollo',
                            'description'    => 'Implementación del nuevo diseño del homepage: HTML/CSS/JS responsive, integración con el theme de WordPress, optimización de imágenes, animaciones sutiles, y compatibilidad con todos los dispositivos (móvil, tablet, desktop).',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con contenido dinámico',
                            'description'    => 'Conectar homepage con productos dinámicos: productos destacados, productos en oferta, categorías, bestseller. Widgets configurables desde el panel de WordPress.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + ajustes finales',
                            'description'    => 'Pruebas completas en múltiples dispositivos, verificación de enlaces, velocidad de carga, compatibilidad con navegadores, y ajustes visuales finales.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 2. REDISEÑO DE PÁGINA DE CATEGORÍAS ─────────────────
                [
                    'name'        => 'Rediseño de Página de Categorías',
                    'description' => 'Rediseño de las páginas de categorías de productos: nuevo layout de grid/listado, filtros mejorados (por precio, país de origen, disponibilidad), ordenamiento, paginación optimizada, y visualización de cantidad de productos por categoría.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño UI de páginas de categoría',
                            'description'    => 'Diseñar nuevo layout para páginas de categoría: header de categoría con imagen y descripción, opciones de vista (grid/listado), filtros sidebar o top, ordenamiento (precio, nombre, popularidad), paginación o infinite scroll. Mejorar experiencia de navegación.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Implementación de filtros avanzados',
                            'description'    => 'Desarrollar sistema de filtros avanzado: filtro por precio (rango), filtro por país de origen (nuevo), filtro por disponibilidad, filtro por categoría. Filtros AJAX para experiencia sin recarga de página.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación responsive + optimización',
                            'description'    => 'Implementar diseño responsive: filtros adaptables (sidebar en desktop, modal/drawer en móvil), grid de productos adaptable, optimización de rendimiento para listados grandes.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de navegación por categorías',
                            'description'    => 'Pruebas completas: navegación entre categorías, funcionamiento de filtros, ordenamiento, paginación, visualización correcta de productos, responsive en móvil.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 3. REDISEÑO DE PÁGINA DE PRODUCTO ───────────────────
                [
                    'name'        => 'Rediseño de Página de Producto',
                    'description' => 'Rediseño completo de la ficha de producto: nueva galería de imágenes mejorada, información del producto optimizada, visualización del país de origen, selector de cantidad, botón de agregar al carrito prominente, productos relacionados, y reseñas.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño UI/UX de ficha de producto',
                            'description'    => 'Diseñar nueva ficha de producto: galería de imágenes mejorada (zoom, slider, thumbnails), información del producto (nombre, precio, descripción corta/larga), badges (novedad, oferta, país de origen), sección de información adicional (ingredientes, contenido neto), tabs para descripción/reseñas/especificaciones.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Implementación de galería mejorada',
                            'description'    => 'Desarrollar galería de imágenes avanzada: zoom al hover, slider principal con thumbnails, lightbox para vista completa, soporte para múltiples imágenes por producto, lazy loading de imágenes.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sección de compra optimizada',
                            'description'    => 'Implementar sección de compra: selector de cantidad con validaciones, botón de "Agregar al Carrito" prominente y accesible, mostrar disponibilidad en tiempo real, integración con sistema de restricción de países.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Productos relacionados + upsell',
                            'description'    => 'Desarrollar sección de productos relacionados y upsell: mostrar productos relacionados por categoría, "otros clientes también compraron", productos complementarios para aumentar ticket promedio.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de ficha de producto',
                            'description'    => 'Pruebas completas: galería, zoom, información del producto, país de origen visible, proceso de agregar al carrito, productos relacionados, responsive, velocidad de carga.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 4. REDISEÑO DE CARRITO DE COMPRAS ────────────────────
                [
                    'name'        => 'Rediseño de Carrito de Compras',
                    'description' => 'Rediseño del carrito de compras: nuevo layout más limpio y visual, edición de cantidades directamente, eliminación de items, cálculo de envío en tiempo real, cupones de descuento, y resumen claro del pedido.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño UI del carrito',
                            'description'    => 'Diseñar nuevo layout del carrito: lista de productos con miniaturas, nombres, precios, selector de cantidad, botón de eliminar, cálculo automático de subtotal, igv y total, sección de cupón de descuento expandible.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Funcionalidad de edición en carrito',
                            'description'    => 'Desarrollar funcionalidad de edición: actualizar cantidad directamente en el carrito con recalculo automático, eliminar productos, guardar carrito para más tarde (wishlist), validación de stock en tiempo real.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Cálculo de envío + impuestos',
                            'description'    => 'Implementar cálculo de envío: integración con métodos de envío, estimación de costo por zona/peso, cálculo de impuestos por país, mostrar desglose claro de costos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA del carrito de compras',
                            'description'    => 'Pruebas: agregar/eliminar productos, cambio de cantidades, aplicación de cupones, cálculo correcto de totales, proceso de checkout desde el carrito.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 5. REDISEÑO DE CHECKOUT ───────────────────────────────
                [
                    'name'        => 'Rediseño de Checkout (Proceso de Compra)',
                    'description' => 'Rediseño completo del checkout: proceso de compra simplificado y optimizado para reducir abandonos, pasos claros (información de envío, método de pago, confirmación), validación en tiempo real, y resumen del pedido siempre visible.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Análisis y optimización del funnel de compra',
                            'description'    => 'Analizar el funnel de compra actual, identificar puntos de abandono, diseñar proceso optimizado: checkout de una página o multi-paso reducido, reducir campos obligatorios, guest checkout, guardar información para clientes recurrentes.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño UI/UX del checkout',
                            'description'    => 'Diseñar nuevo checkout: diseño limpio y minimalista, pasos claros (Envío > Pago > Confirmación), resumen del pedido siempre visible en sidebar, progress indicator, diseño responsive para móvil.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración de métodos de pago',
                            'description'    => 'Integrar métodos de pago: tarjetas de crédito/débito (Stripe, PayPal u otro), pagos locales (Yape, Plin si aplica), transferencia bancaria. Validaciones de pago en tiempo real.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Campos de envío optimizados + validación',
                            'description'    => 'Optimizar campos de dirección: autocompletado de direcciones, validación de código postal, selección de país con restricción por producto, guardar direcciones frecuentes para usuarios registrados.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA del proceso de checkout',
                            'description'    => 'Pruebas completas: proceso completo de compra, todos los métodos de pago, validación de campos, correos de confirmación, registro de pedido en backend, responsive en móvil.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 6. REDISEÑO DE MI CUENTA / LOGIN ─────────────────────
                [
                    'name'        => 'Rediseño de Mi Cuenta / Login',
                    'description' => 'Rediseño de las páginas de autenticación y cuenta de usuario: login/register optimizado, dashboard de Mi Cuenta con historial de pedidos, dirección guardada, wishlist, y configuración de cuenta.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño de páginas de autenticación',
                            'description'    => 'Diseñar páginas de login y registro: diseño limpio y profesional, opciones de login social (Google, Facebook), recuperar contraseña, registro rápido con email o redes sociales.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño de dashboard Mi Cuenta',
                            'description'    => 'Diseñar dashboard de Mi Cuenta: overview con información de cuenta, historial de pedidos recientes, lista de direcciones guardadas, wishlist, puntos de recompensa (si aplica), configuración de cuenta.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Implementación de funcionalidades',
                            'description'    => 'Desarrollar: proceso de login/register, gestión de direcciones, historial de pedidos con detalles, wishlist, actualizar información de perfil, cambiar contraseña.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de autenticación y cuenta',
                            'description'    => 'Pruebas: registro, login, logout, recuperación de contraseña, dashboard de cuenta, historial de pedidos, gestión de direcciones, responsive.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 7. SISTEMA DE RESTRICCIÓN DE PAÍSES ─────────────────
                [
                    'name'        => 'Sistema de Restricción de Países por Producto',
                    'description' => 'Desarrollo de sistema para restringir la venta de productos por país: cada producto puede configurarse para estar disponible solo en países específicos. El sistema bloqueará la compra si el país del cliente no está permitido para ese producto.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura del sistema de restricciones',
                            'description'    => 'Diseñar estructura de datos: tabla de países disponibles, relación muchos-a-muchos entre productos y países permitidos, lógica de validación en checkout, interfaz en panel admin.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Desarrollo del módulo de gestión',
                            'description'    => 'Desarrollar módulo en panel admin: selector múltiple de países por producto, lista de países predefinida, bulk edit para asignar países a múltiples productos, validación de que al menos un país esté seleccionado.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Lógica de restricción en frontend',
                            'description'    => 'Implementar validación: verificar país del cliente contra productos en el carrito, mostrar mensaje de error si producto no está disponible en su país, sugerir productos alternativos disponibles, bloquear checkout si hay productos no disponibles.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Detección de país del cliente',
                            'description'    => 'Implementar detección automática de país: por IP del cliente, opción manual de cambio de país, guardar preferencia en cookie/sesión, mostrar indicador de país en el sitio.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA del sistema de restricciones',
                            'description'    => 'Pruebas: agregar restricciones a productos, intentar comprar desde país no permitido, checkout bloqueado correctamente, mensajes de error claros, bulk edit funcionando.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 8. VISUALIZACIÓN DE PAÍS DE ORIGEN ───────────────────
                [
                    'name'        => 'Visualización de País de Origen en Productos',
                    'description' => 'Implementación de visualización del país de origen de cada producto: bandera del país, nombre del país visible en la ficha de producto y en el listado, filtros por país de origen, y opción de mostrar "productos de [país]" en el frontend.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Campo de país de origen en productos',
                            'description'    => 'Agregar campo de país de origen en el admin de productos: selector de país con lista completa, bandera representativa, permitir múltiples países de origen si aplica.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Visualización en listing de productos',
                            'description'    => 'Mostrar país de origen en el grid/listado de productos: icono de bandera pequeño junto al nombre, tooltip con nombre del país, filtro por país de origen en sidebar de categorías.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Visualización en ficha de producto',
                            'description'    => 'Mostrar país de origen destacado en la ficha de producto: badge o etiqueta con bandera y nombre del país, sección de "Información de origen" en tabs, destacar país de origen como valor agregado.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Filtro por país de origen',
                            'description'    => 'Implementar filtro por país de origen en sidebar de categorías: lista de países con cantidad de productos, filtro AJAX, integración con sistema de restricción de países.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de país de origen',
                            'description'    => 'Pruebas: campo en admin, visualización en listing, visualización en ficha de producto, filtros, responsive, consistencia visual.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 9. migrACIÓN DE PRODUCTOS ────────────────────────────
                [
                    'name'        => 'Migración de Productos (130 productos: 30 existentes + 100 nuevos)',
                    'description' => 'Migración y carga de 130 productos: 30 productos existentes del sitio actual (con posibles mejoras) + 100 productos nuevos. Incluye creación de categorías, carga de imágenes, descripciones optimizadas para SEO, precios, inventario, país de origen, y restricciones de países.',
                    'quantity'    => 130,
                    'unit'        => 'producto',
                    'unit_price'  => 3.08,
                    'tasks'       => [
                        [
                            'name'           => 'Organización y limpieza de datos existentes',
                            'description'    => 'Revisar los 30 productos existentes: limpiar datos, actualizar precios, verificar imágenes, unificar formatos, preparar para migración al nuevo template.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Recepción y organización de 100 productos nuevos',
                            'description'    => 'Recibir lista de 100 productos nuevos del cliente: nombres, descripciones, precios, categorías, países de origen, imágenes. Organizar datos en spreadsheet para importación masiva.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Creación de categorías y atributos',
                            'description'    => 'Crear/actualizar estructura de categorías: categorías principales y subcategorías, atributos de productos (sabor, presentación, contenido neto), tags para filtrado.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Carga masiva de productos (importación)',
                            'description'    => 'Importación masiva de productos: usar CSV/plugin de importación para cargar los 130 productos con todos los campos (nombre, descripción, precio, categorías, imágenes, país de origen, atributos).',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de imágenes de productos',
                            'description'    => 'Optimizar todas las imágenes de productos: compresión, redimensionamiento al tamaño correcto, formato WebP, lazy loading, calidad consistente.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de precios e inventario',
                            'description'    => 'Configurar precios: precios regulares, precios de oferta si aplica, cálculo de igv, gestión de inventario (stock), alertas de stock bajo.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de país de origen y restricciones',
                            'description'    => 'Para cada producto: seleccionar país de origen, configurar países donde está permitido vender (según sistema de restricción), verificar que los 130 productos estén correctamente configurados.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización SEO de productos',
                            'description'    => 'Optimizar cada producto para SEO: títulos SEO, meta descriptions, URLs amigables, schema markup para productos, atributos alt en imágenes.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA y corrección de errores',
                            'description'    => 'Verificar los 130 productos: revisar que todos los datos estén correctos, imágenes cargadas, precios correctos, categorías asignadas, país de origen visible, restricciones configuradas. Corregir errores encontrados.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 10. OPTIMIZACIÓN DE PERFORMANCE Y SEO ─────────────────
                [
                    'name'        => 'Optimización de Performance y SEO Técnico',
                    'description' => 'Optimización técnica del sitio: velocidad de carga, Core Web Vitals, SEO técnico (metadatos, sitemap, schema), optimización de imágenes, minificación de CSS/JS, y configuración de caching.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Auditoría de performance actual',
                            'description'    => 'Realizar auditoría completa de performance: PageSpeed Insights, GTmetrix, Web Vitals. Identificar cuellos de botella, imágenes pesadas, scripts lentos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de imágenes',
                            'description'    => 'Optimizar todas las imágenes del sitio: compresión WebP, lazy loading, responsive images (srcset), optimización de miniaturas de productos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Minificación y optimización de assets',
                            'description'    => 'Minificar CSS, JavaScript y HTML. Combinar archivos cuando sea posible. Optimizar carga de scripts (defer/async). Configurar caching de navegador.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SEO técnico',
                            'description'    => 'Optimizar SEO técnico: sitemap XML actualizado, robots.txt, metadatos por página, schema markup (Product, Organization, BreadcrumbList), canonical URLs, optimización de Core Web Vitals (LCP, FID, CLS).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de performance post-optimización',
                            'description'    => 'Verificar mejoras: nuevas pruebas de PageSpeed, comparación con métricas iniciales, ajustes finales para alcanzar scores óptimos (mínimo 80 en mobile, 90 en desktop).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 11. PANEL DE ADMINISTRACIÓN ───────────────────────────
                [
                    'name'        => 'Panel de Administración + Capacitación + Manual',
                    'description' => 'Panel de administración para gestionar la tienda: gestión de productos (CRUD), gestión de pedidos, gestión de clientes, configuración de restricciones de países, configuración de métodos de envío y pago, reportes básicos. Incluye capacitación remota y manual de uso.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Configuración de acceso y seguridad',
                            'description'    => 'Configurar acceso seguro al panel: usuarios administradores, roles y permisos, protección de rutas, sesiones seguras, políticas de contraseñas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de productos',
                            'description'    => 'Configurar módulo de gestión de productos: CRUD completo, edición masiva, importación/exportación CSV, gestión de categorías y atributos, país de origen, restricciones de países.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de pedidos',
                            'description'    => 'Configurar gestión de pedidos: listado de pedidos, cambio de estado (pendiente, procesamiento, enviado, entregado, cancelado), detalles del pedido, notas internas, notificaciones al cliente.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de clientes',
                            'description'    => 'Configurar gestión de clientes: listado de clientes registrados, datos de contacto, historial de pedidos, direcciones guardadas, capacidad de banneo si es necesario.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de restricciones de países',
                            'description'    => 'Configurar panel de restricción de países: lista de países disponibles, gestión global de restricciones, herramientas bulk para asignar países a múltiples productos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de envío y pago',
                            'description'    => 'Configurar métodos de envío: zonas de envío, costos por peso/pedido, método de entrega. Configurar métodos de pago: Stripe, PayPal, transferencia, etc.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de contenido estático',
                            'description'    => 'Configurar gestión de páginas: homepage, políticas (privacidad, términos), información de contacto, banner promocional.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación remota + manual de uso',
                            'description'    => 'Sesión de capacitación remota (videoconferencia) sobre uso del panel: gestión de productos, pedidos, clientes, restricciones de países, configuración. Entrega de manual en PDF con capturas y flujos principales. Duración: 1.5-2 horas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA final del panel',
                            'description'    => 'Pruebas completas de todos los módulos: crear/editar/eliminar productos, gestionar pedidos, gestionar clientes, configurar restricciones, métodos de envío/pago. Ajustes finales y corrección de errores.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 12. HOSTING Y DOMINIO ─────────────────────────────────
                [
                    'name'        => 'Hosting y Dominio (primer año)',
                    'description' => 'Gestión de hosting y dominio: configuración del servidor, certificado SSL, migración del sitio (si es necesario), publicación y pruebas finales.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Evaluación del hosting actual + solución',
                            'description'    => 'Evaluar el hosting actual de WordPress: verificar si es adecuado para el rediseño, o si es necesario migrar a un hosting más robusto. Selección de proveedor si es necesario.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de hosting + SSL',
                            'description'    => 'Configurar hosting: creación de cuenta, configuración de PHP/servidor, base de datos, certificado SSL (Let\'s Encrypt), dominio.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Migración del sitio (si aplica)',
                            'description'    => 'Migrar sitio actual al nuevo hosting si es necesario: transferencia de archivos, base de datos, DNS, verificación de funcionamiento.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Publicación + pruebas finales',
                            'description'    => 'Publicar sitio rediseñado: deploy, verificación de todas las funcionalidades, pruebas de rendimiento, testing de compra completa, verificación de SEO.',
                            'duration_value' => 3,
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
