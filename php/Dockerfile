# Utilizar una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilitar módulos de Apache
RUN a2enmod rewrite

# Instalar el cliente PostgreSQL y sus extensiones PHP
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar la extensión MySQLi
RUN docker-php-ext-install mysqli

# Establecer el directorio de trabajo en /var/www/html
WORKDIR /var/www/html

# Copiar el contenido del código PHP desde ../html al contenedor en /var/www/html
COPY ../html .

