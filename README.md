# 🏢 **PsicoAlianza - Prueba Técnica**  

**Aplicación web para la gestión de empleados y nómina, desarrollada como parte de una prueba técnica para el puesto de desarrollador backend en PsicoAlianza.**  

-----------------------------------------

## 🚀 **Funciones Principales**  

- 🧑‍💼 **Gestión de Empleados:** Crear, listar, actualizar y eliminar empleados de forma lógica.  
- 📌 **Relaciones Jerárquicas:** Asociación de empleados con cargos y asignación de jefes inmediatos.  
- 🌎 **Ubicación Dinámica:** Selección de ciudad según el país de nacimiento.  
- 🔒 **Validaciones de Datos:** Protección contra registros inválidos y relaciones incorrectas.  
- 🛠️ **Desarrollo Modular:** Implementación siguiendo buenas prácticas con Laravel 8.

-----------------------------------------

## 🛠 **Instalación del Proyecto**  

1. **Clonar repositorio** 🖥️  
   Clona el repositorio con el siguiente comando:  
   `git clone https://github.com/danielpg10/psicoalianza-prueba-tecnica.git`  
   Luego, navega al directorio del proyecto:  
   `cd psicoalianza-prueba-tecnica`

2. **Instalar dependencias** 🔧  
   Para instalar las dependencias del proyecto, usa el siguiente comando:  
   `composer install`

3. **Configurar entorno Laravel** ⚙️  
   Copia el archivo de configuración de entorno:  
   `cp .env.example .env`  
   Genera la clave de la aplicación Laravel con:  
   `php artisan key:generate`

4. **Crear base de datos** 🗄️  
   Crea la base de datos SQLite con el comando:  
   `touch database/database.sqlite`

5. **Ejecutar migraciones con datos iniciales** 🔄  
   Ejecuta las migraciones y los datos iniciales con el siguiente comando:  
   `php artisan migrate:fresh`

6. **Iniciar el servidor** 🚀  
   Inicia el servidor de desarrollo con:  
   `php artisan serve`

🔍 **Acceder a:** [http://localhost:8000](http://localhost:8000)

-----------------------------------------

## 📬 **Contacto**  

Desarrollado por **Marlon Daniel Portuguez Gómez**  

📧 Email: [danielpg2020md@gmail.com](https://mail.google.com/mail/?view=cm&fs=1&to=danielpg2020md@gmail.com)  
🔗 LinkedIn: [linkedin.com/in/marlon-daniel-portuguez-gomez-65271231a](https://www.linkedin.com/in/marlon-daniel-portuguez-gomez-65271231a/)  
🔗 GitHub: [github.com/danielpg10](https://github.com/danielpg10)
