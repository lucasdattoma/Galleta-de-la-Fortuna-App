🥠 Galleta de la Fortuna - Aplicación Web

Requisitos Previos

- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Apache
- Node.js y npm



Instalación

1. Clonar el repositorio

git clone https://github.com/lucasdattoma/Galleta-de-la-Fortuna-App.git
cd galleta-fortuna

2. Instalar dependencias de PHP

composer install


3. Configurar el archivo de entorno

cp .env.example .env

Edita el archivo '.env' y configura tu base de datos:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fortuna
DB_USERNAME=root
DB_PASSWORD=tu_contraseña


4. Generar la clave de aplicación

php artisan key:generate

5. Crear la base de datos

Crea una base de datos MySQL llamada 'fortuna' y luego en una query ejecuta esto:
CREATE DATABASE fortuna CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

6. Ejecutar migraciones

php artisan migrate

7. Ejecutar seeders

php artisan db:seed

Esto creará:
- 2 roles: 'usuario' y 'Admin'
- 1 usuario administrador
- 29 mensajes de fortuna predefinidos

8. Iniciar el servidor

php artisan serve


La aplicación estará disponible en: 'http://localhost:8000'

Credenciales de Prueba

Administrador:
Email: admin@admin.com
Password: admin123

Usuario Normal:
??

Testing

php artisan test
