<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NexusEnergiaLandingPageQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Luz)
     * - Lead de empresa (Nexus Energía / RUC: 20604456739)
     * - Cotización en PEN (S/ 1,700 + IGV 18% = S/ 2,006) para una landing page
     *   de servicios de instalación y venta de cámaras de seguridad que incluye:
     *   - Landing Page profesional (S/ 1,300):
     *     - Diseño responsive
     *     - SEO básico
     *     - Formulario de contacto
     *     - Integración con redes sociales
     *   - Campaña Google Ads - Búsqueda (S/ 400):
     *     - Estudio de mercado
     *     - Estudio de palabras clave
     *     - Creación de anuncios
     *     - Configuración de campaña
     * Tiempo máximo: 1 semana (7 días).
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente/empresa
            // =========================
            $clientName = 'Luz';
            $clientEmail = 'nexusenergiagl@gmail.com';
            $clientPhone = '';
            $clientAddress = null;

            $companyName = 'Nexus Energía';
            $companyRuc = '20604456739';
            $companyIndustry = 'Servicios de instalación y venta de cámaras de seguridad';

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
                    'project_type' => 'Landing Page para venta de servicios de cámaras de seguridad + Campaña Google Ads',
                    'budget_up_to' => 2000,
                    'message' => "Cotización solicitada para: {$companyName} (RUC: {$companyRuc}). Rubro: {$companyIndustry}. Plan: Landing Page + Google Ads.",
                    'status' => 'new',
                    'source' => 'seed',
                    'notes' => 'Lead creado automáticamente desde seeder para generar cotización de landing page con campaña publicitaria Google Ads.',
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
            $quoteNumber = 'COT-20604456739-LP-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id' => $clientUser->id,
                    'created_by' => $createdBy?->id,
                    'title' => 'Cotización: Landing Page + Campaña Google Ads (Nexus Energía)',
                    'description' => "Desarrollo de una landing page profesional para {$companyName}, especializada en la venta de servicios de instalación y venta de cámaras de seguridad.\n\n" .
                        "OBJETIVO DE LA LANDING PAGE:\n" .
                        "- Convertir visitantes en clientes potenciales interesados en servicios de cámaras de seguridad.\n" .
                        "- Mostrar servicios de instalación y venta de cámaras de seguridad.\n" .
                        "- Generar cotizaciones y contactos a través de formularios.\n" .
                        "- Incrementar la presencia digital de {$companyName}.\n\n" .
                        "CARACTERÍSTICAS INCLUIDAS:\n" .
                        "- Diseño responsive (móvil/tablet/desktop)\n" .
                        "- SEO básico optimizado para búsquedas locales\n" .
                        "- Formulario de contacto y cotización\n" .
                        "- Integración con redes sociales\n" .
                        "- Diseño profesional enfocado en conversión\n\n" .
                        "TIEMPO ESTIMADO DE ENTREGA: 1 semana (7 días) (sin imprevistos y con entrega oportuna de accesos/contenido).",
                    'currency_id' => $pen->id,
                    'tax_rate' => 18,
                    'discount_amount' => 0,
                    'status' => 'draft',
                    'valid_until' => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes' => "Requisitos para iniciar:\n" .
                        "- Acceso al hosting y dominio existente (el cliente ya cuenta con ambos).\n" .
                        "- Contenido base: textos para la landing page, datos de contacto, imágenes de cámaras de seguridad y trabajos realizados.\n" .
                        "- Lista de servicios a ofrecer (tipos de cámaras, servicios de instalación, mantenimiento, etc.).\n" .
                        "- Información de precios o rangos de precios (opcional).\n" .
                        "- Logos y branding de la empresa.\n" .
                        "- Testimonios de clientes (si existen).\n\n" .
                        "Entregables:\n" .
                        "- Landing page publicada en el hosting existente.\n" .
                        "- Formulario de contacto funcionando.\n" .
                        "- SEO básico configurado.\n" .
                        "- Acceso a panel de gestión si aplica.\n" .
                        "- Manual de uso básico.\n",
                    'terms_conditions' => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 1,700.00\n" .
                        "  • Desarrollo Landing Page: S/ 1,300.00\n" .
                        "  • Campaña Google Ads - Búsqueda: S/ 400.00\n" .
                        "- IGV (18%): S/ 306.00\n" .
                        "- Total: S/ 2,006.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto (S/ 1,003.00) / 50% al culminar el proyecto y previo a la publicación final (S/ 1,003.00).\n" .
                        "- Hosting y dominio: NO INCLUIDO (el cliente ya cuenta con ambos servicios).\n" .
                        "- Propiedad del código y diseños: 100% del código fuente y material gráfico serán del cliente.\n" .
                        "- Alcance: incluye landing page básica y campaña Google Ads básica. Cambios mayores o nuevos módulos fuera del alcance se cotizan por separado.\n" .
                        "- Plazo estimado: 1 semana (7 días), sujeto a entrega de contenido y aprobaciones sin demoras.\n" .
                        "- La campaña Google Ads incluye configuración inicial y creación de anuncios; el presupuesto publicitario ( clicks) no está incluido en esta cotización.\n",
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

            // Total items (subtotal) = 1700.00
            // Desarrollo Landing Page = 1300.00
            // Campaña Google Ads = 400.00
            // IGV (18%) = 306.00
            // Total con IGV = 2006.00
            $items = [
                // =============================================
                // DESARROLLO LANDING PAGE (S/ 1,300)
                // =============================================
                [
                    'name' => 'Desarrollo Landing Page',
                    'description' => "Desarrollo de una landing page profesional para {$companyName}, especializada en servicios de instalación y venta de cámaras de seguridad. Incluye diseño responsive, SEO básico, formulario de contacto y optimización para conversión.",
                    'quantity' => 1,
                    'unit' => 'proyecto',
                    'unit_price' => 1300,
                    'tasks' => [
                        [
                            'name' => 'Reunión de briefing y análisis de requerimientos',
                            'description' => 'Reunión con el cliente para definir objetivos, estructura, contenido, servicios a destacar y público objetivo de la landing page.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Arquitectura y wireframe de la landing page',
                            'description' => 'Definir la estructura de la landing page: secciones, flujo de navegación, ubicación de CTAs y layout orientado a conversión.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Diseño UI/UX de la landing page',
                            'description' => 'Creación del diseño visual profesional: paleta de colores, tipografía, estilo visual orientado al sector de seguridad, mockups de cada sección.',
                            'duration_value' => 6,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Maquetación HTML/CSS responsive',
                            'description' => 'Implementación del diseño en código HTML5, CSS3 y JavaScript.确保完全兼容各种设备和浏览器。',
                            'duration_value' => 8,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Desarrollo de secciones de la landing page',
                            'description' => 'Implementación de todas las secciones: Hero (banner principal), Servicios, Beneficios, Testimonios, FAQ, Galería de trabajos, Contacto, etc.',
                            'duration_value' => 8,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Formulario de contacto y cotización',
                            'description' => 'Creación de formulario personalizado para solicitudes de cotización y contacto. Incluye validaciones, notificación por email y almacenamiento de leads.',
                            'duration_value' => 4,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'SEO básico y optimización',
                            'description' => 'Implementación de meta títulos, descripciones, etiquetas OG,itemap.xml, robots.txt y optimización de contenido para búsquedas locales.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Integración con redes sociales',
                            'description' => 'Añadir enlaces a perfiles de redes sociales de la empresa (Facebook, Instagram, WhatsApp Business) y botones de compartir.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Integración con Google Analytics',
                            'description' => 'Configuración básica de Google Analytics 4 para seguimiento de visitantes, eventos de conversión y Goals.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Pruebas y QA',
                            'description' => 'Verificar funcionamiento en diferentes dispositivos y navegadores,validar formularios, revisar velocidad de carga y enlaces.',
                            'duration_value' => 4,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Publicación en hosting existente',
                            'description' => 'Subir archivos al hosting del cliente, configurar DNS si es necesario, verificar funcionamiento en producción.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Entrega y capacitación básica',
                            'description' => 'Entrega de accesos, manual de uso básico y capacitación sobre cómo actualizar contenido de la landing page.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                    ],
                ],
                // =============================================
                // CAMPAÑA GOOGLE ADS - BÚSQUEDA (S/ 400)
                // =============================================
                [
                    'name' => 'Campaña Google Ads - Búsqueda',
                    'description' => "Configuración completa de campaña publicitaria en Google Ads para {$companyName}. Enfoque en búsqueda para atraer clientes interesados en servicios de instalación y venta de cámaras de seguridad en Perú.",
                    'quantity' => 1,
                    'unit' => 'campaña',
                    'unit_price' => 400,
                    'tasks' => [
                        [
                            'name' => 'Estudio de mercado',
                            'description' => 'Análisis del mercado de cámaras de seguridad en Perú: principales competidores, precios promedio, demanda estacional, tendencias del sector y oportunidades.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Estudio de palabras clave',
                            'description' => 'Investigación detallada de palabras clave relevantes: "cámaras de seguridad", "instalación de cámaras", "cámaras de vigilancia", "sistemas de seguridad", "cctv", etc. Incluye keywords de cola larga y местные búsquedas.',
                            'duration_value' => 4,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Estrategia de campaña',
                            'description' => 'Definir estructura de campañas: audiencias objetivo, ubicación geográfica (Perú), idioma, presupuesto diario, estrategia de puja y objetivos de conversión.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Creación de grupos de anuncios',
                            'description' => 'Organizar grupos de anuncios por categoría de servicio: instalación de cámaras, venta de equipos, mantenimiento, empresas, hogares, etc.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Creación de anuncios',
                            'description' => 'Redactar y diseñar anuncios/textos publicitarios atractiva para cada grupo de anuncios. Incluir extensiones de anuncios: sitelinks, llamadas, ubicación.',
                            'duration_value' => 4,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Configuración de seguimiento de conversiones',
                            'description' => 'Implementar código de seguimiento de conversiones en la landing page para medir Leads, formularios enviados y llamadas.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Configuración de extensiones',
                            'description' => 'Configurar extensiones de anuncios: sitelinks (Servicios, Contacto, Cotización), extensiones de llamada, extensiones de ubicación y fragmentos destacados.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Configuración de remarketing (opcional)',
                            'description' => 'Crear lista de remarketing para visitantes de la landing page y configurar campaña de remarketing básica.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Configuración de red de display (opcional)',
                            'description' => 'Configurar segmentación por audiencias de interés relacionadas con seguridad y tecnología.',
                            'duration_value' => 1,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Documentación y entrega',
                            'description' => 'Entregar documentación completa de la campaña: palabras clave seleccionadas, textos de anuncios, configuración, recomendaciones y guía básica de gestión.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
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

            // Recalcular totales - Forzar carga de items y recálculo
            $quote->load('items');
            $quote->calculateTotals();
            $quote->save();
        });
    }
}
