# 🎯 Gestion de Hábitos - API REST

## 📋 Endpoints API

### Autenticación
Todos los endpoints requieren autenticación con Bearer token (Sanctum).

**Headers requeridos:**
```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

### Generar token de acceso
```
POST /api/tokens/create
Content-Type: application/json

{
  "email": "test@example.com",
  "password": "test1234",
  "device_name": "Postman"
}
```

**Respuesta:**
```json
{
  "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ"
}
```

Usa ese token en `Authorization: Bearer {token}` para todas las demás llamadas a la API.

---

## 👥 HABITS (Hábitos)

### 1. Listar todos los hábitos
```
GET /api/habits
```
**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "title": "Ejercicio",
      "description": "Hacer 30 minutos de ejercicio",
      "is_active": true,
      "days": [...],
      "logs": [...]
    }
  ]
}
```

### 2. Crear nuevo hábito
```
POST /api/habits
Content-Type: application/json

{
  "title": "Meditar",
  "description": "Meditar 10 minutos cada mañana",
  "is_active": true
}
```
**Respuesta:** `201 Created`

### 3. Actualizar hábito
```
PUT /api/habits/{id}
Content-Type: application/json

{
  "title": "Meditar actualizado",
  "is_active": false
}
```
**Respuesta:** `200 OK`

### 4. Eliminar hábito
```
DELETE /api/habits/{id}
```
**Respuesta:** `200 OK`

---

## 📅 HABIT DAYS (Días del Hábito)

### 5. Listar días de un hábito
```
GET /api/habits/{habit_id}/days
```
**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "habit_id": 1,
      "day_of_week": 1,
      "created_at": "2026-05-16T10:00:00.000Z"
    }
  ]
}
```

### 6. Agregar día al hábito
```
POST /api/habits/{habit_id}/days
Content-Type: application/json

{
  "day_of_week": 2
}
```
**Valores de day_of_week:** 1-7 (Lunes a Domingo)

**Respuesta:** `201 Created`

### 7. Eliminar día del hábito
```
DELETE /api/habits/{habit_id}/days/{day_id}
```
**Respuesta:** `200 OK`

---

## 📝 HABIT LOGS (Registros del Hábito)

### 8. Listar logs de un hábito
```
GET /api/habits/{habit_id}/logs
```
**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "habit_id": 1,
      "user_id": 1,
      "log_date": "2026-05-16",
      "completed_at": "2026-05-16T10:30:00.000Z"
    }
  ]
}
```

### 9. Crear/actualizar log
```
POST /api/habits/{habit_id}/logs
Content-Type: application/json

{
  "log_date": "2026-05-16",
  "completed": true
}
```
**Respuesta:** `201 Created` (o actualiza si ya existe)

### 10. Eliminar log
```
DELETE /api/logs/{log_id}
```
**Respuesta:** `200 OK`

---

## 🔐 Códigos de Error

| Código | Significado |
|--------|------------|
| `200` | OK |
| `201` | Created |
| `400` | Bad Request - Datos inválidos |
| `403` | Forbidden - No tiene permisos |
| `404` | Not Found - Recurso no existe |
| `422` | Unprocessable Entity - Validación fallida |

---

## 📦 Ejemplo con cURL

```bash
# Obtener todos los hábitos
curl -X GET "http://localhost:8000/api/habits" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"

# Crear un nuevo hábito
curl -X POST "http://localhost:8000/api/habits" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"title":"Leer","description":"Leer 30 minutos"}'
```

---

## 🛠️ Notas para el Desarrollo

- **Admin** puede ver y modificar hábitos de cualquier usuario
- **Usuario Normal** solo puede ver/modificar sus propios hábitos
- Los **logs** son únicos por (habit_id, user_id, log_date)
- Los **days** son únicos por (habit_id, day_of_week)
- Las fechas se devuelven en formato ISO 8601 (YYYY-MM-DD)
