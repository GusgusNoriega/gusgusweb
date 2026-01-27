# BetkoPeruAppLubricacionQuoteSeeder

## Descripción

Seeder para crear una cotización de desarrollo de aplicación móvil para BETKO PERU S.A.C., conectada al sistema de lubricación de maquinaria pesada existente, con capacidad de funcionamiento offline y sincronización automática de datos.

## Datos del Cliente

| Campo | Valor |
|-------|-------|
| **Empresa** | BETKO PERU S.A.C. |
| **RUC** | 20371939173 |
| **Contacto** | M. Guerrero |
| **Email** | mguerrero@betkoperu.com |
| **Rubro** | Mantenimiento Industrial / Lubricación de Maquinaria Pesada |

## Datos de la Cotización

### Información General

| Campo | Valor |
|-------|-------|
| **Número de Cotización** | COT-20371939173-APP-0001 |
| **Proyecto** | Aplicación Móvil - Sistema de Lubricación con Sincronización Offline |
| **Tipo** | Desarrollo de Aplicación Móvil Nativa |
| **Moneda** | PEN (Sol Peruano) |

### Costos

| Concepto | Monto |
|----------|-------|
| **Subtotal** | S/ 6,000.00 |
| **IGV (18%)** | S/ 1,080.00 |
| **TOTAL** | S/ 7,080.00 |

### Forma de Pago

| Pago | Porcentaje | Monto | Momento |
|------|------------|-------|---------|
| Primer pago | 50% | S/ 3,540.00 | Al iniciar el proyecto |
| Segundo pago | 50% | S/ 3,540.00 | Al culminar el proyecto |

### Cronograma General

| Mes | Actividades |
|-----|-------------|
| **Mes 1** | Evaluación, diseño y desarrollo de APIs |
| **Mes 2** | Desarrollo de la aplicación móvil core |
| **Mes 3** | Implementación offline, sincronización y módulos |
| **Mes 4** | Pruebas, correcciones y despliegue |

## Estructura de Fases

### Fase 1: Evaluación del Sistema Actual y Análisis de APIs (S/ 600.00)
**Duración:** Semanas 1-2

| Tarea | Descripción | Duración |
|-------|-------------|----------|
| Revisión de arquitectura del sistema web | Análisis de estructura, tecnologías y patrones | 8 horas |
| Análisis y documentación de APIs existentes | Revisión de endpoints, autenticación, documentación OpenAPI | 12 horas |
| Diagnóstico de APIs necesarias | Identificar APIs reutilizables, modificables y nuevas | 8 horas |
| Análisis de estructura de base de datos | Revisión de modelos, relaciones, datos para réplica local | 6 horas |
| Definición de estrategia de sincronización | Diseño de mecanismo sync, manejo de conflictos, versionado | 8 horas |
| Documento de especificaciones técnicas | Hallazgos, arquitectura propuesta, plan detallado | 6 horas |
| Reunión de presentación y validación | Presentación al cliente y ajustes al plan | 3 horas |

### Fase 2: Desarrollo y Actualización de APIs (S/ 850.00)
**Duración:** Semanas 2-4

| Tarea | Descripción | Duración |
|-------|-------------|----------|
| Configuración de entorno de APIs móviles | Setup de rutas, middlewares, rate limiting, CORS | 6 horas |
| API de autenticación móvil | JWT/OAuth, refresh tokens, sesiones, logout remoto | 10 horas |
| APIs de gestión de maquinaria | Listar, detalle, historial, estado. Paginación y filtros | 12 horas |
| APIs de registro de lubricación | CRUD, adjuntos, envío batch de registros offline | 14 horas |
| APIs de sincronización | Sync pull, sync push, verificación de conflictos | 16 horas |
| APIs de catálogos y configuración | Tipos de lubricantes, catálogos, parámetros del sistema | 8 horas |
| APIs de alertas y notificaciones | Obtener alertas, marcar vistas, config de push | 8 horas |
| Documentación y testing de APIs | Swagger/OpenAPI, Postman, tests automatizados | 10 horas |

### Fase 3: Diseño UX/UI de la Aplicación Móvil (S/ 500.00)
**Duración:** Semanas 3-4

