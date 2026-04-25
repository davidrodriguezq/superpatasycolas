# ROADMAP — Sistema Web Super Patas y Colas

> Plan técnico detallado. Fases, sprints, tareas por módulo, dependencias y criterios de completitud.

---

## Resumen de progreso

| Fase | Nombre | Estado |
|---|---|---|
| Fase 1 | Fundamentos: autenticación, usuarios, animales | ✅ Completada |
| Fase 2 | Adopción, cesión y seguimiento post-adopción | ✅ Completada |
| Fase 3 | Portal público, blog, responsive, SEO | 🔄 En progreso |
| Fase 4 | Dashboard, reportes, calidad, despliegue final | ⬜ Pendiente |

---

## Fase 1 — Fundamentos

### F1-T01 — Configuración del proyecto Laravel ✅ Completada
### F1-T02 — Migraciones de base de datos ✅ Completada
### F1-T03 — Seeders de datos iniciales ✅ Completada
### F1-T04 — Autenticación (login, registro, logout) ✅ Completada
### F1-T05 — Gestión de usuarios (admin) ✅ Completada
### F1-T06 — Perfil de usuario ✅ Completada
### F1-T07 — Layout administrativo ✅ Completada
### F1-T08 — Layout público ✅ Completada
### F1-T09 — CRUD de animales (admin) ✅ Completada
### F1-T10 — Subida de fotografías de animales ✅ Completada
### F1-T11 — Estados y enums de animales ✅ Completada
### F1-T12 — Historial clínico ✅ Completada
### F1-T13 — Filtros y búsqueda de animales (admin) ✅ Completada
### F1-T14 — Dashboard administrativo básico ✅ Completada

---

## Fase 2 — Adopción, cesión y seguimiento

### F2-T01 — Catálogo público de mascotas ✅ Completada
### F2-T02 — Formulario de solicitud de adopción ✅ Completada
### F2-T03 — Gestión de solicitudes de adopción (admin) ✅ Completada
### F2-T04 — Aprobación/rechazo de solicitudes ✅ Completada
### F2-T05 — Cambio de estado del animal al aprobar adopción ✅ Completada
### F2-T06 — Vista de solicitudes del adoptante ✅ Completada
### F2-T07 — Formulario de cesión de animal ✅ Completada
### F2-T08 — Gestión de cesiones (admin) ✅ Completada
### F2-T09 — Ingreso de animal cedido al albergue ✅ Completada
### F2-T10 — Módulo de seguimiento post-adopción ✅ Completada
### F2-T11 — Registro de visita de seguimiento ✅ Completada
### F2-T12 — Listado y filtros de seguimientos ✅ Completada
### F2-T13 — Alertas por condición crítica ✅ Completada
### F2-T14 — Fotos de seguimiento ✅ Completada

---

## Fase 3 — Portal público, blog, responsive, SEO

### F3-T01 — Página de inicio (home) ✅ Completada
### F3-T02 — Catálogo público con filtros ✅ Completada
### F3-T03 — Detalle de mascota pública ✅ Completada
### F3-T04 — Página "Sobre nosotros" ✅ Completada
### F3-T05 — Página de contacto ✅ Completada
### F3-T06 — Blog/noticias (CRUD público + admin) ✅ Completada

**Criterios completados:**
- Controlador público BlogController (index, show)
- Controlador admin BlogPostController (CRUD completo)
- Form Request de validación StoreBlogPostRequest
- Rutas públicas /blog y /blog/{slug}
- Ruta admin Route::resource('blog-posts')
- Vistas públicas: blog/index y blog/show
- Vistas admin: blog-posts/index, create, edit
- Navegación actualizada en ambos layouts
- Enlace "Leer más" del home conectado al blog

### F3-T07 — Optimización responsive (360 px mínimo) ✅ Completada

**Criterios completados:**
- Footer: corrección de overflow de email largo (overflow-wrap: break-word)
- Home: botones hero y CTA apilados en columna en móvil (flex-column flex-sm-row)
- Catálogo: grid de 2 columnas en móvil (col-6)
- Contacto: formulario aparece primero en móvil (order-1 order-md-2)
- Blog: 1 columna en móvil (col-12)
- CSS sincronizado en resources/css/app.css y public/css/app.css

### F3-T08 — SEO básico ✅ Completada

**Criterios completados:**
- Todas las vistas públicas con @section('title') descriptivo
- Todas las vistas públicas con @section('meta-description') específico
- Layout público renderiza meta description con valor por defecto
- Open Graph tags en layout público (og:title, og:description, og:type, og:locale, og:site_name)
- og:image en detalle de mascota y detalle de blog post

---

## Fase 4 — Dashboard, reportes y calidad

### F4-T01 — Dashboard con métricas e indicadores ⬜ Pendiente
### F4-T02 — Gráficas con Chart.js ⬜ Pendiente
### F4-T03 — Pruebas unitarias — módulos core ⬜ Pendiente
### F4-T04 — Pruebas de integración — flujos principales ⬜ Pendiente
### F4-T05 — Revisión y corrección de bugs finales ⬜ Pendiente
### F4-T06 — Despliegue final en Azure y verificación ⬜ Pendiente

---

*Última actualización: 2026-04-25*
