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

# 3. ALTERAÇÃO AQUI: Configura o PHP para esconder avisos de Deprecated e Warnings na tela
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    sed -i 's/display_errors = On/display_errors = Off/g' "$PHP_INI_DIR/php.ini" && \
    sed -i 's/error_reporting = .*/error_reporting = E_ALL \& ~E_DEPRECATED \& ~E_WARNING \& ~E_NOTICE/g' "$PHP_INI_DIR/php.ini"

# 4. Copia o Composer oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Permite que o Composer rode como root na máquina de build sem avisos
ENV COMPOSER_ALLOW_SUPERUSER=1

# 5. Define diretório e copia o projeto todo
WORKDIR /var/www/html
COPY . .

# 6. ALTERAÇÃO AQUI: Garante a pasta dados e dá permissão total de escrita antes de rodar o composer
RUN mkdir -p /var/www/html/dados && chmod -R 775 /var/www/html/dados

# 7. Roda o composer nas pastas corretas
RUN cd /var/www/html/BuscaCEP && composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs
RUN cd /var/www/html/Praticando-20-03 && composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs

# 8. Permissões finais para o usuário do Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
