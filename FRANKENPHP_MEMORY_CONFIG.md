# FrankenPHP PHP Memory Configuration Guide

## ✅ Current Configuration

Your FrankenPHP now has:
- **Memory Limit:** 512M
- **Max Execution Time:** 300 seconds
- **Upload Max Filesize:** 100M
- **Post Max Size:** 100M

## 📝 How to Modify PHP Memory Limit

### **Method 1: Edit php.ini File (Easiest)**

Edit `/home/mohamed-rifky/projects/laradock-2/frankenphp/php.ini`:

```ini
# Increase memory limit
memory_limit = 1024M

# Increase execution time
max_execution_time = 600

# Increase file upload size
upload_max_filesize = 500M

# Increase POST data limit
post_max_size = 500M
```

Then restart FrankenPHP:
```bash
docker compose restart frankenphp
```

### **Method 2: Edit Dockerfile (Permanent)**

Edit `/home/mohamed-rifky/projects/laradock-2/frankenphp/Dockerfile`:

Find this section:
```dockerfile
RUN mkdir -p /usr/local/etc/php/conf.d && \
    echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory.ini && \
    echo "max_execution_time=300" >> /usr/local/etc/php/conf.d/memory.ini && \
    echo "upload_max_filesize=100M" >> /usr/local/etc/php/conf.d/memory.ini && \
    echo "post_max_size=100M" >> /usr/local/etc/php/conf.d/memory.ini
```

Change the values:
```dockerfile
RUN mkdir -p /usr/local/etc/php/conf.d && \
    echo "memory_limit=1024M" > /usr/local/etc/php/conf.d/memory.ini && \
    echo "max_execution_time=600" >> /usr/local/etc/php/conf.d/memory.ini && \
    echo "upload_max_filesize=500M" >> /usr/local/etc/php/conf.d/memory.ini && \
    echo "post_max_size=500M" >> /usr/local/etc/php/conf.d/memory.ini
```

Then rebuild:
```bash
docker compose build frankenphp
docker compose up -d frankenphp
```

### **Method 3: Using Environment Variables in docker-compose.yml**

Add to the FrankenPHP service in `docker-compose.yml`:

```yaml
frankenphp:
  environment:
    - PHP_MEMORY_LIMIT=1024M
    - PHP_MAX_EXECUTION_TIME=600
    - PHP_UPLOAD_MAX_FILESIZE=500M
    - PHP_POST_MAX_SIZE=500M
```

## 🔍 Verify Your Settings

Check current PHP memory limit:

```bash
# Access FrankenPHP container
docker compose exec -T frankenphp php -i | grep memory_limit

# Or via web
curl http://localhost:8085/info.php
```

Create a test file at `/var/www/public/info.php`:

```php
<?php
phpinfo();
?>
```

Then visit: `http://localhost:8085/info.php`

## 📋 Common Memory Values

| Use Case | Recommended |
|----------|-------------|
| Small apps | 256M |
| Medium apps | 512M (Current) |
| Large apps | 1024M |
| Very large | 2048M+ |

## 🔧 Other Common PHP Configurations

Edit `frankenphp/php.ini` to adjust:

```ini
# Execution limits
max_execution_time = 300
max_input_time = 60
default_socket_timeout = 60

# File uploads
upload_max_filesize = 100M
post_max_size = 100M
max_file_uploads = 20

# Timeouts
mysql.connect_timeout = 60
mysqli.connect_timeout = 10

# Output buffering
output_buffering = 4096
implicit_flush = Off

# Error handling
display_errors = 1
error_reporting = E_ALL
log_errors = 1

# Session
session.gc_maxlifetime = 1440
session.cache_expire = 180

# Database
mysqli.max_links = 0
pdo_mysql.default_socket = /var/run/mysqld/mysqld.sock
```

## ✅ Steps to Update Memory Limit

1. **Edit the file:**
   ```bash
   nano /home/mohamed-rifky/projects/laradock-2/frankenphp/php.ini
   ```

2. **Update memory_limit:**
   ```ini
   memory_limit = 1024M
   ```

3. **Save and restart:**
   ```bash
   docker compose restart frankenphp
   ```

4. **Verify:**
   ```bash
   docker compose exec -T frankenphp php -r "echo ini_get('memory_limit');"
   ```

## ⚠️ Important Notes

- Changes to `php.ini` take effect immediately after restart
- Higher memory limits use more server resources
- Monitor your server's total available memory
- For production, set realistic limits based on your workload
- The mounted `php.ini` file overrides Dockerfile defaults

## 🚀 Quick Command to Set Memory Limit

```bash
# Set memory limit to 1024M
sed -i 's/memory_limit = 512M/memory_limit = 1024M/' /home/mohamed-rifky/projects/laradock-2/frankenphp/php.ini

# Restart
docker compose restart frankenphp

# Verify
docker compose exec -T frankenphp php -r "echo 'Memory: ' . ini_get('memory_limit') . PHP_EOL;"
```

## 📞 Current Status

✅ **Memory Limit:** 512M  
✅ **Max Execution Time:** 300s  
✅ **Upload Max:** 100M  
✅ **Post Max:** 100M  

Change any of these values in `frankenphp/php.ini` and restart! 🎉

