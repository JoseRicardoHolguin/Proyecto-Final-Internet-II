# DOCUMENTACIÓN DEL PROYECTO
## Sistema de Gestión de Hábitos

**Materia:** Programación para Internet II    
**Estudiante:** Jose Ricardo Holguin  
**Fecha:** Mayo 16, 2026  
**Versión:** 1.0

---

## 1. DESCRIPCIÓN DEL PROYECTO

### 1.1 Objetivo General
Desarrollar una aplicación web completa que permita a los usuarios registrar, seguir y gestionar sus hábitos diarios mediante una interfaz intuitiva, incluyendo funcionalidades de seguimiento, estadísticas y control de acceso basado en roles.

### 1.2 Objetivos Específicos
- Implementar un sistema de autenticación seguro con Laravel Breeze
- Crear un CRUD completo para gestionar hábitos, días y registros
- Desarrollar una API REST funcional con 10+ endpoints
- Implementar control de acceso mediante roles (Admin y Usuario)
- Proporcionar una interfaz web responsiva y fácil de usar
- Poblar la base de datos con seeders de prueba

### 1.3 Justificación
Este proyecto demuestra los conocimientos adquiridos en:
- Desarrollo full-stack con Laravel
- Autenticación y autorización
- Diseño de bases de datos relacionales
- Desarrollo de APIs REST
- Implementación de patrones de diseño (MVC, RESTful)

### 1.4 Alcance
**Incluye:**
- ✅ Sistema de autenticación con Breeze
- ✅ CRUD de hábitos, días y logs
- ✅ API REST con 10 endpoints
- ✅ Dashboard interactivo
- ✅ Control por roles

**No incluye:**
- ❌ Notificaciones por email
- ❌ Gráficos estadísticos avanzados
- ❌ Aplicación móvil
- ❌ Integración con redes sociales

---

## 2. MODELO DE DATOS

### 2.1 Diagrama Entidad-Relación (ER)

#### Diagrama ER - Parte 1
![Diagrama ER 1](./pictures/EER1.png)

#### Diagrama ER - Parte 2
![Diagrama ER 2](./pictures/EER2.png)

### 2.2 Descripción de Tablas

#### 2.2.1 Tabla `users`
```
Propósito: Almacenar información de usuarios registrados

Campos:
- id (INT, PK) - Identificador único
- name (VARCHAR 255) - Nombre del usuario
- email (VARCHAR 255, UNIQUE) - Email único
- password (VARCHAR 255) - Contraseña hasheada
- role (ENUM: 'admin', 'usuario') - Rol del usuario
- created_at (TIMESTAMP) - Fecha de creación
- updated_at (TIMESTAMP) - Fecha de actualización

Índices:
- PRIMARY KEY (id)
- UNIQUE KEY (email)
```

#### 2.2.2 Tabla `habits`
```
Propósito: Almacenar hábitos creados por usuarios

Campos:
- id (INT, PK) - Identificador único
- user_id (INT, FK) - ID del usuario propietario
- title (VARCHAR 255) - Nombre del hábito
- description (TEXT, nullable) - Descripción detallada
- is_active (BOOLEAN, DEFAULT: true) - Estado del hábito
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

Relaciones:
- Pertenece a: User (belongsTo)
- Tiene muchos: HabitDay (hasMany)
- Tiene muchos: HabitLog (hasMany)

Índices:
- PRIMARY KEY (id)
- FOREIGN KEY (user_id) REFERENCES users(id)
```

#### 2.2.3 Tabla `habit_days`
```
Propósito: Definir en qué días de la semana se aplica cada hábito

Campos:
- id (INT, PK) - Identificador único
- habit_id (INT, FK) - ID del hábito
- day_of_week (INT, 1-7) - Día de la semana (1=Lunes, 7=Domingo)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

Relaciones:
- Pertenece a: Habit (belongsTo)

Restricciones:
- UNIQUE (habit_id, day_of_week) - No puede repetirse el mismo día para un hábito

Índices:
- PRIMARY KEY (id)
- FOREIGN KEY (habit_id) REFERENCES habits(id)
- UNIQUE KEY (habit_id, day_of_week)
```

