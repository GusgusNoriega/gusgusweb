<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FlaviaJimenaElearningQuoteSeeder extends Seeder
{
    /**
     * Crea:
     * - Usuario cliente (Flavia Jimena) + Lead (RUC: 10726758528)
     * - Cotización en PEN (S/ 9,500.00 + IGV 18% = S/ 11,210.00) para:
     *   - Desarrollo de Plataforma de Aprendizaje Virtual (E-Learning)
     *
     * Cliente: Flavia Jimena
     * Email: flavia.jimena25@gmail.com
     * Rubro: Plataforma de Aprendizaje Virtual / E-Learning
     */
    public function run(): void
    {
        DB::transaction(function () {
            // =========================
            // Datos del cliente
            // =========================
            $clientName = 'Flavia Jimena';
            $clientEmail = 'flavia.jimena25@gmail.com';
            $clientPhone = '+51 962 982 942';
            $clientAddress = 'Lima, Perú';

            $companyName = 'Flavia Jimena - E-Learning';
            $companyRuc = '10726758528';

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
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            // =========================
            // Lead (cliente)
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
                    'company_ruc' => $companyRuc,
                    'project_type' => 'Plataforma de Aprendizaje Virtual (E-Learning)',
                    'budget_up_to' => 11210,
                    'message' => "Cotización solicitada para: {$clientName} (RUC: {$companyRuc}). Alcance: Desarrollo de plataforma de aprendizaje virtual (e-learning) con gestión de cursos, evaluaciones en línea, certificaciones digitales, panel de administración y experiencia de usuario optimizada.",
                    'status' => 'new',
                    'source' => 'seed',
                    'notes' => 'Lead creado automáticamente desde seeder para generar cotización formal de plataforma de aprendizaje virtual (e-learning).',
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
            // Subtotal: S/ 9,500.00
            // IGV (18%): S/ 1,710.00
            // Total: S/ 11,210.00
            // =========================
            $quoteNumber = 'COT-10726758528-ELEARNING-0001';

            $quote = Quote::withTrashed()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'user_id' => $clientUser->id,
                    'created_by' => $createdBy?->id,
                    'title' => 'Desarrollo de Plataforma de Aprendizaje Virtual (E-Learning)',
                    'description' => "Desarrollo integral de una plataforma de aprendizaje virtual (e-learning) para {$clientName}, orientada a ofrecer una experiencia educativa moderna, interactiva y escalable.\n\n" .
                        "El proyecto contempla:\n" .
                        "- Diseño UI/UX completo de la plataforma con enfoque en usabilidad y accesibilidad.\n" .
                        "- Sistema de gestión de usuarios con roles diferenciados (administrador, instructor, estudiante).\n" .
                        "- Módulo de cursos con contenido multimedia (videos, PDFs, texto enriquecido), organizado por módulos y lecciones.\n" .
                        "- Sistema de evaluaciones en línea con constructor de exámenes, múltiples tipos de preguntas y calificación automática.\n" .
                        "- Generación de certificaciones digitales personalizadas con código QR de verificación.\n" .
                        "- Panel de administración con dashboard de métricas, reportes de actividad y exportación de datos.\n" .
                        "- Despliegue en producción, configuración de servidor y capacitación al equipo administrador.\n\n" .
                        "La plataforma será desarrollada con tecnologías web modernas, garantizando rendimiento, seguridad y una experiencia de usuario optimizada tanto en escritorio como en dispositivos móviles.",
                    'currency_id' => $pen->id,
                    'tax_rate' => 18,
                    'discount_amount' => 0,
                    'status' => 'draft',
                    'valid_until' => now()->addDays(30)->toDateString(),
                    'estimated_start_date' => now()->addDays(7)->toDateString(),
                    'notes' => "Requisitos técnicos del proyecto:\n" .
                        "- Hosting: Servidor VPS o cloud con mínimo 2GB RAM, 2 vCPU y 50GB SSD.\n" .
                        "- Dominio: Registro y configuración del dominio principal de la plataforma.\n" .
                        "- Certificado SSL: Instalación y configuración de SSL (Let's Encrypt o comercial) para conexión segura HTTPS.\n" .
                        "- Base de datos: MySQL 8.0+ o PostgreSQL 14+.\n" .
                        "- Almacenamiento: Configuración de almacenamiento para contenido multimedia (videos, documentos, imágenes).\n\n" .
                        "Entregables:\n" .
                        "- Plataforma e-learning operativa en entorno de producción.\n" .
                        "- Código fuente completo y documentación técnica.\n" .
                        "- Manual de usuario para administradores e instructores.\n" .
                        "- Sesión de capacitación práctica al equipo administrador.\n" .
                        "- Acceso al repositorio de código fuente.\n\n" .
                        "Tiempo estimado de entrega: 3 meses a partir del inicio del proyecto, sujeto a la entrega oportuna de contenido y aprobaciones por parte del cliente.",
                    'terms_conditions' => "Condiciones de pago:\n" .
                        "- 50% al inicio del proyecto (S/ 5,605.00): Se abona al firmar el acuerdo e iniciar la fase de diseño y planificación.\n" .
                        "- 25% a mitad del proyecto (S/ 2,802.50): Se abona al completar los módulos de gestión de usuarios, cursos y evaluaciones.\n" .
                        "- 25% a la entrega final (S/ 2,802.50): Se abona una vez desplegada la plataforma en producción y realizada la capacitación.\n\n" .
                        "Garantía y soporte post-entrega:\n" .
                        "- Se incluye garantía de 3 meses posterior a la entrega final.\n" .
                        "- Durante el período de garantía se corregirán errores de funcionamiento sin costo adicional.\n" .
                        "- Soporte técnico incluido vía email y WhatsApp en horario laboral (lunes a viernes, 9:00 a 18:00).\n" .
                        "- Mejoras, nuevas funcionalidades o cambios de alcance solicitados después de la entrega se cotizarán por separado.\n\n" .
                        "Consideraciones generales:\n" .
                        "- Moneda: PEN (S/).\n" .
                        "- Subtotal: S/ 9,500.00\n" .
                        "- IGV (18%): S/ 1,710.00\n" .
                        "- Total: S/ 11,210.00\n" .
                        "- Vigencia de la cotización: 30 días calendario.\n" .
                        "- Hosting, dominio y renovaciones anuales posteriores corren por cuenta del cliente.\n" .
                        "- El plazo de entrega puede verse afectado por demoras en la entrega de contenidos o aprobaciones del cliente.",
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

            // Subtotal items = S/ 9,500.00
            // 1,200 + 1,500 + 2,200 + 1,800 + 1,300 + 1,000 + 500 = 9,500
            // IGV (18%) = S/ 1,710.00
            // Total = S/ 11,210.00
            $items = [
                [
                    'name' => 'Diseño UI/UX de la Plataforma',
                    'description' => "Diseño completo de la interfaz de usuario y experiencia de usuario para la plataforma e-learning, incluyendo wireframes, mockups de alta fidelidad y prototipo interactivo.\n\nIncluye:\n- Investigación de referencia de plataformas e-learning existentes.\n- Wireframes de baja fidelidad para todas las vistas principales.\n- Mockups de alta fidelidad con sistema de diseño consistente.\n- Prototipado interactivo con flujos de navegación.\n- Revisión con el cliente y ajustes de diseño.",
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 1200,
                    'tasks' => [
                        ['name' => 'Investigación y análisis de plataformas e-learning de referencia', 'description' => 'Análisis de plataformas e-learning de referencia (Moodle, Coursera, Udemy, Platzi) para identificar buenas prácticas de UX, patrones de navegación y funcionalidades clave.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de wireframes de baja fidelidad para todas las vistas principales', 'description' => 'Creación de wireframes de baja fidelidad para las vistas principales: dashboard, catálogo de cursos, detalle de curso, reproductor de lecciones, evaluaciones, perfil de usuario y panel de administración.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Diseño de mockups de alta fidelidad con sistema de diseño', 'description' => 'Diseño visual de mockups de alta fidelidad con sistema de diseño definido (paleta de colores, tipografías, componentes reutilizables, iconografía) para desktop y mobile.', 'duration_value' => 20, 'duration_unit' => 'hours'],
                        ['name' => 'Prototipado interactivo y flujos de navegación', 'description' => 'Creación de prototipo interactivo con flujos de navegación completos para validar la experiencia de usuario antes del desarrollo.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Revisión con el cliente y ajustes de diseño', 'description' => 'Presentación del diseño al cliente, recopilación de feedback y realización de ajustes y correcciones según sus observaciones.', 'duration_value' => 4, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Módulo de Gestión de Usuarios y Autenticación',
                    'description' => "Sistema completo de autenticación y gestión de usuarios con roles diferenciados (administrador, instructor, estudiante), registro, login, recuperación de contraseña y perfiles de usuario.\n\nIncluye:\n- Sistema de autenticación seguro (registro, login, recuperación de contraseña).\n- Roles y permisos diferenciados (administrador, instructor, estudiante).\n- Perfiles de usuario con foto, datos personales y preferencias.\n- Panel de gestión de usuarios para administradores (CRUD completo).\n- Notificaciones por email.\n- Validación de seguridad por rol.",
                    'quantity' => 1,
                    'unit' => 'módulo',
                    'unit_price' => 1500,
                    'tasks' => [
                        ['name' => 'Implementación del sistema de autenticación (registro, login, recuperación de contraseña)', 'description' => 'Desarrollo del sistema de autenticación completo con registro de usuarios, inicio de sesión seguro, recuperación de contraseña por email y verificación de cuenta.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Desarrollo del sistema de roles y permisos (administrador, instructor, estudiante)', 'description' => 'Implementación de roles diferenciados con permisos específicos: administrador (gestión total), instructor (gestión de cursos y evaluaciones), estudiante (acceso a cursos y evaluaciones).', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Módulo de perfiles de usuario con foto, datos personales y preferencias', 'description' => 'Desarrollo de perfiles de usuario con carga de foto de perfil, edición de datos personales, configuración de preferencias de notificación y zona horaria.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Panel de gestión de usuarios para administradores (CRUD completo)', 'description' => 'Desarrollo del panel administrativo para gestión de usuarios: listado con filtros, creación, edición, activación/desactivación, asignación de roles y exportación de datos.', 'duration_value' => 20, 'duration_unit' => 'hours'],
                        ['name' => 'Implementación de notificaciones por email (bienvenida, recuperación, avisos)', 'description' => 'Configuración del sistema de notificaciones por email: correo de bienvenida al registrarse, recuperación de contraseña, avisos de inscripción a cursos y notificaciones administrativas.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de seguridad y validación de accesos por rol', 'description' => 'Pruebas exhaustivas de seguridad: validación de permisos por rol, protección contra accesos no autorizados, pruebas de inyección y XSS, y verificación de flujos de autenticación.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Módulo de Cursos y Contenido Educativo',
                    'description' => "Sistema central de gestión de cursos con creación de contenido multimedia, organización por módulos y lecciones, seguimiento de progreso del estudiante, y reproducción de contenido en video, PDF y texto enriquecido.\n\nIncluye:\n- CRUD de cursos con categorías y etiquetas.\n- Estructura jerárquica de módulos y lecciones.\n- Gestión de contenido multimedia (videos, PDFs, imágenes, texto enriquecido).\n- Sistema de inscripción y matrícula de estudiantes.\n- Barra de progreso y seguimiento de avance.\n- Reproductor de video integrado.\n- Foro de discusión por lección.",
                    'quantity' => 1,
                    'unit' => 'módulo',
                    'unit_price' => 2200,
                    'tasks' => [
                        ['name' => 'Desarrollo del CRUD de cursos con categorías y etiquetas', 'description' => 'Implementación del sistema de gestión de cursos: creación, edición, eliminación, publicación/despublicación, asignación de categorías y etiquetas, imagen de portada y descripción.', 'duration_value' => 20, 'duration_unit' => 'hours'],
                        ['name' => 'Sistema de módulos y lecciones dentro de cada curso (estructura jerárquica)', 'description' => 'Desarrollo de la estructura jerárquica de contenido: cursos contienen módulos, módulos contienen lecciones. Interfaz drag-and-drop para reordenamiento y gestión de prerequisitos entre módulos.', 'duration_value' => 24, 'duration_unit' => 'hours'],
                        ['name' => 'Gestión de contenido multimedia (videos, PDFs, imágenes, texto enriquecido)', 'description' => 'Sistema de carga y gestión de contenido multimedia: soporte para videos (upload y embed), documentos PDF, imágenes y editor de texto enriquecido con formato avanzado.', 'duration_value' => 20, 'duration_unit' => 'hours'],
                        ['name' => 'Sistema de inscripción y matrícula de estudiantes a cursos', 'description' => 'Módulo de inscripción y matrícula: catálogo de cursos disponibles, proceso de inscripción, gestión de cupos, listado de estudiantes inscritos por curso y panel de mis cursos para el estudiante.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Barra de progreso y seguimiento de avance por estudiante', 'description' => 'Implementación del sistema de seguimiento de progreso: barra de avance por curso y módulo, marcado de lecciones completadas, dashboard de progreso para el estudiante y reportes para el instructor.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Reproductor de video integrado con marcadores de progreso', 'description' => 'Desarrollo de reproductor de video personalizado con controles de reproducción, marcadores de progreso, reanudación automática desde el último punto visto y soporte para múltiples formatos.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Sistema de comentarios y foro de discusión por lección', 'description' => 'Implementación del sistema de comentarios y foro de discusión por lección: publicación de preguntas y respuestas, hilos de discusión, notificaciones al instructor y moderación de contenido.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Módulo de Evaluaciones y Exámenes',
                    'description' => "Sistema de evaluaciones en línea con constructor de exámenes, múltiples tipos de preguntas (opción múltiple, verdadero/falso, respuesta abierta, completar), calificación automática, banco de preguntas y reportes de resultados.\n\nIncluye:\n- Constructor de exámenes con interfaz drag-and-drop.\n- Múltiples tipos de preguntas.\n- Motor de calificación automática.\n- Banco de preguntas reutilizable.\n- Configuración de intentos, tiempo límite y disponibilidad.\n- Reportes de resultados.",
                    'quantity' => 1,
                    'unit' => 'módulo',
                    'unit_price' => 1800,
                    'tasks' => [
                        ['name' => 'Constructor de exámenes con interfaz drag-and-drop para preguntas', 'description' => 'Desarrollo del constructor visual de exámenes con interfaz drag-and-drop para agregar, reordenar y configurar preguntas. Incluye vista previa del examen y duplicación de evaluaciones.', 'duration_value' => 24, 'duration_unit' => 'hours'],
                        ['name' => 'Implementación de tipos de preguntas: opción múltiple, verdadero/falso, respuesta abierta, completar', 'description' => 'Desarrollo de los diferentes tipos de preguntas soportados: opción múltiple (una o varias respuestas correctas), verdadero/falso, respuesta abierta con rúbrica y completar espacios en blanco.', 'duration_value' => 20, 'duration_unit' => 'hours'],
                        ['name' => 'Motor de calificación automática con ponderación configurable', 'description' => 'Implementación del motor de calificación automática: corrección inmediata para preguntas objetivas, ponderación configurable por pregunta, cálculo de nota final y retroalimentación automática.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Banco de preguntas reutilizable por curso y categoría', 'description' => 'Desarrollo del banco de preguntas: repositorio centralizado organizado por curso y categoría, importación/exportación de preguntas, selección aleatoria para exámenes y estadísticas de uso.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Configuración de intentos, tiempo límite y fecha de disponibilidad', 'description' => 'Sistema de configuración de parámetros de examen: número máximo de intentos, tiempo límite por examen, fechas de disponibilidad (inicio y fin), y opciones de visualización de resultados.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Reportes de resultados por estudiante y por evaluación', 'description' => 'Generación de reportes de resultados: vista detallada por estudiante con respuestas y retroalimentación, estadísticas generales por evaluación (promedio, distribución de notas, tasa de aprobación) y exportación de datos.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Módulo de Certificaciones Digitales',
                    'description' => "Sistema de generación de certificados digitales personalizados al completar cursos, con diseño de plantillas, código QR de verificación, descarga en PDF y página de verificación pública.\n\nIncluye:\n- Plantillas de certificados personalizables.\n- Generación automática de certificados en PDF.\n- Código QR y código único para verificación.\n- Página pública de verificación.\n- Reglas de emisión configurables.\n- Historial de certificados emitidos.",
                    'quantity' => 1,
                    'unit' => 'módulo',
                    'unit_price' => 1300,
                    'tasks' => [
                        ['name' => 'Diseño y configuración de plantillas de certificados personalizables', 'description' => 'Desarrollo del sistema de plantillas de certificados: editor visual para personalizar diseño, logo, colores, textos dinámicos (nombre del estudiante, curso, fecha, calificación) y firma digital del instructor.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Motor de generación automática de certificados en PDF', 'description' => 'Implementación del motor de generación de certificados en formato PDF de alta calidad, con renderizado de plantillas, datos dinámicos del estudiante y curso, y optimización del archivo para descarga e impresión.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Sistema de código QR y código único para verificación de autenticidad', 'description' => 'Generación de código QR y código alfanumérico único por certificado para verificación de autenticidad. El QR enlaza directamente a la página de verificación pública.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Página pública de verificación de certificados', 'description' => 'Desarrollo de página web pública accesible sin autenticación donde cualquier persona puede verificar la autenticidad de un certificado ingresando el código único o escaneando el QR.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Gestión de reglas de emisión (nota mínima, porcentaje de avance, asistencia)', 'description' => 'Configuración de reglas para emisión automática de certificados: nota mínima requerida, porcentaje de avance del curso completado, asistencia mínima y aprobación de evaluaciones obligatorias.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Historial de certificados emitidos por estudiante', 'description' => 'Panel de historial de certificados: listado de todos los certificados emitidos por estudiante, opción de re-descarga, revocación por administrador y estadísticas de emisión.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Panel de Administración y Reportes',
                    'description' => "Dashboard administrativo con estadísticas en tiempo real, reportes de actividad, gestión de configuraciones generales de la plataforma y exportación de datos.\n\nIncluye:\n- Dashboard con métricas clave.\n- Reportes de actividad y progreso.\n- Sistema de configuración general.\n- Exportación de reportes en Excel y PDF.\n- Log de actividad y auditoría.",
                    'quantity' => 1,
                    'unit' => 'módulo',
                    'unit_price' => 1000,
                    'tasks' => [
                        ['name' => 'Dashboard con métricas clave (estudiantes activos, cursos, evaluaciones, certificados)', 'description' => 'Desarrollo del dashboard administrativo con widgets de métricas en tiempo real: total de estudiantes activos, cursos publicados, evaluaciones realizadas, certificados emitidos, gráficos de tendencias y actividad reciente.', 'duration_value' => 16, 'duration_unit' => 'hours'],
                        ['name' => 'Reportes de actividad y progreso por curso y por estudiante', 'description' => 'Sistema de reportes detallados: progreso de estudiantes por curso, tasas de completación, rendimiento en evaluaciones, tiempo invertido por lección y comparativas entre períodos.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Sistema de configuración general de la plataforma (branding, emails, parámetros)', 'description' => 'Panel de configuración general: personalización de branding (logo, colores, nombre), configuración de plantillas de email, parámetros generales de la plataforma y configuración de integraciones.', 'duration_value' => 12, 'duration_unit' => 'hours'],
                        ['name' => 'Exportación de reportes en Excel y PDF', 'description' => 'Funcionalidad de exportación de datos y reportes en formatos Excel (.xlsx) y PDF, con filtros de fecha, curso y estudiante, e inclusión de gráficos en los reportes PDF.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                        ['name' => 'Log de actividad y auditoría de acciones administrativas', 'description' => 'Sistema de registro de actividad (audit log): registro de todas las acciones administrativas, accesos al sistema, cambios en configuración, con filtros de búsqueda y exportación.', 'duration_value' => 10, 'duration_unit' => 'hours'],
                    ],
                ],
                [
                    'name' => 'Despliegue, Configuración del Servidor y Capacitación',
                    'description' => "Configuración del entorno de producción, despliegue de la plataforma, pruebas finales de funcionamiento y capacitación al equipo administrador para la gestión autónoma de la plataforma.\n\nIncluye:\n- Configuración del servidor de producción (hosting, dominio, SSL).\n- Despliegue y configuración de la aplicación.\n- Pruebas de funcionamiento integral.\n- Capacitación al equipo administrador.\n- Documentación técnica y manual de usuario.",
                    'quantity' => 1,
                    'unit' => 'servicio',
                    'unit_price' => 500,
                    'tasks' => [
                        ['name' => 'Configuración del servidor de producción (hosting, dominio, SSL)', 'description' => 'Setup completo del servidor de producción: configuración del hosting/VPS, apuntamiento de dominio y DNS, instalación y configuración de certificado SSL, configuración de PHP, base de datos y servicios necesarios.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Despliegue y configuración de la aplicación en producción', 'description' => 'Despliegue de la plataforma en el servidor de producción: configuración de variables de entorno, migraciones de base de datos, configuración de colas y tareas programadas, y optimización de caché.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Pruebas de funcionamiento integral y corrección de errores', 'description' => 'Ejecución de pruebas integrales en el entorno de producción: verificación de todos los módulos, pruebas de carga, validación de emails, verificación de certificados y corrección de errores detectados.', 'duration_value' => 8, 'duration_unit' => 'hours'],
                        ['name' => 'Capacitación al administrador en gestión de cursos, evaluaciones y certificados', 'description' => 'Sesión de capacitación práctica al equipo administrador: gestión de usuarios y roles, creación y publicación de cursos, configuración de evaluaciones, emisión de certificados y uso del panel de reportes.', 'duration_value' => 6, 'duration_unit' => 'hours'],
                        ['name' => 'Documentación técnica y manual de usuario', 'description' => 'Elaboración de documentación técnica (arquitectura, instalación, configuración) y manual de usuario para administradores e instructores con capturas de pantalla y guías paso a paso.', 'duration_value' => 4, 'duration_unit' => 'hours'],
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
