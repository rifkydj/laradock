# FrankenPHP Setup Complete! 🚀

## What Was Done

Your Laradock environment has been successfully configured with FrankenPHP running on port **8085** alongside your existing Nginx (port 8083). Both services will run independently without affecting each other.

## Files Created

```
/frankenphp/
├── Dockerfile          - FrankenPHP container image definition
├── Caddyfile          - Web server configuration (Caddy)
├── README.md          - Detailed documentation
└── .dockerignore      - Build optimization
```

## Configuration Summary

### Nginx (Your Current Setup)
- **Port**: 8083 (HTTP) / 8443 (HTTPS)
- **Status**: ✅ Unchanged

### FrankenPHP (Newly Added)
- **Port**: 8085 (HTTP) / 8445 (HTTPS)
- **PHP Version**: 8.3
- **Status**: ✅ Ready to use

## Environment Variables (Already in .env)

```env
FRANKENPHP_HOST_HTTP_PORT=8085
FRANKENPHP_HOST_HTTPS_PORT=8445
FRANKENPHP_VERSION=php8.3
```

## Quick Start

### 1. Build the FrankenPHP image
```bash
docker-compose build frankenphp
```

### 2. Start FrankenPHP alongside Nginx
```bash
docker-compose up -d frankenphp nginx
```

### 3. Access your applications
- **Nginx**: http://localhost:8083
- **FrankenPHP**: http://localhost:8085

### 4. View logs
```bash
docker-compose logs -f frankenphp
```

## How It Works

**FrankenPHP** = **PHP 8.3 + Caddy Web Server**

- FrankenPHP runs PHP applications directly (no need for separate PHP-FPM)
- It uses Caddy as the built-in web server
- Your application code is served from `/var/www` (same as nginx)
- Both are connected to the same Docker networks (`frontend` and `backend`)

## Customization

### Modify Caddyfile
Edit `/frankenphp/Caddyfile` to configure how your application is served:

```caddy
:80
root * /var/www/public
php_fastcgi localhost:9000
encode gzip
file_server
```

### Change PHP Version
Edit `.env`:
```env
FRANKENPHP_VERSION=php8.4  # or php8.3, php8.2, etc.
```

Then rebuild:
```bash
docker-compose build --no-cache frankenphp
docker-compose up -d frankenphp
```

## Database and Services

Both Nginx and FrankenPHP can access:
- MySQL: `mysql`
- PostgreSQL: `postgres`
- Redis: `redis`
- All other services as configured

## Running Commands

```bash
# Run PHP command in FrankenPHP
docker-compose exec frankenphp php -v

# Composer
docker-compose exec frankenphp composer --version

# Laravel artisan
docker-compose exec frankenphp php artisan migrate

# Bash shell
docker-compose exec frankenphp bash
```

## Stopping Services

```bash
# Stop only FrankenPHP
docker-compose stop frankenphp

# Stop only Nginx
docker-compose stop nginx

# Stop all
docker-compose down
```

## Troubleshooting

### Port Already in Use
Edit `.env`:
```env
FRANKENPHP_HOST_HTTP_PORT=8086
FRANKENPHP_HOST_HTTPS_PORT=8446
```

### Permission Issues
Make sure your application code directory has proper permissions:
```bash
chmod -R 755 ../  # Adjust path as needed
```

### Can't Access Application
1. Verify the application is running: `docker-compose logs frankenphp`
2. Check if port 8085 is accessible: `curl http://localhost:8085`
3. Verify your Caddyfile points to the correct directory

## Important Notes

✅ **Your nginx setup remains untouched**
✅ **All other services (MySQL, Redis, etc.) work with both**
✅ **Can run both nginx and FrankenPHP simultaneously**
✅ **Easy to switch between them by stopping one service**

## Next Steps

1. Review the `Caddyfile` configuration
2. Run `docker-compose build frankenphp`
3. Run `docker-compose up -d frankenphp`
4. Visit `http://localhost:8085` in your browser

Happy coding! 🎉