#### 2.2.4 Tabla `habit_logs`
```
Propósito: Registrar el progreso diario de cumplimiento de hábitos

Campos:
- id (INT, PK) - Identificador único
- habit_id (INT, FK) - ID del hábito
- user_id (INT, FK) - ID del usuario que realiza el registro
- log_date (DATE) - Fecha del registro
- completed_at (TIMESTAMP, nullable) - Fecha/hora de completación
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

Relaciones:
- Pertenece a: Habit (belongsTo)
- Pertenece a: User (belongsTo)

Restricciones:
- UNIQUE (habit_id, user_id, log_date) - Un único registro por fecha

Índices:
- PRIMARY KEY (id)
- FOREIGN KEY (habit_id) REFERENCES habits(id)
- FOREIGN KEY (user_id) REFERENCES users(id)
- UNIQUE KEY (habit_id, user_id, log_date)
```

### 2.3 Relaciones Entre Tablas

```
Users (1) ──→ (N) Habits
      └──→ (N) HabitLogs

Habits (1) ──→ (N) HabitDays
       └──→ (N) HabitLogs
```

---

## 3. IMPLEMENTACIÓN DEL CRUD

### 3.1 CREATE (Crear)

#### 3.1.1 Crear Hábito
**Ruta Web:** `POST /habits`  
**Controlador:** `HabitController@store`

**Formulario:**
```
Título: [campo requerido, max 255 caracteres]
Descripción: [opcional, textarea]
Activo: [checkbox, default: true]
```

**Validaciones:**
- Title: required, string, max:255
- Description: nullable, string
- is_active: boolean

**Proceso:**
1. Usuario ingresa datos del formulario
2. Sistema valida los datos
3. Se crea el registro con user_id del usuario autenticado
4. Se redirecciona al formulario de hábito para agregar días

#### 3.1.2 Crear Día de Hábito
**Ruta Web:** `POST /habits/{habit}/days`  
**Controlador:** `HabitDayController@store`

**Formulario:**
```
Día de la semana: [select dropdown]
  - Lunes (1)
  - Martes (2)
  - ... Domingo (7)
```

**Validaciones:**
- day_of_week: required, integer, min:1, max:7
- unique: (habit_id, day_of_week)

#### 3.1.3 Crear Log (Registro)
**Ruta Web:** `POST /habits/{habit}/logs`  
**Controlador:** `HabitLogController@store`

**Formulario:**
```
Fecha: [date input]
Completado: [checkbox]
```

**Validaciones:**
- log_date: required, date, format:Y-m-d
- completed: required, boolean
- unique: (habit_id, user_id, log_date)

### 3.2 READ (Leer)

#### 3.2.1 Listar Hábitos
**Ruta Web:** `GET /habits`  
**Controlador:** `HabitController@index`

**Funcionalidad:**
- Muestra tabla con todos los hábitos del usuario
- Paginación de 10 registros
- Muestra: Título, descripción, estado, cantidad de días, cantidad de logs
- Admin ve todos; Usuario normal solo sus propios

**Campos mostrados:**
| Campo | Tipo | Descripción |
|-------|------|-------------|
| Título | Text | Nombre del hábito |
| Descripción | Text | Resumen (max 40 caracteres) |
| Días | Badge | Contador de días asociados |
| Logs | Badge | Contador de registros |
| Estado | Badge | Activo/Inactivo |

#### 3.2.2 Ver Detalles de Hábito
**Ruta Web:** `GET /habits/{habit}/edit`  
**Controlador:** `HabitController@edit`

Muestra:
- Información completa del hábito
- Formulario para editar
- Accesos rápidos a días y logs

#### 3.2.3 Listar Días de Hábito
**Ruta Web:** `GET /habits/{habit}/days`  
**Controlador:** `HabitDayController@index`

Muestra:
- Tabla con días configurados
- Opción para eliminar cada día
- Formulario para agregar nuevo día

#### 3.2.4 Listar Logs
**Ruta Web:** `GET /habits/{habit}/logs`  
**Controlador:** `HabitLogController@index`

Muestra:
- Tabla paginada (10 por página)
- Columnas: ID, Fecha, Día de semana, Estado, Hora completado, Acciones
- Estado visual con badges (verde=completado, amarillo=pendiente)

### 3.3 UPDATE (Actualizar)

#### 3.3.1 Actualizar Hábito
**Ruta Web:** `PUT /habits/{habit}`  
**Controlador:** `HabitController@update`

