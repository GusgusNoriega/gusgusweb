<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BetkoPeruAppLubricacionQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (BETKO PERU)
     * - Lead de empresa (RUC: 20371939173)
     * - Cotización en PEN para desarrollo de aplicación móvil
     *   Sistema de Lubricación de Maquinaria Pesada con sincronización offline
     *   Subtotal: S/ 6,000.00 + IGV 18% = S/ 7,080.00
     *   Duración: 3 meses de desarrollo + período de pruebas
     *   Pago: 50% al inicio (S/ 3,540.00) / 50% al culminar (S/ 3,540.00)
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente/empresa
            // =========================
            $clientName = 'M. Guerrero';
            $clientEmail = 'mguerrero@betkoperu.com';
            $clientPhone = null;
            $clientAddress = null;

            $companyName = 'BETKO PERU S.A.C.';
            $companyRuc = '20371939173';
            $companyIndustry = 'Mantenimiento Industrial / Lubricación de Maquinaria Pesada';

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
                    'project_type' => 'Aplicación Móvil Nativa - Sistema de Lubricación con Sincronización Offline',
                    'budget_up_to' => 7080,
                    'message' => "Cotización para desarrollo de aplicación móvil conectada al sistema de lubricación existente de {$companyName}. Funcionalidad principal: gestión de lubricaciones sin conexión a internet con sincronización automática.",
                    'status' => 'new',
                    'source' => 'seed',
                    'notes' => "Lead creado automáticamente desde seeder. Proyecto de aplicación móvil para sistema de lubricación de maquinaria pesada con capacidad offline-first.",
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
            // Subtotal: S/ 6,000.00
            // IGV (18%): S/ 1,080.00
            // Total: S/ 7,080.00
            // =========================
            $quoteNumber = 'COT-20371939173-APP-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id' => $clientUser->id,
                    'created_by' => $createdBy?->id,
                    'title' => "Cotización: Aplicación Móvil - Sistema de Lubricación de Maquinaria Pesada con Sincronización Offline - {$companyName}",
                    'description' => "Proyecto de desarrollo de aplicación móvil nativa para {$companyName} (BETKO PERU), conectada al sistema web existente de verificación de tiempos de lubricación de maquinaria pesada.\n\n" .
                        "OBJETIVO PRINCIPAL:\n" .
                        "Desarrollar una aplicación móvil que permita a los operadores y técnicos gestionar las lubricaciones de maquinaria pesada directamente desde sus dispositivos móviles, con capacidad de trabajo OFFLINE (sin conexión a internet) y sincronización automática cuando se recupere la conexión.\n\n" .
                        "CARACTERÍSTICAS PRINCIPALES:\n" .
                        "- Aplicación móvil nativa (Android/iOS o híbrida según evaluación).\n" .
                        "- Conexión con el sistema web actual a través de APIs.\n" .
                        "- Funcionamiento 100% offline para registro de lubricaciones.\n" .
                        "- Sincronización automática de datos al recuperar conexión.\n" .
                        "- Gestión de conflictos de sincronización.\n" .
                        "- Almacenamiento local seguro de datos.\n" .
                        "- Notificaciones push de alertas de mantenimiento.\n\n" .
                        "PÚBLICO OBJETIVO:\n" .
                        "Técnicos y operadores de campo que realizan lubricaciones en zonas donde la conectividad puede ser limitada o inexistente.\n\n" .
                        "DURACIÓN ESTIMADA:\n" .
                        "- Desarrollo: 3 meses (12 semanas)\n" .
                        "- Pruebas y ajustes: 3-4 semanas adicionales\n" .
                        "- Total: Aproximadamente 4 meses",
                    'currency_id' => $pen->id,
                    'tax_rate' => 18,
                    'discount_amount' => 0,
                    'status' => 'draft',
                    'valid_until' => now()->addDays(30)->toDateString(),
                    'estimated_start_date' => now()->addDays(7)->toDateString(),
                    'notes' => "REQUISITOS PARA INICIAR:\n" .
                        "- Acceso completo al sistema web actual (credenciales de administrador y desarrollador).\n" .
                        "- Documentación técnica de APIs existentes (si la hay).\n" .
                        "- Acceso al código fuente del backend para evaluar endpoints.\n" .
                        "- Credenciales de bases de datos para entender estructura de datos.\n" .
                        "- Listado de funcionalidades prioritarias para la app.\n" .
                        "- Especificaciones de dispositivos móviles utilizados por el equipo.\n" .
                        "- Cuenta de desarrollador Apple (si se requiere iOS) - costo adicional del cliente.\n" .
                        "- Cuenta de desarrollador Google Play - costo adicional del cliente.\n\n" .
                        "ENTREGABLES:\n" .
                        "- Aplicación móvil funcional (APK para Android / IPA para iOS si aplica).\n" .
                        "- APIs nuevas o actualizadas para sincronización.\n" .
                        "- Documentación técnica completa.\n" .
                        "- Manual de usuario de la aplicación.\n" .
                        "- Código fuente de la aplicación.\n" .
                        "- Capacitación al equipo de usuarios.\n" .
                        "- Soporte post-lanzamiento (30 días).",
                    'terms_conditions' => "CONDICIONES COMERCIALES:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 6,000.00\n" .
                        "- IGV (18%): S/ 1,080.00\n" .
                        "- TOTAL: S/ 7,080.00\n\n" .
                        "FORMA DE PAGO:\n" .
                        "- 50% al iniciar el proyecto: S/ 3,540.00\n" .
                        "- 50% al culminar el proyecto: S/ 3,540.00\n\n" .
                        "CRONOGRAMA GENERAL:\n" .
                        "- Mes 1: Evaluación, diseño y desarrollo de APIs.\n" .
                        "- Mes 2: Desarrollo de la aplicación móvil core.\n" .
                        "- Mes 3: Implementación offline, sincronización y módulos.\n" .
                        "- Mes 4: Pruebas, correcciones y despliegue.\n\n" .
                        "CONSIDERACIONES IMPORTANTES:\n" .
                        "- Las cuentas de desarrollador (Google Play ~$25 USD, Apple ~$99 USD/año) son responsabilidad del cliente.\n" .
                        "- El hosting de APIs adicionales (si se requiere) es responsabilidad del cliente.\n" .
                        "- Cualquier funcionalidad adicional fuera del alcance se cotiza por separado.\n" .
                        "- Se incluye soporte post-lanzamiento de 30 días para bugs críticos.\n" .
                        "- Las pruebas se realizarán en dispositivos Android e iOS representativos del mercado.\n" .
                        "- Se requiere disponibilidad del cliente para sesiones de validación y pruebas.",
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

            // Subtotal items = S/ 6,000.00
            // IGV (18%) = S/ 1,080.00
            // Total con IGV = S/ 7,080.00
            $items = [
                // ==========================================
                // FASE 1: EVALUACIÓN Y ANÁLISIS (Semanas 1-2)
                // ==========================================
                [
                    'name' => 'Fase 1: Evaluación del Sistema Actual y Análisis de APIs',
                    'description' => "Análisis exhaustivo del sistema web existente de lubricación de maquinaria pesada, con enfoque en las APIs actuales y requerimientos para la aplicación móvil.\n\nIncluye:\n- Revisión de arquitectura del sistema actual.\n- Análisis y documentación de APIs existentes.\n- Diagnóstico de APIs necesarias para la aplicación.\n- Evaluación de estructura de base de datos.\n- Definición de requerimientos de sincronización.\n- Documento de especificaciones técnicas.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 600,
                    'tasks' => [
                        ['name' => 'Revisión de arquitectura del sistema web', 'description' => 'Análisis de la estructura del proyecto web actual: tecnologías utilizadas, frameworks, base de datos, servidores y patrones de diseño implementados.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Análisis y documentación de APIs existentes', 'description' => 'Revisión detallada de todos los endpoints actuales: métodos HTTP, parámetros, respuestas, autenticación y autorización. Documentación en formato estándar (OpenAPI/Swagger).', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Diagnóstico de APIs necesarias', 'description' => 'Identificar qué APIs existentes pueden reutilizarse, cuáles necesitan modificaciones y cuáles deben crearse desde cero para soportar la funcionalidad móvil y offline.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Análisis de estructura de base de datos', 'description' => 'Revisión del modelo de datos: tablas, relaciones, índices y campos necesarios para sincronización. Identificar datos que requieren réplica en dispositivo móvil.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Definición de estrategia de sincronización', 'description' => 'Diseño del mecanismo de sincronización: manejo de conflictos, timestamps, versionado de datos, estrategia de merge y resolución de colisiones.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Documento de especificaciones técnicas', 'description' => 'Elaboración del documento técnico con hallazgos, recomendaciones, arquitectura propuesta para la app y plan de desarrollo detallado.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Reunión de presentación y validación', 'description' => 'Presentación de resultados de evaluación al cliente, validación de alcance y ajustes al plan de trabajo.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 2: DESARROLLO DE APIs (Semanas 2-4)
                // ==========================================
                [
                    'name' => 'Fase 2: Desarrollo y Actualización de APIs para Aplicación Móvil',
                    'description' => "Desarrollo de las APIs necesarias para la comunicación entre la aplicación móvil y el sistema web existente.\n\nIncluye:\n- Actualización de APIs existentes para soporte móvil.\n- Desarrollo de nuevas APIs para funcionalidades específicas.\n- Implementación de endpoints de sincronización.\n- Sistema de autenticación móvil (tokens).\n- APIs de gestión de conflictos.\n- Documentación completa de APIs.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 850,
                    'tasks' => [
                        ['name' => 'Configuración de entorno de APIs móviles', 'description' => 'Setup de rutas, middlewares específicos para app móvil, rate limiting, CORS y configuración de respuestas optimizadas para móvil.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'API de autenticación móvil', 'description' => 'Implementación de sistema de autenticación por tokens (JWT/OAuth), refresh tokens, manejo de sesiones y logout remoto.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'APIs de gestión de maquinaria', 'description' => 'Endpoints para: listar máquinas, obtener detalle de máquina, historial de lubricaciones, estado actual. Optimizados para consumo móvil con paginación y filtros.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'APIs de registro de lubricación', 'description' => 'Endpoints para: crear registro de lubricación, actualizar, eliminar, adjuntar evidencias (fotos). Soporte para envío batch de registros offline.', 'duration_value' => 14, 'duration_unit' => 'hours'],
                        ['name' => 'APIs de sincronización', 'description' => 'Desarrollo de endpoints especializados: sync pull (obtener cambios del servidor), sync push (enviar cambios locales), verificación de conflictos, timestamps de última sincronización.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'APIs de catálogos y configuración', 'description' => 'Endpoints para: tipos de lubricantes, catálogos de máquinas, configuraciones del sistema, parámetros de negocio que deben estar disponibles offline.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'APIs de alertas y notificaciones', 'description' => 'Endpoints para: obtener alertas pendientes, marcar alertas como vistas, configuración de notificaciones push.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Documentación y testing de APIs', 'description' => 'Documentación completa en Swagger/OpenAPI, colección de Postman para pruebas, tests automatizados de endpoints críticos.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 3: DISEÑO UX/UI APLICACIÓN (Semanas 3-4)
                // ==========================================
                [
                    'name' => 'Fase 3: Diseño UX/UI de la Aplicación Móvil',
                    'description' => "Diseño de la experiencia de usuario e interfaces de la aplicación móvil, optimizadas para trabajo en campo.\n\nIncluye:\n- Investigación de usuarios y casos de uso.\n- Arquitectura de información de la app.\n- Wireframes de todas las pantallas.\n- Diseño visual de interfaces (UI).\n- Prototipo interactivo.\n- Diseño de estados offline/online.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 500,
                    'tasks' => [
                        ['name' => 'Investigación de usuarios y contexto', 'description' => 'Entender el perfil de los usuarios finales: técnicos de campo, condiciones de trabajo, dispositivos utilizados, contextos de uso sin conectividad.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Arquitectura de información', 'description' => 'Definición de la estructura de navegación de la app: flujos principales, jerarquía de pantallas, navegación bottom/tab/drawer.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Wireframes de pantallas principales', 'description' => 'Diseño de wireframes: Login, Dashboard, Lista de máquinas, Detalle de máquina, Formulario de lubricación, Historial, Sincronización, Configuración.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de sistema de componentes', 'description' => 'Definición del sistema de diseño: colores, tipografías, iconografía, botones, cards, formularios, estados de carga y error.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño UI de pantallas', 'description' => 'Diseño visual de alta fidelidad de todas las pantallas de la aplicación, siguiendo Material Design (Android) y Human Interface Guidelines (iOS).', 'duration_value' => 14, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de estados offline/online', 'description' => 'Diseño de indicadores visuales de estado de conexión, cola de sincronización, conflictos pendientes, datos desactualizados.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Prototipo interactivo', 'description' => 'Creación de prototipo navegable en Figma/Adobe XD para validación con el cliente antes del desarrollo.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Validación de diseños con cliente', 'description' => 'Presentación de propuesta de diseño, recepción de feedback y ajustes finales antes de desarrollo.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 4: DESARROLLO APP - CORE (Semanas 5-7)
                // ==========================================
                [
                    'name' => 'Fase 4: Desarrollo de Aplicación Móvil - Módulo Core',
                    'description' => "Desarrollo del núcleo de la aplicación móvil con funcionalidades fundamentales.\n\nIncluye:\n- Configuración del proyecto móvil (React Native/Flutter).\n- Sistema de autenticación y sesiones.\n- Navegación principal de la app.\n- Conexión con APIs del backend.\n- Dashboard principal.\n- Sistema de gestión de estado.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 900,
                    'tasks' => [
                        ['name' => 'Configuración del proyecto móvil', 'description' => 'Setup inicial del proyecto: framework seleccionado (React Native/Flutter), estructura de carpetas, configuración de linters, entorno de desarrollo Android/iOS.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Implementación de navegación', 'description' => 'Configuración del sistema de navegación: stack navigation, tab navigation, drawer si aplica, deep linking.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Sistema de gestión de estado', 'description' => 'Implementación de state management (Redux/Bloc/Provider): stores, actions, reducers, selectors para datos de la aplicación.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de autenticación', 'description' => 'Desarrollo de pantallas de login, manejo de tokens, persistencia de sesión, auto-refresh de tokens, logout.', 'duration_value' => 14, 'duration_unit' => 'hours'],
                        ['name' => 'Capa de servicios y APIs', 'description' => 'Implementación de la capa de servicios HTTP: interceptores, manejo de errores, retry logic, headers de autenticación.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Dashboard principal', 'description' => 'Desarrollo de la pantalla de inicio: resumen de lubricaciones pendientes, alertas activas, accesos rápidos, indicador de sincronización.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Componentes UI reutilizables', 'description' => 'Desarrollo del sistema de componentes base: buttons, inputs, cards, lists, modals, loading states, error states.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Testing y QA del módulo core', 'description' => 'Pruebas unitarias de componentes, integración y verificación de flujos principales de la aplicación.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 5: DESARROLLO OFFLINE/SYNC (Semanas 7-9)
                // ==========================================
                [
                    'name' => 'Fase 5: Implementación de Sistema Offline y Sincronización',
                    'description' => "Desarrollo del sistema de almacenamiento local y sincronización de datos, permitiendo el uso de la app sin conexión a internet.\n\nIncluye:\n- Base de datos local (SQLite/Realm/WatermelonDB).\n- Sistema de caché de datos.\n- Cola de operaciones offline.\n- Motor de sincronización bidireccional.\n- Resolución de conflictos.\n- Indicadores de estado de sincronización.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 1000,
                    'tasks' => [
                        ['name' => 'Configuración de base de datos local', 'description' => 'Setup de base de datos local (SQLite/Realm/WatermelonDB): definición de schemas, migraciones, índices para consultas rápidas.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Implementación de modelos locales', 'description' => 'Desarrollo de modelos de datos locales: máquinas, lubricaciones, usuarios, catálogos, configuraciones. Mapeo con modelos del servidor.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Sistema de caché de datos', 'description' => 'Implementación de estrategia de caché: datos maestros, catálogos, configuraciones. TTL de caché, invalidación y actualización.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Cola de operaciones offline', 'description' => 'Desarrollo del sistema de queue para operaciones realizadas sin conexión: persistencia de operaciones, orden de ejecución, reintentos.', 'duration_value' => 14, 'duration_unit' => 'hours'],
                        ['name' => 'Motor de sincronización - Push', 'description' => 'Implementación del sync push: envío de cambios locales al servidor, manejo de errores, rollback en caso de fallo, confirmación de sync.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Motor de sincronización - Pull', 'description' => 'Implementación del sync pull: obtención de cambios del servidor, actualización de datos locales, manejo de eliminaciones.', 'duration_value' => 14, 'duration_unit' => 'hours'],
                        ['name' => 'Sistema de resolución de conflictos', 'description' => 'Desarrollo de lógica de resolución de conflictos: última escritura gana, merge de campos, notificación de conflictos al usuario, UI de resolución manual.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Detección de conectividad', 'description' => 'Implementación de detector de estado de red: cambios de conectividad, triggers de sincronización automática, reintentos con backoff exponencial.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'UI de estado de sincronización', 'description' => 'Desarrollo de componentes visuales: indicador de sync en progreso, cola pendiente, último sync exitoso, errores de sincronización.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 6: MÓDULOS FUNCIONALES (Semanas 9-11)
                // ==========================================
                [
                    'name' => 'Fase 6: Desarrollo de Módulos Funcionales de la Aplicación',
                    'description' => "Desarrollo de los módulos específicos del negocio: gestión de maquinaria, registro de lubricaciones, alertas y reportes.\n\nIncluye:\n- Módulo de gestión de maquinaria.\n- Módulo de registro de lubricación (offline-first).\n- Módulo de alertas y notificaciones push.\n- Módulo de historial y reportes.\n- Captura de evidencias fotográficas.\n- Configuración de usuario.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 900,
                    'tasks' => [
                        ['name' => 'Módulo de listado de maquinaria', 'description' => 'Desarrollo de pantalla de lista de máquinas: búsqueda, filtros por estado/tipo/ubicación, cards con estado de lubricación, indicador de datos offline.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de detalle de máquina', 'description' => 'Pantalla de ficha técnica: información de la máquina, historial de lubricaciones, próxima lubricación programada, acciones rápidas.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Formulario de registro de lubricación', 'description' => 'Desarrollo del formulario completo: selección de máquina, tipo de lubricante, cantidad, fecha/hora, observaciones, firma digital opcional. 100% funcional offline.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Captura de evidencias fotográficas', 'description' => 'Integración con cámara del dispositivo: captura de fotos, compresión, almacenamiento local, sincronización posterior de imágenes.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de alertas y notificaciones', 'description' => 'Listado de alertas pendientes, detalle de alerta, acciones (marcar como atendida, posponer). Integración con notificaciones push del sistema.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Configuración de notificaciones push', 'description' => 'Setup de Firebase Cloud Messaging (FCM) / APNs: recepción de push, manejo en foreground/background, deep linking desde notificación.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de historial y reportes', 'description' => 'Pantalla de historial de lubricaciones: filtros por fecha/máquina/operador, exportación básica, gráficos simples de resumen.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Configuración y perfil de usuario', 'description' => 'Pantalla de configuración: perfil del usuario, ajustes de sincronización, preferencias de notificaciones, cerrar sesión, información de la app.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 7: PRUEBAS Y QA (Semanas 12-14)
                // ==========================================
                [
                    'name' => 'Fase 7: Pruebas Integrales, QA y Optimización',
                    'description' => "Fase exhaustiva de pruebas para garantizar la calidad y confiabilidad de la aplicación, especialmente en escenarios offline.\n\nIncluye:\n- Pruebas funcionales completas.\n- Pruebas de sincronización y offline.\n- Pruebas en dispositivos reales.\n- Pruebas de rendimiento.\n- Corrección de bugs.\n- Optimización de la aplicación.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 700,
                    'tasks' => [
                        ['name' => 'Pruebas funcionales por módulo', 'description' => 'Testing exhaustivo de cada módulo: autenticación, maquinaria, lubricaciones, alertas, configuración. Verificación de todos los flujos de usuario.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de sincronización', 'description' => 'Testing del sistema de sync: creación offline, edición offline, eliminación offline, sincronización parcial, sincronización completa, errores de red.', 'duration_value' => 14, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de escenarios offline', 'description' => 'Testing de uso sin conexión: registro de múltiples lubricaciones, trabajo prolongado offline (días), recuperación de conexión, datos corruptos.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de conflictos de datos', 'description' => 'Simulación de conflictos: edición simultánea, datos modificados en servidor mientras se trabaja offline, resolución de conflictos.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas en dispositivos Android', 'description' => 'Testing en múltiples dispositivos Android: distintas versiones de OS (Android 10+), diferentes tamaños de pantalla, marcas variadas.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas en dispositivos iOS', 'description' => 'Testing en dispositivos iOS (si aplica): iPhone SE, iPhone 14+, diferentes versiones de iOS (15+).', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de rendimiento y batería', 'description' => 'Análisis de consumo de recursos: memoria, CPU, batería durante uso normal y durante sincronización. Optimización donde sea necesario.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Corrección de bugs y ajustes', 'description' => 'Resolución de todos los issues encontrados durante las pruebas: bugs funcionales, problemas de UI, errores de sincronización.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Optimización general de la app', 'description' => 'Optimización de rendimiento: tiempos de carga, tamaño de app, lazy loading, compresión de imágenes, limpieza de código.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 8: DESPLIEGUE Y ENTREGA (Semanas 14-16)
                // ==========================================
                [
                    'name' => 'Fase 8: Despliegue, Documentación y Entrega Final',
                    'description' => "Cierre del proyecto con publicación de la aplicación y entrega de todos los entregables.\n\nIncluye:\n- Preparación para publicación en stores.\n- Documentación técnica completa.\n- Manual de usuario.\n- Capacitación al equipo.\n- Despliegue de APIs a producción.\n- Soporte post-lanzamiento.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 550,
                    'tasks' => [
                        ['name' => 'Preparación de assets para stores', 'description' => 'Creación de iconos, screenshots, feature graphics, descripciones para Google Play Store y App Store.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Build de producción Android', 'description' => 'Generación de APK/AAB firmado para producción, configuración de ofuscación, optimización de release.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Build de producción iOS', 'description' => 'Generación de IPA para producción (si aplica), configuración de certificados, provisioning profiles.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Publicación en Google Play Store', 'description' => 'Subida de app a Google Play Console, configuración de ficha de la app, pruebas internas, publicación.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Publicación en App Store', 'description' => 'Subida a App Store Connect (si aplica), revisión de Apple, configuración de TestFlight, publicación.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Despliegue de APIs a producción', 'description' => 'Deploy de nuevas APIs y actualizaciones al servidor de producción, verificación de funcionamiento, monitoreo inicial.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Documentación técnica', 'description' => 'Documentación completa: arquitectura de la app, APIs desarrolladas, base de datos local, sistema de sincronización, guía de mantenimiento.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Manual de usuario', 'description' => 'Elaboración de manual de usuario ilustrado: instalación, autenticación, uso de módulos, trabajo offline, sincronización, troubleshooting.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Capacitación al equipo', 'description' => 'Sesiones de capacitación: una para administradores/TI sobre gestión de la app, otra para usuarios finales sobre uso en campo.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Entrega de código fuente', 'description' => 'Entrega de repositorios con código fuente de la app y APIs, documentación de setup de desarrollo, credenciales y accesos.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Soporte post-lanzamiento (30 días)', 'description' => 'Período de soporte incluido: corrección de bugs críticos, ajustes menores, soporte técnico básico.', 'duration_value' => 20, 'duration_unit' => 'hours'],
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
