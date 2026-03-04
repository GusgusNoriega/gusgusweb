<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CentroNeurologicoIntegralQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Sharon Vera - Centro Neurológico Integral)
     * - Lead de empresa (Centro Neurológico Integral)
     * - Cotización en PEN (S/ 1,150 + IGV 18% = S/ 1,357) para una página web estándar
     *   para un centro de salud neurológico, con 4 vistas, SEO básico, botón de WhatsApp,
     *   formulario de contacto para leads, panel de administración, capacitación y manual.
     *
     * Ítems:
     *   1. Vista: Inicio (Home)                                          S/ 200
     *   2. Vista: Nosotros                                               S/ 150
     *   3. Vista: Servicios                                              S/ 200
     *   4. Vista: Contacto                                               S/ 150
     *   5. SEO Básico                                                    S/ 100
     *   6. Botón WhatsApp flotante                                      S/  50
     *   7. Formulario de contacto para leads                            S/ 100
     *   8. Panel de administración + capacitación + manual             S/ 150
     *   9. Hosting y Dominio (compra, configuración, publicación)       S/  50
     *                                                          Subtotal: S/ 1,150
     *                                                       IGV (18%):  S/   207
     *                                                            Total:  S/ 1,357
     *
     * Tiempo estimado: 2 semanas (10 días hábiles).
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente
            // =========================
            $clientName    = 'Sharon Vera';
            $clientEmail   = 'centroneuroin@gmail.com';
            $clientPhone   = null;
            $clientAddress = null;

            $companyName     = 'Centro Neurológico Integral';
            $companyRuc      = '20615355543';
            $companyIndustry = 'Centro de salud neurológico';

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
                    'project_type' => 'Página web estándar para centro de salud neurológico (4 vistas)',
                    'budget_up_to' => 1150,
                    'message'      => "Cotización solicitada para: {$companyName} ({$clientName}). Rubro: {$companyIndustry}. Proyecto: Página web corporativa estándar con 4 vistas, SEO básico, botón WhatsApp, formulario de contacto para leads, panel de administración, capacitación y manual.",
                    'status'       => 'new',
                    'source'       => 'seed',
                    'notes'        => 'Lead creado automáticamente desde seeder para generar cotización formal de página web estándar para centro neurológico.',
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
            $quoteNumber = 'COT-CENTRONEURO-WEB-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id'              => $clientUser->id,
                    'created_by'           => $createdBy?->id,
                    'title'                => 'Cotización: Página Web Estándar para Centro Neurológico Integral – 4 Vistas + SEO + Panel Admin + Capacitación',
                    'description'          => "Desarrollo de una página web corporativa estándar para {$companyName}, centro de salud neurológico ubicado en Perú.\n\n" .
                        "El sitio web incluirá:\n" .
                        "- Página de inicio con información de la clínica, servicios destacados, equipo médico y llamado a la acción.\n" .
                        "- Sección Nosotros con la historia del centro, misión, visión, valores y equipo médico especializado.\n" .
                        "- Sección de Servicios detallando los servicios neurológicos ofrecidos (consultas, tratamientos, estudios diagnósticos).\n" .
                        "- Página de Contacto con formulario de contacto para captación de leads, datos de ubicación, teléfonos, correo y botón de WhatsApp.\n" .
                        "- SEO básico para posicionamiento en buscadores (Google).\n" .
                        "- Botón flotante de WhatsApp para contacto directo.\n" .
                        "- Formulario de contacto integrado con sistema de leads.\n" .
                        "- Panel de administración para gestionar contenido básico.\n" .
                        "- Capacitación final y manual de uso.\n\n" .
                        "Vistas incluidas:\n" .
                        "- Inicio (home con información institucional, servicios destacados y CTA)\n" .
                        "- Nosotros (historia, misión, visión, equipo médico)\n" .
                        "- Servicios (listado y descripción de servicios neurológicos)\n" .
                        "- Contacto (formulario + WhatsApp + datos de contacto)\n\n" .
                        "Incluye:\n" .
                        "- Panel de administración para gestionar contenido.\n" .
                        "- Hosting y dominio (primer año incluido).\n" .
                        "- SEO básico (metadatos, sitemap, robots básico).\n" .
                        "- Capacitación y manual de uso.\n\n" .
                        "Tiempo estimado de entrega: 2 semanas (10 días hábiles, sin imprevistos y con entrega oportuna de contenido/accesos).",
                    'currency_id'          => $pen->id,
                    'tax_rate'             => 18,
                    'discount_amount'      => 0,
                    'status'               => 'draft',
                    'valid_until'          => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes'                => "Requisitos para iniciar:\n" .
                        "- Definición del nombre de dominio deseado (2-3 opciones) y datos para compra/registro.\n" .
                        "- Logo del centro neurológico (si ya cuentan con diseño de logo e identidad de marca, favor hacerlo llegar).\n" .
                        "- Paleta de colores y estilo visual deseado (o参考 de sitios web del sector salud/neurología que les gusten).\n" .
                        "- Contenido base: textos de Inicio, Nosotros, historia del centro, datos del equipo médico.\n" .
                        "- Listado de servicios neurológicos ofrecidos con descripciones.\n" .
                        "- Datos de contacto: teléfonos, WhatsApp, correo, dirección, horarios de atención, redes sociales.\n" .
                        "- Referencias de diseño (sitios web de centros de salud o clínicas que les gusten).\n\n" .
                        "Entregables:\n" .
                        "- Sitio web publicado con certificado SSL.\n" .
                        "- Panel de administración para gestionar contenido.\n" .
                        "- Sitemap.xml y robots.txt configurados.\n" .
                        "- Botón flotante de WhatsApp configurado.\n" .
                        "- Formulario de contacto conectado al sistema de leads.\n" .
                        "- Manual (PDF) + capacitación remota de uso del panel.\n\n" .
                        "Costos adicionales:\n" .
                        "- Hosting y dominio primer año: incluido en esta cotización.\n" .
                        "- Renovación anual de hosting y dominio: aproximadamente S/ 350 anuales (cargo por cuenta del cliente).",
                    'terms_conditions'     => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 1,150.00\n" .
                        "- IGV (18%): S/ 207.00\n" .
                        "- Total: S/ 1,357.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto (S/ 678.50) / 50% al culminar el proyecto y previo a la publicación final (S/ 678.50).\n" .
                        "- Hosting + dominio: se incluye la gestión y el costo del primer año dentro de esta cotización; renovaciones anuales posteriores corren por cuenta del cliente (costo estimado S/ 350 anuales según proveedor/plan).\n" .
                        "- Propiedad del código: 100% del código fuente y entregables serán del cliente.\n" .
                        "- Alcance: incluye las 4 vistas (Inicio, Nosotros, Servicios, Contacto), SEO básico, botón WhatsApp, formulario de leads, panel de administración, capacitación y manual. Cambios mayores, nuevas secciones o módulos fuera del alcance se cotizan por separado.\n" .
                        "- Plazo estimado: 2 semanas (10 días hábiles), sujeto a entrega de contenido y aprobaciones sin demoras.\n" .
                        "- Nota importante: El cliente ya cuenta con su diseño de logo e identidad de marca, la cual nos tienen que hacer llegar para su implementación en el sitio web.",
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
            // Ítems de la cotización  (subtotal = S/ 1,150.00)
            // =========================================================
            $items = [
                // ─── 1. INICIO ─────────────────────────────────────────
                [
                    'name'        => 'Vista: Inicio (Home)',
                    'description' => "Diseño e implementación de la página de inicio para el Centro Neurológico Integral: hero con imagen representativa, propuesta de valor institucional, servicios destacados, información del equipo médico, testimonios de pacientes (si aplica), sección de contacto rápido y llamado a la acción (CTA) para agendar cita o comunicarse via WhatsApp.",
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Arquitectura de secciones + UI kit base',
                            'description'    => 'Definir estructura completa del Home: hero con imagen del centro o ilustración neurológica, mensaje de bienvenida, sección de servicios destacados (consultas, tratamientos, diagnósticos), información breve del equipo médico, sección de por qué elegirnos (equipamiento, especialistas, atención personalizada), CTA principal (agendar cita) y secundario (contactar por WhatsApp), footer con datos de contacto y enlaces rápidos. Definir componentes reutilizables (cards de servicio, botones, badges, iconos).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación responsive (móvil/tablet/desktop)',
                            'description'    => 'Implementación del layout responsive completo del Home: hero con superposición de texto sobre imagen, grid de servicios destacados (2-3 columnas adaptables), sección de equipo médico con fotos y nombres, sección de beneficios, CTAs prominentes, formulario de contacto rápido y footer. Asegurar experiencia óptima en dispositivos móviles (pacientes pueden buscar desde celular). Animaciones sutiles de entrada.',
                            'duration_value' => 6,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con contenido editable (panel admin)',
                            'description'    => 'Conectar todas las secciones del Home a campos editables desde el panel de administración: textos del hero (título, subtítulo, CTA), imágenes de fondo, servicios destacados (selección desde el catálogo de servicios), datos del equipo médico, testimonios, datos de contacto del footer.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de imágenes y performance',
                            'description'    => 'Compresión y optimización de imágenes del centro médico y equipo (WebP, lazy-load), preload de hero image, compresión de assets. Asegurar tiempos de carga rápidos considerando que el Home tendrá imágenes profesionales.',
                            'duration_value' => 2,
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
                    'name'        => 'Vista: Nosotros',
                    'description' => 'Vista institucional para presentar el Centro Neurológico Integral: historia del centro, misión, visión, valores, equipo médico especializado (neurólogos, técnicos, personal administrativo), equipamiento tecnológico, certificaciones y alianzas. Contenido editable desde el panel.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Estructura de contenido institucional',
                            'description'    => 'Definir secciones: historia del centro neurológico y años de experiencia, misión/visión/valores (compromiso con la salud, excelencia médica, humanidad), equipo médico (fotos, nombres, especialidades, años de experiencia, formación académica), sección de equipamiento tecnológico (tecnología de vanguardia en neurología), certificaciones o alianzas con instituciones de salud y CTA a contacto.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación responsive + estilos',
                            'description'    => 'Implementación del layout: sección hero secundario con imagen del centro o equipo médico, timeline de historia (opcional), grid de equipo médico con fotos, nombres, especialidades y formación, sección de equipamiento con iconos/imágenes, sección de certificaciones/alianzas con logos, diseño coherente con el Home y responsive.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con panel admin (textos e imágenes)',
                            'description'    => 'Vincular contenido de Nosotros al panel de administración: textos de historia, misión, visión, valores, datos del equipo médico (foto, nombre, cargo, especialidad, descripción), información del equipamiento, certificaciones e imágenes.',
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

                // ─── 3. SERVICIOS ───────────────────────────────────────
                [
                    'name'        => 'Vista: Servicios',
                    'description' => 'Vista de servicios neurológicos ofrecidos por el centro: consulta neurológica, electroencefalograma, electromiografía, tratamiento de enfermedades neurológicas (migraña, epilepsia, Alzheimer, Parkinson, accidentes cerebrovasculares), rehabilitación neurológica, entre otros. Cada servicio con descripción, beneficios y CTA a contacto.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Definición de estructura de servicios',
                            'description'    => 'Definir modelo de datos para servicios: nombre del servicio, slug, descripción corta (para cards), descripción completa, beneficios, equipamiento utilizado (si aplica), duración estimada de la consulta/procedimiento, precio de referencia (opcional), imagen/icono representativo, orden y visibilidad (publicado/borrador).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Maquetación del listado de servicios',
                            'description'    => 'Implementar grid de servicios con cards profesionales: icono o imagen representativa, nombre del servicio, descripción corta, beneficios principales y botón "Ver más" o "Solicitar información". Diseño limpio y profesional apropiado para el sector salud. Responsive optimizado para móvil.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Vista detalle de servicio',
                            'description'    => 'Página individual de cada servicio: descripción completa del servicio, beneficios para el paciente, equipamiento o tecnología utilizada, información relevante (duración, preparación necesaria si aplica), FAQ común del servicio, testimonios de pacientes relacionados (si aplica) y CTAs prominentes a contacto/whatsapp para solicitar información o agendar cita.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con panel admin (CRUD de servicios)',
                            'description'    => 'Panel para crear/editar/eliminar servicios neurológicos: todos los campos definidos (nombre, slug, descripción, beneficios, equipamiento, duración, precio, imagen, orden y visibilidad). Validaciones y previsualización.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + pruebas de navegación',
                            'description'    => 'Verificar listado de servicios, detalle de cada servicio, funcionamiento de filtros si aplica, paginación, enlaces, imágenes, responsividad y consistencia visual.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 4. CONTACTO ───────────────────────────────────────
                [
                    'name'        => 'Vista: Contacto',
                    'description' => 'Vista de contacto con formulario completo para captación de leads (nombre, correo, teléfono, servicio de interés, mensaje), datos del centro neurológico (dirección, teléfonos, correo, horarios de atención), mapa de ubicación (Google Maps embed), botón de WhatsApp directo y sección de redes sociales.',
                    'quantity'    => 1,
                    'unit'        => 'vista',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Maquetación de la vista de Contacto',
                            'description'    => 'Layout profesional: dos columnas (formulario a un lado, información de contacto al otro) o diseño vertical para móvil. Datos del centro: dirección completa, teléfonos (líneas fijo y móvil), correo electrónico, horarios de atención (mañana/tarde), días de atención. Mapa de Google Maps embebido con la ubicación del centro. Botón flotante/prominente de WhatsApp visible en toda la página. Sección de redes sociales (Facebook, Instagram, LinkedIn si aplica). Responsive y consistente con el diseño del sitio.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Formulario de contacto (campos + validaciones + anti-spam)',
                            'description'    => 'Campos del formulario: nombre completo, correo electrónico, teléfono (opcional), servicio de interés (dropdown con servicios cargados desde el panel), motivo de consulta (opciones: información general, solicitar cita, presupuestos, otro), mensaje. Validaciones frontend y backend, protección anti-spam (honeypot o captcha básico). Campo oculto para trackear origen si viene de campaña publicitaria (UTM params).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con sistema de leads + notificaciones',
                            'description'    => 'Guardar cada envío como lead en el sistema con toda la información capturada (servicio de interés, motivo de consulta). Notificación por email al equipo del centro neurológico. Página de agradecimiento personalizada con siguiente paso sugerido (ej: "Nos comunicaremos contigo en las próximas 24 horas para confirmar tu cita"). Tracking de origen (directo, orgánico, campaña).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Contenido editable desde panel + QA',
                            'description'    => 'Configurar datos editables desde panel: teléfonos, WhatsApp, correo, dirección, horarios, coordenadas del mapa, texto de agradecimiento, enlaces de redes sociales. Pruebas end-to-end del formulario (envío, recepción de notificación, registro de lead). Verificar botón de WhatsApp en móvil y desktop.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 5. SEO BÁSICO ─────────────────────────────────────
                [
                    'name'        => 'SEO Básico (Posicionamiento en Buscadores)',
                    'description' => 'SEO técnico básico para el sitio web del centro neurológico: configuración de metadatos por vista, sitemap.xml básico, robots.txt, optimización de URLs amigables, etiquetas H1/H2 correctas, atributos alt en imágenes, y configuración básica de Google Search Console (si se proporciona acceso).',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Investigación de keywords base + estrategia',
                            'description'    => 'Investigación de keywords orientadas al sector neurológico: "centro neurológico", "neurólogo", "consulta neurológica", "tratamiento neurológico", "electroencefalograma", "electromiografía", "Alzheimer", "Parkinson", "migraña", "epilepsia", etc. Definir palabras clave principales por página.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Metadatos por vista (title + description)',
                            'description'    => 'Configurar title tags y meta descriptions únicos y optimizados por cada vista (Inicio, Nosotros, Servicios, Contacto). Incluir keywords principales y llamado a la acción. Asegurar que cada página tenga metadatos únicos para evitar contenido duplicado.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sitemap.xml + robots.txt',
                            'description'    => 'Generar sitemap.xml con todas las páginas del sitio. Configurar robots.txt para permitir indexación de páginas principales y seguir directrices adecuadas. Instrucciones básicas para提交 sitemap a Google Search Console.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización técnica básica',
                            'description'    => 'Optimización de URLs amigables (slug en español), estructura de encabezados H1/H2/H3 correcta por página, atributos alt en todas las imágenes,速度 de carga básica (compresión de imágenes, minificación de CSS/JS si aplica).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 6. BOTÓN WHATSAPP FLOTANTE ────────────────────────
                [
                    'name'        => 'Botón WhatsApp Flotante',
                    'description' => 'Implementación de botón flotante de WhatsApp visible en todas las páginas del sitio web. El botón permitirá a los visitantes iniciar una conversación directa con el centro neurológico a través de WhatsApp Business (número configurado). Include verificación de horario de atención (opcional) y personalización del mensaje inicial.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 50,
                    'tasks'       => [
                        [
                            'name'           => 'Diseño e implementación del botón flotante',
                            'description'    => 'Crear botón flotante de WhatsApp con ícono de WhatsApp, posicionado en la esquina inferior derecha de la pantalla (o inferior izquierda). Diseño responsive que se adapte al color del sitio, con animación sutil de entrada. Visible en todas las páginas del sitio.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de número y mensaje',
                            'description'    => 'Configurar número de WhatsApp Business del centro neurológico. Personalizar mensaje inicial (ej: "Hola, me interesa obtener información sobre los servicios neurológicos de Centro Neurológico Integral"). Enlace con formato wa.me para apertura directa en app.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA + pruebas en dispositivos',
                            'description'    => 'Verificar funcionamiento del botón en móvil (Android/iOS) y desktop. Probar apertura de WhatsApp Web y app móvil. Verificar que no interfiera con otros elementos de la UI y que sea accesible.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 7. FORMULARIO DE CONTACTO PARA LEADS ─────────────
                [
                    'name'        => 'Formulario de Contacto para Leads',
                    'description' => 'Sistema completo de captación de leads a través del formulario de contacto: guardado de datos en base de datos, notificación por email al equipo del centro, página de agradecimiento, y estructura lista para integración con herramientas de email marketing o CRM (opcional futuro).',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 100,
                    'tasks'       => [
                        [
                            'name'           => 'Backend del formulario (validaciones + guardado)',
                            'description'    => 'Implementar backend completo: validación de todos los campos (nombre requerido, email válido, teléfono opcional), sanitización de datos, guardado en tabla de leads con todos los campos del formulario (nombre, email, teléfono, servicio de interés, motivo de consulta, mensaje, fecha/hora del lead, URL de origen, parámetros UTM si aplica).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de notificaciones por email',
                            'description'    => 'Configurar sistema de notificaciones: email de alerta al equipo del centro cuando se reciba un nuevo lead (con todos los datos del formulario). Plantilla de email profesional con los datos del lead. Configuración SMTP del servidor.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Página de agradecimiento + tracking',
                            'description'    => 'Crear página de agradecimiento personalizada que se muestra tras el envío exitoso del formulario. Incluir mensaje de confirmación, tiempo estimado de respuesta y siguiente paso sugerido. Configurar tracking de conversión en analytics si está instalado.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Panel de visualización de leads',
                            'description'    => 'Crear vista en el panel de administración para que el administrador pueda ver todos los leads recibidos: listado con nombre, email, teléfono, servicio de interés, fecha. Posibilidad de marcar leads como atendidos/eliminados.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 8. PANEL DE ADMINISTRACIÓN ────────────────────────
                [
                    'name'        => 'Panel de Administración + Capacitación + Manual',
                    'description' => 'Panel de administración para gestionar el contenido del sitio web: secciones de páginas (Inicio, Nosotros, Contacto), gestión de servicios neurológicos, gestión de equipo médico (opcional), leads recibidos y configuración básica del sitio. Incluye capacitación remota y manual de uso en PDF.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Accesos y seguridad del panel',
                            'description'    => 'Configuración de acceso seguro al panel: creación de usuario(s) administrador(es), credenciales, protección de rutas, sesiones seguras y buenas prácticas de contraseñas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de contenido de páginas (Inicio / Nosotros / Contacto)',
                            'description'    => 'Módulo para editar contenido de todas las páginas estáticas: textos del hero, imágenes de fondo, secciones de Nosotros (misión, visión, valores, equipo), datos de contacto, horarios, coordenadas del mapa, textos de agradecimiento del formulario. Validaciones y previsualización.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Módulo de gestión de servicios',
                            'description'    => 'CRUD completo de servicios neurológicos: crear/editar/eliminar servicios con nombre, slug, descripción, beneficios, equipamiento, duración, precio (opcional), imagen, orden y visibilidad (publicado/borrador).',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Módulo de gestión de equipo médico (opcional)',
                            'description'    => 'CRUD de miembros del equipo médico: nombre, especialidad, foto, formación académica, experiencia, orden y visibilidad. Este módulo es opcional y puede omitirse si no se requiere.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de leads recibidos',
                            'description'    => 'Vista en el panel para que el administrador vea los leads/contactos recibidos: listado con nombre, correo, teléfono, servicio de interés, fecha, estado (nuevo/atendido). Posibilidad de ver detalles completos y exportar datos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración básica del sitio',
                            'description'    => 'Módulo de configuración: datos de la empresa (nombre, RUC, dirección), información de contacto (teléfonos, email, WhatsApp), redes sociales, horario de atención, configuración de SEO básico (title/description global), configuración del formulario de contacto.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de media (imágenes)',
                            'description'    => 'Módulo de carga y gestión de imágenes: subir, organizar y seleccionar imágenes para servicios, equipo médico, páginas y banner. Recomendaciones de tamaños/peso y soporte de formatos (JPG/PNG/WebP).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación remota + manual de uso',
                            'description'    => 'Sesión de capacitación remota (videoconferencia) sobre uso completo del panel: gestión de contenido, servicios, equipo médico, leads y configuración. Entrega de manual paso a paso (PDF) con capturas de pantalla y flujos principales. Duración aproximada: 1-1.5 horas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'QA final del panel + ajustes de usabilidad',
                            'description'    => 'Pruebas de todos los flujos: editar contenido, crear servicio, ver leads, subir imágenes, modificar configuración. Ajustes de usabilidad y corrección de errores menores. Verificar permisos y accesos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 9. HOSTING Y DOMINIO ─────────────────────────────
                [
                    'name'        => 'Hosting y Dominio (Compra, Configuración, Publicación)',
                    'description' => 'Gestión completa de compra/registro de hosting y dominio, configuración técnica del servidor, certificado SSL, sincronización DNS y publicación/deploy del sitio web en producción. Incluye el primer año de hosting y dominio.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 50,
                    'tasks'       => [
                        [
                            'name'           => 'Selección de proveedor + compra de hosting y dominio',
                            'description'    => 'Selección del plan de hosting adecuado para una web corporativa de centro de salud (rendimiento estable, buen soporte). Compra/registro del dominio (.com, .com.pe, .pe u otra extensión apropiada). Recolección de datos del cliente para titularidad del dominio.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración inicial de hosting + SSL',
                            'description'    => 'Creación del sitio en hosting, configuración de SSL (Let\'s Encrypt o certificado del proveedor), variables de entorno, base de datos y parámetros de PHP/servidor para despliegue óptimo.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sincronización dominio ↔ hosting (DNS)',
                            'description'    => 'Configuración de registros DNS (A/CNAME), validación de propagación, redirecciones www/no-www, y pruebas de resolución correcta del dominio.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Deploy (publicación) + verificación final',
                            'description'    => 'Despliegue del sitio web a producción: subida de archivos, migración de base de datos. Verificación de SSL activo, formulario de contacto funcional, rutas, imágenes, performance básica, navegación completa y botón de WhatsApp.',
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
