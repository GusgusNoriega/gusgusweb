<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CVGCorredoresSegurosQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Olenka Campos - CVG Corredores de Seguros)
     * - Lead de empresa (CVG Corredores de Seguros)
     * - Cotización en PEN (S/ 1,700 + IGV 18% = S/ 2,006) para Landing Page + Google Ads + Panel de Leads.
     *
     * Ítems:
     *   1. Estudio de Mercado                                                     S/ 150
     *   2. Estudio de Palabras Clave (Keywords)                                  S/ 120
     *   3. Diseño UI/UX de Landing Page                                          S/ 180
     *   4. Desarrollo: Sección Hero + Propuesta de Valor                        S/ 100
     *   5. Desarrollo: Sección de Servicios de Seguro                           S/ 120
     *   6. Desarrollo: Sección ¿Por Qué Elegirnos?                               S/  80
     *   7. Desarrollo: Sección de Testimonios                                    S/  80
     *   8. Desarrollo: Sección de Preguntas Frecuentes (FAQ)                    S/  60
     *   9. Desarrollo: Sección de Contacto + Formulario de Cotización           S/ 150
     *  10. Sistema de WhatsApp Flotante                                          S/  60
     *  11. Formulario de Captación de Leads                                      S/ 100
     *  12. Panel de Administración de Leads                                      S/ 150
     *  13. Integración con Google Analytics + Pixel de Seguimiento              S/  80
     *  14. Configuración de Google Ads (Campaña de Búsqueda)                    S/ 400
     *  15. SEO Técnico + Optimización                                            S/ 100
     *  16. Pruebas de Calidad (QA) + Ajustes Finales                            S/  70
     *                                                          Subtotal: S/ 1,700
     *                                                            IGV:    S/   306
     *                                                            Total:  S/ 2,006
     *
     * Tiempo estimado: 3 semanas (15 días hábiles).
     * Nota: El cliente ya cuenta con hosting y dominio propios.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente
            // =========================
            $clientName    = 'Olenka Campos';
            $clientEmail   = 'olenkacampos@cvgacorredoresdeseguros.com';
            $clientPhone   = null;
            $clientAddress = null;

            $companyName     = 'CVG Corredores de Seguros';
            $companyRuc      = '10708492413';
            $companyIndustry = 'Corredor de Seguros / Broker de Seguros';

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
                    'project_type' => 'Landing Page + Google Ads + Panel de Administración de Leads para corredora de seguros',
                    'budget_up_to' => 1700,
                    'message'      => "Cotización solicitada para: {$companyName} ({$clientName}). Rubro: {$companyIndustry}. Proyecto: Landing page profesional para captación de clientes de seguros, campaña publicitaria en Google Ads con configuración completa, y panel de administración para gestión de leads.",
                    'status'       => 'new',
                    'source'       => 'seed',
                    'notes'        => 'Lead creado automáticamente desde seeder para generar cotización formal de landing page + Google Ads para CVG Corredores de Seguros.',
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
            $quoteNumber = 'COT-CVG-SEGUROS-LP-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id'              => $clientUser->id,
                    'created_by'           => $createdBy?->id,
                    'title'                => 'Cotización: Landing Page + Google Ads + Panel de Leads - CVG Corredores de Seguros',
                    'description'          => "Desarrollo de una landing page profesional para {$companyName}, corredora de seguros especializada en ofrecer asesoría y gestión de seguros para personas y empresas.\n\n" .
                        "El proyecto incluye:\n" .
                        "- Landing page de alta conversión diseñada para el sector de seguros.\n" .
                        "- Estudio de mercado específico para el sector asegurador en Perú.\n" .
                        "- Estudio de palabras clave para posicionamiento SEO y campañas paid.\n" .
                        "- Diseño UI/UX profesional y moderno adaptado al sector financiero/seguros.\n" .
                        "- Formulario de cotización de seguros para captación de leads.\n" .
                        "- Sistema de WhatsApp flotante para contacto directo.\n" .
                        "- Panel de administración para gestionar leads y seguimientos.\n" .
                        "- Integración con Google Analytics y Pixel de seguimiento.\n" .
                        "- Configuración completa de campaña de Google Ads (búsqueda).\n" .
                        "- SEO técnico optimizado para atraer tráfico orgánico.\n" .
                        "- Configuración en el hosting y dominio existentes del cliente.\n\n" .
                        "Secciones de la Landing Page:\n" .
                        "1. Hero (Inicio) - Banner principal con propuesta de valor\n" .
                        "2. Servicios de Seguros (Vida, Salud, Vehicular, Empresas, etc.)\n" .
                        "¿Por Qué Elegirnos? - Beneficios y diferenciales\n" .
                        "3. Testimonios de clientes\n" .
                        "4. Preguntas Frecuentes (FAQ)\n" .
                        "5. Formulario de Cotización / Contacto\n" .
                        "6. Footer con información de contacto\n\n" .
                        "Tiempo estimado de entrega: 3 semanas (15 días hábiles).",
                    'currency_id'          => $pen->id,
                    'tax_rate'             => 18,
                    'discount_amount'      => 0,
                    'status'               => 'draft',
                    'valid_until'          => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes'                => "Requisitos para iniciar:\n" .
                        "- Acceso al panel de hosting (cPanel o similar) para configuración.\n" .
                        "- Acceso al dominio o configuración de DNS.\n" .
                        "- Acceso a Google Ads (cuenta existente o crear nueva).\n" .
                        "- Acceso a Google Analytics (si lo tienen configurado).\n" .
                        "- Logo de la empresa en alta resolución.\n" .
                        "- Información de los servicios de seguros que ofrecen.\n" .
                        "- Datos de contacto: teléfonos, correo, dirección, horarios.\n" .
                        "- Testimonios de clientes actuales (si los hay).\n" .
                        "- Referencias de diseño (otras landing pages de seguros que les gusten).\n" .
                        "- Presupuesto mensual deseado para Google Ads.\n\n" .
                        "Entregables:\n" .
                        "- Landing page publicada y funcionando.\n" .
                        "- Todas las secciones desarrolladas y configuradas.\n" .
                        "- Formulario de cotización funcionando.\n" .
                        "- Sistema de leads capturando en base de datos.\n" .
                        "- Panel de administración de leads.\n" .
                        "- WhatsApp flotante configurado.\n" .
                        "- Google Ads configurado con campaña de búsqueda.\n" .
                        "- Google Analytics y Pixel de seguimiento integrados.\n" .
                        "- SEO técnico implementado.\n" .
                        "- Manual PDF de uso + capacitación remota.\n\n" .
                        "Costos adicionales:\n" .
                        "- Hosting y dominio: El cliente ya cuenta con ellos (no incluido en esta cotización).\n" .
                        "- Mantenimiento mensual: No incluido.\n" .
                        "- Campañas Google Ads: El presupuesto de medios es adicional a esta cotización.",
                    'terms_conditions'     => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 1,700.00\n" .
                        "- IGV (18%): S/ 306.00\n" .
                        "- Total: S/ 2,006.00\n" .
                        "- Forma de pago: 50% al iniciar (S/ 1,003.00) / 50% al culminar (S/ 1,003.00).\n" .
                        "- Hosting y dominio: No incluido (el cliente ya cuenta con ellos).\n" .
                        "- Propiedad del código: 100% del código fuente y entregables serán del cliente.\n" .
                        "- Alcance: Landing page completa, estudio de mercado, estudio de keywords, formulario de leads, panel admin, WhatsApp, Google Analytics, Google Ads configurado, SEO técnico, capacitación y manual.\n" .
                        "- Plazo: 3 semanas (15 días hábiles).",
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
                // ─── 1. ESTUDIO DE MERCADO ────────────────────────────────────────
                [
                    'name'        => 'Estudio de Mercado',
                    'description' => 'Análisis completo del mercado de seguros en Perú: investigación de competencia, identificación de público objetivo, análisis de tendencias del sector asegurador, estudio de necesidades de clientes potenciales (personas y empresas), y definición de propuesta de valor diferenciada para CVG Corredores de Seguros.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Análisis del sector de seguros en Perú',
                            'description'    => 'Investigar el mercado de seguros en Perú: principales competidores, tipos de seguros más demandados (vida, salud, vehicular, empresas), regulaciones, tendencias del sector.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Investigación de competidores',
                            'description'    => 'Analizar a los principales corredores de seguros en Perú y la región: estudiar sus páginas web, estrategias de captación, propuestas de valor, precios, fortalezas y debilidades.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Definición de público objetivo',
                            'description'    => 'Identificar y definir los perfiles de clientes ideales: personas (edad, ingresos, necesidades) y empresas (tamaño, sectores) a los que CVG debe dirigirse.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Análisis de necesidades de clientes',
                            'description'    => 'Estudiar las necesidades y dolores de los clientes potenciales: qué buscan en un corredor de seguros, qué valoran, qué los hace decidir.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Propuesta de valor diferenciada',
                            'description'    => 'Definir la propuesta de valor única de CVG: qué lo diferencia de la competencia, cuáles son sus fortalezas clave, cómo comunicar su diferenciación.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Informe de estudio de mercado',
                            'description'    => 'Elaborar informe completo con hallazgos, recomendaciones estratégicas, oportunidades identificadas y sugerencias para la landing page.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 2. ESTUDIO DE PALABRAS CLAVE ────────────────────────────────
                [
                    'name'        => 'Estudio de Palabras Clave (Keywords)',
                    'description' => 'Investigación detallada de palabras clave para SEO y campañas de Google Ads: identificación de términos de búsqueda más relevantes para el sector de seguros, análisis de volumen de búsquedas, competencia y costo por clic estimado, y selección de keywords estratégicas.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Brainstorming de keywords del sector',
                            'description'    => 'Generar lista inicial de palabras clave relacionadas con seguros: seguros de vida, seguro de salud, seguro vehicular, seguro de empresas, corredor de seguros, cotización de seguros, etc.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Análisis de volumen y competencia',
                            'description'    => 'Investigar volumen de búsquedas estimado y nivel de competencia para cada keyword: usar herramientas de SEO, analizar CPC estimado para Google Ads.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Selección de keywords principales',
                            'description'    => 'Seleccionar las keywords principales y secundarias: categorizar por intención de búsqueda (informacional, transaccional, comercial).',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Keywords para SEO',
                            'description'    => 'Definir keywords para optimización SEO de la landing page: meta tags, contenido, URLs, estructura de encabezados.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Keywords para Google Ads',
                            'description'    => 'Seleccionar keywords para campaña de Google Ads: grupos de anuncios, palabras clave de concordancia amplia, exacta y de frase.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Informe de keywords',
                            'description'    => 'Crear informe detallado con keywords seleccionadas, volumen estimado, competencia, CPC estimado y recomendaciones de uso.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 3. DISEÑO UI/UX ─────────────────────────────────────────────
                [
                    'name'        => 'Diseño UI/UX de Landing Page',
                    'description' => 'Diseño de interfaz y experiencia de usuario profesional: wireframes, mockups de alta fidelidad, guía de estilos visuales para el sector financiero/seguros, diseño responsive para todos los dispositivos.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 180,
                    'tasks'       => [
                        [
                            'name'           => 'Análisis de requisitos + briefing',
                            'description'    => 'Reunión con el cliente para definir objetivos: servicios de seguros a destacar, público objetivo, funcionalidades requeridas, referencias visuales.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Wireframes de la landing page',
                            'description'    => 'Crear wireframes de todas las secciones: estructura de información, layout, distribución de contenido, flujo de conversión.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño de paleta de colores',
                            'description'    => 'Definir paleta de colores profesional para el sector seguros: colores que transmitan confianza, seguridad, profesionalismo (azules, grises, dorados).',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Mockups de alta fidelidad',
                            'description'    => 'Diseñar mockups visuales completos: tipografías profesionales, componentes UI, estados, animaciones sutiles, coherencia visual.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño responsive',
                            'description'    => 'Adaptar diseño para móvil, tablet y desktop: layouts fluidos, navegación móvil optimizada, touch-friendly.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Guía de estilos',
                            'description'    => 'Crear guía de estilos: paleta de colores, tipografías, botones, formularios, iconografía, spacing, componentes reutilizables.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 4. DESARROLLO: HERO + PROPUESTA DE VALOR ──────────────────
                [
                    'name'        => 'Desarrollo: Sección Hero + Propuesta de Valor',
                    'description' => 'Desarrollo de la sección principal (hero) y propuesta de valor: banner principal con llamada a la acción, headline impactante, subtítulo, formulario de cotización rápida visible, y sección de propuesta de valor con beneficios clave.',
                    'quantity'    => 1,
                    'unit'        => 'sección',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Maquetación del hero',
                            'description'    => 'Crear estructura HTML/CSS del hero: banner con imagen de fondo profesional (oficina, familia protegida, negocio), headline principal, subtítulo explicativo.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Formulario de cotización rápida',
                            'description'    => 'Desarrollar formulario de cotización en el hero: campos básicos (nombre, email, teléfono, tipo de seguro), botón de envío, validación de datos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sección de propuesta de valor',
                            'description'    => 'Crear sección de beneficios: iconos con textos de valor (asesoría personalizada, múltiples compañías, mejores precios, atención 24/7).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Animaciones y efectos',
                            'description'    => 'Agregar animaciones sutiles: entrada de elementos, hover effects, transiciones suaves para una experiencia moderna.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización y QA',
                            'description'    => 'Verificar rendimiento, responsividad, velocidad de carga, funcionamiento correcto en todos los dispositivos.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 5. DESARROLLO: SERVICIOS DE SEGURO ─────────────────────────
                [
                    'name'        => 'Desarrollo: Sección de Servicios de Seguro',
                    'description' => 'Desarrollo de la sección de servicios: presentación de los diferentes tipos de seguros que ofrece CVG (vida, salud, vehicular, empresas, hogar, etc.) con tarjetas visuales, información breve y llamada a la acción.',
                    'quantity'    => 1,
                    'unit'        => 'sección',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura de servicios',
                            'description'    => 'Definir estructura de servicios: tipos de seguros a mostrar (vida, salud, vehicular, empresas, hogar, viajes), información a incluir por cada uno.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño de cards de servicios',
                            'description'    => 'Crear diseño de tarjetas para cada servicio: icono representativo, título, descripción breve, botón de "Más información" o "Cotizar".',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Implementación responsive',
                            'description'    => 'Desarrollar grid de servicios: adaptación a móvil (stack vertical), tablet y desktop (grid de 2-3 columnas).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con formulario',
                            'description'    => 'Conectar cada servicio con el formulario de cotización: al hacer clic en "Cotizar" de un servicio, se abre el formulario con ese tipo de seguro preseleccionado.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de sección de servicios',
                            'description'    => 'Verificar responsividad, funcionamiento de enlaces, velocidad, consistencia visual.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 6. DESARROLLO: ¿POR QUÉ ELEGIRNOS? ─────────────────────────
                [
                    'name'        => 'Desarrollo: Sección ¿Por Qué Elegirnos?',
                    'description' => 'Desarrollo de sección de diferenciación: presentación de las razones por las que los clientes deben elegir CVG Corredores de Seguros (experiencia, cobertura, atención personalizada, etc.).',
                    'quantity'    => 1,
                    'unit'        => 'sección',
                    'unit_price'  => 80,
                    'tasks'       => [
                        [
                            'name'           => 'Estructura de contenido',
                            'description'    => 'Definir los beneficios/diferenciales a destacar: años de experiencia, múltiples aseguradoras, ahorro de tiempo y dinero, atención personalizada, respaldo legal.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño visual',
                            'description'    => 'Crear layout de sección: iconos representativos para cada beneficio, textos cortos e impactantes, diseño atractivo y profesional.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Implementación responsive',
                            'description'    => 'Desarrollar sección adaptativa: grid de beneficios que se adapta a móvil, tablet y desktop.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA',
                            'description'    => 'Verificar responsividad, ortografía, enlaces, consistencia visual.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 7. DESARROLLO: TESTIMONIOS ─────────────────────────────────
                [
                    'name'        => 'Desarrollo: Sección de Testimonios',
                    'description' => 'Desarrollo de sección de testimonios: muestra de experiencias de clientes satisfechos con frases destacadas, nombre, empresa (si aplica), y foto opcional.',
                    'quantity'    => 1,
                    'unit'        => 'sección',
                    'unit_price'  => 80,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño de tarjetas de testimonios',
                            'description'    => 'Crear diseño de testimonios: cita textual, nombre del cliente, empresa, foto de perfil (opcional), estrellas de valoración.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Slider o grid de testimonios',
                            'description'    => 'Implementar visualización: slider automático o manual, o grid de testimonios, diseño adaptativo.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión desde admin',
                            'description'    => 'Permitir agregar/editar testimonios desde el panel de administración: nombre, texto, empresa, foto, fecha.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA',
                            'description'    => 'Verificar funcionamiento, responsividad, velocidad,兼容性.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 8. DESARROLLO: PREGUNTAS FRECUENTES ────────────────────────
                [
                    'name'        => 'Desarrollo: Sección de Preguntas Frecuentes (FAQ)',
                    'description' => 'Desarrollo de sección de FAQ: preguntas frecuentes sobre seguros y el servicio de CVG con diseño de acordeón expansible para una navegación limpia.',
                    'quantity'    => 1,
                    'unit'        => 'sección',
                    'unit_price'  => 60,
                    'tasks'       => [
                        [
                            'name'           => 'Definición de preguntas frecuentes',
                            'description'    => 'Crear lista de preguntas relevantes: qué documentos necesito, cuánto tiempo toma, cómo comparo seguros, qué cubre cada tipo.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño de acordeón FAQ',
                            'description'    => 'Crear diseño de acordeón: pregunta como encabezado, respuesta expandible al hacer clic, indicadores visuales de estado.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión desde admin',
                            'description'    => 'Permitir agregar/editar preguntas desde el panel: pregunta, respuesta, orden, activar/desactivar.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA',
                            'description'    => 'Verificar funcionamiento del acordeón, responsividad, velocidad.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 9. DESARROLLO: CONTACTO + FORMULARIO ────────────────────────
                [
                    'name'        => 'Desarrollo: Sección de Contacto + Formulario de Cotización',
                    'description' => 'Desarrollo de sección de contacto completa: formulario detallado de cotización de seguros, información de contacto (teléfono, email, dirección), horarios, y mapa de ubicación.',
                    'quantity'    => 1,
                    'unit'        => 'sección',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño de layout de contacto',
                            'description'    => 'Crear layout: formulario a un lado, información de contacto al otro, horarios, redes sociales, mapa.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Formulario de cotización completo',
                            'description'    => 'Desarrollar formulario detallado: datos personales, tipo de seguro interesado, información adicional, preferencias de contacto, validación completa.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Backend del formulario',
                            'description'    => 'Desarrollar backend: validación, sanitización, guardado en tabla de leads con todos los campos, asignación de estado inicial.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de notificaciones',
                            'description'    => 'Configurar notificaciones: email al admin con datos del lead, email de confirmación al cliente, WhatsApp notification (si aplica).',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Google Maps',
                            'description'    => 'Integrar Google Maps: embed de ubicación de la oficina de CVG, marker personalizado.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Página de agradecimiento',
                            'description'    => 'Crear thank you page: mensaje de confirmación, siguiente paso sugerido, opción de WhatsApp.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de contacto',
                            'description'    => 'Pruebas: formulario completo, notificaciones, mapa, emails, responsive.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 10. WHATSAPP FLOTANTE ────────────────────────────────────────
                [
                    'name'        => 'Sistema de WhatsApp Flotante',
                    'description' => 'Botón flotante de WhatsApp visible en todas las páginas para contacto directo: diseño profesional, mensaje inicial configurable, funcionamiento en móvil y desktop.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 60,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño del botón flotante',
                            'description'    => 'Crear botón flotante: ícono de WhatsApp, posición esquina inferior derecha, diseño adaptativo, animación de entrada.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de número',
                            'description'    => 'Configurar número de WhatsApp de CVG, mensaje inicial predefinido, formato wa.me, pruebas de funcionamiento.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Adaptación móvil',
                            'description'    => 'Asegurar funcionamiento correcto en dispositivos móviles: abrir app de WhatsApp o WhatsApp Web.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA',
                            'description'    => 'Probar en dispositivos, verificar que no interfiera con otros elementos, verificar visualización.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 11. FORMULARIO DE CAPTACIÓN DE LEADS ───────────────────────
                [
                    'name'        => 'Formulario de Captación de Leads',
                    'description' => 'Sistema completo de captación de leads: formularios en múltiples secciones (hero, servicios, contacto), guardado en base de datos, seguimiento de fuente/origen del lead.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Backend de gestión de leads',
                            'description'    => 'Desarrollar tabla y modelo de leads: campos completos (nombre, email, teléfono, tipo seguro, mensaje, fuente, fecha, estado).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Seguimiento de fuente',
                            'description'    => 'Implementar tracking de origen: detectar si el lead viene de Google Ads, búsqueda orgánica, WhatsApp, directo.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con formularios',
                            'description'    => 'Conectar todos los formularios (hero, servicios, contacto) con el sistema de leads centralizado.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Notificaciones múltiples',
                            'description'    => 'Configurar sistema de notificaciones: email al admin, SMS al vendedor, notificación en panel.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de leads',
                            'description'    => 'Probar todos los flujos de captura, verificar datos guardados, notificaciones enviadas.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 12. PANEL DE ADMINISTRACIÓN DE LEADS ───────────────────────
                [
                    'name'        => 'Panel de Administración de Leads',
                    'description' => 'Panel administrativo para gestionar leads: listado de leads captados, filtros por fecha/estado/tipo de seguro, detalles del lead, cambio de estado (nuevo, contactado, cotizado, cerrado), notas de seguimiento.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Dashboard de leads',
                            'description'    => 'Crear dashboard: overview de leads, gráfico de leads por día, leads por estado, conversión estimada.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Listado de leads',
                            'description'    => 'Desarrollar listado: tabla con todos los leads, paginación, búsqueda, filtros por fecha, estado, tipo de seguro, fuente.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Detalle de lead',
                            'description'    => 'Crear vista de detalle: todos los datos del lead, historial de estados, notas de seguimiento, timeline de interacciones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de estados',
                            'description'    => 'Implementar cambio de estado: nuevo → contactado → cotizado → cerradoganado / cerrado perdido. Notificaciones de cambio.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de notas',
                            'description'    => 'Agregar notas: permitir agregar notas de seguimiento a cada lead, fecha, autor, contenido.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Exportación de leads',
                            'description'    => 'Exportar leads: descargar lista en Excel/CSV con todos los campos y notas.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA del panel',
                            'description'    => 'Probar todas las funcionalidades: CRUD de leads, filtros, estados, notas, exportación.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 13. GOOGLE ANALYTICS + PIXEL ────────────────────────────────
                [
                    'name'        => 'Integración con Google Analytics + Pixel de Seguimiento',
                    'description' => 'Configuración de herramientas de análisis y seguimiento: Google Analytics 4 para tracking de visitas, eventos y conversiones, pixel de Facebook (opcional), tracking de conversiones de Google Ads.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 80,
                    'tasks'       => [
                        [
                            'name'           => 'Configuración de Google Analytics',
                            'description'    => 'Configurar GA4: crear propiedad, instalar código de seguimiento, verificar funcionamiento.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Eventos de conversión',
                            'description'    => 'Implementar eventos: envío de formulario de cotización, clics en WhatsApp, clicks en teléfono.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Google Ads Remarketing',
                            'description'    => 'Configurar remarketing: audiencias de remarketing para visitantes que no convirtieron, etiquetas de seguimiento.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Facebook Pixel (opcional)',
                            'description'    => 'Instalar pixel de Facebook: si el cliente lo requiere, configurar seguimiento de conversiones.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Verificación y QA',
                            'description'    => 'Verificar en GA4 y Google Tag Manager que los eventos se disparan correctamente.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 14. CONFIGURACIÓN DE GOOGLE ADS ────────────────────────────
                [
                    'name'        => 'Configuración de Google Ads (Campaña de Búsqueda)',
                    'description' => 'Configuración completa de campaña de Google Ads para captación de clientes de seguros: configuración de cuenta, estructura de campañas, grupos de anuncios, palabras clave, anuncios responsivos, extensiones, seguimiento de conversiones.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 400,
                    'tasks'       => [
                        [
                            'name'           => 'Configuración de cuenta',
                            'description'    => 'Configurar cuenta de Google Ads: configuración de facturación, objetivos de campaña, zona horaria, moneda.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Estrategia de campaña',
                            'description'    => 'Definir estrategia: campaña de búsqueda, objetivos (captación de leads), presupuesto diario/mensual sugerido.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Estructura de grupos de anuncios',
                            'description'    => 'Crear grupos de anuncios por tipo de seguro: seguros de vida, seguro de salud, seguro vehicular, seguro de empresas.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Selección de palabras clave',
                            'description'    => 'Seleccionar keywords por grupo: usar estudio de keywords, concordancia exacta y de frase, negativas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Creación de anuncios responsivos',
                            'description'    => 'Crear anuncios responsivos de búsqueda: múltiples headlines y descripciones para cada grupo, optimización de headlines.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Extensiones de anuncios',
                            'description'    => 'Configurar extensiones: sitelinks, llamadas, textos destacados, extensiones de precio (tipos de seguros).',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Seguimiento de conversiones',
                            'description'    => 'Configurar conversiones: seguimiento de envío de formulario como conversión, importación de conversiones a Google Ads.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de puja',
                            'description'    => 'Estrategia de puja: CPC manual o CPA objetivo, ajustes por dispositivo, ubicación.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Geolocalización y público',
                            'description'    => 'Configurar segmentación: ubicaciones (Perú, ciudades principales), exclusión de ubicaciones no deseadas.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización inicial',
                            'description'    => 'Recomendaciones de optimización: sugerencias para mejorar el Quality Score, estructura de cuenta, nächste Schritte.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 15. SEO TÉCNICO + OPTIMIZACIÓN ──────────────────────────────
                [
                    'name'        => 'SEO Técnico + Optimización',
                    'description' => 'Optimización SEO técnica para mejorar el posicionamiento orgánico: metadatos, sitemap, robots.txt, schema markup, optimización de velocidad, URLs amigables.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Metadatos optimizados',
                            'description'    => 'Configurar title y meta description únicos para cada página: keywords principales, longitud correcta, llamadas a la acción.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sitemap XML',
                            'description'    => 'Generar sitemap.xml dinámico: todas las páginas, imágenes, frecuencia de cambio, prioridad.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Robots.txt',
                            'description'    => 'Configurar robots.txt: permitir indexing, bloquear páginas no necesarias, sitemap declaration.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Schema Markup',
                            'description'    => 'Implementar schemas: Organization, LocalBusiness, InsuranceAgency, BreadcrumbList, FAQ.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de velocidad',
                            'description'    => 'Mejorar velocidad de carga: compresión de imágenes, minificación de CSS/JS, lazy loading, caché.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Google Search Console',
                            'description'    => 'Configurar Google Search Console: verificar propiedad, sitemap submission, análisis de indexing.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA de SEO',
                            'description'    => 'Verificar implementación: herramientas de SEO, Lighthouse, Core Web Vitals.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 16. PRUEBAS DE CALIDAD (QA) ────────────────────────────────
                [
                    'name'        => 'Pruebas de Calidad (QA) + Ajustes Finales',
                    'description' => 'Pruebas exhaustivas de todas las funcionalidades, velocidad, compatibilidad, seguridad, y ajustes finales antes de la publicación.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 70,
                    'tasks'       => [
                        [
                            'name'           => 'Pruebas funcionales',
                            'description'    => 'Probar todas las funcionalidades: formularios, WhatsApp, lead capture, panel admin, navegación.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pruebas de compatibilidad',
                            'description'    => 'Verificar en múltiples navegadores: Chrome, Firefox, Safari, Edge. Múltiples dispositivos.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pruebas de velocidad',
                            'description'    => 'Medir velocidad de carga: PageSpeed Insights, GTmetrix, optimizar si es necesario.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pruebas de formularios',
                            'description'    => 'Verificar todos los formularios: validación, guardado de datos, notificaciones, thank you pages.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pruebas de SEO',
                            'description'    => 'Verificar SEO: meta tags, sitemap, schema, robots.txt, Core Web Vitals.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Ajustes finales',
                            'description'    => 'Realizar ajustes basados en pruebas: corregir errores, optimizar rendimiento, mejorar UX.',
                            'duration_value' => 1,
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