Campos editables:
- Título
- Descripción
- Estado (Activo/Inactivo)

**Validaciones:** Iguales al CREATE

#### 3.3.2 Actualizar Log
**Ruta Web:** `POST /habits/{habit}/logs` (updateOrCreate)  
**Controlador:** `HabitLogController@store`

Funcionalidad:
- Si existe log para esa fecha → actualiza
- Si no existe → crea uno nuevo
- Cambia el estado (completado/pendiente)

### 3.4 DELETE (Eliminar)

#### 3.4.1 Eliminar Hábito
**Ruta Web:** `DELETE /habits/{habit}`  
**Controlador:** `HabitController@destroy`

Proceso:
1. Solicita confirmación al usuario
2. Valida que el usuario sea propietario
3. Elimina el hábito (en cascada se eliminan days y logs)

#### 3.4.2 Eliminar Día
**Ruta Web:** `DELETE /habits/{habit}/days/{day}`  
**Controlador:** `HabitDayController@destroy`

Seguridad:
- Solo propietario del hábito puede eliminar
- Admin puede eliminar cualquiera

#### 3.4.3 Eliminar Log
**Ruta Web:** `DELETE /habits/{habit}/logs/{log}`  
**Controlador:** `HabitLogController@destroy`

Seguridad:
- Solo propietario del log o admin
- Solicita confirmación

### 3.5 Resumen CRUD

| Operación | Modelo | Ruta | Método | Controlador |
|-----------|--------|------|--------|-------------|
| Create | Habit | /habits | POST | store() |
| Read | Habit | /habits | GET | index() |
| Read | Habit | /habits/{id}/edit | GET | edit() |
| Update | Habit | /habits/{id} | PUT | update() |
| Delete | Habit | /habits/{id} | DELETE | destroy() |
| Create | HabitDay | /habits/{id}/days | POST | store() |
| Read | HabitDay | /habits/{id}/days | GET | index() |
| Delete | HabitDay | /habits/{id}/days/{id} | DELETE | destroy() |
| Create | HabitLog | /habits/{id}/logs | POST | store() |
| Read | HabitLog | /habits/{id}/logs | GET | index() |
| Delete | HabitLog | /habits/{id}/logs/{id} | DELETE | destroy() |

---

## 4. API REST

### 4.1 Autenticación
- Usa Laravel Sanctum
- Token Bearer en header: `Authorization: Bearer {token}`
- Todos los endpoints requieren autenticación

### 4.2 Endpoints Implementados

#### 4.2.1 HABITS

**1. Listar hábitos**
```
GET /api/habits
Respuesta: 200 OK
{
  "data": [
    {
      "id": 1,
      "title": "Ejercicio",
      "description": "...",
      "is_active": true,
      "days": [],
      "logs": []
    }
  ]
}
```

**2. Crear hábito**
```
POST /api/habits
Body: {
  "title": "Meditar",
  "description": "10 minutos",
  "is_active": true
}
Respuesta: 201 Created
```

**3. Actualizar hábito**
```
PUT /api/habits/{id}
Body: {
  "title": "Meditación actualizada"
}
Respuesta: 200 OK
```

**4. Eliminar hábito**
```
DELETE /api/habits/{id}
Respuesta: 200 OK
{"message": "Deleted"}
```

#### 4.2.2 HABIT DAYS

**5. Listar días**
```
GET /api/habits/{id}/days
Respuesta: 200 OK
```

**6. Agregar día**
```
POST /api/habits/{id}/days
Body: {"day_of_week": 1}
Respuesta: 201 Created
```

**7. Eliminar día**
```
DELETE /api/habits/{id}/days/{day_id}
Respuesta: 200 OK
```

#### 4.2.3 HABIT LOGS

**8. Listar logs**
```
GET /api/habits/{id}/logs
Respuesta: 200 OK
```

**9. Crear/Actualizar log**
```
POST /api/habits/{id}/logs
Body: {
  "log_date": "2026-05-16",
  "completed": true
}
Respuesta: 201 Created
```

**10. Eliminar log**
```
DELETE /api/logs/{id}
Respuesta: 200 OK
```

### 4.3 Códigos de Estado HTTP

