#!/bin/bash

# 🔍 Pre-deployment verification script
# Run this before deploying to production

set -e

echo "🔍 Running pre-deployment checks..."
echo ""

# Check PHP version
PHP_VERSION=$(php -v | grep -oP 'PHP \K[0-9]+\.[0-9]+')
echo "✓ PHP version: $PHP_VERSION (requires 8.2+)"

# Check required extensions
REQUIRED_EXTENSIONS=("pdo" "pdo_mysql" "mbstring" "openssl" "json" "tokenizer" "curl" "intl")
for ext in "${REQUIRED_EXTENSIONS[@]}"; do
    if php -m | grep -q "^$ext$"; then
        echo "✓ PHP extension: $ext"
    else
        echo "✗ Missing PHP extension: $ext"
        exit 1
    fi
done

# Check Composer
if ! command -v composer &> /dev/null; then
    echo "✗ Composer not found"
    exit 1
fi
echo "✓ Composer installed"

# Check Node.js
if ! command -v node &> /dev/null; then
    echo "✗ Node.js not found"
    exit 1
fi
NODE_VERSION=$(node -v)
echo "✓ Node.js: $NODE_VERSION"

# Check .env file
if [ ! -f .env ]; then
    echo "✗ .env file not found"
    exit 1
fi
echo "✓ .env file exists"

# Check APP_KEY
if grep -q "APP_KEY=$" .env; then
    echo "✗ APP_KEY not set in .env"
    exit 1
fi
echo "✓ APP_KEY configured"

# Check database connection
if grep -q "DB_HOST=" .env; then
    echo "✓ Database configuration found"
else
    echo "✗ Database configuration missing"
    exit 1
fi

# Check if database is reachable
DB_HOST=$(grep "DB_HOST" .env | cut -d '=' -f 2)
DB_PORT=$(grep "DB_PORT" .env | cut -d '=' -f 2)
if command -v mysql &> /dev/null; then
    if mysql -h "$DB_HOST" -P "${DB_PORT:=3306}" -e "SELECT 1" &> /dev/null; then
        echo "✓ Database connection successful"
    else
        echo "⚠ Warning: Could not verify database connection"
    fi
fi

# Check directory permissions
DIRS=("bootstrap/cache" "storage" "public")
for dir in "${DIRS[@]}"; do
    if [ -d "$dir" ]; then
        if [ -w "$dir" ]; then
            echo "✓ Writable directory: $dir"
        else
            echo "⚠ Warning: Directory not writable: $dir"
        fi
    fi
done

# Check disk space
DISK_USAGE=$(df . | tail -1 | awk '{print $5}' | sed 's/%//')
if [ "$DISK_USAGE" -gt 80 ]; then
    echo "⚠ Warning: Disk usage at ${DISK_USAGE}%"
else
    echo "✓ Disk space: ${DISK_USAGE}% used"
fi

echo ""
echo "✅ Pre-deployment checks passed!"
echo ""
echo "Next steps:"
echo "1. Review .env configuration: nano .env"
echo "2. Run: composer install --no-dev --optimize-autoloader"
echo "3. Run: npm ci && npm run build"
echo "4. Run: php artisan migrate --force"
echo "5. Run: php artisan config:cache && php artisan route:cache"
echo ""
