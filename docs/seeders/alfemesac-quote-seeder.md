# AlfemesacQuoteSeeder

## Descripción

Seeder que crea una cotización para **ALEACIONES FERROSAS Y METALICAS S.A.C. (ALFEMESAC)**, empresa peruana exportadora de residuos metálicos y electrónicos orientada a la gestión ambiental responsable.

## Datos de la Empresa

| Campo | Valor |
|-------|-------|
| **Razón Social** | ALEACIONES FERROSAS Y METALICAS S.A.C. |
| **Nombre Comercial** | Alfemesac |
| **RUC** | 20607388416 |
| **Dirección** | Av. Los Rosales 655, Coop. 27 de Abril, Santa Anita - Lima, Perú |
| **Teléfono** | +51 960 666 901 |
| **Email** | info@alfemesac.com.pe |
| **Web Actual** | https://alfemesac.com.pe/ |
| **Tipo Empresa** | Sociedad Anónima Cerrada |
| **Rubro** | Exportación de residuos metálicos y electrónicos, gestión ambiental |

## Detalle de la Cotización

| Concepto | Valor |
|----------|-------|
| **Número de Cotización** | COT-20607388416-WEB-0001 |
| **Tipo** | Página Web Corporativa |
| **Subtotal** | S/ 1,400.00 |
| **IGV (18%)** | S/ 252.00 |
| **Total** | S/ 1,652.00 |
| **Moneda** | PEN (Sol Peruano) |
| **Validez** | 15 días |
| **Tiempo Estimado** | 2-3 semanas |

## Items de la Cotización

### 1. Diseño Web UI/UX - S/ 350.00
- Análisis de marca y sector industrial/ambiental
- Definición de paleta de colores y tipografías
- Wireframes de las secciones principales
- Diseño visual de mockups (desktop y mobile)
- Revisiones y ajustes según feedback del cliente

**Tareas:**
- Análisis de marca y requerimientos (1 día)
- Definición de identidad visual web (1 día)
- Wireframes y estructura de navegación (1 día)
- Diseño de mockups (desktop y mobile) (2 días)

### 2. Desarrollo Frontend (HTML/CSS/JS) - S/ 400.00
- Estructura HTML5 semántica
- Estilos CSS3/SCSS responsive
- Animaciones y transiciones suaves
- Optimización de rendimiento (lazy loading, minificación)
- Compatibilidad con navegadores modernos

**Tareas:**
- Estructura HTML base y componentes (1 día)
- Estilos CSS/SCSS responsive (2 días)
- Interactividad JavaScript (1 día)
- Optimización de rendimiento (1 día)

### 3. Desarrollo Backend y CMS - S/ 350.00
- Panel de administración para gestión de contenido
- Gestión de secciones editables (textos, imágenes)
- Formulario de contacto con envío de correos
- Base de datos para contenido dinámico
- Sistema de usuarios básico para admins

**Tareas:**
- Configuración del entorno backend (1 día)
- Panel de administración básico (2 días)
- Formulario de contacto funcional (1 día)
- Integración WhatsApp Business (0.5 días)

### 4. SEO Básico y Configuración - S/ 150.00
- Meta tags optimizados (title, description)
- Estructura de URLs amigables
- Sitemap XML y robots.txt
- Schema markup básico (LocalBusiness)
- Configuración de Google Search Console

**Tareas:**
- Optimización de meta tags (0.5 días)
- Estructura SEO y URLs amigables (0.5 días)
- Sitemap, robots.txt y Schema (0.5 días)
- Registro en Google Search Console (0.5 días)

### 5. Despliegue y Puesta en Producción - S/ 150.00
- Configuración de servidor/hosting
- Instalación de certificado SSL
- Configuración de dominio y DNS
- Migración y despliegue del sitio
- Pruebas finales de funcionamiento

**Tareas:**
- Configuración de hosting y dominio (0.5 días)
- Instalación de SSL y seguridad (0.5 días)
- Despliegue y pruebas finales (1 día)
- Capacitación básica (0.5 días)

## Secciones de la Página Web

1. **Inicio** - Hero, presentación de la empresa, CTA
2. **¿Quiénes somos?** - Misión, visión, valores, equipo
3. **Productos que comercializamos** - Acero inoxidable, tarjetas electrónicas, metales ferrosos/no ferrosos
4. **Exportación** - Países destino, alianzas
5. **Contacto** - Formulario, mapa, datos de contacto

## Condiciones Comerciales

- **Forma de pago:** 50% al iniciar / 50% antes de publicación
- **Hosting y dominio:** Se incluye configuración; renovaciones anuales a cargo del cliente
- **Soporte post-lanzamiento:** 15 días para ajustes menores incluidos
- **Alcance:** Funcionalidades adicionales se cotizan por separado

## Requisitos para Iniciar

- Logo en alta resolución (PNG, SVG o AI)
- Textos institucionales (misión, visión, valores, historia)
- Listado de productos/servicios con descripciones
- Fotografías de instalaciones, equipo y procesos
- Información de contacto oficial
- Certificaciones y registros (MINAM, EO-RS, etc.)
- Países de exportación y alianzas comerciales

## Entregables

- Página web operativa en servidor de producción con SSL
- Panel de administración (CMS) para gestión de contenido
- Capacitación básica para actualización de contenido
- Código fuente y documentación técnica

## Ejecución del Seeder

```bash
# Ejecutar solo este seeder
php artisan db:seed --class=AlfemesacQuoteSeeder

# O ejecutar junto con todos los seeders
php artisan db:seed
```

## Archivos Relacionados

- [`database/seeders/AlfemesacQuoteSeeder.php`](../../database/seeders/AlfemesacQuoteSeeder.php)
- [`database/seeders/DatabaseSeeder.php`](../../database/seeders/DatabaseSeeder.php)

## Referencias

- Web actual de la empresa: https://alfemesac.com.pe/
- Registro MINAM: EO-RS-00218-2021-MINAM/VMGA/DGRS
- Consulta RUC: https://www.universidadperu.com/ruc
