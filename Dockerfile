# Stage 1: pegar o composer
FROM composer:2 AS composer_stage

# Stage 2: app Laravel com PHP + Node
FROM php:8.3-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    curl \
    && docker-php-ext-install pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Node.js (via nvm simplificado)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && node -v \
    && npm -v

# Copiar composer do stage anterior
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# Diretório da aplicação
WORKDIR /var/www/html

# Copiar arquivos de definição primeiro (cache de build melhor)
COPY composer.json composer.lock package.json package-lock.json* vite.config.* ./

# Instalar dependências PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Instalar dependências JS
RUN npm install

# Copiar o resto do projeto
COPY . .

# Build dos assets (produção)
RUN npm run build

# Ajustar permissões das pastas de storage/cache (se quiser garantir)
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && chmod -R 777 storage bootstrap/cache

# Copiar entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]
