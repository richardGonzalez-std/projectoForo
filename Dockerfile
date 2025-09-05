FROM php:8.2-apache

# Instalar extensiones necesarias para PostgreSQL
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/*
# Habilitar mod_rewrite (opcional, para URLs amigables)
RUN a2enmod rewrite

# Copiar todos los archivos PHP al directorio web de Apache
COPY . /var/www/html/

# Dar permisos correctos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Exponer puerto 80 (Apache usa este por defecto)
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
