FROM php:8.3-apache

# 1. Instalar extensiones necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql gd

# 2. Configurar Apache (Habilitar mod_rewrite para Laravel y evitar conflicto MPM)
RUN a2dismod mpm_event mpm_worker 2>/dev/null || true
RUN a2enmod mpm_prefork rewrite || true
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# 3. Copiar el código al contenedor
WORKDIR /var/www/html
COPY . .

# 4. Instalar Composer y dependencias
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# 5. Permisos para carpetas de Laravel
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# 6. Exponer puerto y comando de inicio (Compatible con puerto dinámico de Railway)
EXPOSE 8000
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}