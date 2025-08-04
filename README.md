# 🎓 Sistema de Gestión de Cursos

Un sistema completo de gestión académica desarrollado con **Laravel 12** y **PHP 8.4**, diseñado para administrar cursos, docentes, alumnos, inscripciones y evaluaciones.

## 🚀 Características Principales

### 👥 Gestión de Usuarios
- **Sistema de roles:** Administrador, Coordinador, Docente
- **Autenticación segura** con middleware personalizado
- **Control de acceso** basado en permisos

### 📚 Gestión Académica
- **Cursos:** Creación, edición, estados (activo/finalizado/cancelado)
- **Inscripciones:** Gestión de alumnos por curso
- **Evaluaciones:** Sistema de calificaciones
- **Asistencias:** Control de asistencia con validaciones
- **Archivos:** Subida y gestión de materiales

### 🎯 Funcionalidades Avanzadas
- **Validaciones de negocio:** Máximo 3 cursos por docente, 75% asistencia mínima
- **AJAX dinámico:** Carga de alumnos por curso
- **Filtros y búsquedas:** Avanzadas con paginación
- **Reportes:** Estadísticas y métricas

## 🛠️ Tecnologías Utilizadas

- **Backend:** Laravel 12, PHP 8.4
- **Base de Datos:** MySQL
- **Frontend:** Bootstrap 5, JavaScript, AJAX
- **Autenticación:** Laravel Auth
- **Validación:** Form Requests personalizados
- **ORM:** Eloquent con relaciones complejas

## 📋 Requisitos del Sistema

- PHP >= 8.4
- Composer
- MySQL >= 8.0
- Node.js (para compilación de assets)

## ⚙️ Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/lucianoba77/sistema-gestion-cursos.git
cd sistema-gestion-cursos
```

### 2. Instalar dependencias
```bash
composer install
npm install
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar base de datos
Editar `.env` con tus credenciales:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_cursos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 5. Ejecutar migraciones y seeders
```bash
php artisan migrate
php artisan db:seed
```

### 6. Compilar assets
```bash
npm run build
```

### 7. Iniciar servidor
```bash
php artisan serve
```

## 👤 Usuarios de Prueba

### Administrador
- **Email:** admin@gmail.com
- **Contraseña:** password

### Coordinador
- **Email:** coordinador1@gmail.com
- **Contraseña:** password

### Docente
- **Email:** juan.perez@gmail.com
- **Contraseña:** password

## 🏗️ Arquitectura del Proyecto

### Estructura MVC
```
app/
├── Http/
│   ├── Controllers/     # Controladores con lógica de negocio
│   ├── Requests/        # Validaciones personalizadas
│   └── Middleware/      # Middleware de autenticación y roles
├── Models/              # Modelos Eloquent con relaciones
└── Providers/           # Proveedores de servicios
```

### Base de Datos
- **6 tablas principales:** users, docentes, alumnos, cursos, inscripciones, evaluaciones
- **Relaciones complejas:** Many-to-Many, One-to-Many
- **Índices optimizados** para consultas frecuentes

### Rutas Organizadas
```php
// Rutas por rol
Route::prefix('admin')->name('admin.')->middleware(['role.admin'])->group(function () {
    // Rutas de administrador
});

Route::prefix('coordinador')->name('coordinador.')->middleware(['role.coordinador'])->group(function () {
    // Rutas de coordinador
});

Route::prefix('docente')->name('docente.')->middleware(['role.docente'])->group(function () {
    // Rutas de docente
});
```

## 🔧 Configuración Avanzada

### Variables de Entorno Personalizables
```env
# Configuraciones de negocio
TOTAL_CLASES_CURSO=20
PORCENTAJE_ASISTENCIA_MINIMO=75
MAX_CURSOS_POR_DOCENTE=3
MAX_INSCRIPCIONES_POR_ALUMNO=5
```

### Middleware Personalizado
- **RoleMiddleware:** Control de acceso por roles
- **DocenteMiddleware:** Validaciones específicas para docentes

## 🎨 Características de UX/UI

- **Diseño responsivo** con Bootstrap 5
- **Interfaz intuitiva** con navegación por roles
- **Feedback visual** con alertas y notificaciones
- **Modales interactivos** para confirmaciones
- **Filtros dinámicos** con AJAX

## 🔒 Seguridad

- **CSRF Protection** en todos los formularios
- **Validación server-side** con Form Requests
- **Sanitización de datos** automática
- **Control de acceso** granular por roles
- **Protección contra SQL Injection** con Eloquent

## 📊 Funcionalidades Destacadas

### Sistema de Evaluaciones
- Carga masiva de evaluaciones por curso
- Cálculo automático de promedios
- Validación de notas (1-10)

### Gestión de Archivos
- Subida de archivos con validación de tipos
- Organización por curso y tipo
- Control de permisos por rol

### Reportes y Estadísticas
- Dashboard con métricas en tiempo real
- Filtros por estado y fecha
- Exportación de datos

## 🚀 Despliegue

### Producción
1. Configurar variables de entorno de producción
2. Optimizar con `php artisan config:cache`
3. Configurar servidor web (Apache/Nginx)
4. Configurar SSL para HTTPS

### Docker (Opcional)
```dockerfile
FROM php:8.4-fpm
# Configuración de Docker...
```

## 🤝 Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 👨‍💻 Autor

**Julio Luciano Barrenechea**
- GitHub: [@lucianoba77](https://github.com/lucianoba77)
- LinkedIn: [Julio Luciano Barrenechea](https://www.linkedin.com/in/juliolbarrenechea/)

## 🙏 Agradecimientos

- Laravel Framework
- Bootstrap Team
- Comunidad de desarrolladores PHP

---

⭐ **Si te gusta este proyecto, dale una estrella en GitHub!**