| Tarea | Descripción | Duración |
|-------|-------------|----------|
| Investigación de usuarios y contexto | Perfil de técnicos, condiciones de trabajo, dispositivos | 4 horas |
| Arquitectura de información | Estructura de navegación, jerarquía de pantallas | 4 horas |
| Wireframes de pantallas principales | Login, Dashboard, Máquinas, Lubricación, Historial, etc. | 10 horas |
| Diseño de sistema de componentes | Colores, tipografías, iconografía, estados | 6 horas |
| Diseño UI de pantallas | Alta fidelidad para todas las pantallas | 14 horas |
| Diseño de estados offline/online | Indicadores de conexión, cola de sync, conflictos | 6 horas |
| Prototipo interactivo | Prototipo navegable en Figma/Adobe XD | 6 horas |
| Validación de diseños con cliente | Presentación, feedback y ajustes | 4 horas |

### Fase 4: Desarrollo de Aplicación Móvil - Módulo Core (S/ 900.00)
**Duración:** Semanas 5-7

| Tarea | Descripción | Duración |
|-------|-------------|----------|
| Configuración del proyecto móvil | Setup React Native/Flutter, estructura, linters | 8 horas |
| Implementación de navegación | Stack, tab, drawer navigation, deep linking | 8 horas |
| Sistema de gestión de estado | Redux/Bloc/Provider: stores, actions, reducers | 12 horas |
| Módulo de autenticación | Login, tokens, persistencia de sesión, logout | 14 horas |
| Capa de servicios y APIs | HTTP layer, interceptores, retry logic, auth headers | 10 horas |
| Dashboard principal | Resumen, alertas, accesos rápidos, indicador sync | 12 horas |
| Componentes UI reutilizables | Buttons, inputs, cards, lists, modals, states | 12 horas |
| Testing y QA del módulo core | Pruebas unitarias, integración, flujos principales | 8 horas |

### Fase 5: Implementación de Sistema Offline y Sincronización (S/ 1,000.00)
**Duración:** Semanas 7-9

| Tarea | Descripción | Duración |
|-------|-------------|----------|
| Configuración de base de datos local | SQLite/Realm/WatermelonDB: schemas, migraciones, índices | 12 horas |
| Implementación de modelos locales | Modelos de máquinas, lubricaciones, catálogos | 10 horas |
| Sistema de caché de datos | Estrategia de caché, TTL, invalidación | 8 horas |
| Cola de operaciones offline | Queue para operaciones sin conexión, reintentos | 14 horas |
| Motor de sincronización - Push | Envío de cambios, manejo de errores, rollback | 16 horas |
| Motor de sincronización - Pull | Obtención de cambios, actualización local | 14 horas |
| Sistema de resolución de conflictos | Lógica de merge, UI de resolución manual | 12 horas |
| Detección de conectividad | Estado de red, triggers de sync, backoff exponencial | 8 horas |
| UI de estado de sincronización | Componentes de indicador sync, cola, errores | 8 horas |

### Fase 6: Desarrollo de Módulos Funcionales (S/ 900.00)
**Duración:** Semanas 9-11

| Tarea | Descripción | Duración |
|-------|-------------|----------|
| Módulo de listado de maquinaria | Búsqueda, filtros, cards con estado, indicador offline | 12 horas |
| Módulo de detalle de máquina | Ficha técnica, historial, próxima lubricación | 10 horas |
| Formulario de registro de lubricación | Formulario completo, 100% funcional offline | 16 horas |
| Captura de evidencias fotográficas | Integración cámara, compresión, sync de imágenes | 12 horas |
| Módulo de alertas y notificaciones | Lista de alertas, detalle, acciones, push | 12 horas |
| Configuración de notificaciones push | FCM/APNs, foreground/background, deep linking | 10 horas |
| Módulo de historial y reportes | Historial filtrable, exportación, gráficos | 10 horas |
| Configuración y perfil de usuario | Perfil, ajustes de sync, preferencias, logout | 8 horas |

### Fase 7: Pruebas Integrales, QA y Optimización (S/ 700.00)
**Duración:** Semanas 12-14

