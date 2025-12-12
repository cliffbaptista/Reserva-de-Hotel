FROM php:8.3-fpm

# Argumentos
ARG USER=www-data
ARG UID=1000

# Atualiza mirrors e instala dependências
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        zip \
        unzip \
    && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP
RUN docker-php-ext-install pdo_mysql bcmath gd zip exif pcntl

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria usuário do sistema
RUN useradd -G www-data,root -u $UID -d /home/$USER $USER || echo "User already exists"
RUN mkdir -p /home/$USER/.composer && \
    chown -R $USER:$USER /home/$USER

# Define diretório de trabalho
WORKDIR /var/www

# Permissões
COPY --chown=www-data:www-data . /var/www

# Troca usuário
USER $USER

EXPOSE 9000

CMD ["php-fpm"]