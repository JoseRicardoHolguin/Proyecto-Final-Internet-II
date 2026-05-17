# 🔐 Control de Acceso por Rol

## Matriz de Permisos

| Recurso/Acción | Admin | Usuario |
|---|:---:|:---:|
| **HÁBITOS** | | |
| Ver todos los hábitos | ✅ | ✅ (solo propios) |
| Crear hábito | ✅ | ✅ |
| Editar hábito | ✅ (cualquiera) | ✅ (solo propios) |
| Eliminar hábito | ✅ (cualquiera) | ✅ (solo propios) |
| **DÍAS** | | |
| Ver días de hábito | ✅ | ✅ (solo propios) |
| Agregar día a hábito | ✅ | ✅ (solo propios) |
| Eliminar día de hábito | ✅ | ✅ (solo propios) |
| **REGISTROS (LOGS)** | | |
| Ver todos los logs | ✅ | ✅ (solo propios) |
| Crear log | ✅ | ✅ (solo propios) |
| Editar log | ✅ | ❌ |
| Eliminar log | ✅ | ✅ (solo propios) |
| **USUARIOS** | | |
| Ver perfil propio | ✅ | ✅ |
| Editar perfil propio | ✅ | ✅ |
| Ver otros perfiles | ✅ | ❌ |
| Cambiar roles de usuarios | ✅ | ❌ |
| **DASHBOARD** | | |
| Ver datos personales | ✅ | ✅ |
| Ver datos globales | ✅ | ❌ |

## Detalles de Implementación

### 1. Middleware de Autenticación
```php
// Requiere estar autenticado
Route::middleware('auth')->group(function () {
    // Rutas protegidas
});
```

### 2. Middleware de Rol
```php
// En bootstrap/app.php
$middleware->alias([
    'role' => EnsureRole::class,
]);

// Uso en rutas
Route::middleware('role:admin')->group(function () {
    // Solo admin
});
```

### 3. Verificación en Controladores
```php
// En controladores
if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
    abort(403); // Forbidden
}
```

### 4. Verificación en Vistas
```blade
@if(auth()->user()->role === 'admin' || $log->user_id === auth()->id())
    <!-- Mostrar acción -->
@endif
```

## Flujos por Rol

### 👨‍💼 Usuario Normal
1. ✅ Puede crear sus propios hábitos
2. ✅ Puede registrar su progreso diario
3. ✅ Solo ve su propio dashboard
4. ✅ No puede ver datos de otros usuarios
5. ❌ No puede acceder a panel de admin

### 👨‍💻 Admin
1. ✅ Puede ver todos los hábitos
2. ✅ Puede ver todos los registros
3. ✅ Puede eliminar cualquier hábito/log
4. ✅ Acceso a panel de admin (futuro)
5. ✅ Puede crear usuarios

## Rutas Protegidas

### Protegidas por Autenticación (`auth`)
```
GET  /dashboard
GET  /habits
GET  /habits/{id}/edit
GET  /habits/{id}/days
GET  /habits/{id}/logs
```

### Protegidas por API (`auth:sanctum`)
```
GET  /api/habits
POST /api/habits
PUT  /api/habits/{id}
DELETE /api/habits/{id}
GET  /api/habits/{id}/days
POST /api/habits/{id}/days
GET  /api/habits/{id}/logs
POST /api/habits/{id}/logs
DELETE /api/logs/{id}
```

## Manejo de Errores de Acceso

| Caso | Respuesta |
|------|----------|
| No autenticado | 302 Redirect a `/login` |
| Sin rol requerido | 403 Forbidden |
| Recurso no encontrado | 404 Not Found |
| Datos inválidos | 422 Unprocessable Entity |

## Seguridad

✅ **Implementado:**
- Verificación de propiedad de recursos
- Middleware de autenticación
- Validación de roles
- CSRF protection con Breeze
- SQL injection prevention (Eloquent ORM)
- XSS prevention (Blade escaping)

⏳ **Futuras mejoras:**
- Rate limiting
- Two-factor authentication
- Audit logging
- Permission-based access control