| Código | Significado |
|--------|------------|
| 200 | OK - Solicitud exitosa |
| 201 | Created - Recurso creado |
| 400 | Bad Request - Datos inválidos |
| 403 | Forbidden - Sin permisos |
| 404 | Not Found - Recurso no existe |
| 422 | Unprocessable Entity - Validación fallida |

### 4.4 Ejemplo de Uso con cURL

```bash
# Obtener todos los hábitos
curl -X GET "http://localhost:8000/api/habits" \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Accept: application/json"

# Crear nuevo hábito
curl -X POST "http://localhost:8000/api/habits" \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Leer",
    "description": "30 minutos al día"
  }'
```

---

## 5. GESTIÓN DE ROLES

### 5.1 Roles Implementados

#### 5.1.1 Admin
**Permisos:**
- ✅ Ver todos los hábitos de todos los usuarios
- ✅ Editar/eliminar cualquier hábito
- ✅ Ver todos los logs del sistema
- ✅ Administrar usuarios (futuro)

**Restricciones:**
- ❌ No especificadas

#### 5.1.2 Usuario (Normal)
**Permisos:**
- ✅ Crear sus propios hábitos
- ✅ Ver solo sus hábitos
- ✅ Editar/eliminar sus propios hábitos
- ✅ Registrar su progreso

**Restricciones:**
- ❌ No puede ver datos de otros usuarios
- ❌ No puede eliminar hábitos ajenos
- ❌ No puede acceder a funciones de admin

### 5.2 Matriz de Control de Acceso

| Recurso | Admin | Usuario |
|---------|:----:|:-------:|
| Ver todos los hábitos | ✅ | ❌ |
| Ver propios hábitos | ✅ | ✅ |
| Crear hábito | ✅ | ✅ |
| Editar cualquier hábito | ✅ | ❌ |
| Editar propio hábito | ✅ | ✅ |
| Eliminar cualquier hábito | ✅ | ❌ |
| Eliminar propio hábito | ✅ | ✅ |
| Ver todos los logs | ✅ | ❌ |
| Ver propios logs | ✅ | ✅ |
| Crear log | ✅ | ✅ |
| Eliminar cualquier log | ✅ | ❌ |
| Eliminar propio log | ✅ | ✅ |

### 5.3 Implementación

**Middleware de Autenticación:**
```php
Route::middleware('auth')->group(function () {
    // Rutas protegidas
});
```

**Middleware de Rol:**
```php
Route::middleware('role:admin')->group(function () {
    // Solo admin
});
```

**Verificación en Controladores:**
```php
if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
    abort(403);
}
```

### 5.4 Usuarios de Prueba

| Email | Contraseña | Rol |
|-------|-----------|-----|
| admin@example.com | admin1234 | Admin |
| test@example.com | test1234 | Usuario |

---

## 6. PROBLEMAS ENCONTRADOS Y SOLUCIONES

### 6.1 Problema 1: Validación de Unicidad en HabitDay

**Problema:**
Al intentar agregar dos veces el mismo día de la semana a un hábito, no se validaba correctamente.

**Solución:**
Se agregó validación única con restricción compuesta:
```php
'day_of_week' => ['required', 'integer', 'min:1', 'max:7', 
    'unique:habit_days,day_of_week,NULL,id,habit_id,'.$habit->id]
```

### 6.2 Problema 2: Autorización de Acceso

**Problema:**
Los usuarios podían acceder a hábitos de otros usuarios directamente en la URL.

**Solución:**
Se implementó verificación de propiedad en todos los controladores:
```php
if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
    abort(403);
}
```

### 6.3 Problema 3: Comportamiento de UpdateOrCreate en Logs

**Problema:**
Al actualizar un log, no se estaban preservando los valores anteriores correctamente.

**Solución:**
Se usó método `updateOrCreate()` que crea o actualiza según las claves de búsqueda:
```php
$log = $habit->logs()->updateOrCreate(
    ['user_id' => $userId, 'log_date' => $validated['log_date']],
    ['completed_at' => $completedAt]
);
```

### 6.4 Problema 4: Naming de Días en Frontend

**Problema:**
Los días se mostraban como números (1-7) sin clara identificación.

**Solución:**
Se agregó array de mapeo en Blade:
```php
$dayNames = [1 => 'Lunes', 2 => 'Martes', ..., 7 => 'Domingo'];
```

---

## 7. CONCLUSIONES

