# 🎬 GUÍA PARA VIDEO DE DEMOSTRACIÓN

## 📋 Estructura del Video (5-8 minutos)

### PARTE 1: INTRODUCCIÓN (0:30-1:00)
**Duración:** ~30 segundos

**Contenido:**
- Título en pantalla: "Sistema de Gestión de Hábitos"
- Tu nombre
- Materia: "Programación para Internet II"
- Breve explicación: "Aplicación web para registrar y seguir hábitos diarios"

**Script sugerido:**
> "Hola, este es mi proyecto final de Programación para Internet II. Se trata de un Sistema de Gestión de Hábitos, una aplicación web donde los usuarios pueden crear, registrar y seguir el progreso de sus hábitos diarios con un sistema de roles y una API REST completamente funcional."

---

### PARTE 2: DEMOSTRACIÓN WEB - LOGIN (1:00-1:30)
**Duración:** ~30 segundos

**Pantalla:** Mostrar página de login

**Acciones:**
1. Mostrar URL: `http://localhost:8000`
2. Redirecciona a login automáticamente
3. Explicar que está protegido con autenticación

**Script:**
> "Como pueden ver, la aplicación tiene un sistema de autenticación seguro. Solo los usuarios registrados pueden acceder. Voy a iniciar sesión con una cuenta de prueba."

---

### PARTE 3: DASHBOARD (1:30-2:30)
**Duración:** ~1 minuto

**Pantalla:** Mostrar dashboard lleno de datos

**Acciones:**
1. Mostrar la estructura del dashboard
2. Señalar los 10 hábitos con sus relaciones
3. Expandir un hábito para ver detalles
4. Leer en voz alta: "Hábito 1 usa 2 habit_days y 5 habit_logs"

**Script:**
> "Este es el dashboard principal. Aquí se muestran todos los hábitos del usuario con información detallada:
> - El título del hábito
> - Cuántos días de la semana está configurado (habit_days)
> - Cuántos registros de progreso tiene (habit_logs)
> 
> Por ejemplo, el Hábito 1 está configurado para 2 días y tiene 5 registros de cumplimiento."

---

### PARTE 4: CRUD - CREAR HÁBITO (2:30-3:15)
**Duración:** ~45 segundos

**Pantalla:** Página "Mis hábitos"

**Acciones:**
1. Ir a "Mis hábitos" (botón principal)
2. Mostrar tabla con hábitos listados
3. Click en "+ Nuevo hábito"
4. Rellenar formulario con datos de prueba
5. Guardar

**Script:**
> "Ahora voy a crear un nuevo hábito. Hago click en 'Nuevo hábito', completo el formulario con un título, descripción opcional y si está activo."

**Datos de ejemplo:**
```
Título: Beber agua
Descripción: 8 vasos de agua al día
Activo: ✓
```

---

### PARTE 5: CONFIGURAR DÍAS (3:15-4:00)
**Duración:** ~45 segundos

**Pantalla:** Página de días del hábito

**Acciones:**
1. Desde la tabla de hábitos, click en "Días"
2. Mostrar select dropdown con días (Lunes-Domingo)
3. Agregar 3 días diferentes
4. Mostrar la tabla actualizada

**Script:**
> "Ahora configuro en qué días de la semana se aplica este hábito. Selecciono los días en este dropdown y agrego varios. Como pueden ver, no puedo agregar el mismo día dos veces - hay validación de unicidad."

**Días a agregar:**
- Lunes
- Miércoles
- Viernes

---

### PARTE 6: REGISTRAR PROGRESO (4:00-4:45)
**Duración:** ~45 segundos

**Pantalla:** Página de logs

**Acciones:**
1. Click en "Logs" del hábito
2. Mostrar formulario de nuevo registro
3. Seleccionar fecha
4. Marcar como "Completado" o "Pendiente"
5. Guardar
6. Mostrar tabla actualizada con el nuevo registro
7. Mostrar badge verde (Completado)

