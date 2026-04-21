# AutoRent 🚗
**Plataforma Web de Alquiler de Autos**
Trabajo de Campo — Ingeniería de Software II · Grupo 72
Universidad Nacional del Nordeste

---

## 👥 Integrantes
| Alumno | Responsabilidad |
|---|---|
| **Tomás Conti** | Backend: infraestructura, base de datos, autenticación, admin |
| **Gastón Encinas** | Frontend: maquetación web, catálogo, flujo de renta |

---

## 🚀 Instalación (Parte de Tomás — `feature/backend-auth`)

### Requisitos
- PHP >= 8.2
- Composer
- Cuenta en [Supabase](https://supabase.com) (gratuita)

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/gaston123-code/ISII_26TC_Grupo72.git
cd ISII_26TC_Grupo72

# 2. Cambiar a la rama de backend
git checkout feature/backend-auth

# 3. Instalar dependencias PHP
composer install

# 4. Configurar el entorno
cp .env.example .env
php artisan key:generate
```

### Configurar Supabase en `.env`
Abrí tu proyecto en [Supabase Dashboard](https://supabase.com/dashboard) →
**Settings → Database → Connection string** y completá:

```env
DB_CONNECTION=pgsql
DB_HOST=db.XXXXXXXXXX.supabase.co   # Tu project ref
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=tu_password_de_supabase
```

```bash
# 5. Ejecutar migraciones (crea todas las tablas en Supabase)
php artisan migrate

# 6. Cargar datos iniciales (marcas, modelos, estados, admin por defecto)
php artisan db:seed

# 7. Publicar storage (para imágenes de autos)
php artisan storage:link

# 8. Levantar el servidor local
php artisan serve
```

---

## 🔑 Credenciales del Administrador por defecto
| Campo | Valor |
|---|---|
| Email | `admin@autorent.com` |
| Contraseña | `Admin1234!` |
| URL | `http://localhost:8000/admin/login` |

---

## 🗂️ Estructura implementada (Tomás)

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/AuthController.php     ← Login/Registro (cliente + admin)
│   │   │   └── Admin/AutoController.php    ← CRUD de autos (RF3)
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php          ← Protege rutas /admin/*
│   │       └── ClienteAuthMiddleware.php    ← Protege rutas /cliente/*
│   └── Models/
│       ├── Administrador.php (guard: admin)
│       ├── Cliente.php       (guard: cliente)
│       ├── Auto.php
│       ├── Alquiler.php
│       ├── Pago.php
│       ├── Marca.php
│       ├── Modelo.php
│       ├── EstadoAuto.php
│       └── EstadoAlquiler.php
│
├── config/auth.php                  ← Guards separados: admin / cliente
├── routes/web.php                   ← Rutas con prefijos y middlewares
├── bootstrap/app.php                ← Registro de middlewares
│
├── database/
│   ├── migrations/                  ← 9 migraciones en orden correcto
│   └── seeders/DatabaseSeeder.php   ← Datos iniciales
│
└── resources/views/
    ├── layouts/admin.blade.php      ← Layout panel admin (sidebar)
    ├── auth/
    │   ├── admin-login.blade.php
    │   ├── cliente-login.blade.php
    │   └── cliente-register.blade.php
    └── admin/
        ├── dashboard.blade.php
        └── autos/
            ├── index.blade.php      ← Listado de flota
            ├── create.blade.php     ← RF3: Registrar auto
            ├── edit.blade.php
            └── show.blade.php
```

---

## 📐 Diagrama de Base de Datos

```
marcas (id_marca, nombre_marca)
   └──< modelos (id_modelo, nombre_modelo, id_marca→marcas)
             └──< autos (id_auto, precio, anio, imagen, descripcion, id_modelo→modelos, id_estadoAuto→estado_autos)

estado_autos     (id_estadoAuto, estado_auto)
estado_alquileres(id_estadoAlquiler, estado_alquiler)

clientes (id_cliente, nombre, apellido, dni, telefono, direccion, email, contrasena, licencia)
   └──< alquileres (id_reserva, fecha_retiro, fecha_devolucion, hora_retiro, hora_devolucion,
                    precioTotal, id_cliente→clientes, id_auto→autos, id_estadoAlquiler→estado_alquileres)
                └──< pagos (id_pago, monto, medio_pago, fecha_pago, id_reserva→alquileres)

administradores (id_administrador, nombre, apellido, dni, telefono, direccion, email, contrasena)
```

---

## 🔗 Rutas disponibles

### Admin
| Método | URL | Descripción |
|---|---|---|
| GET | `/admin/login` | Login del administrador |
| POST | `/admin/login` | Procesar login |
| POST | `/admin/logout` | Cerrar sesión |
| GET | `/admin/dashboard` | Panel principal |
| GET | `/admin/autos` | Listado de flota |
| GET | `/admin/autos/create` | Formulario nuevo auto (RF3) |
| POST | `/admin/autos` | Guardar nuevo auto |
| GET | `/admin/autos/{id}` | Ver detalle de auto |
| GET | `/admin/autos/{id}/edit` | Editar auto |
| PUT | `/admin/autos/{id}` | Actualizar auto |
| DELETE | `/admin/autos/{id}` | Eliminar auto |

### Cliente
| Método | URL | Descripción |
|---|---|---|
| GET | `/cliente/login` | Login del cliente |
| POST | `/cliente/login` | Procesar login |
| GET | `/cliente/registro` | Formulario de registro |
| POST | `/cliente/registro` | Registrar nuevo cliente |
| POST | `/cliente/logout` | Cerrar sesión |

---

## 📝 Notas para Gastón
- Las rutas del catálogo y flujo de renta van en `routes/web.php` bajo `Route::get('/', ...)` y rutas dentro de `Route::middleware('auth.cliente')`.
- Usá el modelo `Auto::with(['modelo.marca', 'estadoAuto'])->where('estadoAuto.estado_auto', 'Disponible')` para mostrar autos disponibles.
- El guard del cliente es `auth('cliente')` → p.ej: `auth('cliente')->user()->nombre`.
