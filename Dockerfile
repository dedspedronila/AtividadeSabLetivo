FROM php:8.2-apache

# Instala ferramentas essenciais e extensões PHP necessárias para o Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Copia o Composer da imagem oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório padrão e copia o projeto todo (já ignorando as pastas vendor via .gitignore)
WORKDIR /var/www/html
COPY . .

# ENTRA EM CADA SUBPASTA COM COMPOSER E INSTALA AS DEPENDÊNCIAS
RUN cd "/var/www/html/Busca CEP" && composer install --no-interaction --optimize-autoloader --no-dev
RUN cd "/var/www/html/Praticando-20-03" && composer install --no-interaction --optimize-autoloader --no-dev

# Ajusta as permissões para o servidor web rodar tudo sem travar
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
