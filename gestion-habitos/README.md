# 🎯 Gestión de Hábitos

Una aplicación web completa en Laravel para registrar, seguir y gestionar tus hábitos diarios con una interfaz intuitiva y una API REST funcional.

## ✨ Características

- ✅ **Autenticación completa** con Laravel Breeze
- ✅ **Sistema de roles** (Admin y Usuario)
- ✅ **CRUD funcional** para hábitos, días y registros
- ✅ **API REST** con 10 endpoints
- ✅ **Dashboard interactivo** con información en tiempo real
- ✅ **Validaciones** en frontend y backend
- ✅ **Base de datos** con 4 tablas relacionadas
- ✅ **Seeders** con datos de prueba

## 🏗️ Estructura del Proyecto

### Modelos y Relaciones
- **User** (Usuario)
  - `hasMany(Habit)` - Muchos hábitos
  - `hasMany(HabitLog)` - Muchos registros

- **Habit** (Hábito)
  - `belongsTo(User)` - Pertenece a un usuario
  - `hasMany(HabitDay)` - Muchos días
  - `hasMany(HabitLog)` - Muchos registros

- **HabitDay** (Día del Hábito)
  - `belongsTo(Habit)` - Pertenece a un hábito

- **HabitLog** (Registro del Hábito)
  - `belongsTo(Habit)` - Pertenece a un hábito
  - `belongsTo(User)` - Pertenece a un usuario

### Base de Datos
```
users
├─ id
├─ name
├─ email
├─ password
├─ role (admin, usuario)
└─ timestamps

habits
├─ id
├─ user_id (FK → users.id)
├─ title
├─ description
├─ is_active
└─ timestamps

habit_days
├─ id
├─ habit_id (FK → habits.id)
├─ day_of_week (1-7)
└─ timestamps

habit_logs
├─ id
├─ habit_id (FK → habits.id)
├─ user_id (FK → users.id)
├─ log_date
├─ completed_at
└─ timestamps
```

## 🚀 Instalación

### Requisitos
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL/MariaDB

### Pasos

1. **Clonar el repositorio**
```bash
git clone <url-repositorio>
cd gestion-habitos
```

2. **Instalar dependencias**
```bash
composer install
npm install && npm run build
```

3. **Configurar el archivo .env**
```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` con tus credenciales de base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_habitos
DB_USERNAME=root
DB_PASSWORD=
```

4. **Ejecutar migraciones**
```bash
php artisan migrate
```

5. **Popular base de datos con seeders**
```bash
php artisan db:seed
```

6. **Iniciar servidor de desarrollo**
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## 🔐 Usuarios de Prueba

Después de ejecutar el seeder, tendrás estos usuarios:

| Email | Contraseña | Rol |
|-------|-----------|-----|
| `admin@example.com` | `admin1234` | Admin |
| `test@example.com` | `test1234` | Usuario |

## 📱 Uso

### Panel Web
1. Inicia sesión con tu cuenta
2. **Dashboard** - Ve todos tus hábitos de un vistazo
3. **Mis hábitos** - Gestiona tus hábitos (crear, editar, eliminar)
4. **Días** - Configura en qué días se aplica cada hábito
5. **Logs** - Registra el progreso diario

### API REST
La API está disponible en `/api/`

**Endpoints principales:**
- `GET /api/habits` - Listar hábitos
- `POST /api/habits` - Crear hábito
- `PUT /api/habits/{id}` - Actualizar hábito
- `DELETE /api/habits/{id}` - Eliminar hábito
- `GET /api/habits/{habit_id}/days` - Listar días
- `POST /api/habits/{habit_id}/days` - Agregar día
- `GET /api/habits/{habit_id}/logs` - Listar logs
- `POST /api/habits/{habit_id}/logs` - Crear log
- `DELETE /api/logs/{id}` - Eliminar log

Ver [API_ENDPOINTS.md](API_ENDPOINTS.md) para documentación completa.

## 🔐 Control de Acceso

### Admin
- ✅ Ver todos los hábitos de todos los usuarios
- ✅ Editar/eliminar cualquier hábito
- ✅ Ver todos los logs

### Usuario Normal
- ✅ Ver solo sus propios hábitos
- ✅ Editar/eliminar solo sus hábitos
- ✅ Ver solo sus propios logs
- ❌ No puede ver datos de otros usuarios

## 🧪 Testing con Postman

1. Obtener token de autenticación desde:
   - `POST /api/tokens/create`
   - Body JSON: `{"email":"test@example.com","password":"test1234","device_name":"Postman"}`
2. Agregar header: `Authorization: Bearer {token}`
3. Hacer solicitudes a los endpoints

Ver `API_ENDPOINTS.md` para ejemplos completos.

## 📁 Estructura de Carpetas

```
gestion-habitos/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/                 # Controladores API
│   │   └── *.php                # Controladores web
│   ├── Models/
│   │   └── *.php                # Modelos Eloquent
│   └── Http/Middleware/
│       └── *.php                # Middleware personalizado
├── database/
│   ├── migrations/              # Migraciones
│   ├── seeders/                 # Seeders
│   └── factories/               # Factories
├── resources/views/             # Vistas Blade
│   ├── habits/
│   ├── habit_days/
│   ├── habit_logs/
│   └── dashboard.blade.php
├── routes/
│   ├── web.php                  # Rutas web
│   ├── api.php                  # Rutas API
│   └── auth.php                 # Rutas autenticación
└── ...
```

## 🛠️ Desarrollo

### Crear un nuevo hábito
```bash
# Desde web
1. Navega a "Mis hábitos"
2. Click en "+ Nuevo hábito"
3. Completa el formulario

# Desde API
curl -X POST http://localhost:8000/api/habits \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"title":"Meditar","description":"10 minutos"}'
```

### Agregar un día a un hábito
```bash
# Desde web
1. En "Mis hábitos", click en "Días"
2. Selecciona el día de la semana
3. Click en "Agregar día"

# Desde API
curl -X POST http://localhost:8000/api/habits/1/days \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"day_of_week":1}'
```

### Registrar un progreso
```bash
# Desde web
1. En "Mis hábitos", click en "Logs"
2. Completa la fecha y marca si fue completado
3. Click en "Guardar log"

# Desde API
curl -X POST http://localhost:8000/api/habits/1/logs \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"log_date":"2026-05-16","completed":true}'
```

## 📝 Validaciones

### Título del hábito
- Requerido
- Máximo 255 caracteres

### Día de la semana
- Requerido
- Entre 1 (Lunes) y 7 (Domingo)
- Único por hábito

### Fecha del log
- Requerido
- Formato válido (Y-m-d)
- Único por (hábito, usuario, fecha)

## 🐛 Troubleshooting

### Error: "No existe la tabla"
```bash
php artisan migrate
```

### Error: "No hay datos"
```bash
php artisan db:seed
```

### Error: CORS
Asegurate de que el header `Accept: application/json` esté presente en peticiones API.

### Error: 403 Forbidden
Verifica que el usuario tenga permisos sobre el recurso solicitado.

## 📄 Licencia

Este proyecto está bajo la licencia MIT.

## 👨‍💻 Autor

Proyecto final de Programación para Internet II

---

**¡Mantén tus hábitos y alcanza tus metas! 🚀**

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
