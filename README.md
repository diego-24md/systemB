# SystemB - Sistema de Biblioteca Escolar Chinchaysuyo

Sistema de gestión de biblioteca escolar desarrollado en **CodeIgniter 4**, con módulo administrativo y módulo para alumnas (catálogo, reservas, préstamos, notificaciones y reportes).

## Requisitos previos

- PHP 8.1 o superior
- Composer
- MySQL
- Servidor local (XAMPP)

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/diego-24md/systemB.git
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Copiar el template SB Admin 2

El proyecto usa la plantilla **SB Admin 2**. Su carpeta `vendor` debe copiarse dentro de la carpeta `public`.

Descargar desde:

https://startbootstrap.com/theme/sb-admin-2

Una vez descargado, copiar la carpeta `vendor` del template dentro de la carpeta `public` del proyecto:

```
public/
 └── vendor/   <-- carpeta de SB Admin 2 (CSS/JS del template)
```

> ⚠️ Esta carpeta no se sube al repositorio (está en `.gitignore`), por lo que debe copiarse manualmente desde el proyecto original o solicitarla al desarrollador.

### 4. Configurar variables de entorno

Copiar el archivo `env` y renombrarlo a `.env`:

Editar el archivo `.env` con los siguientes valores:

```env
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = systemB
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

> ⚠️ Crear primero la base de datos vacía en MySQL:
> ```sql
> CREATE DATABASE systemB;
> ```

### 5. Instalar librería para subir alumnas en Excel

```bash
composer require phpoffice/phpspreadsheet
```

### 6. Ejecutar las migraciones

```bash
php spark migrate
```

### 7. Ejecutar el seeder principal

```bash
php spark db:seed DatabaseSeeder
```

### 8. Levantar el servidor

```bash
php spark serve
```

El proyecto quedará disponible en:

```
http://localhost:8080
```

## Acceso al sistema

- Administrador (completar con las siguientes credenciales)

| Campo       | Claves            |
|-------------|-------------------|
| Usuario     | `bibliotecario`   |
| Contraseña  | `bibliotecario123`|

- **Alumna:** `DNI / Apellido Paterno` (completar con credenciales de prueba)

| Campo       | Claves            |
|-------------|-------------------|
| DNI         |     `68929686`    |
| Apellido    |       `APAZA`     |

** Para que las credenciales de ALUMNA DE PRUEBA funcione se tiene que importar un archivo de EXCEL 'nomina_1A_prueba'. Una vez subido el archivo se puede ingresar con cualquier dni y apellido. **

## Estructura principal

```
app/
 ├── Controllers/
 ├── Models/
 ├── Views/
 └── Database/
     ├── Migrations/  # Definición de tablas
     └── Seeds/        # DatabaseSeeder
public/
 └── vendor/        # Plantilla SB Admin 2 (copiar manualmente)
```

## Notas de diseño

- Tema oscuro (azul marino `#1b2436`) con acentos dorados (`#FFCC00`)
- Confirmaciones mediante `confirm()` nativo de JavaScript

## Problemas comunes

- **Errores de sintaxis falsos marcados por Intelephense**
- **Error de conexión a la base de datos**: revisar usuario/contraseña en `.env`.
- **Tablas no encontradas**: asegurarse de correr `php spark migrate` antes del seeder.
- **Estilos del template no cargan**: verificar que la carpeta `public/vendor` (SB Admin 2) esté presente.
- **Página en blanco**: verificar `CI_ENVIRONMENT = development` para ver errores detallados.