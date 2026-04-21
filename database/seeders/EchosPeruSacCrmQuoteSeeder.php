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
                    'project_type' => 'CRM de eventos: administracion, clientes, cotizaciones, proyectos, logistica, personal, inventario, geolocalizacion y finanzas',
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
                        "- Logistica: planificacion operativa de recursos y transporte por evento.\n" .
                        "- Control de personal: asignacion, asistencia y control operativo por evento.\n" .
                        "- Inventariado y almacenes: entradas/salidas de stock, movimientos y control por almacen.\n" .
                        "- Geolocalizacion: ubicacion de eventos, rutas y puntos operativos.\n" .
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
                        "- Se agregan modulos de logistica, control de personal, inventariado/almacenes y geolocalizacion sin variar precio total ni plazo.\n" .
                        "- El modulo Finanzas cubre gastos por evento, adjuntos de comprobantes y analitica semanal/mensual.\n" .
                        "- Se contempla carga de documentos (imagenes, PDF, Excel) con validaciones de formato/tamano.\n\n" .
                        "Requisitos para iniciar:\n" .
                        "- Definir responsables por area (administracion, operaciones, finanzas).\n" .
                        "- Validar flujo de aprobacion: cotizacion -> factura/baucher -> proyecto.\n" .
                        "- Definir categorias de cotizacion por tipo de producto/servicio.\n" .
                        "- Compartir estructura de reportes financieros esperados (semanal y mensual).\n" .
                        "- Definir catalogo de almacenes, items de inventario y responsables de logistica/personal.\n\n" .
                        "Entregables:\n" .
                        "- CRM funcional por modulos con permisos por rol.\n" .
                        "- Vistas operativas y formularios de datos de proyecto.\n" .
                        "- Modulos de logistica, personal, inventario y geolocalizacion integrados con proyectos.\n" .
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
                    'description' => 'Levantamiento de alcance y ordenamiento de requisitos para integrar modulos nuevos sin alterar costo ni plazo global.',
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 140,
                    'tasks' => [
                        ['name' => 'Alineacion de alcance integral', 'description' => 'Ajustar alcance final considerando nuevos modulos de logistica, personal, inventario y geolocalizacion.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Mapa de dependencias entre modulos', 'description' => 'Definir dependencias funcionales entre cotizaciones, proyectos, logistica, personal e inventario.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                        ['name' => 'Definicion de prioridades por iteracion', 'description' => 'Ordenar implementacion por sprints para sostener entrega en 48 dias.', 'duration_value' => 0.25, 'duration_unit' => 'days'],
                        ['name' => 'Criterios de aceptacion por modulo', 'description' => 'Establecer checklist funcional por cada seccion a entregar.', 'duration_value' => 0.25, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Administracion (usuarios, roles, permisos, configuracion y documentos)',
                    'description' => 'Nucleo de seguridad y operacion para controlar acceso, parametros del CRM y gestion de archivos.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 300,
                    'tasks' => [
                        ['name' => 'Vista y CRUD de usuarios', 'description' => 'Listado y formularios para alta, edicion, desactivacion y restablecimiento de acceso.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Vista de roles y permisos', 'description' => 'Gestion de roles por area y permisos por accion para cada modulo.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Aplicacion de control RBAC', 'description' => 'Proteccion de rutas, menus y acciones criticas segun perfil.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Configuracion general del sistema', 'description' => 'Parametros corporativos, reglas base y preferencias operativas.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                        ['name' => 'Gestion documental central', 'description' => 'Carga y validacion de imagenes, PDF y Excel para uso transversal.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'Pruebas de seguridad y accesos', 'description' => 'QA de permisos, restricciones y navegacion por rol.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Clientes (vista todos los clientes)',
                    'description' => 'Gestion centralizada de clientes con trazabilidad comercial y operativa.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 170,
                    'tasks' => [
                        ['name' => 'Vista general de clientes', 'description' => 'Pantalla de todos los clientes con filtros por documento, razon social y estado.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'CRUD de clientes', 'description' => 'Formularios de registro y actualizacion de datos fiscales y de contacto.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'Relacion cliente-cotizacion-proyecto', 'description' => 'Trazabilidad del cliente en procesos de venta y ejecucion.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'QA funcional del modulo', 'description' => 'Pruebas de filtros, integridad de datos y relacion con otros modulos.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Cotizaciones (listado, configuracion y categorias)',
                    'description' => 'Gestion comercial de cotizaciones con configuraciones, categorias y conversion a proyecto.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 350,
                    'tasks' => [
                        ['name' => 'Vista de todas las cotizaciones', 'description' => 'Listado con filtros por cliente, fecha, estado y numero de cotizacion.', 'duration_value' => 1.5, 'duration_unit' => 'days'],
                        ['name' => 'Formulario de creacion y edicion', 'description' => 'Alta y actualizacion de cotizaciones con items, importes y condiciones.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Configuracion de cotizaciones', 'description' => 'Numeracion, vigencia por defecto, observaciones y terminos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Categorias por producto/servicio', 'description' => 'Clasificacion de cotizaciones segun lineas de producto para analitica.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'Regla de pase a proyecto', 'description' => 'Habilitar creacion de proyecto tras validacion de factura/baucher.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'QA de montos y estados', 'description' => 'Pruebas de calculos, flujo de estados y coherencia del proceso.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Proyectos y datos operativos (vistas + no vistas)',
                    'description' => 'Gestion integral de proyectos incluyendo vistas operativas y datos internos de evento que no son vistas.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 300,
                    'tasks' => [
                        ['name' => 'Vista de todos los proyectos', 'description' => 'Panel de proyectos con filtros por cliente, estado y calendario de ejecucion.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Vista detalle de evento', 'description' => 'Detalle de proyecto con seguimiento de hitos y documentos asociados.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Relacion evento-cotizacion-comprobante', 'description' => 'Estructura de enlace entre cotizacion aprobada y factura/baucher de respaldo.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Fechas operativas obligatorias', 'description' => 'Registro y validacion de montaje, inicio, desmontaje y finalizacion.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'Guias de remision y documentos del evento', 'description' => 'Campos y adjuntos para guias, evidencias y archivos operativos.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'QA de consistencia operativa', 'description' => 'Validar que no se cierre evento sin data obligatoria.', 'duration_value' => 0.5, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo de Logistica',
                    'description' => 'Planificacion de recursos, movilidad y actividades logisticas para cada evento/proyecto.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 320,
                    'tasks' => [
                        ['name' => 'Catalogo de recursos logisticos', 'description' => 'Definir recursos (vehiculos, equipos, materiales) por tipo de evento.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Planificacion operativa por evento', 'description' => 'Programar requerimientos logisticos por fecha y responsable.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Control de despacho y retorno', 'description' => 'Registro de salida y retorno de recursos con estado y observaciones.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Checklist de cumplimiento logistico', 'description' => 'Control de hitos logisticos pre-evento, durante y post-evento.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Alertas de incidencias operativas', 'description' => 'Registro de incidencias y alertas por retrasos o faltantes.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'QA del flujo logistico', 'description' => 'Pruebas de trazabilidad y cierre de ciclo logistico.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Control de Personal',
                    'description' => 'Asignacion y seguimiento del personal por evento, turnos y cumplimiento operativo.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 260,
                    'tasks' => [
                        ['name' => 'Maestro de personal operativo', 'description' => 'Registro de personal, roles operativos y disponibilidad.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Asignacion de personal por evento', 'description' => 'Vincular personal a proyectos con fecha, horario y funcion.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Control de asistencia y cumplimiento', 'description' => 'Seguimiento de asistencia y estados de participacion.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Bitacora de novedades del personal', 'description' => 'Registrar incidencias, reemplazos y observaciones de jornada.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'QA de asignaciones y estados', 'description' => 'Pruebas de cruces entre personal, evento y logistica.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Inventariado y Almacenes',
                    'description' => 'Control de inventario por almacen con entradas, salidas, transferencias y stock por evento.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 330,
                    'tasks' => [
                        ['name' => 'Catalogo de items y unidades', 'description' => 'Crear ficha de inventario por item, unidad, categoria y estado.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Gestion de almacenes', 'description' => 'Registrar almacenes, ubicaciones y responsables operativos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Movimientos de entrada y salida', 'description' => 'Controlar ingresos y egresos con motivo, fecha y referencia de evento.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Transferencias entre almacenes', 'description' => 'Gestionar traslado interno de items con trazabilidad.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Reserva y consumo por evento', 'description' => 'Separar stock para eventos y registrar consumo real.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'QA de stock y trazabilidad', 'description' => 'Pruebas de consistencia de saldos y movimientos historicos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Geolocalizacion',
                    'description' => 'Gestion de ubicaciones de eventos, rutas y puntos operativos vinculados a proyectos y logistica.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 210,
                    'tasks' => [
                        ['name' => 'Registro de ubicacion de evento', 'description' => 'Guardar direccion estructurada y coordenadas del evento.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Integracion con Google Maps', 'description' => 'Visualizacion de punto geografico en mapa dentro del proyecto.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Rutas logisticas por evento', 'description' => 'Asociar rutas sugeridas para traslado de personal y recursos.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'QA de precision y enlaces', 'description' => 'Validar enlaces de mapa, coordenadas y consistencia por proyecto.', 'duration_value' => 1, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'Modulo Finanzas (gastos, ganancias y estadisticas)',
                    'description' => 'Control financiero por evento con indicadores semanales y mensuales.',
                    'quantity' => 1,
                    'unit' => 'modulo',
                    'unit_price' => 220,
                    'tasks' => [
                        ['name' => 'Registro de gastos y adjuntos', 'description' => 'Registrar egresos por evento y cargar facturas de sustento.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'Calculo de inversion y ganancia', 'description' => 'Obtener margen por evento a partir de ingresos vs gastos.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'Reportes semanales y mensuales', 'description' => 'Consolidar resultados financieros por periodo y proyecto.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                        ['name' => 'QA de reportes financieros', 'description' => 'Pruebas de exactitud de totales, filtros y trazabilidad.', 'duration_value' => 0.75, 'duration_unit' => 'days'],
                    ],
                ],
                [
                    'name' => 'QA integral, despliegue y capacitacion',
                    'description' => 'Cierre del proyecto con validacion funcional completa y transferencia operativa.',
                    'quantity' => 1,
                    'unit' => 'fase',
                    'unit_price' => 100,
                    'tasks' => [
                        ['name' => 'Pruebas end-to-end', 'description' => 'Ejecutar pruebas integrales sobre todos los modulos y sus dependencias.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Ajustes finales y estabilizacion', 'description' => 'Corregir hallazgos de QA y validar no regresion.', 'duration_value' => 1, 'duration_unit' => 'days'],
                        ['name' => 'Capacitacion y entrega funcional', 'description' => 'Transferencia operativa con guia de uso por modulo.', 'duration_value' => 1, 'duration_unit' => 'days'],
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
