<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LubricacionMaquinariaPesadaQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente
     * - Lead de empresa
     * - Cotización en PEN del proyecto de actualización responsive
     *   Sistema de Verificación de Tiempos de Lubricación de Maquinaria Pesada
     *   Subtotal: S/ 2,000.00 + IGV 18% = S/ 2,360.00
     *   Duración: 3 semanas desarrollo + 2 semanas pruebas = 5 semanas total
     *   Pago: 50% al inicio (S/ 1,180.00) / 50% al culminar (S/ 1,180.00)
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente/empresa
            // =========================
            $clientName = 'Cliente Sistema Lubricación';
            $clientEmail = 'cliente@lubricacion-maquinaria.com';
            $clientPhone = null;
            $clientAddress = null;

            $companyName = 'Sistema de Lubricación de Maquinaria Pesada';
            $companyRuc = '00000000000'; // Actualizar con RUC real del cliente
            $companyIndustry = 'Mantenimiento Industrial / Maquinaria Pesada';

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
                    'project_type' => 'Actualización de Sistema Web - Versión Responsive Completa',
                    'budget_up_to' => 2360,
                    'message' => "Cotización para actualización del sistema de verificación de tiempos de lubricación de maquinaria pesada. Objetivo: hacer el sistema completamente responsive para administración desde dispositivos móviles.",
                    'status' => 'new',
                    'source' => 'seed',
                    'notes' => 'Lead creado automáticamente desde seeder. Sistema existente utilizado por grandes y pequeñas empresas para control de mantenimiento de maquinaria pesada.',
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
            // Subtotal: S/ 2,000.00
            // IGV (18%): S/ 360.00
            // Total: S/ 2,360.00
            // =========================
            $quoteNumber = 'COT-LUBMAQ-RESP-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id' => $clientUser->id,
                    'created_by' => $createdBy?->id,
                    'title' => "Cotización: Actualización Responsive - Sistema de Verificación de Tiempos de Lubricación de Maquinaria Pesada",
                    'description' => "Proyecto de actualización del sistema web existente de verificación de tiempos de lubricación de maquinaria pesada.\n\n" .
                        "OBJETIVO PRINCIPAL:\n" .
                        "Desarrollar una estructura completa, intuitiva y 100% responsive que permita administrar todas las funcionalidades del sistema desde dispositivos móviles (smartphones y tablets).\n\n" .
                        "ALCANCE DEL PROYECTO:\n" .
                        "- Evaluación completa del sistema actual.\n" .
                        "- Rediseño de interfaces para adaptabilidad móvil.\n" .
                        "- Implementación de componentes responsive.\n" .
                        "- Optimización de navegación táctil.\n" .
                        "- Pruebas exhaustivas en múltiples dispositivos.\n\n" .
                        "PÚBLICO OBJETIVO:\n" .
                        "El sistema es utilizado actualmente por grandes y pequeñas empresas para el control y seguimiento de tiempos de lubricación de maquinaria pesada.\n\n" .
                        "DURACIÓN ESTIMADA:\n" .
                        "- Desarrollo: 3 semanas\n" .
                        "- Pruebas y ajustes: 2 semanas\n" .
                        "- Total: 5 semanas",
                    'currency_id' => $pen->id,
                    'tax_rate' => 18,
                    'discount_amount' => 0,
                    'status' => 'draft',
                    'valid_until' => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(3)->toDateString(),
                    'notes' => "REQUISITOS PARA INICIAR:\n" .
                        "- Acceso completo al sistema actual (credenciales de administrador).\n" .
                        "- Documentación técnica existente (si la hay).\n" .
                        "- Listado de módulos y funcionalidades prioritarias.\n" .
                        "- Dispositivos de prueba o especificaciones de dispositivos objetivo.\n" .
                        "- Feedback de usuarios actuales sobre necesidades móviles.\n\n" .
                        "ENTREGABLES:\n" .
                        "- Sistema actualizado con interfaz 100% responsive.\n" .
                        "- Documentación de cambios realizados.\n" .
                        "- Manual de usuario actualizado para versión móvil.\n" .
                        "- Reporte de pruebas en múltiples dispositivos.\n" .
                        "- Capacitación sobre nuevas funcionalidades móviles.",
                    'terms_conditions' => "CONDICIONES COMERCIALES:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 2,000.00\n" .
                        "- IGV (18%): S/ 360.00\n" .
                        "- TOTAL: S/ 2,360.00\n\n" .
                        "FORMA DE PAGO:\n" .
                        "- 50% al iniciar el proyecto: S/ 1,180.00\n" .
                        "- 50% al culminar el proyecto: S/ 1,180.00\n\n" .
                        "PLAZOS:\n" .
                        "- Semana 1: Evaluación completa del sistema.\n" .
                        "- Semanas 2-3: Desarrollo e implementación responsive.\n" .
                        "- Semanas 4-5: Pruebas, ajustes y entrega final.\n\n" .
                        "CONSIDERACIONES:\n" .
                        "- Cualquier funcionalidad adicional fuera del alcance se cotiza por separado.\n" .
                        "- Las pruebas se realizarán en los dispositivos más comunes del mercado.\n" .
                        "- Se incluye soporte post-implementación de 15 días para ajustes menores.",
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

            // Subtotal items = S/ 2,000.00
            // IGV (18%) = S/ 360.00
            // Total con IGV = S/ 2,360.00
            $items = [
                // ==========================================
                // FASE 1: EVALUACIÓN DEL SISTEMA (Semana 1)
                // ==========================================
                [
                    'name' => 'Fase 1: Evaluación Completa del Sistema',
                    'description' => "Análisis exhaustivo del sistema actual de verificación de tiempos de lubricación de maquinaria pesada.\n\nIncluye:\n- Revisión de arquitectura y código fuente.\n- Mapeo de módulos y funcionalidades existentes.\n- Identificación de puntos críticos para adaptación responsive.\n- Análisis de base de datos y flujos de datos.\n- Documentación del estado actual.\n- Definición de estrategia de implementación responsive.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 400,
                    'tasks' => [
                        ['name' => 'Revisión de arquitectura técnica', 'description' => 'Análisis de la estructura del proyecto: tecnologías utilizadas, frameworks, patrones de diseño y dependencias.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Mapeo de módulos y funcionalidades', 'description' => 'Documentar todos los módulos del sistema: gestión de maquinaria, control de tiempos, reportes, usuarios, empresas, etc.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Análisis de interfaces actuales', 'description' => 'Evaluación de todas las vistas/pantallas existentes e identificación de elementos que requieren adaptación responsive.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Análisis de base de datos y API', 'description' => 'Revisión de estructura de datos, endpoints existentes y flujos de información.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Documentación y planificación', 'description' => 'Elaboración de documento de evaluación con hallazgos, recomendaciones y plan de trabajo detallado para la implementación.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Reunión de presentación de evaluación', 'description' => 'Presentación de resultados de la evaluación al cliente y validación del plan de trabajo.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 2: DISEÑO RESPONSIVE (Semana 2)
                // ==========================================
                [
                    'name' => 'Fase 2: Diseño de Interfaces Responsive',
                    'description' => "Diseño y maquetación de las interfaces adaptativas para dispositivos móviles y tablets.\n\nIncluye:\n- Diseño de sistema de navegación móvil.\n- Wireframes de pantallas principales en versión móvil.\n- Definición de breakpoints y comportamientos responsive.\n- Diseño de componentes táctiles (botones, formularios, tablas).\n- Prototipado de flujos críticos en móvil.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 350,
                    'tasks' => [
                        ['name' => 'Diseño de navegación móvil', 'description' => 'Crear sistema de navegación adaptativo: menú hamburguesa, barra inferior, navegación por gestos si aplica.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Wireframes de módulos principales', 'description' => 'Diseño de wireframes para: Dashboard, Listado de máquinas, Registro de lubricación, Reportes, Configuración.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de componentes responsive', 'description' => 'Diseño de tablas adaptativas, formularios táctiles, botones de acción, cards de información, modales responsive.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Prototipado de flujos críticos', 'description' => 'Prototipo interactivo de flujos: registro de lubricación, consulta de historial, generación de alertas.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Validación de diseños con cliente', 'description' => 'Presentación de propuestas de diseño y ajustes según feedback del cliente.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 3: DESARROLLO RESPONSIVE (Semana 2-3)
                // ==========================================
                [
                    'name' => 'Fase 3: Implementación de Estructura Responsive',
                    'description' => "Desarrollo e implementación de la estructura responsive en todo el sistema.\n\nIncluye:\n- Implementación de grid system responsive.\n- Adaptación de layouts existentes.\n- Desarrollo de componentes responsive reutilizables.\n- Implementación de media queries.\n- Optimización de CSS/SCSS.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 450,
                    'tasks' => [
                        ['name' => 'Configuración de framework responsive', 'description' => 'Setup de sistema de grid, variables CSS, mixins de responsive y configuración de breakpoints.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Desarrollo de componentes base', 'description' => 'Implementación de componentes reutilizables: headers, footers, sidebars, cards, botones responsive.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Adaptación del Dashboard', 'description' => 'Implementación responsive del dashboard principal: widgets, gráficos, resumen de alertas, accesos rápidos.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Adaptación de tablas y listados', 'description' => 'Implementación de tablas responsive (scroll horizontal, cards en móvil, filtros adaptables).', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Adaptación de formularios', 'description' => 'Optimización de formularios para uso táctil: campos, selectores, datepickers, validaciones.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 4: MÓDULOS ESPECÍFICOS (Semana 3)
                // ==========================================
                [
                    'name' => 'Fase 4: Adaptación de Módulos Específicos',
                    'description' => "Implementación responsive de los módulos específicos del sistema de lubricación.\n\nIncluye:\n- Módulo de gestión de maquinaria.\n- Módulo de registro de lubricación.\n- Módulo de alertas y notificaciones.\n- Módulo de reportes.\n- Módulo de configuración y usuarios.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 400,
                    'tasks' => [
                        ['name' => 'Módulo de Gestión de Maquinaria', 'description' => 'Adaptación responsive: listado de máquinas, ficha técnica, historial de mantenimiento, state cards.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de Registro de Lubricación', 'description' => 'Adaptación del flujo de registro: selección de máquina, tipo de lubricante, fecha/hora, observaciones. Optimizado para captura rápida en campo.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de Alertas y Notificaciones', 'description' => 'Sistema de alertas responsive: notificaciones push-like, listado de alertas pendientes, acciones rápidas.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de Reportes', 'description' => 'Adaptación de reportes para visualización móvil: filtros colapsables, gráficos responsive, exportación.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de Configuración y Usuarios', 'description' => 'Adaptación de pantallas de configuración: gestión de usuarios, parámetros del sistema, perfiles de empresa.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 5: PRUEBAS Y QA (Semana 4-5)
                // ==========================================
                [
                    'name' => 'Fase 5: Pruebas, QA y Optimización',
                    'description' => "Fase de pruebas exhaustivas y aseguramiento de calidad en múltiples dispositivos.\n\nIncluye:\n- Pruebas en dispositivos reales (iOS/Android).\n- Pruebas en diferentes resoluciones y navegadores.\n- Optimización de rendimiento móvil.\n- Corrección de bugs y ajustes.\n- Pruebas de usabilidad.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 250,
                    'tasks' => [
                        ['name' => 'Pruebas en dispositivos móviles', 'description' => 'Testing en smartphones iOS y Android de diferentes tamaños: iPhone SE, iPhone 14+, Samsung Galaxy, Xiaomi, etc.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas en tablets', 'description' => 'Testing en tablets: iPad, tablets Android. Verificación de layouts en orientación vertical y horizontal.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de navegadores', 'description' => 'Verificación de compatibilidad en Chrome, Safari, Firefox, Edge (versiones móviles y desktop).', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Optimización de rendimiento', 'description' => 'Análisis y optimización: carga de imágenes, lazy loading, minimización de CSS/JS, tiempos de respuesta.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Corrección de bugs y ajustes', 'description' => 'Resolución de issues encontrados durante las pruebas y ajustes de usabilidad.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 6: ENTREGA Y DOCUMENTACIÓN (Semana 5)
                // ==========================================
                [
                    'name' => 'Fase 6: Entrega Final y Documentación',
                    'description' => "Cierre del proyecto con documentación y capacitación.\n\nIncluye:\n- Documentación técnica de cambios.\n- Manual de usuario actualizado.\n- Capacitación sobre uso móvil.\n- Deploy a producción.\n- Soporte post-implementación.",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 150,
                    'tasks' => [
                        ['name' => 'Documentación técnica', 'description' => 'Documentar todos los cambios realizados: nuevos componentes, estructura CSS, breakpoints, guía de estilos.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Manual de usuario móvil', 'description' => 'Actualización del manual de usuario con instrucciones para uso desde dispositivos móviles.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Capacitación al equipo', 'description' => 'Sesión de capacitación sobre las nuevas funcionalidades responsive y mejores prácticas de uso móvil.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Despliegue a producción', 'description' => 'Deploy de cambios a ambiente de producción con verificación de funcionamiento.', 'duration_value' => 3, 'duration_unit' => 'hours'],
                        ['name' => 'Reporte final y cierre', 'description' => 'Entrega de reporte final con resumen de trabajo realizado, métricas de mejora y recomendaciones.', 'duration_value' => 2, 'duration_unit' => 'hours'],
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