**Script:**
> "Aquí puedo registrar el progreso diario. Selecciono una fecha, indico si se completó o no, y guardo. Como ven, el sistema muestra un badge verde para completado y amarillo para pendiente. Puedo registrar múltiples días sin problema."

---

### PARTE 7: CONTROL DE ACCESO POR ROLES (4:45-5:30)
**Duración:** ~45 segundos

**Pantalla:** Mostrar diferentes vistas según rol

**Acciones:**
1. Mostrar la aplicación con usuario normal
2. Hablar sobre los permisos
3. (Opcional) Cambiar sesión a admin si es posible

**Script:**
> "El sistema tiene dos roles: Admin y Usuario. 
> 
> Un usuario normal solo puede:
> - Ver sus propios hábitos
> - Crear y editar sus hábitos
> - Ver solo sus registros
> 
> Un administrador puede:
> - Ver todos los hábitos de todos los usuarios
> - Editar o eliminar cualquier hábito
> - Ver todos los registros del sistema"

---

### PARTE 8: API REST (5:30-6:30)
**Duración:** ~1 minuto

**Pantalla:** Mostrar Postman (u otra herramienta)

**Acciones:**
1. Abrir Postman
2. Mostrar 3-4 endpoints:
   - GET /api/habits (listar)
   - POST /api/habits (crear)
   - GET /api/habits/{id}/logs (logs)
3. Ejecutar requests y mostrar respuestas JSON
4. Explicar que hay 10 endpoints totales

**Script:**
> "El proyecto también incluye una API REST completamente funcional con 10 endpoints. Aquí en Postman puedo ver:
> 
> 1. GET /api/habits - Lista todos los hábitos
> 2. POST /api/habits - Crea un nuevo hábito
> 3. GET /api/habits/1/logs - Obtiene los logs de un hábito
> 
> La API devuelve JSON y requiere autenticación con Bearer token. Los datos coinciden con la base de datos, demostrando que web y API están sincronizadas."

---

### PARTE 9: BASE DE DATOS (6:30-7:00)
**Duración:** ~30 segundos

**Pantalla:** Mostrar PHPMyAdmin o similar

**Acciones:**
1. Mostrar las 4 tablas:
   - users
   - habits
   - habit_days
   - habit_logs
2. Mostrar datos en cada tabla
3. Explicar las relaciones

**Script:**
> "Aquí pueden ver la base de datos con 4 tablas relacionadas:
> - Users: Almacena usuarios con sus roles
> - Habits: Los hábitos creados
> - Habit_days: Los días configurados para cada hábito
> - Habit_logs: El registro de cada completación
> 
> Las relaciones están correctamente implementadas con foreign keys."

---

### PARTE 10: CONCLUSIÓN (7:00-7:30)
**Duración:** ~30 segundos

**Pantalla:** Mostrar el proyecto en general (puede ser el dashboard)

**Script:**
> "En resumen, este proyecto demuestra:
> 
> ✅ Autenticación segura con Laravel Breeze
> ✅ Sistema de roles funcional
> ✅ CRUD completo en 3 entidades relacionadas
> ✅ API REST con 10 endpoints
> ✅ Base de datos bien diseñada
> ✅ Interfaz amigable y responsiva
> ✅ Validaciones en frontend y backend
> 
> El código está disponible en GitHub y la documentación completa está incluida. Gracias por ver."

---

## 🎥 OPCIONES DE GRABACIÓN

### Opción 1: OBS Studio (Recomendado - Gratis)
**Descargar:** https://obsproject.com/

**Pasos:**
1. Abre OBS
2. Click en "+" en "Sources"
3. Selecciona "Display Capture" o "Window Capture"
4. Selecciona tu pantalla o ventana del navegador
5. Añade micrófono en "Audio Input Capture"
6. Click "Start Recording"
7. Sigue el script
8. Click "Stop Recording"

**Calidad recomendada:**
- Resolución: 1920x1080 (Full HD)
- FPS: 30
- Bitrate: 4000-6000 kbps

