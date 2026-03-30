# ─────────────────────────────────────────────────────────────────
# GoodPanda — PHP 8.3 FPM + Node.js 20 + SQL Server drivers
# ─────────────────────────────────────────────────────────────────
FROM php:8.3-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    gnupg \
    apt-transport-https \
    && rm -rf /var/lib/apt/lists/*

# ─────────────────────────────────────────
# Install Node.js 20 (for Vite / npm run build)
# ─────────────────────────────────────────
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# ─────────────────────────────────────────
# Install Microsoft ODBC Driver 18 for SQL Server
# ─────────────────────────────────────────
RUN curl -sSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > /usr/share/keyrings/microsoft-prod.gpg \
    && curl -sSL https://packages.microsoft.com/config/debian/12/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 unixodbc-dev \
    && rm -rf /var/lib/apt/lists/*

# ─────────────────────────────────────────
# Install PHP extensions
# ─────────────────────────────────────────
RUN docker-php-ext-install \
    pdo \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    xml \
    intl

# Install sqlsrv and pdo_sqlsrv via PECL
RUN pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# ─────────────────────────────────────────
# Composer
# ─────────────────────────────────────────
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ─────────────────────────────────────────
# Entrypoint script — runs on every container start
# ─────────────────────────────────────────
COPY Docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

# Create non-root user
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

USER www

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]