# 🔄 FUNCIONES AJAX EN EL SISTEMA DE GESTIÓN DE CURSOS

## 📋 **RESUMEN EJECUTIVO**

El sistema utiliza **AJAX (Asynchronous JavaScript and XML)** para mejorar la experiencia del usuario mediante:
- **Carga dinámica de datos** sin recargar páginas
- **Filtrado en tiempo real** de información
- **Búsquedas interactivas** con resultados instantáneos
- **Validaciones en tiempo real** de formularios

---

## 🎯 **FUNCIÓN AJAX PRINCIPAL - CARGAR ALUMNOS POR CURSO**

### **📍 Ubicación**
- **Archivo**: `resources/views/evaluaciones/create.blade.php`
- **Líneas**: 320-350
- **Ruta**: `/evaluaciones/alumnos-by-curso`

### **🔧 Funcionalidad**
```javascript
fetch(`/evaluaciones/alumnos-by-curso?curso_id=${this.value}`, {
    method: 'GET',
    credentials: 'same-origin',
    headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': token
    }
})
```

### **📝 Propósito**
1. **Carga Dinámica**: Cuando un usuario selecciona un curso en el formulario de crear evaluación
2. **Filtrado Inteligente**: Solo muestra alumnos que están inscritos activamente en ese curso
3. **UX Mejorada**: Evita recargar la página completa
4. **Validación**: Asegura que solo se evalúen alumnos realmente inscritos

### **🔄 Flujo de Funcionamiento**
1. Usuario selecciona un curso del dropdown
2. JavaScript detecta el cambio y ejecuta la petición AJAX
3. Backend filtra alumnos inscritos en ese curso específico
4. Frontend recibe la respuesta JSON y actualiza el dropdown de alumnos
5. Se muestran solo los alumnos relevantes para ese curso

### **🎛️ Controlador Backend**
```php
// EvaluacionController.php - Línea 209
public function getAlumnosByCurso(Request $request)
{
    $request->validate([
        'curso_id' => 'required|exists:cursos,id'
    ]);

    $alumnos = Alumno::whereHas('inscripciones', function($query) use ($request) {
        $query->where('curso_id', $request->curso_id)
              ->where('estado', 'activo');
    })
    ->orderBy('apellido')
    ->orderBy('nombre')
    ->get();

    return response()->json($alumnos);
}
```

---

## 🔍 **FUNCIONES DE FILTRADO (NO AJAX - Navegación)**

### **📊 Filtrado de Evaluaciones**

#### **1. Filtrar por Estado de Curso**
- **Ruta**: `/evaluaciones/filtrar/curso`
- **Método**: `EvaluacionController::filtrarPorCurso()`
- **Propósito**: Mostrar evaluaciones de cursos activos o finalizados
- **Parámetros**: `filtro` (activos/finalizados)

#### **2. Filtrar por Alumno**
- **Ruta**: `/evaluaciones/filtrar/alumno`
- **Método**: `EvaluacionController::filtrarPorAlumno()`
- **Propósito**: Mostrar todas las evaluaciones de un alumno específico
- **Parámetros**: `alumno_id`

### **👥 Filtrado de Alumnos**
- **Ruta**: `/alumnos/filtrar/estado`
- **Método**: `AlumnoController::filtrarPorEstado()`
- **Propósito**: Mostrar alumnos activos o inactivos

### **👨‍🏫 Filtrado de Docentes**
- **Ruta**: `/docentes/filtrar/estado`
- **Método**: `DocenteController::filtrarPorEstado()`
- **Propósito**: Mostrar docentes activos o inactivos

### **📚 Filtrado de Cursos**
- **Ruta**: `/cursos/filtrar/estado`
- **Método**: `CursoController::filtrarPorEstado()`
- **Propósito**: Mostrar cursos activos, finalizados o cancelados

### **📝 Filtrado de Inscripciones**
- **Ruta**: `/inscripciones/filtrar/estado`
- **Método**: `InscripcionController::filtrarPorEstado()`
- **Propósito**: Mostrar inscripciones por estado (activo, aprobado, desaprobado)

### **📁 Filtrado de Archivos**
- **Ruta**: `/archivos/filtrar/tipo`
- **Método**: `ArchivoAdjuntoController::filtrarPorTipo()`
- **Propósito**: Mostrar archivos por tipo (tarea, material, guía)

- **Ruta**: `/archivos/filtrar/curso`
- **Método**: `ArchivoAdjuntoController::filtrarPorCurso()`
- **Propósito**: Mostrar archivos de un curso específico

---

## 🔎 **FUNCIONES DE BÚSQUEDA (NO AJAX - Navegación)**

