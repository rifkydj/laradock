# FrankenPHP Configuration for Laradock

This directory contains the FrankenPHP configuration for Laradock. FrankenPHP is a modern PHP application server that uses Caddy as its web server.

## Overview

- **Service Name**: `frankenphp`
- **HTTP Port**: `8085` (as per your .env: `FRANKENPHP_HOST_HTTP_PORT=8085`)
- **HTTPS Port**: `8445` (as per your .env: `FRANKENPHP_HOST_HTTPS_PORT=8445`)
- **PHP Version**: `8.3` (as per your .env: `FRANKENPHP_VERSION=php8.3`)

## Files

- **Dockerfile**: Contains the FrankenPHP Docker image configuration
- **Caddyfile**: Caddy web server configuration (used by FrankenPHP to serve requests)

## Configuration

### Using FrankenPHP

To use FrankenPHP instead of nginx, you have several options:

#### Option 1: Run FrankenPHP alongside nginx
By default, both nginx and FrankenPHP can run together:
- Nginx will be on port `8083`
- FrankenPHP will be on port `8085`

```bash
docker-compose up -d frankenphp nginx
```

#### Option 2: Run only FrankenPHP
If you want to use only FrankenPHP:

```bash
docker-compose up -d frankenphp
```

Access your application at: `http://localhost:8085`

### Modifying Caddyfile

Edit the `Caddyfile` to customize how FrankenPHP serves your application:

```caddy
# Simple Laravel/PHP application
:80
root * /var/www/public
php_fastcgi localhost:9000
encode gzip
file_server
try_files {path} {path}/ /index.php?{query}
```

### Environment Variables

The following environment variables from your `.env` file are used:

- `FRANKENPHP_VERSION`: PHP version (default: `php8.3`)
- `FRANKENPHP_HOST_HTTP_PORT`: HTTP port on host (default: `8085`)
- `FRANKENPHP_HOST_HTTPS_PORT`: HTTPS port on host (default: `8445`)
- `APP_CODE_PATH_HOST`: Path to your application code
- `APP_CODE_PATH_CONTAINER`: Container path (default: `/var/www`)
- `APP_CODE_CONTAINER_FLAG`: Container flag (default: `:cached`)

## Common Issues and Solutions

### Issue: Port already in use
If port 8085 is already in use, modify in `.env`:
```env
FRANKENPHP_HOST_HTTP_PORT=8086
FRANKENPHP_HOST_HTTPS_PORT=8446
```

### Issue: Application not found
Make sure your application is accessible at `/var/www` in the container. The container mounts `APP_CODE_PATH_HOST` to `APP_CODE_PATH_CONTAINER`.

### Issue: Can't connect to database
Make sure you're using the service name as the hostname:
- For MySQL: `mysql` or use the `DOCKER_HOST_IP` with exposed ports
- For PostgreSQL: `postgres`
- For Redis: `redis`

## Logs

To view FrankenPHP logs:

```bash
docker-compose logs -f frankenphp
```

## Rebuilding

After changing the Dockerfile or Caddyfile, rebuild the image:

```bash
docker-compose build --no-cache frankenphp
docker-compose up -d frankenphp
```

## Accessing from Host

- HTTP: `http://localhost:8085`
- HTTPS: `https://localhost:8445` (self-signed certificate)

## Performance Tips

1. **Enable Caching**: The Caddyfile includes gzip compression by default
2. **PHP Extensions**: Common extensions are pre-installed:
   - curl, pdo_mysql, pdo_pgsql, iconv, xml, gd, zip

3. **Worker Processes**: FrankenPHP automatically manages PHP-FPM processes

## Useful Commands

```bash
# Start FrankenPHP
docker-compose up -d frankenphp

# Stop FrankenPHP
docker-compose stop frankenphp

# Restart FrankenPHP
docker-compose restart frankenphp

# Execute command in container
docker-compose exec frankenphp bash

# View logs
docker-compose logs -f frankenphp

# Remove and rebuild
docker-compose down
docker-compose build --no-cache frankenphp
docker-compose up -d frankenphp
```

## Documentation

- [FrankenPHP Documentation](https://frankenphp.dev)
- [Caddy Documentation](https://caddyserver.com)
- [Laradock Documentation](https://laradock.io)