### Opción 2: Zoom (Con video)
1. Abre Zoom
2. "Nueva reunión"
3. "Compartir pantalla"
4. "Grabar localmente"
5. Presenta tu proyecto
6. Detén grabación

### Opción 3: ScreenFlow (Mac) o Camtasia (Multi-plataforma)
- Software pagado pero muy bueno
- Fácil edición post-grabación

---

## 🎤 CONSEJOS DE GRABACIÓN

### Antes de grabar:
- ✅ Prueba el micrófono
- ✅ Cierra notificaciones (Win + A)
- ✅ Ten los datos listos (usuarios de prueba)
- ✅ Agranda el texto del navegador (Ctrl + +)
- ✅ Asegúrate que el servidor Laravel está corriendo
- ✅ Practica el script una vez

### Durante la grabación:
- ✅ Habla clara y lentamente
- ✅ Evita "um" y "eh"
- ✅ Sigue el script pero suena natural
- ✅ Mueve el ratón deliberadamente
- ✅ Espera 2 segundos antes de cambiar de pantalla
- ✅ Señala cosas importante (puntero, colores)

### Después de grabar:
- ✅ Edita si es necesario (OBS hace clip automáticos)
- ✅ Añade títulos al inicio y fin
- ✅ Comprime el archivo (H.264)
- ✅ Sube a OneDrive o Google Drive
- ✅ Asegúrate que el archivo sea MP4

---

## 📊 DURACIÓN PROPUESTA

| Parte | Duración | Tiempo acumulado |
|-------|----------|------------------|
| Introducción | 0:30 | 0:30 |
| Login | 0:30 | 1:00 |
| Dashboard | 1:00 | 2:00 |
| Crear Hábito | 0:45 | 2:45 |
| Configurar Días | 0:45 | 3:30 |
| Registrar Progreso | 0:45 | 4:15 |
| Roles y Acceso | 0:45 | 5:00 |
| API REST | 1:00 | 6:00 |
| Base de Datos | 0:30 | 6:30 |
| Conclusión | 1:00 | 7:30 |
| **TOTAL** | - | **7:30** |

---

## ✅ CHECKLIST ANTES DE ENVIAR

- [ ] Duración entre 5-8 minutos
- [ ] Audio claro sin ruidos de fondo
- [ ] Se ve todo correctamente (texto legible)
- [ ] Se demuestra login exitoso
- [ ] Se crea un nuevo hábito
- [ ] Se agregan días al hábito
- [ ] Se registra progreso
- [ ] Se explica sistema de roles
- [ ] Se muestra API en Postman
- [ ] Se muestra base de datos
- [ ] Se menciona GitHub y documentación
- [ ] Conclusiones claras

---

## 💡 IDEAS EXTRAS

### Para hacer el video más profesional:

1. **Intro animado:** Crea un intro simple con Canva (5 segundos)
2. **Transiciones:** Usa fade transitions entre secciones
3. **Música de fondo:** Añade música royalty-free (sin copyright)
4. **Zoom:** Amplía áreas importantes durante la demostración
5. **Captions:** Añade subtítulos a puntos clave
6. **Logo:** Añade tu logo o nombre al inicio

### Música recomendada (Royalty-free):
- YouTube Audio Library
- Epidemic Sound
- Freepik Music
- Pixabay Music

---

## 📝 NOTAS IMPORTANTES

**NO olvides mostrar:**
- ✅ Que los datos persisten (recarga la página)
- ✅ Las validaciones en acción
- ✅ El mensaje de error al intentar acciones no autorizadas
- ✅ La paginación funcionando
- ✅ Los badges de estado

**EVITA:**
- ❌ Mostrar contraseñas reales
- ❌ Datos sensibles (emails personales)
- ❌ Conexiones lentas/lag
- ❌ Ruidos de teclado/ratón fuertes
- ❌ Pantallazos de código no necesarios

---

**¡Buena suerte con tu video!** 🎬🚀
