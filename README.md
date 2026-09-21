# Sistema web para la gestión de animales y procesos de adopción de un albergue


![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-MVC-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Azure](https://img.shields.io/badge/Azure-App%20Service-0078D4?logo=microsoftazure&logoColor=white)

---

## Acerca del proyecto

Este repositorio contiene una aplicación web desarrollada para reemplazar el manejo disperso de la información del albergue por una plataforma única que permite:

- Registrar y administrar los animales rescatados, con fotografías e historial clínico.
- Gestionar solicitudes de adopción mediante un flujo de aprobación con notificaciones por correo.
- Realizar el seguimiento post-adopción, con alertas cuando se detectan condiciones críticas.
- Mostrar un catálogo público de mascotas disponibles que incrementa la visibilidad del albergue.

## Funcionalidades

**Portal público**
- Página de inicio con animales destacados y estadísticas del albergue.
- Catálogo con filtros por especie, sexo y búsqueda por nombre o raza.
- Ficha de detalle con galería de fotografías y acceso directo a la solicitud de adopción.
- Sección "Sobre nosotros", formulario de contacto, blog de noticias y política de privacidad.
- Diseño responsivo, verificado desde 360 px de ancho.

**Panel administrativo**
- Gestión de usuarios y roles (administrador y colaborador).
- CRUD de animales con múltiples fotografías, historial clínico y transiciones de estado validadas.
- Gestión de solicitudes de adopción con código de seguimiento (`SPC-YYYYMMDD-XXXX`), aprobación o rechazo y actualización automática del estado del animal.
- Seguimiento post-adopción con evidencia fotográfica y alertas por estado crítico.
- Dashboard con indicadores operativos y gráficas (Chart.js).
- Reportes en PDF: ficha médica, estadísticas del albergue y listado de animales.
- Editor del blog institucional.

**Seguridad y cuentas**
- Autenticación con verificación de correo electrónico.
- Control de acceso por roles (Spatie Laravel Permission).
- Consentimiento de tratamiento de datos personales conforme a la Ley N.° 29733.

> El módulo de cesión de animales fue desarrollado, pero se encuentra desactivado. El código se conserva y únicamente se restringió su acceso.

## Tecnologías

| Capa | Tecnologías |
|---|---|
| Frontend | Blade, Bootstrap 5, JavaScript Vanilla, Chart.js |
| Backend | PHP 8.3, Laravel, Eloquent ORM, Laravel Breeze |
| Base de datos | MySQL 8.4 |
| Correo | Azure Communication Services |
| Reportes | barryvdh/laravel-dompdf |
| Despliegue | Azure App Service y Azure Database for MySQL, con CI/CD en GitHub Actions |
| Pruebas | PHPUnit |

## Arquitectura

El proyecto sigue el patrón MVC de Laravel. Las validaciones se realizan en Form Requests, los estados de las entidades se modelan con PHP Enums y las rutas administrativas se agrupan bajo el prefijo `/admin` con control por rol.

```
app/
├── Enums/              # Estados del dominio
├── Http/
│   ├── Controllers/    # Admin, Public y Auth
│   └── Requests/       # Validaciones
├── Mail/               # Correos transaccionales
└── Models/             # Modelos Eloquent
resources/views/        # admin, public, layouts, emails
routes/                 # web.php y admin.php
```

## Instalación local

**Requisitos:** PHP 8.3, Composer y MySQL 8.x. En Windows se recomienda [Laragon](https://laragon.org/).

```bash
git clone https://github.com/<usuario>/superpatasycolas.git
cd superpatasycolas

composer install
cp .env.example .env
php artisan key:generate

# Crear la base de datos "superpatasycolas" (utf8mb4) y configurar DB_* en .env

php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Para evitar el envío real de correos en desarrollo, se recomienda `MAIL_MAILER=log`. Los mensajes, incluido el enlace de verificación de cuenta, se escriben en `storage/logs/laravel.log`.

Los seeders crean usuarios de prueba (administrador, colaboradores y adoptantes), 10 animales y datos de ejemplo. Las credenciales se encuentran en `database/seeders/UserSeeder.php` y solo deben usarse en desarrollo.

## Pruebas

```bash
php artisan test
```

## Despliegue

El proyecto se despliega automáticamente en Azure App Service mediante GitHub Actions al hacer push a la rama `main`. La base de datos opera en Azure Database for MySQL Flexible Server con conexión SSL, y las variables de entorno de producción se configuran en el portal de Azure.

## Estado del proyecto

Los módulos funcionales se encuentran completos. Quedan pendientes la ampliación de pruebas automatizadas, la carga de datos reales del albergue en producción y la documentación de usuario.

## Contexto académico

Este proyecto fue desarrollado como trabajo del curso Capstone Project Sistemas (INVE1535), de la carrera de Ingeniería de Sistemas Computacionales de la Universidad Privada del Norte (UPN), período 2026-1, y responde a una necesidad real del albergue.

<!-- Opcional: descomentar si se desea declarar el uso de IA.
El desarrollo contó con el apoyo de herramientas de inteligencia artificial (Claude Code), cuyo uso quedó registrado en la bitácora del proyecto (`WORKLOG.md`).
-->

## Autor

**David Alejandro Rodríguez Quiroga**
[LinkedIn](https://www.linkedin.com/in/david-alejandro-rodriguez-quiroga) · [GitHub](https://github.com/davidrodriguezq)

## Licencia

Distribuido bajo la licencia MIT. Consulte el archivo [LICENSE](./LICENSE.md) para más información.
