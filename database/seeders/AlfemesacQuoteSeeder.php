<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlfemesacQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (ALFEMESAC) + Lead (RUC: 20607388416)
     * - Cotización en PEN (S/ 1,400.00 + IGV 18% = S/ 1,652.00) para:
     *   - Diseño y Desarrollo de Página Web Corporativa
     *
     * Empresa: ALEACIONES FERROSAS Y METALICAS S.A.C.
     * Nombre Comercial: Alfemesac
     * Rubro: Exportadora de residuos metálicos y electrónicos
     * Web actual: https://alfemesac.com.pe/
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente/empresa
            // =========================
            $clientName = 'Alfemesac';
            $clientEmail = 'info@alfemesac.com.pe';
            $clientPhone = '+51 960 666 901';
            $clientAddress = 'Av. Los Rosales 655, Coop. 27 de Abril, Santa Anita - Lima, Perú';

            $companyName = 'ALEACIONES FERROSAS Y METALICAS S.A.C.';
            $companyRuc = '20607388416';

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
                    'project_type' => 'Página Web Corporativa - Rediseño/Actualización',
                    'budget_up_to' => 1652,
                    'message' => "Cotización solicitada para: {$companyName} (RUC: {$companyRuc}). Alcance: Diseño y desarrollo de página web corporativa para empresa exportadora de residuos metálicos y electrónicos.",
                    'status' => 'new',
                    'source' => 'seed',
                    'notes' => 'Lead creado automáticamente desde seeder para generar cotización formal de página web corporativa. Web actual: https://alfemesac.com.pe/',
                ]
            );

            // =========================
            // Usuario creador (interno)
            // =========================
            $createdBy = User::where('email', 'gusgusnoriega@gmail.com')->first()
                ?? User::first()
                ?? $clientUser;

            // =========================
            // Cotización (PEN) - CON IGV 18%
            // Subtotal: S/ 1,400.00
            // IGV (18%): S/ 252.00
            // Total: S/ 1,652.00
            // =========================
            $quoteNumber = 'COT-20607388416-WEB-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id' => $clientUser->id,
                    'created_by' => $createdBy?->id,
                    'title' => "Cotización: Página Web Corporativa - {$companyName}",
                    'description' => "Diseño y desarrollo de página web corporativa para {$companyName} (ALFEMESAC), empresa peruana exportadora de residuos metálicos y electrónicos, orientada a la gestión ambiental responsable.\n\n" .
                        "Incluye:\n" .
                        "- Diseño web moderno y profesional acorde al rubro industrial/ambiental.\n" .
                        "- Desarrollo responsive (adaptable a móviles, tablets y escritorio).\n" .
                        "- Secciones principales: Inicio, Quiénes Somos, Servicios/Productos, Exportación, Contacto.\n" .
                        "- Galería de imágenes y/o slider de proyectos/instalaciones.\n" .
                        "- Formulario de contacto funcional.\n" .
                        "- Integración con WhatsApp Business.\n" .
                        "- Optimización SEO básica (meta tags, estructura, velocidad).\n" .
                        "- Configuración de hosting y dominio (si se requiere).\n\n" .
                        "Referencia web actual: https://alfemesac.com.pe/",
                    'currency_id' => $pen->id,
                    'tax_rate' => 18,
                    'discount_amount' => 0,
                    'status' => 'draft',
                    'valid_until' => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(3)->toDateString(),
                    'notes' => "Requisitos para iniciar:\n" .
                        "- Logo en alta resolución (PNG, SVG o AI).\n" .
                        "- Textos institucionales (misión, visión, valores, historia).\n" .
                        "- Listado de productos/servicios con descripciones.\n" .
                        "- Fotografías de instalaciones, equipo y procesos (si aplica).\n" .
                        "- Información de contacto oficial (dirección, teléfonos, correos, redes sociales).\n" .
                        "- Certificaciones y registros (MINAM, EO-RS, etc.).\n" .
                        "- Países de exportación y alianzas comerciales.\n\n" .
                        "Entregables:\n" .
                        "- Página web operativa en servidor de producción con SSL.\n" .
                        "- Panel de administración (CMS) para gestión de contenido.\n" .
                        "- Capacitación básica para actualización de contenido.\n" .
                        "- Código fuente y documentación técnica.",
                    'terms_conditions' => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 1,400.00\n" .
                        "- IGV (18%): S/ 252.00\n" .
                        "- Total: S/ 1,652.00\n" .
                        "- Forma de pago sugerida: 50% al iniciar (S/ 826.00) / 50% al finalizar y antes de publicación (S/ 826.00).\n" .
                        "- Plazo estimado: 2-3 semanas (sujeto a entrega de contenidos por parte del cliente).\n" .
                        "- Hosting y dominio: se incluye configuración; renovaciones anuales posteriores corren por cuenta del cliente.\n" .
                        "- Soporte post-lanzamiento: 15 días para ajustes menores incluidos.\n" .
                        "- Alcance: cualquier funcionalidad adicional no descrita se cotiza por separado.",
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

            // Subtotal items = S/ 1,400.00
            // IGV (18%) = S/ 252.00
            // Total = S/ 1,652.00
            $items = [
                [
                    'name' => 'Diseño Web UI/UX',
                    'description' => "Diseño de interfaz de usuario (UI) y experiencia de usuario (UX) para la página web corporativa de {$companyName}.\n\nIncluye:\n- Análisis de marca y sector industrial/ambiental.\n- Definición de paleta de colores y tipografías.\n- Wireframes de las secciones principales.\n- Diseño visual de mockups (desktop y mobile).\n- Revisiones y ajustes según feedback del cliente.",
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 350,
                    'tasks' => [
                        ['name' => 'Análisis de marca y requerimientos', 'description' => 'Levantamiento de información sobre la marca, valores, público objetivo y competencia. Revisión de la web actual.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Definición de identidad visual web', 'description' => 'Establecer paleta de colores, tipografías, estilo de iconografía y elementos gráficos acorde al rubro.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Wireframes y estructura de navegación', 'description' => 'Creación de wireframes para las secciones principales: Inicio, Quiénes Somos, Productos, Servicios, Exportación, Contacto.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Diseño de mockups (desktop y mobile)', 'description' => 'Diseño visual de las pantallas principales en versión escritorio y móvil.', 'duration_value' => 2, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Desarrollo Frontend (HTML/CSS/JS)',
                    'description' => "Maquetación y desarrollo frontend de la página web con tecnologías modernas.\n\nIncluye:\n- Estructura HTML5 semántica.\n- Estilos CSS3/SCSS responsive.\n- Animaciones y transiciones suaves.\n- Optimización de rendimiento (lazy loading, minificación).\n- Compatibilidad con navegadores modernos.",
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 400,
                    'tasks' => [
                        ['name' => 'Estructura HTML base y componentes', 'description' => 'Desarrollo de la estructura HTML5 semántica con componentes reutilizables.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Estilos CSS/SCSS responsive', 'description' => 'Implementación de estilos responsive con breakpoints para móvil, tablet y escritorio.', 'duration_value' => 2, 'duration_unit' => 'days'],
                        ['name' => 'Interactividad JavaScript', 'description' => 'Carrusel/slider de imágenes, menú móvil, animaciones de scroll y efectos interactivos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Optimización de rendimiento', 'description' => 'Lazy loading de imágenes, minificación de archivos, optimización de carga.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Desarrollo Backend y CMS',
                    'description' => "Desarrollo del backend y sistema de gestión de contenido (CMS) para administrar la página web.\n\nIncluye:\n- Panel de administración para gestión de contenido.\n- Gestión de secciones editables (textos, imágenes).\n- Formulario de contacto con envío de correos.\n- Base de datos para contenido dinámico.\n- Sistema de usuarios básico para admins.",
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 350,
                    'tasks' => [
                        ['name' => 'Configuración del entorno backend', 'description' => 'Setup del proyecto backend (Laravel/PHP) con estructura MVC y base de datos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Panel de administración básico', 'description' => 'Desarrollo de panel admin para gestión de contenido de secciones principales.', 'duration_value' => 2, 'duration_unit' => 'days'],
                        ['name' => 'Formulario de contacto funcional', 'description' => 'Implementación de formulario con validaciones y envío de correos (SMTP).', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Integración WhatsApp Business', 'description' => 'Botón flotante de WhatsApp con mensaje predefinido y enlace directo.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'SEO Básico y Configuración',
                    'description' => "Optimización SEO on-page y configuración técnica para buscadores.\n\nIncluye:\n- Meta tags optimizados (title, description).\n- Estructura de URLs amigables.\n- Sitemap XML y robots.txt.\n- Schema markup básico (LocalBusiness).\n- Configuración de Google Search Console.",
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 150,
                    'tasks' => [
                        ['name' => 'Optimización de meta tags', 'description' => 'Configuración de títulos, descripciones y palabras clave para cada sección.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                        ['name' => 'Estructura SEO y URLs amigables', 'description' => 'Configuración de URLs limpias, headings jerárquicos y estructura semántica.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                        ['name' => 'Sitemap, robots.txt y Schema', 'description' => 'Generación de sitemap XML, configuración de robots.txt y marcado Schema.org.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                        ['name' => 'Registro en Google Search Console', 'description' => 'Alta del sitio en Search Console, envío de sitemap y verificación.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Despliegue y Puesta en Producción',
                    'description' => "Configuración de hosting, dominio y despliegue de la página web en producción.\n\nIncluye:\n- Configuración de servidor/hosting.\n- Instalación de certificado SSL.\n- Configuración de dominio y DNS.\n- Migración y despliegue del sitio.\n- Pruebas finales de funcionamiento.",
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 150,
                    'tasks' => [
                        ['name' => 'Configuración de hosting y dominio', 'description' => 'Setup del servidor, configuración de PHP, base de datos y variables de entorno.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                        ['name' => 'Instalación de SSL y seguridad', 'description' => 'Instalación de certificado SSL (Let\'s Encrypt) y configuración HTTPS.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                        ['name' => 'Despliegue y pruebas finales', 'description' => 'Deploy del sitio, pruebas de navegación, formularios y rendimiento.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Capacitación básica', 'description' => 'Sesión de capacitación para uso del panel de administración.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
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
