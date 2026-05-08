# FrankenPHP - Database Drivers Setup

## ✅ Status: COMPLETE

Successfully configured FrankenPHP with all database drivers from PHP-FPM!

## 📦 Available Extensions

### PDO Drivers (Database Support)
✓ **PDO** - PHP Data Objects
  - pdo_sqlite (SQLite databases)
  - pdo_mysql (MySQL/MariaDB databases)
  - pdo_pgsql (PostgreSQL databases)

### Database Extensions
✓ **MySQLnd** - MySQL native driver
✓ **mysqli** - MySQL Improved extension

### Core PHP Extensions
✓ **bcmath** - Arbitrary precision mathematics
✓ **intl** - Internationalization
✓ **opcache** - PHP bytecode caching
✓ **exif** - Read EXIF metadata
✓ **calendar** - Calendar functions
✓ **soap** - SOAP/WSDL support
✓ **xsl** - XSL transformations
✓ **pcntl** - Process control
✓ **gettext** - Translation functions
✓ **sockets** - Socket operations
✓ **zip** - ZIP file support

## 🔍 Verify Available Drivers

```bash
# Check all PDO drivers
docker compose exec -T frankenphp php -r "print_r(PDO::getAvailableDrivers());"

# Check loaded modules
docker compose exec -T frankenphp php -m

# List MySQL/Database support
docker compose exec -T frankenphp php -r "echo 'MySQLnd: ' . (extension_loaded('mysqlnd') ? 'YES' : 'NO') . PHP_EOL;"
```

## 📝 Test Database Connections

### Test SQLite (Always works)
```bash
docker compose exec -T frankenphp php << 'EOF'
<?php
try {
    $pdo = new PDO('sqlite::memory:');
    echo "✓ SQLite connection: SUCCESS\n";
} catch (Exception $e) {
    echo "✗ SQLite connection: " . $e->getMessage() . "\n";
}
?>
EOF
```

### Test MySQL
```bash
# Make sure MySQL is running first
docker compose up -d mysql
```

Then test:
```bash
docker compose exec -T frankenphp php << 'EOF'
<?php
try {
    $pdo = new PDO(
        'mysql:host=mysql:3306;dbname=default',
        'default',
        'secret'
    );
    echo "✓ MySQL connection: SUCCESS\n";
} catch (PDOException $e) {
    echo "✗ MySQL connection: " . $e->getMessage() . "\n";
}
?>
EOF
```

### Test PostgreSQL
```bash
# Make sure PostgreSQL is running first
docker compose up -d postgres
```

Then test:
```bash
docker compose exec -T frankenphp php << 'EOF'
<?php
try {
    $pdo = new PDO(
        'pgsql:host=postgres;port=5432;dbname=default',
        'default',
        'secret'
    );
    echo "✓ PostgreSQL connection: SUCCESS\n";
} catch (PDOException $e) {
    echo "✗ PostgreSQL connection: " . $e->getMessage() . "\n";
}
?>
EOF
```

## 🔧 Configuration

### PHP Settings
- **Memory Limit**: 512M
- **Max Execution Time**: 300 seconds
- **Upload Max Filesize**: 100M
- **POST Max Size**: 100M

Edit these in: `/frankenphp/php.ini`

### Caddyfile Web Server
Located at: `/frankenphp/Caddyfile`

Configuration:
```caddyfile
:80 {
    root * /var/www/public
    php {
        root /var/www/public
    }
    file_server
}
```

## 📊 Comparison: Nginx + PHP-FPM vs FrankenPHP

| Feature | Nginx + PHP-FPM | FrankenPHP |
|---------|-----------------|-----------|
| PHP Version | 8.3 | 8.3 |
| PDO Drivers | ✓ | ✓ |
| MySQLnd | ✓ | ✓ |
| Database Support | MySQL, PostgreSQL, SQLite | MySQL, PostgreSQL, SQLite |
| Port | 8083 | 8085 |
| Web Server | Nginx | Caddy (built-in) |
| Memory Limit | 512M | 512M |
| Extensions | Full set | Full set |

## 🚀 Access Your Applications

- **FrankenPHP**: http://localhost:8085
- **Nginx**: http://localhost:8083
- **PHP-FPM**: Internally available (communicates via socket/port 9000)

## 📋 Files Modified/Created

1. **Dockerfile** (`/frankenphp/Dockerfile`)
   - Updated with all PHP extensions
   - Added development libraries for extension compilation
   - Configured Caddyfile for proper PHP execution

2. **Caddyfile** (`/frankenphp/Caddyfile`)
   - Web server configuration
   - Root directory set to /var/www/public
   - PHP handler enabled

3. **php.ini** (`/frankenphp/php.ini`)
   - Memory limit: 512M
   - Max execution time: 300s
   - File upload settings

## ✨ Next Steps

1. **Deploy Your Application**
   ```bash
   # Copy your application code to /var/www/public
   cp -r your_app/* /var/www/public/
   ```

2. **Test Database Connections**
   ```bash
   # Update your application's database configuration to use:
   # - Host: mysql (for MySQL)
   # - Host: postgres (for PostgreSQL)
   # - Driver: mysql or pgsql (both via PDO)
   ```

3. **Monitor Performance**
   ```bash
   # Check error logs
   docker compose logs -f frankenphp
   
   # Check resource usage
   docker stats i4t-2-frankenphp-1
   ```

## 🆘 Troubleshooting

### Error: "could not find driver"
✓ **FIXED** - All PDO drivers now installed and enabled

### PHP Extension Not Loaded
Check with:
```bash
docker compose exec -T frankenphp php -m | grep extension_name
```

### Database Connection Failed
1. Verify database container is running: `docker compose ps`
2. Check database credentials in your application
3. Verify the database service is accessible from the network

## 📞 Support

For issues with:
- **Database Connections**: Check docker compose services are running
- **PHP Extensions**: Run `docker compose exec -T frankenphp php -m`
- **Server Issues**: Check `docker compose logs frankenphp`

---

**FrankenPHP Configuration Complete!** 🎉
All extensions from Nginx/PHP-FPM are now available in FrankenPHP.

