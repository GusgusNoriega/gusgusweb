<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UladechEducativoDashboardQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Luis Bernuy - Universidad Católica Los Ángeles de Chimbote)
     * - Lead de empresa (ULADECH - Universidad Católica Los Ángeles de Chimbote)
     * - Cotización en PEN (S/ 7,500 + IGV 18% = S/ 8,850) para Sistema de Dashboard Educativo + API + Web App.
     *
     * Ítems:
     *   1. Análisis y Planificación                                           S/ 200
     *   2. Diseño UI/UX del Dashboard y Web App                             S/ 350
     *   3. Desarrollo Backend Laravel                                       S/ 400
     *   4. Sistema de Gestión de Usuarios, Roles y Permisos                S/ 350
     *   5. API de Integración con ERP (Solo Lectura)                        S/ 500
     *   6. Dashboard de Visualización de Datos                              S/ 400
     *   7. Módulo: Información Académica (Notas, Asistencias)              S/ 350
     *   8. Módulo: Horarios y Calendario Académico                         S/ 300
     *   9. Módulo: Actividades y Eventos Institucionales                   S/ 300
     *  10. Módulo: Información de Cursos y Docentes                          S/ 280
     *  11. Módulo: Reportes y Estadísticas                                  S/ 300
     *  12. Módulo: Comunicación y Notificaciones                            S/ 250
     *  13. Desarrollo Web App Responsive                                    S/ 400
     *  14. Panel de Administración                                          S/ 300
     *  15. Integración Completa API-ERP-Dashboard                          S/ 350
     *  16. Optimización de Performance y Seguridad                         S/ 200
     *  17. Capacitación y Manual de Uso                                    S/ 150
     *  18. Hosting y Dominio (primer año)                                  S/ 120
     *                                                         Subtotal:  S/ 7,500
     *                                                            IGV:     S/ 1,350
     *                                                            Total:   S/ 8,850
     *
     * Tiempo estimado: 2 meses y medio (10 semanas / 50 días hábiles).
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente
            // =========================
            $clientName    = 'Luis Bernuy';
            $clientEmail   = 'lbernuyt@uladech.edu.pe';
            $clientPhone   = null;
            $clientAddress = null;

            $companyName     = 'Universidad Católica Los Ángeles de Chimbote (ULADECH)';
            $companyRuc      = '20319956043';
            $companyIndustry = 'Educación Superior';

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
                    'project_type' => 'Dashboard Educativo + API + Web App para visualización de datos académicos',
                    'budget_up_to' => 7500,
                    'message'      => "Cotización solicitada para: {$companyName} ({$clientName}). Rubro: {$companyIndustry}. Proyecto: Sistema de dashboard educativo para visualizar información académica del ERP existente (notas, asistencias, horarios, actividades), con API de integración (solo lectura), roles y permisos, web app responsive para docentes y padres de familia.",
                    'status'       => 'new',
                    'source'       => 'seed',
                    'notes'        => 'Lead creado automáticamente desde seeder para generar cotización formal de dashboard educativo para ULADECH.',
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
            $quoteNumber = 'COT-ULADECH-DASHBOARD-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id'              => $clientUser->id,
                    'created_by'           => $createdBy?->id,
                    'title'                => 'Cotización: Sistema de Dashboard Educativo + API + Web App - Universidad Católica Los Ángeles de Chimbote (ULADECH)',
                    'description'          => "Desarrollo de un sistema integral de dashboard educativo para {$companyName}, que permitirá a docentes y padres de familia visualizar información académica del ERP institucional.\n\n" .
                        "El proyecto incluye:\n" .
                        "- API de integración con el ERP existente (solo lectura, sin modificación de datos).\n" .
                        "- Dashboard administrativo para gestión de usuarios y configuración.\n" .
                        "- Portal web para visualización de información académica.\n" .
                        "- Web App responsive (funciona en computadora y dispositivos móviles).\n" .
                        "- Sistema de roles y permisos (docentes, padres de familia, administradores).\n" .
                        "- Módulos de visualización: notas, asistencias, horarios, actividades, cursos, docentes.\n" .
                        "- Sistema de notificaciones y comunicación.\n" .
                        "- Reportes y estadísticas.\n" .
                        "- Hosting y dominio del primer año.\n\n" .
                        "La API solo permitirá visualizar información (consultas GET), sin posibilidad de agregar, modificar o eliminar datos del ERP.\n\n" .
                        "Tiempo estimado de entrega: 2 meses y medio (10 semanas / 50 días hábiles).",
                    'currency_id'          => $pen->id,
                    'tax_rate'             => 18,
                    'discount_amount'      => 0,
                    'status'               => 'draft',
                    'valid_until'          => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(1)->toDateString(),
                    'notes'                => "Requisitos para iniciar:\n" .
                        "- Acceso a la documentación del ERP actual o reunión con el equipo de TI de ULADECH.\n" .
                        "- Acceso a la base de datos del ERP o endpoint de API existente (si lo hay).\n" .
                        "- Listado de módulos/información a visualizar (aproximadamente 6-8 módulos).\n" .
                        "- Datos de contacto del equipo que gestionará el sistema.\n" .
                        "- Requisitos específicos de seguridad y acceso.\n" .
                        "- Logo y branding institucional de ULADECH.\n\n" .
                        "Entregables:\n" .
                        "- API de integración funcionando.\n" .
                        "- Dashboard administrativo para gestión de usuarios.\n" .
                        "- Portal web con todos los módulos.\n" .
                        "- Web App responsive.\n" .
                        "- Sistema de roles y permisos configurado.\n" .
                        "- Hosting y dominio configurados.\n" .
                        "- Manual de usuario en PDF.\n" .
                        "- Capacitación remota.\n\n" .
                        "Costos adicionales:\n" .
                        "- Hosting y dominio primer año: incluido en esta cotización.\n" .
                        "- Renovación anual de hosting y dominio: aproximadamente S/ 350-400 anuales.",
                    'terms_conditions'     => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 7,500.00\n" .
                        "- IGV (18%): S/ 1,350.00\n" .
                        "- Total: S/ 8,850.00\n" .
                        "- Forma de pago: 50% al iniciar el proyecto (S/ 4,425.00) / 50% al culminar el proyecto y previo a la publicación final (S/ 4,425.00).\n" .
                        "- Hosting y dominio primer año: incluido en esta cotización.\n" .
                        "- Propiedad del código: 100% del código fuente y entregables serán del cliente.\n" .
                        "- Alcance: incluye API, dashboard, web app, 6-8 módulos de visualización, roles y permisos, capacitación y manual. Cambios mayores, nuevas funcionalidades o módulos fuera del alcance se cotizan por separado.\n" .
                        "- La API es de solo lectura (GET); no se permite agregar, modificar o eliminar datos del ERP.\n" .
                        "- Plazo estimado: 2 meses y medio (10 semanas / 50 días hábiles), sujeto a entrega de información y aprobaciones sin demoras.",
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
            // Ítems de la cotización  (subtotal = S/ 7,500.00)
            // =========================================================
            $items = [
                // ─── 1. ANÁLISIS Y PLANIFICACIÓN ─────────────────────────
                [
                    'name'        => 'Análisis y Planificación',
                    'description' => 'Análisis completo del proyecto y planificación detallada: reunión con equipo de TI de ULADECH, análisis del ERP actual, definición de estructura de datos a consumir, planificación de módulos, arquitectura técnica y cronograma.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Reunión de requirements + briefing',
                            'description'    => 'Reunión con el cliente para levantar requisitos: objetivos del proyecto, módulos requeridos, usuarios destino (docentes, padres), funcionalidades específicas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Análisis del ERP existente',
                            'description'    => 'Analizar el ERP actual de ULADECH: estructura de base de datos, tablas principales, relaciones, datos disponibles para consumo, documentación técnica.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Mapeo de datos a consumir',
                            'description'    => 'Identificar y documentar: qué datos del ERP se consumirán, campos específicos por módulo, formato de datos, frecuencia de actualización.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Arquitectura del sistema',
                            'description'    => 'Diseñar arquitectura: Laravel backend, API REST, estructura de bases de datos propia, diagramas de arquitectura, flujo de datos ERP → API → Dashboard.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Planificación y cronograma',
                            'description'    => 'Elaborar cronograma: fases de desarrollo, entregables, hitos, timeline de 10 semanas, responsables, fechas de revisión con el cliente.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 2. DISEÑO UI/UX ─────────────────────────────────────
                [
                    'name'        => 'Diseño UI/UX del Dashboard y Web App',
                    'description' => 'Diseño de interfaz y experiencia de usuario profesional: mockups del dashboard, diseño de la web app, guía de estilos institucional, diseño responsive para todos los dispositivos.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 350,
                    'tasks'       => [
                        [
                            'name'           => 'Análisis de experiencia de usuario',
                            'description'    => 'Estudiar usuarios objetivo: docentes, padres de familia. Crear user personas, journey maps, identificar necesidades de información académica.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Wireframes del dashboard',
                            'description'    => 'Crear wireframes: estructura del dashboard administrativo, navegación principal, layouts de módulos, componentes de visualización de datos.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Wireframes de web app',
                            'description'    => 'Diseñar wireframes: portal de acceso para docentes y padres, vistas de información académica, calendario de actividades, notificaciones.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Mockups de alta fidelidad',
                            'description'    => 'Diseñar mockups completos: uso de colores institucionales ULADECH, tipografías profesionales, componentes UI, estados, animaciones.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Guía de estilos',
                            'description'    => 'Crear guía de estilos: paleta de colores institucionales, tipografías, botones, cards, tablas de datos, gráficos, iconografía.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño responsive',
                            'description'    => 'Adaptar diseño: desktop, tablet y móvil. Web app adaptativa, touch-friendly, optimización para diferentes tamaños de pantalla.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 3. DESARROLLO BACKEND LARAVEL ────────────────────────
                [
                    'name'        => 'Desarrollo Backend Laravel',
                    'description' => 'Desarrollo del backend completo en Laravel: configuración del proyecto, modelos, migraciones, controladores, rutas, autenticación, API REST.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 400,
                    'tasks'       => [
                        [
                            'name'           => 'Configuración del proyecto Laravel',
                            'description'    => 'Instalar y configurar Laravel: composer create-project, configuración de entorno, setup de base de datos propia, dependencias necesarias (Laravel Passport, Spatie).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño de base de datos propia',
                            'description'    => 'Crear migraciones: usuarios, roles, permisos, logs de acceso, configuraciones, cache de datos del ERP.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Modelos y relaciones',
                            'description'    => 'Crear modelos Eloquent: User, Role, Permission, con relaciones (hasMany, belongsToMany, polymorphic).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Controladores y rutas API',
                            'description'    => 'Crear controladores RESTful: autenticación, usuarios, roles, módulos de información, con métodos de solo lectura.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de autenticación',
                            'description'    => 'Implementar autenticación: login, logout, recuperación de contraseña, JWT tokens (Laravel Passport), protección de rutas.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Middleware de seguridad',
                            'description'    => 'Crear middleware: autenticación, verificación de roles, rate limiting, CORS, validación de requests.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 4. SISTEMA DE ROLES Y PERMISOS ───────────────────────
                [
                    'name'        => 'Sistema de Gestión de Usuarios, Roles y Permisos',
                    'description' => 'Sistema completo de gestión de usuarios: roles (admin, docente, padre de familia), permisos por módulo, asignación de usuarios a roles, auditoría de accesos.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 350,
                    'tasks'       => [
                        [
                            'name'           => 'Definición de roles',
                            'description'    => 'Definir roles del sistema: Administrador (gestión total), Docente (ver información de sus cursos/estudiantes), Padre de Familia (ver información de sus hijos), Invitado (solo ver).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Definición de permisos',
                            'description'    => 'Crear permisos granulares: por módulo (notas, horarios, actividades), por acción (ver, exportar), por alcance (propios estudiantes/todos).',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de usuarios',
                            'description'    => 'CRUD de usuarios: crear, editar, eliminar usuarios, asignar roles, resetear contraseñas, gestionar estado (activo/inactivo).',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de roles',
                            'description'    => 'Administrar roles: crear, editar roles, asignar permisos a roles, clonar roles, ver usuarios por rol.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sincronización con ERP',
                            'description'    => 'Importar usuarios desde ERP: docentes, estudiantes, padres. Matching de datos, importación masiva, actualización periódica.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Auditoría de accesos',
                            'description'    => 'Sistema de logs: registrar accesos, acciones realizadas, IP, dispositivo, hora. Panel de auditoría para administradores.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Panel de permisos',
                            'description'    => 'Interfaz gráfica: administrar usuarios, roles y permisos desde el panel admin, asignar múltiples roles a usuarios.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 5. API DE INTEGRACIÓN CON ERP ─────────────────────
                [
                    'name'        => 'API de Integración con ERP (Solo Lectura)',
                    'description' => 'Desarrollo de API REST para consumir datos del ERP existente: conexión a base de datos, endpoints de consulta, autenticación, documentación. Solo consultas GET, sin modificación de datos.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 500,
                    'tasks'       => [
                        [
                            'name'           => 'Análisis de estructura del ERP',
                            'description'    => 'Estudiar estructura del ERP ULADECH: tablas de estudiantes, cursos, notas, docentes, horarios, asistencia, actividades.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Diseño de esquema de datos',
                            'description'    => 'Definir cómo mapear datos del ERP: modelos de datos unificados, transformación de datos, caché de consultas frecuentes.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Conexión a base de datos del ERP',
                            'description'    => 'Configurar conexión: leer credentials del ERP, conexión segura, manejo de múltiples conexiones en Laravel.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Desarrollo de endpoints de API',
                            'description'    => 'Crear endpoints RESTful: /api/estudiantes, /api/notas, /api/asistencias, /api/horarios, /api/actividades, /api/cursos, /api/docentes.',
                            'duration_value' => 5,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Validación y sanitización',
                            'description'    => 'Validar requests: parámetros de consulta, paginación, filtros, sanitización de inputs, prevención de SQL injection.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de caché',
                            'description'    => 'Implementar caché: Redis o file cache para datos que no cambian frecuentemente, invalidación de caché, estrategias de refresh.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Documentación de API',
                            'description'    => 'Crear documentación: endpoints disponibles, parámetros, respuestas, ejemplos, formato OpenAPI/Swagger.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pruebas de integración',
                            'description'    => 'Testing: probar cada endpoint, verificar datos正确os del ERP, manejo de errores, timeouts.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 6. DASHBOARD DE VISUALIZACIÓN ──────────────────────
                [
                    'name'        => 'Dashboard de Visualización de Datos',
                    'description' => 'Desarrollo del dashboard principal: métricas clave, gráficos de información académica, indicadores de rendimiento, widgets personalizables.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 400,
                    'tasks'       => [
                        [
                            'name'           => 'Layout del dashboard',
                            'description'    => 'Diseñar layout: sidebar de navegación, header con usuario, contenido principal, widgets de métricas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Widget de métricas principales',
                            'description'    => 'Crear KPIs: total estudiantes, promedio de notas, asistencia, actividades próximas. Tarjetas con datos destacados.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gráficos estadísticos',
                            'description'    => 'Implementar gráficos: notas por curso, asistencia por mes, distribución de estudiantes, usando Chart.js o similar.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Tablas de datos',
                            'description'    => 'Desarrollar tablas: listados de información con paginación, ordenamiento, búsqueda, filtros, exportación a Excel/CSV.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Filtros y búsqueda global',
                            'description'    => 'Sistema de filtros: por período académico, carrera, curso, docente. Búsqueda global en todo el dashboard.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Exportación de datos',
                            'description'    => 'Exportar: PDF, Excel, CSV. Generación de reportes desde el dashboard.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 7. MÓDULO: INFORMACIÓN ACADÉMICA ───────────────────
                [
                    'name'        => 'Módulo: Información Académica (Notas, Asistencias)',
                    'description' => 'Módulo de visualización de información académica: notas por estudiante/curso, asistencia, historial académico, promedio de notas, evolución de rendimiento.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 350,
                    'tasks'       => [
                        [
                            'name'           => 'Vista de notas por estudiante',
                            'description'    => 'Mostrar notas: listado de cursos con notas, promedio por curso, promedio general, historial por período académico.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Vista de notas por curso (docente)',
                            'description'    => 'Para docentes: lista de estudiantes con notas, promedio del curso, distribución de notas, exportar lista.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sistema de asistencia',
                            'description'    => 'Ver asistencia: porcentaje de asistencia por curso, días asistidos/faltados, historial de asistencia por fecha.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Historial académico',
                            'description'    => 'Historial: cursos aprobados/desaprobados, créditos obtenidos, promedio ponderado histórico, evolución académica.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gráficos de rendimiento',
                            'description'    => 'Visualizaciones: evolución de notas por ciclo, comparación con promedio del curso, gráficos de tendencia.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Filtros por período',
                            'description'    => 'Filtrar datos: por ciclo académico, año, carrera, curso. Selector de período académico.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 8. MÓDULO: HORARIOS Y CALENDARIO ───────────────────
                [
                    'name'        => 'Módulo: Horarios y Calendario Académico',
                    'description' => 'Módulo de horarios y calendario: horario de clases por estudiante/docente, calendario académico de exámenes, fechas importantes, eventos institucionales.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 300,
                    'tasks'       => [
                        [
                            'name'           => 'Visualización de horarios',
                            'description'    => 'Mostrar horario: tabla de horarios por día, horarios por curso, por docente, por aula. Vista semanal y diaria.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Calendario académico',
                            'description'    => 'Calendario de eventos: exámenes parciales, finales, entregas de trabajos, vacaciones, eventos institucionales.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Filtros de horario',
                            'description'    => 'Filtrar: por carrera, ciclo, turno, docente, aula. Selector de semana.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Exportar horario',
                            'description'    => 'Exportar: PDF con horario, agregar a Google Calendar/iCal, descargar como imagen.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Notificaciones de cambios',
                            'description'    => 'Alertas: notificaciones de cambios en horarios, exámenes programados,recordatorios de eventos próximos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 9. MÓDULO: ACTIVIDADES Y EVENTOS ────────────────────
                [
                    'name'        => 'Módulo: Actividades y Eventos Institucionales',
                    'description' => 'Módulo de actividades: listado de actividades académicas y extracurriculares, eventos próximos, inscripción a actividades, seguimiento de participación.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 300,
                    'tasks'       => [
                        [
                            'name'           => 'Listado de actividades',
                            'description'    => 'Mostrar actividades: lista de actividades disponibles, próximas, pasadas. Filtros por tipo, fecha, categoría.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Detalle de actividad',
                            'description'    => 'Ver detalle: descripción completa, fecha, lugar, requisitos, cupos disponibles, responsable.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Calendario de eventos',
                            'description'    => 'Vista de calendario: eventos en formato calendario, mensual, semanal. Diferentes colores por tipo.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Inscripción a actividades',
                            'description'    => 'Registrarse: inscribir estudiantes a actividades, verificar cupos, confirmación por email.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Seguimiento de participación',
                            'description'    => 'Track attendance: registro de asistencia a eventos, certificados de participación, historial del estudiante.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 10. MÓDULO: CURSOS Y DOCENTES ─────────────────────
                [
                    'name'        => 'Módulo: Información de Cursos y Docentes',
                    'description' => 'Módulo de cursos y docentes: silabos, información de docentes, materiales, evaluaciones programadas, contactos.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 280,
                    'tasks'       => [
                        [
                            'name'           => 'Listado de cursos',
                            'description'    => 'Catálogo de cursos: todos los cursos por carrera, ciclo, información básica, créditos, docente asignado.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Detalle de curso',
                            'description'    => 'Ver curso: silabo, competencias, evaluación, bibliografía, materiales, docente, contacto.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Perfil de docente',
                            'description'    => 'Ver docente: nombre, foto, especialidades, cursos que dicta, horarios de atención, contacto, evaluación docente.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Materiales y recursos',
                            'description'    => 'Recursos: materiales del curso, presentaciones, enlaces, libros recomendados, videos.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Evaluaciones programadas',
                            'description'    => 'Ver exams: fechas de exámenes, tipo de evaluación, ponderación, temas a evaluar.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 11. MÓDULO: REPORTES Y ESTADÍSTICAS ─────────────────
                [
                    'name'        => 'Módulo: Reportes y Estadísticas',
                    'description' => 'Módulo de reportes: estadísticas académicas, reportes por estudiante/curso/carrera, generación de informes, exportación.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 300,
                    'tasks'       => [
                        [
                            'name'           => 'Estadísticas generales',
                            'description'    => 'Dashboard stats: promedio institucional, tasas de aprobación, deserción, retención, rankings.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Reportes por estudiante',
                            'description'    => 'Reporte individual: historial académico completo, notas, asistencia, gráfico de evolución.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Reportes por curso',
                            'description'    => 'Reporte de curso: promedio, distribución de notas, estudiantes aprovados/desaprovados, asistencia.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Reportes por carrera',
                            'description'    => 'Reporte de carrera: estadísticas por programa de estudios, comparación de ciclos, tendencias.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Generación de PDFs',
                            'description'    => 'Crear PDFs: boletas de notas, certificados de estudios, constancias, reportes formales.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Programación de reportes',
                            'description'    => 'Reports auto-generate: generar reportes periódicos, enviar por email automáticamente.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 12. MÓDULO: COMUNICACIÓN ───────────────────────────
                [
                    'name'        => 'Módulo: Comunicación y Notificaciones',
                    'description' => 'Módulo de comunicación: notificaciones, anuncios institucionales, buzón de mensajes, comunicación docente-estudiante-padre.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 250,
                    'tasks'       => [
                        [
                            'name'           => 'Sistema de notificaciones',
                            'description'    => 'Notificaciones: alertas de nuevas notas, cambios de horario, actividades próximas, recordatorios.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Anuncios institucionales',
                            'description'    => 'Ver anuncios: avisos importantes, circulares, comunicado oficial de la universidad.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Centro de mensajes',
                            'description'    => 'Mensajería: enviar mensajes a docentes, estudiantes, padres. Bandeja de entrada/salida.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Notificaciones por email',
                            'description'    => 'Email notifications: enviar copias de notificaciones por email, configuración de preferencias.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Preferencias de notificaciones',
                            'description'    => 'Settings: elegir qué notificaciones recibir, canal (web, email, SMS), frecuencia.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 13. WEB APP RESPONSIVE ────────────────────────────────
                [
                    'name'        => 'Desarrollo Web App Responsive',
                    'description' => 'Desarrollo de la aplicación web responsive: portal de acceso para docentes y padres, optimización móvil, rendimiento en dispositivos.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 400,
                    'tasks'       => [
                        [
                            'name'           => 'Portal de acceso',
                            'description'    => 'Login page: diseño responsive, opciones de recuperación de contraseña, links útiles.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Layout responsive',
                            'description'    => 'Crear layout: navegación adaptativa (hamburguesa en móvil), sidebar collapsible, header responsive.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Adaptación de módulos',
                            'description'    => 'Mobile views: adaptar cada módulo para móvil, tablas scrollables, cards para información.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Componentes touch-friendly',
                            'description'    => 'Touch interactions: botones táctiles, sliders, selects nativos, gestos de swipe.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de rendimiento',
                            'description'    => 'Speed optimization: lazy loading, compresión, caché, PWA features para funcionamiento offline básico.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Progressive Web App',
                            'description'    => 'PWA setup: manifest, service workers, add to home screen, offline capability.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Testing multi-dispositivo',
                            'description'    => 'Test: verificar en iOS, Android, diferentes tamaños de pantalla, navegadores.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 14. PANEL DE ADMINISTRACIÓN ──────────────────────────
                [
                    'name'        => 'Panel de Administración',
                    'description' => 'Panel administrativo completo: gestión de usuarios, roles, configuraciones del sistema, logs, métricas.',
                    'quantity'    => 1,
                    'unit'        => 'módulo',
                    'unit_price'  => 300,
                    'tasks'       => [
                        [
                            'name'           => 'Gestión de usuarios admin',
                            'description'    => 'CRUD de usuarios: crear, editar, eliminar usuarios del sistema, asignar roles, cambiar contraseñas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de roles y permisos',
                            'description'    => 'Admin panel roles: crear roles, asignar permisos granulares, clonar roles, ver usuarios por rol.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración del sistema',
                            'description'    => 'Settings: configuraciones generales, período académico activo, opciones de visualización, integración ERP.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Logs y auditoría',
                            'description'    => 'Ver logs: actividad de usuarios, errores del sistema, accesos, exportaciones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Métricas del sistema',
                            'description'    => 'Stats: usuarios activos, visitas, uso de API, rendimiento del sistema.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Gestión de caché',
                            'description'    => 'Cache admin: limpiar caché, ver estadísticas de caché, forzar refresh de datos.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Backup y mantenimiento',
                            'description'    => 'Backups: configurar backups automáticos, restaurar sistema, herramientas de mantenimiento.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 15. INTEGRACIÓN COMPLETA ────────────────────────────
                [
                    'name'        => 'Integración Completa API-ERP-Dashboard',
                    'description' => 'Integración de todos los componentes: conectar API con ERP, mostrar datos en dashboard, probar flujos completos, optimizar.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 350,
                    'tasks'       => [
                        [
                            'name'           => 'Conexión API-ERP',
                            'description'    => 'Connect: establecer conexión estable con base de datos del ERP, manejo de reconexiones.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Integración con Dashboard',
                            'description'    => 'Connect API: consumir endpoints desde dashboard, mostrar datos en tiempo real o caché.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Sincronización de usuarios',
                            'description'    => 'Sync users: importar/sincronizar docentes, estudiantes, padres desde ERP periódicamente.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pruebas de integración',
                            'description'    => 'Integration testing: probar todos los flujos de datos, verificar correctitud, manejo de errores.',
                            'duration_value' => 3,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de consultas',
                            'description'    => 'Query optimization: optimizar queries al ERP, reducir tiempo de carga, caché efectivo.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Manejo de errores',
                            'description'    => 'Error handling: qué mostrar si el ERP no responde, retry logic, notificaciones de falla.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 16. OPTIMIZACIÓN Y SEGURIDAD ────────────────────────
                [
                    'name'        => 'Optimización de Performance y Seguridad',
                    'description' => 'Optimización técnica: velocidad, seguridad, protección de datos, mejores prácticas Laravel.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 200,
                    'tasks'       => [
                        [
                            'name'           => 'Auditoría de seguridad',
                            'description'    => 'Security audit: revisar vulnerabilidades, protección contra XSS, CSRF, SQL injection.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Protección de API',
                            'description'    => 'API security: rate limiting, autenticación JWT, cifrado de datos sensibles, headers de seguridad.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Optimización de assets',
                            'description'    => 'Assets: minificar CSS/JS, compresión, caché de navegador, CDN si aplica.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de producción',
                            'description'    => 'Production config: optimize Laravel para producción, queue workers, Horizon.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SSL y HTTPS',
                            'description'    => 'Setup SSL: configurar certificado, forzar HTTPS, HSTS.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 17. CAPACITACIÓN Y MANUAL ───────────────────────────
                [
                    'name'        => 'Capacitación y Manual de Uso',
                    'description' => 'Capacitación remota y manual de usuario: uso del dashboard admin, gestión de usuarios, interpretación de datos.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 150,
                    'tasks'       => [
                        [
                            'name'           => 'Manual de usuario PDF',
                            'description'    => 'Crear manual: documentación completa con capturas, guías paso a paso para cada módulo del dashboard y web app.',
                            'duration_value' => 4,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Manual técnico',
                            'description'    => 'Documentation: arquitectura, endpoints de API, configuración, despliegue, mantenimiento.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación administrativa',
                            'description'    => 'Capacitación admin: gestión de usuarios, roles, configuraciones, reportes. Duración 1.5-2 horas.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Capacitación de usuarios',
                            'description'    => 'Training users: cómo usar el dashboard, ver notas, horarios, actividades. Duración 1 hora.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                    ],
                ],

                // ─── 18. HOSTING Y DOMINIO ───────────────────────────────
                [
                    'name'        => 'Hosting y Dominio (primer año)',
                    'description' => 'Configuración de hosting y dominio: servidor configurado, SSL, publicación del sistema, pruebas en producción.',
                    'quantity'    => 1,
                    'unit'        => 'servicio',
                    'unit_price'  => 120,
                    'tasks'       => [
                        [
                            'name'           => 'Selección de hosting',
                            'description'    => 'Elegir hosting: evaluar opciones, seleccionar proveedor adecuado para Laravel y base de datos.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de servidor',
                            'description'    => 'Setup server: PHP, MySQL, Composer, Node.js, configuraciones de servidor.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Configuración de dominio',
                            'description'    => 'Setup domain: configurar DNS, subdominio, dominio principal.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'SSL y seguridad',
                            'description'    => 'Install SSL: certificado Let\'s Encrypt, configuración HTTPS, renovación automática.',
                            'duration_value' => 1,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Despliegue',
                            'description'    => 'Deploy: subir archivos, configurar entorno, migraciones, seeders, optimizar.',
                            'duration_value' => 2,
                            'duration_unit'  => 'hours',
                        ],
                        [
                            'name'           => 'Pruebas en producción',
                            'description'    => 'Testing: verificar todas las funcionalidades, testing de rendimiento, ajustes finales.',
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