| Tarea | Descripción | Duración |
|-------|-------------|----------|
| Pruebas funcionales por módulo | Testing exhaustivo de cada módulo | 16 horas |
| Pruebas de sincronización | Testing de sync: creación, edición, eliminación offline | 14 horas |
| Pruebas de escenarios offline | Uso prolongado sin conexión, recuperación | 12 horas |
| Pruebas de conflictos de datos | Simulación de conflictos, resolución | 10 horas |
| Pruebas en dispositivos Android | Múltiples versiones y dispositivos | 10 horas |
| Pruebas en dispositivos iOS | iPhone, diferentes versiones de iOS | 8 horas |
| Pruebas de rendimiento y batería | Consumo de recursos, optimización | 8 horas |
| Corrección de bugs y ajustes | Resolución de todos los issues | 16 horas |
| Optimización general de la app | Tiempos de carga, tamaño, lazy loading | 10 horas |

### Fase 8: Despliegue, Documentación y Entrega Final (S/ 550.00)
**Duración:** Semanas 14-16

| Tarea | Descripción | Duración |
|-------|-------------|----------|
| Preparación de assets para stores | Iconos, screenshots, descripciones | 6 horas |
| Build de producción Android | APK/AAB firmado, ofuscación, optimización | 4 horas |
| Build de producción iOS | IPA, certificados, provisioning profiles | 4 horas |
| Publicación en Google Play Store | Subida, configuración, publicación | 4 horas |
| Publicación en App Store | App Store Connect, TestFlight, publicación | 4 horas |
| Despliegue de APIs a producción | Deploy, verificación, monitoreo | 6 horas |
| Documentación técnica | Arquitectura, APIs, base de datos, sync | 10 horas |
| Manual de usuario | Instalación, uso, trabajo offline, troubleshooting | 8 horas |
| Capacitación al equipo | Sesiones para admins y usuarios finales | 6 horas |
| Entrega de código fuente | Repositorios, documentación de setup | 4 horas |
| Soporte post-lanzamiento (30 días) | Bugs críticos, ajustes menores, soporte técnico | 20 horas |

## Características Técnicas Principales

### Funcionamiento Offline
- Base de datos local (SQLite/Realm/WatermelonDB)
- Cola de operaciones pendientes
- Sincronización automática al recuperar conexión
- Resolución de conflictos inteligente

### Sincronización de Datos
- Sync bidireccional (push/pull)
- Timestamps y versionado de datos
- Manejo de conflictos
- Indicadores visuales de estado

### Seguridad
- Autenticación por tokens (JWT/OAuth)
- Refresh tokens
- Almacenamiento seguro de credenciales
- Logout remoto

## Ejecución del Seeder

### Ejecutar solo este seeder:

```bash
php artisan db:seed --class=BetkoPeruAppLubricacionQuoteSeeder
```

### Ejecutar con todos los seeders:

```bash
php artisan db:seed
```

## Entidades Creadas

El seeder crea las siguientes entidades:

1. **Usuario cliente**: `mguerrero@betkoperu.com`
2. **Lead de empresa**: BETKO PERU S.A.C. (RUC: 20371939173)
3. **Cotización**: COT-20371939173-APP-0001 con 8 fases y 67 tareas

## Requisitos del Cliente

### Para iniciar el proyecto:
- Acceso completo al sistema web actual
- Documentación técnica de APIs existentes
- Acceso al código fuente del backend
- Credenciales de bases de datos
- Listado de funcionalidades prioritarias
- Especificaciones de dispositivos móviles utilizados

### Cuentas de desarrollador (costo del cliente):
- **Google Play Console**: ~$25 USD (pago único)
- **Apple Developer Program**: ~$99 USD/año (si se requiere iOS)

## Entregables Finales

- ✅ Aplicación móvil funcional (APK/IPA)
- ✅ APIs nuevas o actualizadas
- ✅ Documentación técnica completa
- ✅ Manual de usuario
- ✅ Código fuente de la aplicación
- ✅ Capacitación al equipo
- ✅ Soporte post-lanzamiento (30 días)

## Notas Importantes

1. **Validez de la cotización**: 30 días desde su creación
2. **El sistema offline** permite trabajar sin conexión durante días y sincronizar cuando hay red
3. **Las pruebas de sincronización** son críticas y exhaustivas para garantizar integridad de datos
4. **El soporte incluido** cubre solo bugs críticos y ajustes menores por 30 días
