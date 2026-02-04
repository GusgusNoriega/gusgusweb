<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CesarVarelaTokkoBrokerQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (César Varela)
     * - Lead de empresa (sin empresa específica / sin RUC)
     * - Cotización en USD ($150 + IGV 18%) para instalación y adaptación del plugin de Tokko Broker
     *   que incluye:
     *   - Instalación y configuración del plugin
     *   - Sincronización de agencias
     *   - Sincronización de vendedores
     *   - Sincronización de propiedades (manual y automática por lotes)
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente/empresa
            // =========================
            $clientName = 'César Varela';
            $clientEmail = 'cesarvarelacorrea@gmail.com';
            $clientPhone = null;
            $clientAddress = null;

            $companyName = null; // Sin empresa específica
            $companyIndustry = 'Inmobiliario (Tokko Broker)';

            // =========================
            // Moneda: USD
            // =========================
            $usd = Currency::firstOrCreate(
                ['code' => 'USD'],
                [
                    'name' => 'Dólar Estadounidense',
                    'symbol' => '$',
                    'exchange_rate' => 1.000000,
                    'is_base' => false,
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
            // Lead (cliente individual)
            // =========================
            Lead::updateOrCreate(
                [
                    'email' => $clientEmail,
                    'company_name' => $companyName,
                ],
                [
                    'name' => $clientName,
                    'phone' => $clientPhone,
                    'is_company' => false,
                    'company_ruc' => null,
                    'project_type' => 'Instalación y adaptación del plugin de Tokko Broker + sincronización de agencias, vendedores y propiedades',
                    'budget_up_to' => 150,
                    'message' => "Cotización solicitada para: {$clientName}. Plugin de Tokko Broker para su página web. Incluye sincronización de agencias, vendedores y propiedades (manual y automática).",
                    'status' => 'new',
                    'source' => 'seed',
                    'notes' => 'Lead creado automáticamente desde seeder para generar cotización de Tokko Broker.',
                ]
            );

            // =========================
            // Usuario creador (interno)
            // =========================
            $createdBy = User::where('email', 'gusgusnoriega@gmail.com')->first()
                ?? User::first()
                ?? $clientUser;

            // =========================
            // Cotización (USD)
            // =========================
            $quoteNumber = 'COT-TOKKO-CESARV-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id' => $clientUser->id,
                    'created_by' => $createdBy?->id,
                    'title' => 'Cotización: Instalación y adaptación del plugin de Tokko Broker + sincronización de agencias, vendedores y propiedades',
                    'description' => "Instalación y adaptación del plugin de Tokko Broker en la página web del cliente para gestión inmobiliaria.\n\n" .
                        "Alcance del proyecto:\n" .
                        "1) Instalación y configuración del plugin de Tokko Broker\n" .
                        "2) Sincronización de agencias\n" .
                        "3) Sincronización de vendedores\n" .
                        "4) Sincronización de propiedades (manual y automática)\n\n" .
                        "Características de la sincronización:\n" .
                        "- Sincronización manual bajo demanda\n" .
                        "- Sincronización automática programada (hora configurable del día)\n" .
                        "- Procesamiento por lotes para manejar grandes cantidades de información\n" .
                        "- Manejo de errores y reintentos automáticos\n" .
                        "- Logs de sincronización para seguimiento\n\n" .
                        "El plugin permitirá mostrar propiedades, agencias y vendedores en tiempo real desde la plataforma Tokko Broker.",
                    'currency_id' => $usd->id,
                    'tax_rate' => 18,
                    'discount_amount' => 0,
                    'status' => 'draft',
                    'valid_until' => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes' => "Requisitos para iniciar:\n" .
                        "- Acceso a la página web del cliente (cPanel/FTP o panel de hosting)\n" .
                        "- Cuenta activa en Tokko Broker con API Key/credenciales de acceso\n" .
                        "- Información de las agencias, vendedores y propiedades a sincronizar\n" .
                        "- Lista de campos requeridos para la visualización de propiedades\n\n" .
                        "Entregables:\n" .
                        "- Plugin de Tokko Broker instalado y configurado\n" .
                        "- Sincronización funcional de agencias\n" .
                        "- Sincronización funcional de vendedores\n" .
                        "- Sincronización funcional de propiedades (manual y automática)\n" .
                        "- Documentación de configuración y uso\n" .
                        "- Configuración de sincronización automática (hora/programación)\n" .
                        "- Panel de control para gestión manual de sincronización",
                    'terms_conditions' => "Condiciones comerciales:\n" .
                        "- Moneda: USD.\n" .
                        "- Subtotal: $ 150.00\n" .
                        "- IGV (18%): $ 27.00\n" .
                        "- Total: $ 177.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto ($ 88.50) / 50% al culminar el proyecto y previo a la entrega final ($ 88.50).\n" .
                        "- Alcance incluye: instalación, configuración, sincronización de agencias, vendedores y propiedades.\n" .
                        "- No incluye: costos de hosting, licencias premium de Tokko Broker, ni desarrollo de funcionalidades adicionales no descritas.\n" .
                        "- Cambios mayores fuera del alcance se cotizan por separado.\n" .
                        "- Soporte post-entrega: 15 días para dudas de configuración.",
                    'client_name' => $clientName,
                    'client_ruc' => null,
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

            // Total items (subtotal) = 150.00 USD
            $items = [
                // =============================================
                // INSTALACIÓN Y CONFIGURACIÓN DEL PLUGIN
                // =============================================
                [
                    'name' => 'Instalación y Configuración del Plugin Tokko Broker',
                    'description' => 'Instalación del plugin de Tokko Broker en la página web del cliente y configuración inicial básica para el funcionamiento del sistema de sincronización.',
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 30,
                    'tasks' => [
                        [
                            'name' => 'Análisis del entorno y compatibilidad',
                            'description' => 'Verificar compatibilidad del plugin con la versión actual del CMS/web del cliente. Revisar requisitos técnicos y dependencias necesarias.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Instalación del plugin',
                            'description' => 'Instalación del plugin de Tokko Broker en el sistema del cliente (WordPress/u otro CMS según corresponda).',
                            'duration_value' => 1,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Configuración de credenciales API',
                            'description' => 'Configuración de las credenciales de acceso a Tokko Broker (API Key, tokens de autenticación) en el plugin.',
                            'duration_value' => 1,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Configuración general del plugin',
                            'description' => 'Ajustes iniciales: moneda, formato de precios, idioma, opciones de visualización y comportamiento base del plugin.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Pruebas de conectividad',
                            'description' => 'Verificar conexión exitosa con la API de Tokko Broker y confirmar que el plugin puede comunicarse con el sistema.',
                            'duration_value' => 1,
                            'duration_unit' => 'hours',
                        ],
                    ],
                ],
                // =============================================
                // SINCRONIZACIÓN DE AGENCIAS
                // =============================================
                [
                    'name' => 'Sincronización de Agencias',
                    'description' => 'Implementación del sistema de sincronización de agencias desde Tokko Broker hacia la página web del cliente.',
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 20,
                    'tasks' => [
                        [
                            'name' => 'Análisis del modelo de datos de agencias',
                            'description' => 'Revisar la estructura de datos de agencias en Tokko Broker (nombre, logo, contacto, ubicación, etc.) y definir mapeo.',
                            'duration_value' => 1,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Desarrollo del módulo de sincronización de agencias',
                            'description' => 'Crear lógica para importar/sincronizar agencias desde Tokko Broker, incluyendo manejo de nuevos registros y actualizaciones.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Interfaz de visualización de agencias',
                            'description' => 'Implementar vista para mostrar las agencias sincronizadas en la página web (listado, cards, detalle de agencia).',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Panel de gestión de agencias (admin)',
                            'description' => 'Crear sección en el panel de administración para ver agencias sincronizadas, forzar sincronización manual y ver estado.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'QA y pruebas de sincronización',
                            'description' => 'Probar sincronización inicial, actualizaciones, casos de error y verificación de datos en frontend.',
                            'duration_value' => 1,
                            'duration_unit' => 'hours',
                        ],
                    ],
                ],
                // =============================================
                // SINCRONIZACIÓN DE VENDEDORES
                // =============================================
                [
                    'name' => 'Sincronización de Vendedores',
                    'description' => 'Implementación del sistema de sincronización de vendedores/agentes desde Tokko Broker hacia la página web del cliente.',
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 20,
                    'tasks' => [
                        [
                            'name' => 'Análisis del modelo de datos de vendedores',
                            'description' => 'Revisar la estructura de datos de vendedores en Tokko Broker (nombre, foto, contacto, agencia, propiedades, etc.) y definir mapeo.',
                            'duration_value' => 1,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Desarrollo del módulo de sincronización de vendedores',
                            'description' => 'Crear lógica para importar/sincronizar vendedores desde Tokko Broker, incluyendo fotos de perfil, contacto y asignación a agencias.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Interfaz de visualización de vendedores',
                            'description' => 'Implementar vistas para mostrar los vendedores en la página web (listado, perfil individual, vinculación con propiedades).',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Panel de gestión de vendedores (admin)',
                            'description' => 'Crear sección en el panel de administración para ver vendedores sincronizados, forzar sincronización manual y ver estado.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'QA y pruebas de sincronización',
                            'description' => 'Probar sincronización inicial, actualizaciones, fotos, vinculación con agencias y verificación de datos en frontend.',
                            'duration_value' => 1,
                            'duration_unit' => 'hours',
                        ],
                    ],
                ],
                // =============================================
                // SINCRONIZACIÓN DE PROPIEDADES (MANUAL Y AUTOMÁTICA)
                // =============================================
                [
                    'name' => 'Sincronización de Propiedades (Manual y Automática por Lotes)',
                    'description' => 'Implementación completa del sistema de sincronización de propiedades desde Tokko Broker, incluyendo sincronización manual bajo demanda, sincronización automática programada por hora configurable, y procesamiento por lotes para grandes volúmenes de información.',
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 60,
                    'tasks' => [
                        [
                            'name' => 'Análisis del modelo de datos de propiedades',
                            'description' => 'Revisar la estructura completa de propiedades en Tokko Broker: títulos, descripciones, precios, ubicación, características, imágenes, estado, operaciones (venta/renta), y campos personalizados.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Diseño del sistema de sincronización por lotes',
                            'description' => 'Arquitectura del sistema de procesamiento por lotes para manejar grandes cantidades de propiedades: chunking, paginación de API, manejo de rate limits y continuación automática.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Desarrollo del motor de sincronización',
                            'description' => 'Crear lógica de importación completa: altas nuevas, actualizaciones existentes, marcados de eliminados, y нормализация de datos.',
                            'duration_value' => 6,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Gestión de imágenes y medios',
                            'description' => 'Implementar descarga, almacenamiento y optimización de imágenes de propiedades. Incluir manejo de galerías, imágenes principales y prevención de duplicados.',
                            'duration_value' => 4,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Sistema de sincronización manual',
                            'description' => 'Crear funcionalidad para ejecutar sincronización manual bajo demanda desde el panel de administración con indicadores de progreso.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Sistema de sincronización automática programada',
                            'description' => 'Implementar sincronización automática configurable: configuración de hora del día para ejecución, programación de tarea cron/queue, y opciones de frecuencia.',
                            'duration_value' => 4,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Sistema de logs y monitoreo',
                            'description' => 'Crear registro de sincronizaciones: fecha/hora, propiedades sincronizadas, errores encontrados, tiempo de ejecución, y estadísticas.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Manejo de errores y reintentos',
                            'description' => 'Implementar sistema de manejo de errores: reintentos automáticos, alertas por fallos continuos, y cola de reintentos para propiedades con problemas.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Interfaz de propiedades en frontend',
                            'description' => 'Implementar vistas públicas: listado de propiedades con filtros (tipo, operación, precio, ubicación), detalle de propiedad, y búsqueda.',
                            'duration_value' => 4,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Panel de control de sincronización (admin)',
                            'description' => 'Crear panel completo: ejecutar sync manual, ver logs, configurar hora automática, ver estadísticas, manejar errores y reiniciar sincronizaciones fallidas.',
                            'duration_value' => 3,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'QA y pruebas completas',
                            'description' => 'Pruebas exhaustivas: sync manual, sync automático, grandes volúmenes, errores de API, recuperación de fallos, y verificación de frontend.',
                            'duration_value' => 4,
                            'duration_unit' => 'hours',
                        ],
                    ],
                ],
                // =============================================
                // DOCUMENTACIÓN Y CAPACITACIÓN
                // =============================================
                [
                    'name' => 'Documentación y Capacitación',
                    'description' => 'Entrega de documentación técnica y funcional, así como capacitación al cliente sobre el uso del plugin y gestión de sincronizaciones.',
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 20,
                    'tasks' => [
                        [
                            'name' => 'Documentación técnica',
                            'description' => 'Documento con detalles técnicos: configuración de credenciales, arquitectura del sistema de sincronización, estructura de datos, y guía de troubleshooting.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Documentación de uso',
                            'description' => 'Manual para el cliente: cómo usar el plugin, cómo ejecutar sincronización manual, interpretar logs, configurar sync automático, y resolver problemas comunes.',
                            'duration_value' => 2,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Capacitación al cliente (sesión remota)',
                            'description' => 'Sesión de capacitación en vivo para explicar el funcionamiento del plugin, demostraciones prácticas y resolución de dudas.',
                            'duration_value' => 1,
                            'duration_unit' => 'hours',
                        ],
                        [
                            'name' => 'Entrega de credenciales y accesos',
                            'description' => 'Organización y entrega de todas las credenciales, accesos y documentación al cliente de forma segura.',
                            'duration_value' => 1,
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

            // Recalcular totales
            $quote->load('items');
            $quote->calculateTotals();
            $quote->save();
        });
    }
}
