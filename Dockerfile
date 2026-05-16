# 1. Usa a imagem oficial do PHP com Apache
FROM php:8.2-apache

# 2. Instala dependências do sistema necessárias para o Composer e extensões PHP comuns (como zip e pdo)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# 3. Habilita o mod_rewrite do Apache (essencial se você estiver usando Laravel ou rotas amigáveis)
RUN a2enmod rewrite

# 4. Copia o instalador do Composer de sua imagem oficial para dentro do nosso container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Define o diretório de trabalho padrão dentro do container
WORKDIR /var/www/html

# 6. Copia todos os arquivos do seu projeto do EC2 para dentro do container
# (Como configuramos o .gitignore, a pasta 'vendor' não será copiada)
COPY . .

# 7. O COMANDO CHAVE: Instala as dependências do Composer de forma otimizada para produção
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 8. Ajusta as permissões de arquivos para o Apache conseguir ler o projeto corretamente
RUN chown -R www-data:www-data /var/www/html

# 9. Expõe a porta padrão do servidor web
EXPOSE 80