### **📋 Búsquedas Implementadas**

#### **1. Búsqueda de Alumnos**
- **Ruta**: `/alumnos/search`
- **Método**: `AlumnoController::search()`
- **Campos**: nombre, apellido, DNI, email

#### **2. Búsqueda de Docentes**
- **Ruta**: `/docentes/search`
- **Método**: `DocenteController::search()`
- **Campos**: nombre, apellido, email, especialidad

#### **3. Búsqueda de Cursos**
- **Ruta**: `/cursos/search`
- **Método**: `CursoController::search()`
- **Campos**: título, descripción, docente

#### **4. Búsqueda de Inscripciones**
- **Ruta**: `/inscripciones/search`
- **Método**: `InscripcionController::search()`
- **Campos**: alumno, curso, estado

#### **5. Búsqueda de Evaluaciones**
- **Ruta**: `/evaluaciones/search`
- **Método**: `EvaluacionController::search()`
- **Campos**: descripción, alumno, curso

#### **6. Búsqueda de Archivos**
- **Ruta**: `/archivos/search`
- **Método**: `ArchivoAdjuntoController::search()`
- **Campos**: título, descripción, tipo

---

## ⚠️ **CONFIRMACIONES (NO AJAX - JavaScript Nativo)**

### **🗑️ Confirmaciones de Eliminación**

#### **1. Eliminación de Archivos**
```javascript
// archivos/show.blade.php - Línea 185
onclick="return confirm('¿Estás seguro de que quieres eliminar este archivo?')"
```

#### **2. Activación/Desactivación de Docentes**
```javascript
// docentes/index.blade.php - Línea 175
onclick="return confirm('¿Estás seguro de {{ $docente->activo ? 'desactivar' : 'activar' }} este docente?')"

// docentes/show.blade.php - Línea 184
onclick="return confirm('¿Estás seguro de desactivar este docente?')"
```

#### **3. Eliminación de Docentes**
```javascript
// docentes/index.blade.php - Línea 189
onclick="return confirm('¿Estás seguro de eliminar este docente? Esta acción no se puede deshacer.')"
```

---

## 🔧 **CONFIGURACIÓN TÉCNICA**

### **🛡️ Seguridad AJAX**
- **CSRF Protection**: Token incluido en headers
- **Session Validation**: Credenciales same-origin
- **Input Validation**: Validación en backend
- **Error Handling**: Manejo de errores en frontend

### **📡 Headers Utilizados**
```javascript
headers: {
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': token
}
```

### **🎯 Rutas Específicas**
```php
// Rutas AJAX específicas ANTES de las rutas resource
Route::get('/evaluaciones/alumnos-by-curso', [EvaluacionController::class, 'getAlumnosByCurso'])
    ->name('evaluaciones.alumnos-by-curso');
Route::get('/evaluaciones/filtrar/curso', [EvaluacionController::class, 'filtrarPorCurso'])
    ->name('evaluaciones.filtrar-curso');
Route::get('/evaluaciones/filtrar/alumno', [EvaluacionController::class, 'filtrarPorAlumno'])
    ->name('evaluaciones.filtrar-alumno');
```

---

## 📊 **ESTADÍSTICAS DE USO**

### **🎯 Funciones AJAX Activas**
- **AJAX Real**: 1 función (cargar alumnos por curso)
- **Filtros**: 8 funciones (navegación)
- **Búsquedas**: 6 funciones (navegación)
- **Confirmaciones**: 4 funciones (JavaScript nativo)

### **🔄 Tipos de Interacción**
- **Carga Dinámica**: 1 función
- **Filtrado**: 8 funciones
- **Búsqueda**: 6 funciones
- **Confirmación**: 4 funciones

---

## 🎯 **CONCLUSIONES**

### **✅ Ventajas del Sistema AJAX**
1. **UX Mejorada**: Carga dinámica sin recargas de página
2. **Eficiencia**: Solo carga datos necesarios
3. **Interactividad**: Respuesta inmediata del usuario
4. **Validación**: Asegura integridad de datos

### **🔧 Funcionalidad Principal**
La función AJAX más importante es **"Cargar Alumnos por Curso"** que:
- Mejora significativamente la experiencia en creación de evaluaciones
- Evita errores de selección de alumnos
- Optimiza el flujo de trabajo para coordinadores y docentes
- Mantiene la consistencia de datos

### **📈 Impacto en el Sistema**
- **Reducción de errores**: Validación en tiempo real
- **Mejor rendimiento**: Menos carga del servidor
- **Interfaz intuitiva**: Flujo natural de trabajo
- **Datos consistentes**: Solo muestra opciones válidas 