<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the blog tables with sample data.
     */
    public function run(): void
    {
        // Categorías del blog
        $categories = [
            [
                'name' => 'Desarrollo Web',
                'slug' => 'desarrollo-web',
                'description' => 'Artículos sobre desarrollo web, frameworks, lenguajes y mejores prácticas.',
                'color' => '#6366f1',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Software a Medida',
                'slug' => 'software-a-medida',
                'description' => 'Todo sobre desarrollo de software personalizado para empresas.',
                'color' => '#10b981',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'SEO',
                'slug' => 'seo',
                'description' => 'Optimización para motores de búsqueda y posicionamiento web.',
                'color' => '#f59e0b',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Tutoriales',
                'slug' => 'tutoriales',
                'description' => 'Guías paso a paso y tutoriales prácticos sobre tecnología.',
                'color' => '#ec4899',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Noticias',
                'slug' => 'noticias',
                'description' => 'Últimas noticias del mundo tecnológico y digital.',
                'color' => '#ef4444',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'UX/UI Design',
                'slug' => 'ux-ui-design',
                'description' => 'Diseño de experiencias de usuario e interfaces modernas.',
                'color' => '#8b5cf6',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Seguridad',
                'slug' => 'seguridad',
                'description' => 'Protección de sitios web, aplicaciones y datos.',
                'color' => '#14b8a6',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Rendimiento',
                'slug' => 'rendimiento',
                'description' => 'Optimización de velocidad y rendimiento web.',
                'color' => '#f97316',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        // Crear categorías
        $categoryIds = [];
        foreach ($categories as $category) {
            $categoryModel = BlogCategory::create($category);
            $categoryIds[$category['slug']] = $categoryModel->id;
        }

        // Posts de prueba
        $posts = [
            [
                'title' => 'Cómo elegir la mejor tecnología para tu proyecto web en 2024',
                'slug' => 'elegir-mejor-tecnologia-proyecto-web-2024',
                'excerpt' => 'Descubre las tecnologías más modernas y eficientes para desarrollar tu página web o sistema. Comparamos Laravel, React, Vue y otras opciones.',
                'content' => '<p>En el mundo del desarrollo web, elegir la tecnología adecuada para tu proyecto es crucial para su éxito a largo plazo. En este artículo, analizamos las principales opciones disponibles en 2024.</p><h2>Laravel: El estándar de PHP</h2><p>Laravel continúa siendo una de las opciones más populares para desarrollo backend. Su ecosistema maduro, documentación excelente y comunidad activa lo convierten en una elección sólida para proyectos de cualquier tamaño.</p><h2>React: Flexibilidad para interfaces dinámicas</h2><p>React de Facebook sigue dominando el desarrollo de interfaces de usuario. Su componente basado en arquitectura y el ecosistema de React Native para aplicaciones móviles lo hacen ideal para proyectos que requieren interfaces interactivas.</p><h2>Vue.js: La opción progresiva</h2><p>Vue.js ofrece una curva de aprendizaje más suave y gran flexibilidad. Es perfecto para proyectos que necesitan crecer gradualmente.</p><h2>Conclusión</h2><p>La mejor tecnología depende de tus necesidades específicas. Considera factores como el tamaño del equipo, los requisitos del proyecto y la escalabilidad futura.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'is_featured' => true,
                'reading_time' => 8,
                'categories' => ['desarrollo-web', 'software-a-medida'],
            ],
            [
                'title' => '10 técnicas SEO esenciales para posicionar tu página web en Google',
                'slug' => 'tecnicas-seo-posicionar-google',
                'excerpt' => 'Aprende las mejores prácticas de SEO técnico y on-page para mejorar el posicionamiento de tu sitio web.',
                'content' => '<p>El SEO (Search Engine Optimization) es fundamental para atraer tráfico orgánico a tu sitio web. Aquí te presentamos 10 técnicas esenciales:</p><h2>1. Investigación de palabras clave</h2><p>Identifica los términos que buscan tus potenciales clientes y incorpóralos estratégicamente en tu contenido.</p><h2>2. Optimización de títulos y meta descripciones</h2><p>Crea títulos atractivos y descripciones que incentiven los clics.</p><h2>3. URLs amigables</h2><p>Utiliza URLs descriptivas que incluyan palabras clave relevantes.</p><h2>4. Velocidad de carga</h2><p>Optimiza imágenes, utiliza caché y minimiza archivos CSS y JavaScript.</p><h2>5. Diseño responsive</h2><p>Asegúrate de que tu sitio se vea bien en dispositivos móviles.</p><h2>6. Contenido de calidad</h2><p>Crea contenido original, útil y relevante para tu audiencia.</p><h2>7. Enlaces internos</h2><p>Conecta tus páginas entre sí para mejorar la navegación y el SEO.</p><h2>8. Datos estructurados</h2><p>Implementa schema.org para ayudar a Google a entender tu contenido.</p><h2>9. Seguridad HTTPS</h2><p>Utiliza certificados SSL para proteger tu sitio.</p><h2>10. Monitorización</h2><p>Usa Google Search Console para monitorear y mejorar tu rendimiento.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'is_featured' => false,
                'reading_time' => 7,
                'categories' => ['seo'],
            ],
            [
                'title' => 'Laravel vs Node.js: ¿Cuál elegir para tu proyecto backend?',
                'slug' => 'laravel-vs-nodejs-backend',
                'excerpt' => 'Comparamos dos de las tecnologías más populares para desarrollo backend para ayudarte a tomar la mejor decisión.',
                'content' => '<p>La elección entre Laravel y Node.js depende de múltiples factores. Analicemos ambas opciones:</p><h2>Laravel</h2><p>Framework PHP completo con:</p><ul><li>ORM elegante (Eloquent)</li><li>Sistema de routing intuitivo</li><li>Plantillas Blade</li><li>Gestión de migraciones</li><li>Comunidad extensa</li></ul><h2>Node.js</h2><p>Runtime de JavaScript con:</p><ul><li>Modelo asíncrono no bloqueante</li><li>Gran ecosistema (npm)</li><li>Ideal para aplicaciones en tiempo real</li><li>JavaScript en cliente y servidor</li></ul><h2>¿Cuál elegir?</h2><p>Elige Laravel si necesitas un framework completo con convenciones claras. Elige Node.js si tu equipo ya trabaja con JavaScript y necesitas alta concurrencia.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'is_featured' => false,
                'reading_time' => 6,
                'categories' => ['desarrollo-web', 'tutoriales'],
            ],
            [
                'title' => 'La importancia del diseño UX/UI en el éxito de tu página web',
                'slug' => 'importancia-diseno-ux-ui-exito-web',
                'excerpt' => 'Un buen diseño no es solo estética. Descubre cómo la experiencia de usuario impacta en las conversiones.',
                'content' => '<p>El diseño UX/UI es fundamental para el éxito de cualquier proyecto digital. Un sitio web visualmente atractivo pero difícil de usar fracasará en convertir visitantes en clientes.</p><h2>用户体验 (UX)</h2><p>Se enfoca en la experiencia del usuario:</p><ul><li>Facilidad de navegación</li><li>Velocidad de carga</li><li>Accesibilidad</li><li>Flujo de usuario intuitivo</li></ul><h2>Interfaz de Usuario (UI)</h2><p>Se centra en los elementos visuales:</p><ul><li>Jerarquía visual</li><li>Tipografía legible</li><li>Paleta de colores coherente</li><li>Espaciado y alineación</li></ul><h2>Estadísticas importantes</h2><p>El 94% de las primeras impresiones son basadas en el diseño web.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'is_featured' => false,
                'reading_time' => 5,
                'categories' => ['ux-ui-design'],
            ],
            [
                'title' => 'Cómo integrar WhatsApp Business en tu sistema de atención al cliente',
                'slug' => 'integrar-whatsapp-business-atencion-cliente',
                'excerpt' => 'Automatiza tus respuestas y mejora la atención al cliente integrando WhatsApp Business API.',
                'content' => '<p>La integración de WhatsApp Business puede transformar tu servicio al cliente. Aprende cómo hacerlo:</p><h2>Beneficios de WhatsApp Business</h2><ul><li>Mayor tasa de apertura que email (98%)</li><li>Comunicación instantánea</li><li>Notificaciones automatizadas</li><li>Envío de medios (imágenes, documentos)</li></ul><h2>Pasos para integrar</h2><ol><li>Obtén acceso a la API de WhatsApp Business</li><li>Configura tu número de empresa</li><li>Implementa webhooks para recibir mensajes</li><li>Crea plantillas de mensajes automatizados</li><li>Conecta con tu CRM</li></ol><h2>Chatbots</h2><p>Implementa respuestas automáticas para preguntas frecuentes y libera a tu equipo para casos complejos.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'is_featured' => false,
                'reading_time' => 6,
                'categories' => ['software-a-medida', 'tutoriales'],
            ],
            [
                'title' => 'Guía completa de seguridad para tu página web: SSL, firewalls y más',
                'slug' => 'guia-completa-seguridad-pagina-web',
                'excerpt' => 'Protege tu sitio web de amenazas cibernéticas con estas prácticas esenciales de seguridad.',
                'content' => '<p>La seguridad web es crítica para proteger tu negocio y a tus usuarios. Aquí tienes una guía completa:</p><h2>SSL/TLS</h2><p>Implementa certificados SSL para cifrar la comunicación entre el navegador y el servidor.</p><h2>Firewall de aplicaciones web (WAF)</h2><p>Un WAF protege contra ataques comunes como SQL injection y XSS.</p><h2>Autenticación segura</h2><ul><li>Contraseñas hash con bcrypt</li><li>Autenticación de dos factores</li><li>Limitación de intentos de login</li></ul><h2>Actualizaciones</h2><p>Mantén todos los componentes actualizados: framework, plugins, dependencias.</p><h2>Copias de seguridad</h2><p>Realiza backups regulares y pruébalos periódicamente.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'is_featured' => false,
                'reading_time' => 8,
                'categories' => ['seguridad'],
            ],
            [
                'title' => '7 formas de mejorar la velocidad de tu sitio web y el Core Web Vitals',
                'slug' => 'mejorar-velocidad-sitio-web-core-web-vitals',
                'excerpt' => 'La velocidad afecta el SEO y la experiencia del usuario. Aprende técnicas prácticas.',
                'content' => '<p>Core Web Vitals de Google evalúa tres aspectos críticos:</p><h2>LCP (Largest Contentful Paint)</h2><p>Tiempo hasta que aparece el contenido principal. Optimiza:</p><ul><li>Compresión de imágenes</li><li>Lazy loading</li><li>CDN para archivos estáticos</li></ul><h2>FID (First Input Delay)</h2><p>Interactividad. Reduce con:</p><ul><li>Minimización de JavaScript</li><li>Deferred loading de scripts</li></ul><h2>CLS (Cumulative Layout Shift)</h2><p>Estabilidad visual. Evita:</p><ul><li>Espacios reservados para imágenes</li><li>Carga asíncrona de anuncios</li></ul><h2>Otras optimizaciones</h2><ul><li>Cacheo con Service Workers</li><li>Minificación de CSS/JS</li><li>Eliminación de código no utilizado</li></ul>',
                'is_published' => true,
                'published_at' => now()->subDays(18),
                'is_featured' => false,
                'reading_time' => 5,
                'categories' => ['rendimiento', 'seo'],
            ],
            [
                'title' => 'Introducción a las APIs REST: Todo lo que necesitas saber',
                'slug' => 'introduccion-apis-rest',
                'excerpt' => 'Aprende los fundamentos de las APIs REST y cómo implementarlas correctamente.',
                'content' => '<p>Las APIs REST son el estándar para comunicación entre sistemas. Aquí tienes una guía completa:</p><h2>¿Qué es REST?</h2><p>Representational State Transfer es un estilo arquitectónico para servicios web.</p><h2>Métodos HTTP</h2><ul><li>GET: Obtener recursos</li><li>POST: Crear recursos</li><li>PUT: Actualizar completamente</li><li>PATCH: Actualizar parcialmente</li><li>DELETE: Eliminar recursos</li></ul><h2>Códigos de estado</h2><ul><li>200: OK</li><li>201: Creado</li><li>400: Bad Request</li><li>401: No autorizado</li><li>404: No encontrado</li><li>500: Error del servidor</li></ul><h2>Buenas prácticas</h2><ul><li>Usa sustantivos en las URLs</li><li>Implementa paginación</li><li>Versiona tu API</li><li>Documenta con OpenAPI/Swagger</li></ul>',
                'is_published' => true,
                'published_at' => now()->subDays(20),
                'is_featured' => false,
                'reading_time' => 7,
                'categories' => ['desarrollo-web', 'tutoriales'],
            ],
            [
                'title' => 'TypeScript vs JavaScript: ¿Cuándo usar cada uno?',
                'slug' => 'typescript-vs-javascript',
                'excerpt' => 'Descubre las ventajas de TypeScript y cuándo es mejor opción que JavaScript puro.',
                'content' => '<p>TypeScript ha ganado popularidad rápidamente. Analicemos cuándo usar cada tecnología:</p><h2>Ventajas de TypeScript</h2><ul><li>Tipado estático opcional</li><li>Detección de errores en desarrollo</li><li>Mejor autocompletado en IDEs</li><li>Refactorización más segura</li><li>Interfaces y tipos personalizados</li></ul><h2>Cuándo usar JavaScript puro</h2><ul><li>Prototipos rápidos</li><li>Proyectos pequeños</li><li>Aprendizaje inicial</li></ul><h2>Cuándo usar TypeScript</h2><ul><li>Proyectos grandes</li><li>Equipos de múltiples desarrolladores</li><li>Aplicaciones críticas</li><li>Largo plazo</li></ul><h2>Conclusión</h2><p>TypeScript es una inversión que paga dividendos en mantenibilidad, especialmente en proyectos grandes.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(22),
                'is_featured' => false,
                'reading_time' => 5,
                'categories' => ['desarrollo-web', 'tutoriales'],
            ],
            [
                'title' => 'Cómo crear un blog con Laravel en 2024: Tutorial completo',
                'slug' => 'crear-blog-laravel-2024-tutorial',
                'excerpt' => 'Tutorial paso a paso para construir un blog completo con Laravel desde cero.',
                'content' => '<p>Aprende a construir un blog profesional con Laravel:</p><h2>Requisitos previos</h2><ul><li>PHP 8.2+</li><li>Composer</li><li>Node.js y npm</li><li>Base de datos (MySQL/PostgreSQL)</li></ul><h2>Pasos</h2><ol><li>Instalar Laravel: composer create-project laravel/laravel mi-blog</li><li>Configurar base de datos en .env</li><li>Crear modelos con migraciones</li><li>Implementar controladores CRUD</li><li>Crear rutas y vistas</li><li>Agregar autenticación con Laravel Breeze</li><li>Implementar panel de administración</li></ol><h2>Características del blog</h2><ul><li>CRUD completo de posts</li><li>Categorías y etiquetas</li><li>Editor WYSIWYG</li><li>Subida de imágenes</li><li>SEO integrado</li></ul>',
                'is_published' => true,
                'published_at' => now()->subDays(25),
                'is_featured' => false,
                'reading_time' => 12,
                'categories' => ['desarrollo-web', 'tutoriales', 'software-a-medida'],
            ],
            [
                'title' => 'Tendencias en diseño web para 2024: Lo que está de moda',
                'slug' => 'tendencias-diseno-web-2024',
                'excerpt' => 'Descubre las tendencias de diseño web que dominarán este año.',
                'content' => '<p>El diseño web evoluciona constantemente. Estas son las tendencias de 2024:</p><h2>1. Dark mode</h2><p>El modo oscuro sigue siendo esencial para la experiencia del usuario.</p><h2>2. Tipografía grande</h2><p>Fuentes bold y grandes para impact visual.</p><h2>3. Gradientes sutiles</h2><p>Degradados delicados que añaden profundidad sin ser abrumadores.</p><h2>4. Glassmorphism</h2><p>Efecto de vidrio translúcido en elementos UI.</p><h2>5. Microinteracciones</h2><p>Animaciones pequeñas que mejoran la experiencia.</p><h2>6. Diseño accesible</h2><p>Inclusión como prioridad, no como característica adicional.</p><h2>7. Móvil primero</h2><p>Diseño optimizado primero para dispositivos móviles.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(28),
                'is_featured' => false,
                'reading_time' => 4,
                'categories' => ['ux-ui-design', 'noticias'],
            ],
            [
                'title' => 'Bases de datos PostgreSQL vs MySQL: Comparativa completa',
                'slug' => 'postgresql-vs-mysql-comparativa',
                'excerpt' => '两大数据库系统的深度对比，帮助你做出正确的选择',
                'content' => '<p>选择正确的数据库对你的项目至关重要。让我们比较一下PostgreSQL和MySQL。</p><h2>PostgreSQL优势</h2><ul><li>完全支持ACID</li><li>高级数据类型（JSON、数组、地理空间）</li><li>强大的扩展性</li><li>出色的并发处理</li><li>开源许可证灵活</li></ul><h2>MySQL优势</h2><ul><li>安装简单</li><li>性能稳定</li><li>广泛的支持和文档</li><li>与WordPress完美兼容</li></ul><h2>何时使用PostgreSQL</h2><ul><li>复杂查询</li><li>需要地理空间数据</li><li>高并发应用</li><li>数据完整性关键</li></ul><h2>何时使用MySQL</h2><ul><li>简单CRUD操作</li><li>网站和博客</li><li>快速原型开发</li></ul>',
                'is_published' => true,
                'published_at' => now()->subDays(30),
                'is_featured' => false,
                'reading_time' => 6,
                'categories' => ['desarrollo-web', 'tutoriales'],
            ],
            [
                'title' => 'Cómo optimizar imágenes para web sin perder calidad',
                'slug' => 'optimizar-imagenes-web-sin-perder-calidad',
                'excerpt' => 'Técnicas profesionales para comprimir imágenes y mejorar la velocidad de tu sitio.',
                'content' => '<p>Las imágenes suelen representar el 50-80% del peso de una página. Aprende a optimizarlas:</p><h2>Formatos modernos</h2><ul><li><strong>WebP:</strong> Mejor compresión que JPEG y PNG</li><li><strong>AVIF:</strong> El formato del futuro, mejor compresión</li><li><strong>SVG:</strong> Para gráficos e iconos</li></ul><h2>Herramientas</h2><ul><li>TinyPNG / Squoosh para compresión</li><li>ImageMagick para procesamiento por lotes</li><li>Laravel Spatie Media Library para gestión</li></ul><h2>Técnicas</h2><ol><li>Redimensiona al tamaño necesario</li><li>Elige el formato correcto</li><li>Comprime sin pérdida visible</li><li>Implementa lazy loading</li><li>Usa srcset para imágenes responsive</li></ol><h2>CDN</h2><p>Usa un CDN para servir imágenes desde servidores cercanos al usuario.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(33),
                'is_featured' => false,
                'reading_time' => 5,
                'categories' => ['rendimiento', 'tutoriales'],
            ],
            [
                'title' => 'Introducción a Docker para desarrolladores Laravel',
                'slug' => 'introduccion-docker-laravel',
                'excerpt' => 'Aprende a configurar un entorno de desarrollo Laravel con Docker.',
                'content' => '<p>Docker simplifica el desarrollo y despliegue de aplicaciones Laravel:</p><h2>¿Qué es Docker?</h2><p>Plataforma para desarrollar, enviar y ejecutar aplicaciones en contenedores aislados.</p><h2>Ventajas para Laravel</h2><ul><li>Entornos consistentes</li><li>Aislamiento de dependencias</li><li>Fácil escalabilidad</li><li>Despliegue simple</li></ul><h2>docker-compose.yml básico</h2><p>services: app, mysql con configuración de volúmenes y dependencias.</p><h2>Comandos esenciales</h2><ul><li>docker-compose up -d: Levantar servicios</li><li>docker-compose down: Detener servicios</li><li>docker-compose exec app bash: Acceder al contenedor</li></ul>',
                'is_published' => true,
                'published_at' => now()->subDays(35),
                'is_featured' => false,
                'reading_time' => 8,
                'categories' => ['desarrollo-web', 'tutoriales', 'software-a-medida'],
            ],
            [
                'title' => 'Cómo implementar pagos con Stripe en tu aplicación Laravel',
                'slug' => 'implementar-pagos-stripe-laravel',
                'excerpt' => 'Tutorial completo para integrar pagos con Stripe en aplicaciones Laravel.',
                'content' => '<p>Stripe es la forma más fácil de aceptar pagos en línea. Aprende a integrarlo:</p><h2>Instalación</h2><p>composer require stripe/stripe-php</p><h2>Configuración</h2><p>Agrega tus claves en .env con STRIPE_KEY y STRIPE_SECRET.</p><h2>Crear intención de pago</h2><p>Usa la API de Stripe para crear PaymentIntent con amount y currency.</p><h2>Webhooks</h2><p>Configura webhooks para escuchar eventos de pago: payment_intent.succeeded y payment_intent.payment_failed.</p><h2>Seguridad</h2><p>Usa webhooks para confirmar pagos, nunca confíes solo en el frontend.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(38),
                'is_featured' => false,
                'reading_time' => 10,
                'categories' => ['software-a-medida', 'tutoriales'],
            ],
            [
                'title' => 'Autenticación JWT en APIs Laravel: Guía práctica',
                'slug' => 'autenticacion-jwt-apis-laravel',
                'excerpt' => 'Implementa autenticación segura con JWT (JSON Web Tokens) en tus APIs Laravel.',
                'content' => '<p>JWT es ideal para APIs stateless. Aprende a implementarlo:</p><h2>¿Qué es JWT?</h2><p>JSON Web Token es un estándar para transmitir información de forma segura entre partes.</p><h2>Estructura</h2><ul><li>Header: tipo de token y algoritmo</li><li>Payload: datos del usuario</li><li>Signature: firma para verificar autenticidad</li></ul><h2>Instalación</h2><p>composer require firebase/php-jwt</p><h2>Generar token</h2><p>Usa JWT::encode con el payload y una clave secreta.</p><h2>Middleware de verificación</h2><p>Crea un middleware que valide el token en cada request protegido.</p><h2>Mejores prácticas</h2><ul><li>Usa HTTPS siempre</li><li>Establece expiración corta</li><li>Almacena en HttpOnly cookies</li></ul>',
                'is_published' => true,
                'published_at' => now()->subDays(40),
                'is_featured' => false,
                'reading_time' => 7,
                'categories' => ['seguridad', 'tutoriales'],
            ],
            [
                'title' => 'SEO Local: Cómo posicionar tu negocio en búsquedas de tu zona',
                'slug' => 'seo-local-posicionar-negocio-zona',
                'excerpt' => 'Estrategias de SEO local para atraer clientes de tu área geográfica.',
                'content' => '<p>El SEO local es esencial para negocios que atienden clientes en una zona específica:</p><h2>Google Business Profile</h2><ul><li>Crea y verifica tu perfil</li><li>Agrega fotos de calidad</li><li>Mantén información actualizada</li><li>Responde a reseñas</li></ul><h2>Palabras clave locales</h2><p>Incorpora tu ciudad o barrio: "dentista en Lima", "cafetería en Miraflores"</p><h2>NAP consistente</h2><p>Mantén el mismo Nombre, Dirección y Teléfono en todos los directorios.</p><h2>Schema markup local</h2><p>Implementa datos estructurados de LocalBusiness con tu dirección.</p><h2>Reseñas</h2><p>Solicita reseñas a tus clientes satisfechos.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(42),
                'is_featured' => false,
                'reading_time' => 5,
                'categories' => ['seo'],
            ],
            [
                'title' => 'Gitflow vs trunk-based development: ¿Cuál metodología usar?',
                'slug' => 'gitflow-vs-trunk-based-development',
                'excerpt' => 'Compara las metodologías de gestión de código más populares.',
                'content' => '<p>Elegir la metodología correcta mejora la colaboración del equipo:</p><h2>Gitflow</h2><p>Flujo tradicional con ramas separadas: main, develop, feature, release, hotfix.</p><h2>Trunk-Based Development</h2><p>Desarrollo centrado en la rama principal con commits frecuentes, feature flags y deploy continuo.</p><h2>¿Cuál elegir?</h2><p><strong>Gitflow:</strong> Equipos grandes, releases planificados</p><p><strong>Trunk-Based:</strong> DevOps, CI/CD maduro, equipos ágiles</p><h2>Nuestra recomendación</h2><p>Para equipos pequeños y medianos, trunk-based con feature flags es más eficiente.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(45),
                'is_featured' => false,
                'reading_time' => 6,
                'categories' => ['desarrollo-web', 'software-a-medida'],
            ],
            [
                'title' => 'Next.js vs Laravel: Combinando frontend y backend modernos',
                'slug' => 'nextjs-vs-laravel-combinando-frontend-backend',
                'excerpt' => 'Aprende a usar Next.js como frontend con Laravel como API backend.',
                'content' => '<p>La arquitectura decouplada ofrece máxima flexibilidad:</p><h2>Por qué separar frontend y backend</h2><ul><li>Escalabilidad independiente</li><li>Equipos especializados</li><li>Tecnología optimizada para cada capa</li><li>Mejor experiencia de usuario</li></ul><h2>Laravel como API</h2><p>Usa apiResource routes para exponer endpoints REST.</p><h2>Next.js como frontend</h2><p>Consume la API de Laravel y renderiza en el servidor o cliente.</p><h2>Comunicación</h2><ul><li>REST API tradicional</li><li>GraphQL con Laravel</li><li>Servicios con Laravel Octane</li></ul><h2>Autenticación</h2><p>Usa Sanctum para tokens o JWT para APIs puras.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(48),
                'is_featured' => false,
                'reading_time' => 8,
                'categories' => ['desarrollo-web', 'tutoriales'],
            ],
            [
                'title' => 'Web Performance Optimization: Métricas que importan en 2024',
                'slug' => 'web-performance-optimization-metricas-2024',
                'excerpt' => 'Comprende las métricas de rendimiento web y cómo optimizarlas.',
                'content' => '<p>El rendimiento web es crítico para UX y SEO. Estas son las métricas clave:</p><h2>Core Web Vitals</h2><h3>LCP (Largest Contentful Paint)</h3><p>Tiempo hasta renderizar el contenido principal. Objetivo: menos de 2.5s</p><h3>FID (First Input Delay)</h3><p>Tiempo hasta que la página responde. Objetivo: menos de 100ms</p><h3>CLS (Cumulative Layout Shift)</h3><p>Estabilidad visual. Objetivo: menos de 0.1</p><h2>Otras métricas importantes</h2><ul><li>TTFB: Tiempo hasta primer byte</li><li>FCP: Primer renderizado de contenido</li><li>TTI: Tiempo hasta interactividad</li></ul><h2>Herramientas de medición</h2><ul><li>PageSpeed Insights</li><li>Lighthouse</li><li>WebPageTest</li></ul>',
                'is_published' => true,
                'published_at' => now()->subDays(50),
                'is_featured' => false,
                'reading_time' => 6,
                'categories' => ['rendimiento', 'seo'],
            ],
            [
                'title' => 'Cómo proteger tu aplicación Laravel de ataques comunes',
                'slug' => 'proteger-aplicacion-laravel-ataques-comunes',
                'excerpt' => 'Guía de seguridad para mantener tu aplicación Laravel a salvo.',
                'content' => '<p>La seguridad es crítica. Estos son los ataques más comunes y cómo prevenirlos:</p><h2>SQL Injection</h2><p>Siempre usa Eloquent o query builder con binding de parámetros.</p><h2>XSS (Cross-Site Scripting)</h2><p>Escapa la salida en vistas: usa double braces {{ $variable }}</p><h2>CSRF (Cross-Site Request Forgery)</h2><p>Laravel incluye protección CSRF automáticamente con @csrf</p><h2>Mass Assignment</h2><p>Usa $fillable o $guarded en modelos para proteger campos.</p><h2>File uploads</h2><ul><li>Valida el tipo MIME real</li><li>Almacena fuera del webroot</li><li>Genera nombres únicos</li></ul><h2>Rate limiting</h2><p>Usa el middleware throttle de Laravel para limitar requests.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(52),
                'is_featured' => false,
                'reading_time' => 7,
                'categories' => ['seguridad', 'tutoriales'],
            ],
            [
                'title' => 'Vue.js 3 Composition API: Guía completa para principiantes',
                'slug' => 'vuejs-3-composition-api-guia-completa',
                'excerpt' => 'Aprende a usar la nueva Composition API de Vue 3 con ejemplos prácticos.',
                'content' => '<p>Vue 3 introdujo la Composition API, revolucionando cómo escribimos componentes:</p><h2>Options API vs Composition API</h2><p>Options API usa data, methods, mounted. Composition API usa ref, reactive, onMounted.</p><h2>Ventajas de Composition API</h2><ul><li>Mejor reutilización de lógica</li><li>Código más organizado</li><li>TypeScript nativo</li><li>Facilita el testing</li></ul><h2>Hooks principales</h2><ul><li>ref(): Valores primitivos reactivos</li><li>reactive(): Objetos reactivos</li><li>computed(): Propiedades calculadas</li><li>watch(): Efectos secundarios</li><li>onMounted(): Ciclo de vida</li></ul><h2>Composable</h2><p>Lógica reutilizable extraída a funciones como useCounter().</p>',
                'is_published' => true,
                'published_at' => now()->subDays(55),
                'is_featured' => false,
                'reading_time' => 8,
                'categories' => ['desarrollo-web', 'tutoriales'],
            ],
        ];

        // Crear posts
        foreach ($posts as $index => $postData) {
            $categories = $postData['categories'];
            unset($postData['categories']);

            $post = BlogPost::create([
                'title' => $postData['title'],
                'slug' => $postData['slug'],
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'is_published' => $postData['is_published'],
                'published_at' => $postData['published_at'],
                'is_featured' => $postData['is_featured'],
                'reading_time' => $postData['reading_time'],
                'author_id' => 1,
                'view_count' => rand(10, 500),
            ]);

            // Asignar categorías
            $categoryIdsArray = [];
            foreach ($categories as $catSlug) {
                if (isset($categoryIds[$catSlug])) {
                    $categoryIdsArray[] = $categoryIds[$catSlug];
                }
            }
            $post->categories()->attach($categoryIdsArray);
        }

        $this->command->info('BlogSeeder: ' . count($posts) . ' posts y ' . count($categories) . ' categorías creadas exitosamente.');
    }
}
