# Usa la imagen base de PHP con Apache
FROM php:8.2-apache

# Instala las extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copia el contenido de tu aplicación al contenedor
COPY ./src /var/www/html
COPY ./public /var/www/html/public

# Configurar permisos adecuados
RUN chown -R www-data:www-data /var/www/html
