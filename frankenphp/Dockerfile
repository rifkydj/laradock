ARG FRANKENPHP_VERSION=latest
FROM dunglas/frankenphp:${FRANKENPHP_VERSION}

LABEL maintainer="FrankenPHP Laradock Integration (Worker Mode)"

ARG CHANGE_SOURCE=false
ARG APP_CODE_PATH_CONTAINER=/var/www

# Set Environment Variables
ENV DEBIAN_FRONTEND noninteractive
ENV FRANKENPHP_WORKER_MODE=true
ENV FRANKENPHP_WORKERS=4

WORKDIR ${APP_CODE_PATH_CONTAINER}

# If you're in China, or you need to change sources
RUN if [ ${CHANGE_SOURCE} = true ]; then \
    sed -i 's/deb.debian.org/mirrors.aliyun.com/' /etc/apt/sources.list.d/debian.sources \
;fi

# ...existing code...

# Install PHP extensions (same as PHP-FPM setup)
# Install core extensions with proper error handling
RUN set -ex && \
    docker-php-ext-configure zip 2>/dev/null || true && \
    docker-php-ext-install zip 2>/dev/null || true && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql pdo_sqlite 2>/dev/null || true && \
    docker-php-ext-install mysqli 2>/dev/null || true && \
    docker-php-ext-install bcmath 2>/dev/null || true && \
    docker-php-ext-install intl 2>/dev/null || true && \
    docker-php-ext-install opcache 2>/dev/null || true && \
    docker-php-ext-install exif 2>/dev/null || true && \
    docker-php-ext-install calendar 2>/dev/null || true && \
    docker-php-ext-install soap 2>/dev/null || true && \
    docker-php-ext-install xsl 2>/dev/null || true && \
    docker-php-ext-install pcntl 2>/dev/null || true && \
    docker-php-ext-install gettext 2>/dev/null || true && \
    docker-php-ext-install sockets 2>/dev/null || true || true

# Create php.ini with memory limit and other settings
RUN mkdir -p /usr/local/etc/php/conf.d && \
    echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory.ini && \
    echo "max_execution_time=300" >> /usr/local/etc/php/conf.d/memory.ini && \
    echo "upload_max_filesize=100M" >> /usr/local/etc/php/conf.d/memory.ini && \
    echo "post_max_size=100M" >> /usr/local/etc/php/conf.d/memory.ini

# Copy FrankenPHP worker bootstrap script (not inside the app volume mount)
COPY worker.php /var/frankenphp-worker.php

# Expose ports (80 for HTTP, 443 for HTTPS)
EXPOSE 80 443

# Caddyfile for worker mode with proper configuration (i4t-platform)
RUN test -f /etc/caddy/Caddyfile || cat > /etc/caddy/Caddyfile << 'CADDYEOF'
{
    frankenphp {
        worker {
            file /var/frankenphp-worker.php
            num 4
        }
    }
}

:80 {
    root * /var/www/i4t-platform/public
    php_server
}
CADDYEOF

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/ || exit 1

# Run FrankenPHP in worker mode (optimal for production)
# Worker mode pre-loads the application once and reuses it across requests
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
