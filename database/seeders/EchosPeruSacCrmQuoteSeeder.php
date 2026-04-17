<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EchosPeruSacCrmQuoteSeeder extends Seeder
{
    /**
     * Crea una cotizacion para:
     * - Empresa: Echos Peru SAC
     * - RUC: 20508768533
     * - Email: echoquecahua@echosperu.com
     *
     * Alcance:
     * - CRM de administracion, clientes, cotizaciones, proyectos y finanzas.
     * - Separacion explicita entre vistas del modulo Proyectos y datos operativos
     *   que no son vistas (fechas, guias, documentos, relacion con cotizacion/factura).
     *
     * Presupuesto:
     * - Total proyecto: S/ 2,700.00 (sin IGV)
     * - Duracion estimada: 48 dias (aprox. 1.5 meses)
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente/empresa
            // =========================
            $clientName = 'Echos Peru SAC';
            $clientEmail = 'echoquecahua@echosperu.com';
            $clientPhone = null;
            $clientAddress = null;

            $companyName = 'Echos Peru SAC';
            $companyRuc = '20508768533';

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
                    'project_type' => 'CRM de eventos: administracion, clientes, cotizaciones, proyectos y finanzas',
                    'budget_up_to' => 2700,
                    'message' => "Cotizacion solicitada para {$companyName} (RUC: {$companyRuc}) por un CRM integral de gestion comercial y operativa de eventos.",
                    'status' => 'new',
                    'source' => 'seed',
                    'notes' => 'Lead creado automaticamente desde seeder para generar cotizacion detallada de CRM en 1.5 meses.',
                ]
            );

            // =========================
            // Usuario creador (interno)
            // =========================
            $createdBy = User::where('email', 'gusgusnoriega@gmail.com')->first()
                ?? User::first()
                ?? $clientUser;

            // =========================
            // Cotizacion (PEN) - SIN IGV
            // =========================
            $quoteNumber = 'COT-20508768533-CRM-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id' => $clientUser->id,
                    'created_by' => $createdBy?->id,
                    'title' => "Cotizacion: CRM integral para eventos - {$companyName}",
                    'description' => "Desarrollo de CRM para {$companyName} orientado a la gestion comercial y operativa de eventos.\n\n" .
                        "Modulos y vistas incluidas:\n" .
                        "- Administracion: usuarios, roles, permisos, configuracion y documentos.\n" .
                        "- Clientes: vista de todos los clientes + gestion completa.\n" .
                        "- Cotizaciones: listado general, configuracion de cotizaciones y categorias por producto.\n" .
                        "- Proyectos: listado y seguimiento de proyectos vinculados a cotizaciones/facturas.\n" .
                        "- Finanzas: gastos por evento, adjuntos de facturas y estadisticas de rentabilidad.\n\n" .
                        "Datos de proyecto que NO son vistas (alcance funcional):\n" .
                        "- Relacion evento-cotizacion y validacion contra factura/baucher/imagen.\n" .
                        "- Fechas operativas: montaje, inicio, desmontaje y finalizacion.\n" .
                        "- Guias de remision.\n" .
                        "- Direccion del evento + ubicacion Google Maps.\n" .
                        "- Cliente asignado al evento.\n" .
                        "- Documentacion del evento.\n\n" .
                        "Duracion estimada: 48 dias calendario (aprox. 6-7 semanas), sujeto a entrega oportuna de validaciones y contenido.",
                    'currency_id' => $pen->id,
                    'tax_rate' => 0,
                    'discount_amount' => 0,
                    'status' => 'draft',
                    'valid_until' => now()->addDays(20)->toDateString(),
                    'estimated_start_date' => now()->addDays(2)->toDateString(),
                    'notes' => "Aclaraciones de alcance:\n" .
                        "- El modulo Proyectos se divide en vistas operativas y en estructura de datos de evento (no vistas).\n" .
                        "- El modulo Finanzas cubre gastos por evento, adjuntos de comprobantes y analitica semanal/mensual.\n" .
                        "- Se contempla carga de documentos (imagenes, PDF, Excel) con validaciones de formato/tamano.\n\n" .
                        "Requisitos para iniciar:\n" .
                        "- Definir responsables por area (administracion, operaciones, finanzas).\n" .
                        "- Validar flujo de aprobacion: cotizacion -> factura/baucher -> proyecto.\n" .
                        "- Definir categorias de cotizacion por tipo de producto/servicio.\n" .
                        "- Compartir estructura de reportes financieros esperados (semanal y mensual).\n\n" .
                        "Entregables:\n" .
                        "- CRM funcional por modulos con permisos por rol.\n" .
                        "- Vistas operativas y formularios de datos de proyecto.\n" .
                        "- Reportes de gastos/ganancias por evento, semanal y mensual.\n" .
                        "- Manual basico y capacitacion de uso.",
                    'terms_conditions' => "Condiciones comerciales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 2,700.00\n" .
                        "- IGV: 0% (no incluido).\n" .
                        "- Total: S/ 2,700.00\n" .
                        "- Forma de pago sugerida: 40% al iniciar (S/ 1,080.00), 30% contra avance funcional (S/ 810.00), 30% al cierre y entrega final (S/ 810.00).\n" .
                        "- Duracion estimada: 48 dias calendario (aprox. 1.5 meses).\n" .
                        "- Cambios mayores fuera del alcance funcional definido se cotizan por separado.",
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

            // Total items (subtotal) = 2700.00
            // IGV = 0.00
            // Total final = 2700.00
            // Duracion total estimada = 48 dias
            $items = [
                [
                    'name' => 'Descubrimiento funcional y arquitectura del CRM',
                    'description' => 'Levantamiento de alcance, ordenamiento de requisitos ambiguos y definicion de arquitectura funcional/tecnica para asegurar ejecucion en 1.5 meses.',
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 200,
                    'tasks' => [
                        ['name' => 'Workshop de alcance y prioridades', 'description' => 'Definir objetivos de negocio, alcance minimo viable, modulos criticos y criterios de aceptacion por area.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Definicion de flujo comercial principal', 'description' => 'Documentar flujo cotizacion -> aprobacion -> factura/baucher -> proyecto -> cierre financiero.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Modelado inicial de entidades y relaciones', 'description' => 'Disenar estructura base para usuarios, clientes, cotizaciones, proyectos, documentos y finanzas.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Planificacion de iteraciones por semana', 'description' => 'Dividir desarrollo por hitos semanales para completar el alcance en 48 dias.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Administracion (usuarios, roles, permisos, configuracion y documentos)',
                    'description' => 'Construccion del nucleo administrativo del CRM con control de accesos y carga de documentos (imagenes, PDF, Excel).',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 520,
                    'tasks' => [
                        ['name' => 'Vista y CRUD de usuarios', 'description' => 'Crear pantalla de listado y formularios para alta/edicion/desactivacion de usuarios.', 'duration_value' => 2, 'duration_unit' => 'days'],
                        ['name' => 'Vista y CRUD de roles', 'description' => 'Gestion de roles operativos (administracion, ventas, operaciones, finanzas).', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Vista y matriz de permisos', 'description' => 'Definir permisos por modulo y accion (ver, crear, editar, eliminar, exportar).', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Aplicacion de RBAC en rutas y acciones', 'description' => 'Proteger backend y frontend segun permisos para evitar accesos indebidos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Vista de configuracion general del sistema', 'description' => 'Configurar datos de empresa, parametros de flujo y ajustes globales del CRM.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Modulo de documentos (imagenes/PDF/Excel)', 'description' => 'Subida, validacion, almacenamiento y relacion de archivos a entidades del sistema.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Pruebas de seguridad y permisos', 'description' => 'QA de accesos por rol y pruebas de subida de archivos por tipo.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Clientes (vista todos los clientes)',
                    'description' => 'Gestion centralizada de clientes con vista global, filtros, historial comercial y relacion con cotizaciones/proyectos.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 240,
                    'tasks' => [
                        ['name' => 'Vista de listado general de clientes', 'description' => 'Construir pagina "Todos los clientes" con busqueda, filtros y paginacion.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'CRUD completo de clientes', 'description' => 'Crear formularios para registro y actualizacion de datos comerciales y fiscales.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Relacion cliente-cotizacion-proyecto', 'description' => 'Mostrar trazabilidad del cliente en procesos comerciales y operativos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'QA funcional del modulo clientes', 'description' => 'Validar filtros, edicion, estados y navegacion entre modulos relacionados.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Cotizaciones (listado, configuracion y categorias)',
                    'description' => 'Gestion de cotizaciones con vista general, parametros configurables y categorias por producto/servicio.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 520,
                    'tasks' => [
                        ['name' => 'Vista "Todas las cotizaciones"', 'description' => 'Listado con filtros por estado, cliente, fechas y busqueda por numero/documento.', 'duration_value' => 2, 'duration_unit' => 'days'],
                        ['name' => 'Flujo de creacion y edicion de cotizacion', 'description' => 'Formulario de cotizacion con items, condiciones, vigencia y estados.', 'duration_value' => 2, 'duration_unit' => 'days'],
                        ['name' => 'Configuracion de cotizaciones', 'description' => 'Parametros de numeracion, vigencia por defecto, observaciones y terminos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Categorias de cotizacion por producto', 'description' => 'CRUD de categorias para clasificar cotizaciones segun tipo de producto/servicio.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Control de aprobacion y pase a proyecto', 'description' => 'Regla para habilitar creacion de proyecto una vez validada factura/baucher.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'QA de calculos y estados', 'description' => 'Pruebas de montos, estados y relacion con cliente/proyecto.', 'duration_value' => 2, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Proyectos (vistas operativas)',
                    'description' => 'Vistas para gestionar todos los proyectos asociados a cotizaciones aceptadas y comprobantes validados.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 500,
                    'tasks' => [
                        ['name' => 'Vista "Todos los proyectos"', 'description' => 'Pantalla principal con filtros por cliente, estado, fecha y responsable.', 'duration_value' => 2, 'duration_unit' => 'days'],
                        ['name' => 'Vista de detalle del proyecto/evento', 'description' => 'Pantalla para visualizar informacion operativa, documentos y avance del evento.', 'duration_value' => 2, 'duration_unit' => 'days'],
                        ['name' => 'Flujo de creacion desde cotizacion', 'description' => 'Creacion de proyecto vinculando cotizacion aprobada y comprobante correspondiente.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Asignacion de cliente y responsables', 'description' => 'Relacionar cliente del evento y usuarios internos responsables de ejecucion.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Adjuntos de documentacion del evento', 'description' => 'Subida y consulta de archivos operativos dentro del proyecto.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Integracion Google Maps en ubicacion', 'description' => 'Registro de direccion del evento y enlace/preview de ubicacion en mapa.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Datos de Proyecto (no vistas): estructura operativa del evento',
                    'description' => 'Implementacion de datos funcionales de proyecto que no son vistas, pero son obligatorios para el control operativo del evento.',
                    'quantity' => 1,
                    'unit' => 'estructura',
                    'unit_price' => 260,
                    'tasks' => [
                        ['name' => 'Relacion evento-cotizacion-factura/baucher', 'description' => 'Definir llaves y validaciones para asociar cada evento a su soporte comercial y financiero.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Campos de fechas operativas del evento', 'description' => 'Implementar fecha de montaje, inicio, desmontaje y finalizacion con reglas de consistencia.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Registro de comprobantes con fecha', 'description' => 'Permitir adjuntar factura, baucher o imagenes con fecha de registro/control.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Guias de remision', 'description' => 'Estructura para almacenar numero, fecha y archivo de guias asociadas al proyecto.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Validaciones de completitud operativa', 'description' => 'Reglas para evitar cierre de evento sin datos minimos requeridos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Finanzas (gastos, ganancias y estadisticas)',
                    'description' => 'Gestion financiera por evento con adjuntos de facturas, control de gastos/ingresos y reportes de rentabilidad semanal y mensual.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 330,
                    'tasks' => [
                        ['name' => 'Registro de gastos del evento', 'description' => 'Formulario para registrar gastos operativos y administrativos por proyecto/evento.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Adjunto de facturas de gasto', 'description' => 'Subida de comprobantes para sustento de egresos y auditoria.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Calculo de inversion vs ganancia', 'description' => 'Reglas para comparar ingresos y gastos por evento con margen resultante.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Reporte semanal de gastos y ganancias', 'description' => 'Vista/reportes con filtros por semana y consolidado por evento.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Reporte mensual de gastos y ganancias', 'description' => 'Vista/reportes mensuales con totales, tendencia y utilidad.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'QA de consistencia financiera', 'description' => 'Pruebas de sumatorias, relacion de comprobantes y exactitud de margenes.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'QA integral, despliegue y capacitacion',
                    'description' => 'Fase final para asegurar calidad del CRM, estabilizar flujo completo y transferir operacion al equipo de Echos Peru SAC.',
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 130,
                    'tasks' => [
                        ['name' => 'Pruebas end-to-end por modulo', 'description' => 'Ejecutar pruebas funcionales completas en administracion, clientes, cotizaciones, proyectos y finanzas.', 'duration_value' => 2, 'duration_unit' => 'days'],
                        ['name' => 'Correccion de incidencias criticas', 'description' => 'Ajustar bugs detectados en QA y verificar regresiones.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Capacitacion operativa y entrega', 'description' => 'Sesion de uso del CRM y entrega de guia basica para procesos diarios.', 'duration_value' => 1, 'duration_unit' => 'days'],
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
