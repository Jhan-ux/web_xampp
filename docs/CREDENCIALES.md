# Cómo probar el proyecto en XAMPP

## 1. Copiar el proyecto a `htdocs`

Copiá toda esta carpeta (`web_xampp`) dentro de la carpeta `htdocs` de tu instalación de XAMPP:

```
C:\xampp\htdocs\web_xampp\
```

## 2. Iniciar los servicios

Abrí el **Panel de Control de XAMPP** y arrancá:
- **Apache**
- **MySQL**

## 3. Crear la base de datos

Entrá a phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)

Pestaña **Importar** → elegí el archivo `sql/schema.sql` de este proyecto → **Continuar**.

Esto crea la base `bd_entregable`, la tabla `usuarios` y 3 usuarios de prueba.

## 4. Abrir el sitio

En el navegador, entrá a:

```
http://localhost/web_xampp/
```

Te va a redirigir directo al login.

## 5. Usuarios de prueba

| Usuario | Contraseña |
|---------|------------|
| `juan`   | `1234`  |
| `maria`  | `1234`  |
| `carlos` | `admin` |

Las contraseñas están guardadas hasheadas (`password_hash`) en la base de datos, tal cual se deben manejar en producción.

## Notas

- Si copiaste el proyecto con otro nombre de carpeta (no `web_xampp`), la URL cambia: `http://localhost/<nombre_de_tu_carpeta>/`.
- Si `bd_entregable` ya existe con datos viejos, podés borrarla desde phpMyAdmin antes de importar `schema.sql` de nuevo.
- Config de conexión a la base de datos: `config/conexion.php` (usuario `root`, sin contraseña — el default de XAMPP).
