<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SociedadAgropecuariaDiegoAlbertoQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Diego Macavilca) + Lead (RUC: 20557685015)
     * - Cotización en PEN (S/ 10,169.49 sin IGV + IGV 18% = S/ 12,000.00 total) para:
     *   - Sistema de Gestión Avícola integral con:
     *     - Recepción de pollos en cajas
     *     - Pesaje de pollos en cajas
     *     - Control de inventario de pollos
     *     - Control de ventas
     *     - Deudas de clientes mayoristas
     *     - Manejo de usuarios y roles
     *     - Sincronización con balanzas para pesaje en tiempo real
     *     - Interfaz touch para operación
     *     - Sistema en VPS/Cloud
     *   - Evaluación de procesos actuales: 1 semana mínimo
     *
     * Cliente: Diego Macavilca
     * Empresa: Sociedad Agropecuaria Diego Alberto
     * RUC: 20557685015
     * Correo: diegomacavilca442@gmail.com
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente/empresa
            // =========================
            $clientName = 'Diego Macavilca';
            $clientEmail = 'diegomacavilca442@gmail.com';
            $clientPhone = null;
            $clientAddress = null;

            $companyName = 'Sociedad Agropecuaria Diego Alberto';
            $companyRuc = '20557685015';
            $companyIndustry = 'Empresa Avícola';

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
                    'project_type' => 'Sistema de Gestión Avícola Integral - Recepción, Pesaje, Inventario, Ventas, Deudas, Usuarios, Balanzas, Touch',
                    'budget_up_to' => 12000,
                    'message' => "Cotización solicitada para: {$companyName} (RUC: {$companyRuc}). Sistema integral para empresa avícola con módulos de recepción de pollos, pesaje con balanzas, control de inventario, ventas, gestión de deudas de clientes mayoristas, usuarios y roles, con interfaz touch para operación.",
                    'status' => 'new',
                    'source' => 'seed',
                    'notes' => 'Lead creado automáticamente desde seeder para generar cotización formal del sistema de gestión avícola integral.',
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
            // Subtotal: S/ 10,169.49
            // IGV (18%): S/ 1,830.51
            // Total: S/ 12,000.00
            // =========================
            $quoteNumber = 'COT-20557685015-AVICOLA-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id' => $clientUser->id,
                    'created_by' => $createdBy?->id,
                    'title' => "Cotización: Sistema de Gestión Avícola Integral - {$companyName}",
                    'description' => "Desarrollo e implementación de un sistema web integral para {$companyName}, empresa dedicada a la actividad avícola.\n\n" .
                        "OBJETIVO PRINCIPAL:\n" .
                        "Desarrollar un sistema de gestión integral que permita automatizar y controlar todos los procesos operativos de la empresa avícola, desde la recepción de pollos hasta el control de ventas y deudas de clientes.\n\n" .
                        "MÓDULOS Y FUNCIONALIDADES PRINCIPALES:\n" .
                        "1. Recepción de Pollos en Cajas:\n" .
                        "   - Registro de ingresos de pollos por cajas\n" .
                        "   - Identificación de proveedores/camiones\n" .
                        "   - Trazabilidad completa del ingreso\n\n" .
                        "2. Pesaje de Pollos en Cajas:\n" .
                        "   - Integración con balanzas para pesaje en tiempo real\n" .
                        "   - Registro automático de peso por caja\n" .
                        "   - Suma total de pollos en camiones\n" .
                        "   - Historial de pesajes\n\n" .
                        "3. Control de Inventario de Pollos:\n" .
                        "   - Control de stock en tiempo real\n" .
                        "   - Movimientos de ingreso y salida\n" .
                        "   - Alertas de stock mínimo\n" .
                        "   - Reportes de inventario\n\n" .
                        "4. Control de Ventas:\n" .
                        "   - Registro de ventas de pollos\n" .
                        "   - Generación de comprobantes\n" .
                        "   - Historial de ventas por cliente\n" .
                        "   - Reportes de ventas\n\n" .
                        "5. Gestión de Deudas de Clientes Mayoristas:\n" .
                        "   - Control de crédito para clientes mayoristas\n" .
                        "   - Registro de pagos y abonos\n" .
                        "   - Alertas de morosidad\n" .
                        "   - Estado de cuenta por cliente\n\n" .
                        "6. Gestión de Usuarios y Roles:\n" .
                        "   - Administración de usuarios del sistema\n" .
                        "   - Roles y permisos (RBAC)\n" .
                        "   - Control de acceso por funciones\n" .
                        "   - Registro de acciones (logs)\n\n" .
                        "7. Interfaz Touch para Operación:\n" .
                        "   - Pantallas táctiles para área operativa\n" .
                        "   - Diseño adaptado para touch\n" .
                        "   - Flujos optimizados para操作的 rápida\n\n" .
                        "8. Sistema en VPS/Cloud:\n" .
                        "   - Hospedaje en servidor cloud/VPS\n" .
                        "   - Acceso desde cualquier ubicación\n" .
                        "   - Respaldo y alta disponibilidad\n\n" .
                        "DURACIÓN ESTIMADA:\n" .
                        "- Evaluación de procesos actuales: 1 semana (mínimo)\n" .
                        "- Desarrollo: 4-6 semanas\n" .
                        "- Pruebas y ajustes: 2 semanas\n" .
                        "- Total estimado: 8-10 semanas",
                    'currency_id' => $pen->id,
                    'tax_rate' => 18,
                    'discount_amount' => 0,
                    'status' => 'draft',
                    'valid_until' => now()->addDays(15)->toDateString(),
                    'estimated_start_date' => now()->addDays(7)->toDateString(),
                    'notes' => "REQUISITOS PARA INICIAR:\n" .
                        "- Acceso completo a los sistemas actuales (si existen)\n" .
                        "- Documentación de procesos operativos actuales\n" .
                        "- Listado de proveedores de pollos\n" .
                        "- Catálogo de clientes mayoristas\n" .
                        "- Información de balanzas a integrar (modelo, protocolo)\n" .
                        "- Especificaciones del hardware touch disponible\n" .
                        "- Definición de estructura organizacional y roles\n\n" .
                        "ENTREGABLES:\n" .
                        "- Sistema web funcional en VPS/Cloud\n" .
                        "- Módulo de recepción de pollos\n" .
                        "- Módulo de pesaje con integración a balanzas\n" .
                        "- Módulo de inventario\n" .
                        "- Módulo de ventas\n" .
                        "- Módulo de gestión de deudas\n" .
                        "- Módulo de usuarios y roles (RBAC)\n" .
                        "- Interfaz touch configurada\n" .
                        "- Documentación técnica y de usuario\n" .
                        "- Capacitación al personal\n" .
                        "- Soporte post-implementación (15 días)\n\n" .
                        "NOTAS IMPORTANTES:\n" .
                        "- El costo de VPS/Cloud NO está incluido en esta cotización.\n" .
                        "- Costo estimado de VPS/Cloud: S/ 800 - S/ 1,000 soles por mes (cliente debe considerar este gasto adicional).\n" .
                        "- La integración con balanzas depende del modelo y protocolo de comunicación del equipo existente.\n" .
                        "- Se requiere una evaluación presencial o remota de los procesos actuales (mínimo 1 semana) para afinar los requerimientos.",
                    'terms_conditions' => "CONDICIONES COMERCIALES:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 10,169.49\n" .
                        "- IGV (18%): S/ 1,830.51\n" .
                        "- TOTAL: S/ 12,000.00\n\n" .
                        "FORMA DE PAGO:\n" .
                        "- 50% al iniciar el proyecto: S/ 6,000.00\n" .
                        "- 50% al culminar el proyecto: S/ 6,000.00\n\n" .
                        "PLAZOS:\n" .
                        "- Semana 1: Evaluación de procesos actuales (mínimo 1 semana)\n" .
                        "- Semanas 2-5: Desarrollo de módulos\n" .
                        "- Semanas 6-7: Pruebas y ajustes\n" .
                        "- Semana 8: Entrega y capacitación\n\n" .
                        "CONSIDERACIONES:\n" .
                        "- El costo de hosting/VPS/Cloud (S/ 800-1,000/mes) no está incluido.\n" .
                        "- Cualquier funcionalidad adicional fuera del alcance se cotiza por separado.\n" .
                        "- La integración con balanzas puede requerir costos adicionales según el equipo.\n" .
                        "- Se incluye soporte post-implementación de 15 días para ajustes menores.\n" .
                        "- La evaluación de procesos actuales es fundamental para el éxito del proyecto.",
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

            // Subtotal items = S/ 10,169.49
            // IGV (18%) = S/ 1,830.51
            // Total con IGV = S/ 12,000.00
            $items = [
                // ==========================================
                // FASE 1: EVALUACIÓN DE PROCESOS ACTUALES (Semana 1)
                // ==========================================
                [
                    'name' => 'Fase 1: Evaluación de Procesos Actuales',
                    'description' => "Evaluación exhaustiva de todos los procesos actuales de la empresa avícola para entender el flujo operativo y definir los requerimientos del nuevo sistema.\n\nIncluye:\n- Visitas técnicas o reuniones remotas\n- Análisis de procesos de recepción de pollos\n- Evaluación del sistema de pesaje actual\n- Revisión de controles de inventario\n- Análisis del flujo de ventas\n- Evaluación de gestión de deudas\n- Documentación de hallazgos y recomendaciones\n- Taller de levantamiento de requerimientos\n\nDuración mínima: 1 semana",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 1000,
                    'tasks' => [
                        ['name' => 'Reunión inicial con el cliente', 'description' => 'Presentación del equipo, definición de objetivos, cronograma de evaluación y puntos de contacto.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Evaluación del proceso de recepción de pollos', 'description' => 'Análisis del flujo actual: llegada de camiones, registro, descarga, conteo de cajas.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Evaluación del sistema de pesaje actual', 'description' => 'Revisión de balanzas existentes, protocolos de pesaje, registro de pesos.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Evaluación de control de inventario', 'description' => 'Análisis de métodos de control de stock, movimientos, registros.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Evaluación de proceso de ventas', 'description' => 'Revisión del flujo de ventas: pedidos, despacho, facturación, cobros.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Evaluación de gestión de deudas', 'description' => 'Análisis de clientes mayoristas, crédito, cobros, morosidad.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Análisis de infraestructura tecnológica', 'description' => 'Evaluación de equipos disponibles: balanzas, tablets/touch, conectividad.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Documentación de hallazgos y requerimientos', 'description' => 'Elaboración de documento de evaluación con procesos actuales, hallazgos y lista de requerimientos refinados.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Taller de validación de requerimientos', 'description' => 'Presentación de hallazgos al cliente y validación de alcances del sistema.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 2: DISEÑO Y ARQUITECTURA
                // ==========================================
                [
                    'name' => 'Fase 2: Diseño y Arquitectura del Sistema',
                    'description' => "Diseño técnico y arquitectural del sistema de gestión avícola.\n\nIncluye:\n- Diseño de arquitectura de la aplicación\n- Diseño de base de datos\n- Diseño de modelos de datos\n- Diseño de interfaces de usuario\n- Diseño de integración con balanzas\n- Diseño de interfaz touch\n- Plan de seguridad\n- Documentación técnica",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 900,
                    'tasks' => [
                        ['name' => 'Diseño de arquitectura de la aplicación', 'description' => 'Definición de estructura técnica: frontend, backend, base de datos, API, servicios.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de base de datos', 'description' => 'Modelado de datos: entidades, relaciones, índices, optimización.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de modelos de datos', 'description' => 'Definición de tablas: pollos, cajas, ingresos, ventas, clientes, deudas, usuarios.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de interfaces de usuario', 'description' => 'Creación de wireframes y prototipos para cada módulo del sistema.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de integración con balanzas', 'description' => 'Definición de protocolo de comunicación, API de integración, manejo de datos en tiempo real.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de interfaz touch', 'description' => 'Diseño de pantallas táctiles optimizadas para área operativa: recepción y pesaje.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Plan de seguridad y permisos', 'description' => 'Definición de roles, permisos, políticas de seguridad, auditoría.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Documentación técnica', 'description' => 'Elaboración de documentación técnica del diseño y arquitectura.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 3: MÓDULO DE RECEPCIÓN DE POLLOS
                // ==========================================
                [
                    'name' => 'Fase 3: Módulo de Recepción de Pollos',
                    'description' => "Desarrollo del módulo de recepción de pollos en cajas para el área operativa.\n\nIncluye:\n- Registro de llegada de camiones\n- Identificación de proveedores\n- Registro de cajas recibidas\n- Conteo de cajas por proveedor\n- Generación de tickets de recepción\n- Historial de recepciones\n- Interfaz touch optimizada",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 900,
                    'tasks' => [
                        ['name' => 'Diseño de flujo de recepción', 'description' => 'Definición del proceso: registro de camión, inicio de recepción, registro de cajas, cierre.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'CRUD de proveedores', 'description' => 'Gestión de catálogo de proveedores de pollos.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Registro de llegada de camiones', 'description' => 'Pantalla para registrar: fecha, hora, proveedor, número de camión, conductor.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Registro de cajas recibidas', 'description' => 'Interfaz para registro de cajas: cantidad, tipo, condiciones.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Conteo y resumen de recepción', 'description' => 'Pantalla de resumen: total cajas, verificación, diferencias.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Generación de tickets de recepción', 'description' => 'Creación de tickets/comprobantes de recepción en PDF.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Interfaz touch para recepción', 'description' => 'Diseño y desarrollo de pantalla touch optimizada para uso en área de recepción.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Historial de recepciones', 'description' => 'Consulta de recepciones históricas por fecha, proveedor.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'QA y pruebas', 'description' => 'Pruebas funcionales del módulo de recepción.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 4: MÓDULO DE PESAJE CON BALANZAS
                // ==========================================
                [
                    'name' => 'Fase 4: Módulo de Pesaje con Integración de Balanzas',
                    'description' => "Desarrollo del módulo de pesaje con sincronización en tiempo real con balanzas.\n\nIncluye:\n- Integración con balanzas electrónicas\n- Lectura de peso en tiempo real\n- Registro de peso por caja\n- Suma total de pollos por camión\n- Historial de pesajes\n- Alertas de peso anomalía\n- Reportes de pesaje",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 2369.49,
                    'tasks' => [
                        ['name' => 'Análisis de balanzas existentes', 'description' => 'Revisión de modelo, marca, protocolo de comunicación de balanzas a integrar.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Desarrollo de driver de integración', 'description' => 'Creación de módulo de comunicación con balanzas (serial, USB, red).', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Lectura de peso en tiempo real', 'description' => 'Implementación de lectura continua de peso desde balanza.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Registro de peso por caja', 'description' => 'Interfaz para registrar peso individual de cada caja.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Cálculo de suma total por camión', 'description' => 'Sistema de acumulación de pesos y suma total por camión.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Pantalla de pesaje touch', 'description' => 'Interfaz touch para operativo de pesaje: peso actual, acumulado, siguiente caja.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Alertas de peso anomalía', 'description' => 'Sistema de alertas para pesos fuera de rango esperado.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Historial y reportes de pesaje', 'description' => 'Consultas y reportes de pesajes por fecha, proveedor, camión.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de integración con balanzas', 'description' => 'Pruebas reales de comunicación y lectura de peso.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 5: MÓDULO DE CONTROL DE INVENTARIO
                // ==========================================
                [
                    'name' => 'Fase 5: Módulo de Control de Inventario',
                    'description' => "Desarrollo del módulo de control de inventario de pollos.\n\nIncluye:\n- Registro de stock actual\n- Movimientos de ingreso (recepciones)\n- Movimientos de salida (ventas)\n- Control de inventario por ubicación\n- Alertas de stock mínimo\n- Reportes de inventario\n- Kárdex de productos",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 850,
                    'tasks' => [
                        ['name' => 'Diseño de estructura de inventario', 'description' => 'Definición de productos, unidades de medida, categorías.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'CRUD de productos', 'description' => 'Gestión del catálogo de productos avícolas.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Registro de stock inicial', 'description' => 'Carga de inventario inicial.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Movimientos de ingreso', 'description' => 'Registro automático de ingresos desde recepciones.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Movimientos de salida', 'description' => 'Registro automático de salidas desde ventas.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Consulta de stock en tiempo real', 'description' => 'Dashboard de stock actual por producto.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Alertas de stock mínimo', 'description' => 'Configuración y alertas de niveles mínimos de inventario.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Kárdex de productos', 'description' => 'Historial detallado de movimientos por producto.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Reportes de inventario', 'description' => 'Reportes: rotación, valoración, envejecido.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'QA y pruebas', 'description' => 'Pruebas del módulo de inventario.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 6: MÓDULO DE VENTAS
                // ==========================================
                [
                    'name' => 'Fase 6: Módulo de Control de Ventas',
                    'description' => "Desarrollo del módulo de control de ventas.\n\nIncluye:\n- Registro de pedidos de clientes\n- Gestión de precios y tarifas\n- Procesamiento de ventas\n- Generación de comprobantes\n- Historial de ventas\n- Reportes de ventas\n- Dashboard de ventas",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 1000,
                    'tasks' => [
                        ['name' => 'Diseño de proceso de ventas', 'description' => 'Definición del flujo: pedido, aprobación, despacho, facturación.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'CRUD de clientes', 'description' => 'Gestión del catálogo de clientes.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Gestión de precios y tarifas', 'description' => 'Catálogo de precios por cliente, producto, cantidad.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Registro de pedidos', 'description' => 'Pantalla de registro de pedidos de clientes.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Procesamiento de ventas', 'description' => 'Flujo de confirmación, despacho, cierre de venta.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Generación de comprobantes', 'description' => 'Creación de facturas, boletas, notas.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Historial de ventas', 'description' => 'Consulta de ventas por fecha, cliente, producto.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Reportes de ventas', 'description' => 'Reportes: diarias, mensuales, por cliente, por producto.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Dashboard de ventas', 'description' => 'Panel con indicadores de ventas en tiempo real.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'QA y pruebas', 'description' => 'Pruebas del módulo de ventas.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 7: MÓDULO DE GESTIÓN DE DEUDAS
                // ==========================================
                [
                    'name' => 'Fase 7: Módulo de Gestión de Deudas de Clientes',
                    'description' => "Desarrollo del módulo de gestión de deudas para clientes mayoristas.\n\nIncluye:\n- Control de crédito por cliente\n- Registro de deudas pendientes\n- Registro de pagos y abonos\n- Estados de cuenta por cliente\n- Alertas de morosidad\n- Historial de cobranzas\n- Reportes de cartera",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 900,
                    'tasks' => [
                        ['name' => 'Diseño de gestión de crédito', 'description' => 'Definición de límites de crédito por cliente, condiciones.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Configuración de clientes mayoristas', 'description' => 'Definición de clientes con crédito, límites, condiciones.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Registro automático de deudas', 'description' => 'Creación de cuentas por cobrar desde ventas a crédito.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Registro de pagos y abonos', 'description' => 'Gestión de pagos parciales y totales.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Estados de cuenta por cliente', 'description' => 'Consulta de deuda actual, historial, vencimientos.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Alertas de morosidad', 'description' => 'Notificaciones de clientes con deuda vencida.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Historial de cobranzas', 'description' => 'Registro de acciones de cobranza, notas.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Reportes de cartera', 'description' => 'Reportes: antigüedad de deuda, morosidad, recuperación.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'QA y pruebas', 'description' => 'Pruebas del módulo de deudas.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 8: MÓDULO DE USUARIOS Y ROLES (RBAC)
                // ==========================================
                [
                    'name' => 'Fase 8: Módulo de Usuarios y Roles (RBAC)',
                    'description' => "Desarrollo del módulo de gestión de usuarios y control de acceso.\n\nIncluye:\n- Administración de usuarios\n- Gestión de roles\n- Permisos por módulo/acción\n- Asignación de roles a usuarios\n- Logs de auditoría\n- Restricciones de acceso\n- Recuperación de contraseñas",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 650,
                    'tasks' => [
                        ['name' => 'Diseño de estructura de roles', 'description' => 'Definición de roles: administrador, recepcionista, vendedor, contador.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'CRUD de usuarios', 'description' => 'Gestión de usuarios del sistema.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'CRUD de roles', 'description' => 'Creación y edición de roles del sistema.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Sistema de permisos', 'description' => 'Matriz de permisos por módulo y acción.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Asignación de roles', 'description' => 'Asignación de roles a usuarios.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Protección de rutas', 'description' => 'Restricción de acceso a pantallas según rol.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Logs de auditoría', 'description' => 'Registro de acciones de usuarios.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Recuperación de contraseñas', 'description' => 'Sistema de reset de contraseña.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'QA y pruebas de seguridad', 'description' => 'Pruebas de acceso y permisos.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 9: INTEGRACIÓN Y CONFIGURACIÓN EN VPS/CLOUD
                // ==========================================
                [
                    'name' => 'Fase 9: Despliegue en VPS/Cloud e Integración',
                    'description' => "Despliegue del sistema en servidor VPS/Cloud y configuración final.\n\nIncluye:\n- Preparación del servidor\n- Despliegue de la aplicación\n- Configuración de base de datos\n- Configuración de SSL\n- Integración con balanzas en producción\n- Configuración de respaldos\n- Pruebas en ambiente de producción",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 650,
                    'tasks' => [
                        ['name' => 'Preparación del servidor', 'description' => 'Configuración de servidor VPS: SO, LAMP/LEMP, dependencias.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Despliegue de la aplicación', 'description' => 'Deploy del código al servidor.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Configuración de base de datos', 'description' => 'Setup de MySQL, migraciones, seeds iniciales.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Configuración de SSL', 'description' => 'Certificado SSL (Lets Encrypt).', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'Integración con balanzas', 'description' => 'Configuración de conexión con balanzas en producción.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Configuración de respaldos', 'description' => 'Setup de backups automáticos.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas en producción', 'description' => 'Verificación de funcionamiento en ambiente real.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                    ],
                ],
                // ==========================================
                // FASE 10: PRUEBAS, CAPACITACIÓN Y ENTREGA
                // ==========================================
                [
                    'name' => 'Fase 10: Pruebas, Capacitación y Entrega Final',
                    'description' => "Fase final de pruebas, capacitación y entrega del sistema.\n\nIncluye:\n- Pruebas integrales del sistema\n- Corrección de bugs\n- Documentación de usuario\n- Capacitación al personal\n- Entrega y soporte post-implementación",
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 950,
                    'tasks' => [
                        ['name' => 'Pruebas integrales', 'description' => 'Pruebas de todos los módulos juntos.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de integración touch', 'description' => 'Verificación de funcionamiento en pantallas táctiles.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de rendimiento', 'description' => 'Verificación de tiempos de respuesta.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                        ['name' => 'Corrección de bugs', 'description' => 'Resolución de errores encontrados.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Documentación de usuario', 'description' => 'Manual de usuario del sistema.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Capacitación al personal', 'description' => 'Sesiones de capacitación por módulo.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Entrega formal', 'description' => 'Acta de entrega del sistema.', 'duration_value' => 2, 'duration_unit' => 'hours'],
                        ['name' => 'Soporte post-implementación', 'description' => 'Soporte de 15 días para ajustes.', 'duration_value' => 16, 'duration_unit' => 'hours'],
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