### 7.1 Logros Alcanzados

1. **Autenticación Segura:** Se implementó correctamente Laravel Breeze con soporte para registro, login y logout.

2. **Sistema de Roles Funcional:** Los roles (admin y usuario) están correctamente implementados con control de acceso granular.

3. **CRUD Completo:** Se desarrollaron todas las operaciones (Create, Read, Update, Delete) para tres entidades relacionadas (Habit, HabitDay, HabitLog).

4. **API REST Profesional:** Se crearon 10 endpoints funcionales que cumplen con estándares RESTful y devuelven respuestas JSON correctas.

5. **Base de Datos bien Diseñada:** Se implementó un modelo ER correcto con relaciones apropiadas y restricciones de unicidad.

6. **Interfaz Amigable:** Se desarrollaron vistas Blade con estilos Tailwind CSS, validaciones visuales y mensajes de error claros.

7. **Código Limpio y Organizado:** Se siguieron patrones de Laravel, principios SOLID y buenas prácticas de programación.

### 7.2 Requisitos Cumplidos

✅ **Estructura base:** Proyecto Laravel completamente funcional  
✅ **Autenticación:** Breeze con login/registro/logout  
✅ **Manejo de roles:** Admin y Usuario con permisos diferenciados  
✅ **Diseño DB:** 4 tablas con relaciones correctas  
✅ **CRUD:** Operaciones completas en 3+ entidades  
✅ **API REST:** 10 endpoints documentados  
✅ **Controladores:** Estructura RESTful adecuada  
✅ **Vistas Blade:** Layout reutilizable, formularios, validaciones  
✅ **Seeders:** Datos de prueba para las 4 tablas  
✅ **Documentación:** Esta especificación técnica  

### 7.3 Aprendizajes

- **Framework Laravel:** Dominio profundo de enrutamiento, controladores, modelos y middleware
- **Autenticación:** Implementación segura de autenticación con roles
- **API Design:** Desarrollo de APIs RESTful siguiendo convenciones
- **Validaciones:** Validación de datos tanto en frontend como backend
- **Database Design:** Diseño de esquemas relacionales normalizados
- **Security:** Prevención de SQL injection, XSS, CSRF

### 7.4 Posibles Mejoras Futuras

1. **Gráficas de progreso:** Visualizar estadísticas de cumplimiento
2. **Notificaciones:** Recordatorios por email o push
3. **Two-Factor Authentication:** Seguridad adicional
4. **Historial de cambios:** Auditoría de acciones
5. **Exportación de datos:** Descargar reportes en Excel/PDF
6. **Aplicación móvil:** Versión nativa o híbrida
7. **Integración social:** Compartir logros con amigos

### 7.5 Reflexión Final

Este proyecto fue una excelente oportunidad para aplicar los conceptos de Programación para Internet II en una aplicación real y funcional. Se logró crear un sistema completo que integra:

- Backend robusto con validaciones
- Frontend responsivo e intuitivo  
- API profesional
- Seguridad mediante autenticación y autorización
- Base de datos bien diseñada

El desarrollo demostró la importancia de:
- Planificación previa (diagrama ER)
- Buenas prácticas de codificación
- Testing y validación
- Documentación clara

La aplicación está lista para producción y puede servir como base para proyectos más complejos.

---

## 8. REFERENCIAS Y TECNOLOGÍAS

### 8.1 Stack Tecnológico

**Backend:**
- PHP 8.2+
- Laravel 11
- MySQL 5.7+

**Frontend:**
- Blade Templates
- Tailwind CSS
- Alpine.js (mínimo uso)

**Otros:**
- Composer (Package Manager)
- npm (Dependencies)
- Git (Version Control)

### 8.2 Librerías Principales

```json
{
  "require": {
    "laravel/framework": "^11.0",
    "laravel/breeze": "^2.0",
    "laravel/sanctum": "^3.0"
  }
}
```

### 8.3 Recursos Consultados

- [Documentación oficial de Laravel](https://laravel.com/docs)
- [Laravel Breeze Docs](https://laravel.com/docs/breeze)
- [RESTful API Design Guidelines](https://restfulapi.net/)
- [Tailwind CSS](https://tailwindcss.com/)

---

**Documento generado:** Mayo 16, 2026  
**Versión:** 1.0  
**Estado:** Completado
