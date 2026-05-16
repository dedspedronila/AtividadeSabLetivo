FROM php:8.2-apache

# 1. Instala dependências e extensões essenciais para requisições e zip
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    curl \
    libcurl4-openssl-dev \
    && docker-php-ext-install zip pdo pdo_mysql curl

# 2. Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# 3. Copia o Composer oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Permite que o Composer rode como root na máquina de build sem avisos
ENV COMPOSER_ALLOW_SUPERUSER=1

# 4. Define diretório e copia o projeto
WORKDIR /var/www/html
COPY . .

# 5. Roda o composer ignorando pequenas travas de plataforma local
RUN cd "/var/www/html/Busca CEP" && composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs
RUN cd "/var/www/html/Praticando-20-03" && composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs

# 6. Permissões finais
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
