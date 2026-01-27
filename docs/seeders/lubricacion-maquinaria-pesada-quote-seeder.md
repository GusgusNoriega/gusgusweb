# LubricacionMaquinariaPesadaQuoteSeeder

## Descripción

Seeder para crear una cotización de actualización del sistema de verificación de tiempos de lubricación de maquinaria pesada, enfocado en hacer el sistema completamente responsive para administración móvil.

## Datos de la Cotización

### Información General

| Campo | Valor |
|-------|-------|
| **Número de Cotización** | COT-LUBMAQ-RESP-0001 |
| **Proyecto** | Actualización Responsive - Sistema de Lubricación de Maquinaria Pesada |
| **Tipo** | Actualización de Sistema Web |
| **Moneda** | PEN (Sol Peruano) |

### Costos

| Concepto | Monto |
|----------|-------|
| **Subtotal** | S/ 2,000.00 |
| **IGV (18%)** | S/ 360.00 |
| **TOTAL** | S/ 2,360.00 |

### Forma de Pago

| Pago | Porcentaje | Monto | Momento |
|------|------------|-------|---------|
| Primer pago | 50% | S/ 1,180.00 | Al iniciar el proyecto |
| Segundo pago | 50% | S/ 1,180.00 | Al culminar el proyecto |

### Cronograma

| Fase | Duración | Semana |
|------|----------|--------|
| Evaluación completa del sistema | 1 semana | Semana 1 |
| Diseño de interfaces responsive | 1 semana | Semana 2 |
| Desarrollo responsive | 1 semana | Semanas 2-3 |
| Adaptación de módulos específicos | 1 semana | Semana 3 |
| Pruebas, QA y optimización | 1.5 semanas | Semanas 4-5 |
| Entrega final y documentación | 0.5 semanas | Semana 5 |
| **TOTAL** | **5 semanas** | |

## Estructura de Items

### Fase 1: Evaluación Completa del Sistema (S/ 400.00)
**Duración:** Semana 1

Tareas incluidas:
- Revisión de arquitectura técnica (8 horas)
- Mapeo de módulos y funcionalidades (8 horas)
- Análisis de interfaces actuales (6 horas)
- Análisis de base de datos y API (6 horas)
- Documentación y planificación (8 horas)
- Reunión de presentación de evaluación (2 horas)

### Fase 2: Diseño de Interfaces Responsive (S/ 350.00)
**Duración:** Semana 2

Tareas incluidas:
- Diseño de navegación móvil (6 horas)
- Wireframes de módulos principales (8 horas)
- Diseño de componentes responsive (6 horas)
- Prototipado de flujos críticos (6 horas)
- Validación de diseños con cliente (4 horas)

### Fase 3: Implementación de Estructura Responsive (S/ 450.00)
**Duración:** Semanas 2-3

Tareas incluidas:
- Configuración de framework responsive (6 horas)
- Desarrollo de componentes base (10 horas)
- Adaptación del Dashboard (8 horas)
- Adaptación de tablas y listados (8 horas)
- Adaptación de formularios (6 horas)

### Fase 4: Adaptación de Módulos Específicos (S/ 400.00)
**Duración:** Semana 3

Tareas incluidas:
- Módulo de Gestión de Maquinaria (8 horas)
- Módulo de Registro de Lubricación (8 horas)
- Módulo de Alertas y Notificaciones (6 horas)
- Módulo de Reportes (8 horas)
- Módulo de Configuración y Usuarios (6 horas)

### Fase 5: Pruebas, QA y Optimización (S/ 250.00)
**Duración:** Semanas 4-5

Tareas incluidas:
- Pruebas en dispositivos móviles (10 horas)
- Pruebas en tablets (6 horas)
- Pruebas de navegadores (6 horas)
- Optimización de rendimiento (8 horas)
- Corrección de bugs y ajustes (10 horas)

### Fase 6: Entrega Final y Documentación (S/ 150.00)
**Duración:** Semana 5

Tareas incluidas:
- Documentación técnica (4 horas)
- Manual de usuario móvil (4 horas)
- Capacitación al equipo (3 horas)
- Despliegue a producción (3 horas)
- Reporte final y cierre (2 horas)

## Ejecución del Seeder

### Ejecutar solo este seeder:

```bash
php artisan db:seed --class=LubricacionMaquinariaPesadaQuoteSeeder
```

### Ejecutar con todos los seeders:

```bash
php artisan db:seed
```

### Ejecutar en ambiente de pruebas:

```bash
php artisan db:seed --class=LubricacionMaquinariaPesadaQuoteSeeder --env=testing
```

## Entidades Creadas

El seeder crea las siguientes entidades:

1. **Usuario cliente**: `cliente@lubricacion-maquinaria.com`
2. **Lead de empresa**: Sistema de Lubricación de Maquinaria Pesada
3. **Cotización**: COT-LUBMAQ-RESP-0001 con 6 items y 32 tareas

## Notas Importantes

- El RUC está definido como `00000000000` y debe actualizarse con el RUC real del cliente.
- Los datos de contacto (email, teléfono, dirección) son genéricos y deben personalizarse.
- La cotización tiene validez de 15 días desde su creación.
- El sistema está diseñado para grandes y pequeñas empresas del sector industrial.

## Alcance del Proyecto

El proyecto cubre la actualización responsive de:
- Dashboard principal
- Gestión de maquinaria
- Registro de tiempos de lubricación
- Sistema de alertas y notificaciones
- Módulo de reportes
- Configuración y gestión de usuarios

## Requisitos para Iniciar

- Acceso completo al sistema actual
- Documentación técnica existente
- Listado de módulos y funcionalidades prioritarias
- Especificaciones de dispositivos objetivo
- Feedback de usuarios actuales

## Entregables

- Sistema actualizado 100% responsive
- Documentación de cambios
- Manual de usuario actualizado
- Reporte de pruebas
- Capacitación sobre funcionalidades móviles
