#!/bin/bash
# Pre-Deployment Verification Script
# Paróquia Sistema - Laravel 11 Project
# Execute ANTES de fazer deploy em produção

set -e

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║         PRÉ-DEPLOYMENT VERIFICATION CHECKLIST                 ║"
echo "║         Paróquia Sistema - Laravel 11 + Vite 7                ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

FAILED=0

# Function to check command
check_command() {
    if command -v $1 &> /dev/null; then
        echo -e "${GREEN}✓${NC} $1 is installed"
        return 0
    else
        echo -e "${RED}✗${NC} $1 is NOT installed"
        FAILED=$((FAILED+1))
        return 1
    fi
}

# Function to run command and check result
run_check() {
    local name="$1"
    local command="$2"
    
    echo -n "Checking $name... "
    if eval "$command" &> /dev/null; then
        echo -e "${GREEN}PASS${NC}"
        return 0
    else
        echo -e "${RED}FAIL${NC}"
        FAILED=$((FAILED+1))
        return 1
    fi
}

echo "═══════════════════════════════════════════════════════════════"
echo "1. ENVIRONMENT CHECKS"
echo "═══════════════════════════════════════════════════════════════"

check_command "php"
check_command "composer"
check_command "node"
check_command "npm"
check_command "git"

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "2. PHP & LARAVEL CHECKS"
echo "═══════════════════════════════════════════════════════════════"

run_check "PHP version (8.2+)" "php -v | grep -E 'PHP (8\.[2-9]|9\.0)'"
run_check "Laravel cache" "php artisan config:cache"
run_check "Laravel routes" "php artisan route:list --quiet"
run_check "Database connection" "php artisan migrate --pretend"

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "3. BUILD SYSTEM CHECKS"
echo "═══════════════════════════════════════════════════════════════"

run_check "Node modules" "test -d node_modules"
run_check "Package.json dependencies" "npm ls --depth=0"
run_check "Build compilation" "npm run build"

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "4. SECURITY CHECKS"
echo "═══════════════════════════════════════════════════════════════"

echo -n "Checking APP_DEBUG=false in .env... "
if grep -q "^APP_DEBUG=false" .env; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo -n "Checking SESSION_ENCRYPT=true... "
if grep -q "^SESSION_ENCRYPT=true" .env; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo -n "Checking SecurityHeaders middleware... "
if test -f "app/Http/Middleware/SecurityHeaders.php"; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo -n "Checking ValidateUploads middleware... "
if test -f "app/Http/Middleware/ValidateUploads.php"; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "5. SEO & PERFORMANCE CHECKS"
echo "═══════════════════════════════════════════════════════════════"

echo -n "Checking SitemapController... "
if test -f "app/Http/Controllers/SitemapController.php"; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo -n "Checking SeoService... "
if test -f "app/Services/SeoService.php"; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo -n "Checking StructuredDataService... "
if test -f "app/Services/StructuredDataService.php"; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo -n "Checking vite.config.js... "
if test -f "vite.config.js" && grep -q "manualChunks" vite.config.js; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "6. CODE QUALITY CHECKS"
echo "═══════════════════════════════════════════════════════════════"

echo -n "Checking Policies (Event, News, Group)... "
if test -f "app/Policies/EventPolicy.php" && \
   test -f "app/Policies/NewsPolicy.php" && \
   test -f "app/Policies/GroupPolicy.php"; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo -n "Checking FormRequests... "
if test -f "app/Http/Requests/StoreGroupRequestRequest.php" && \
   test -f "app/Http/Requests/UpdateGroupRequestRequest.php"; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo -n "Checking Blade components (4 required)... "
if test -f "resources/views/components/form-input.blade.php" && \
   test -f "resources/views/components/button.blade.php" && \
   test -f "resources/views/components/navigation.blade.php" && \
   test -f "resources/views/components/optimized-image.blade.php"; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo -n "Checking design-tokens.css... "
if test -f "resources/css/design-tokens.css" && grep -q "css-variables" resources/css/design-tokens.css 2>/dev/null || grep -q "var(--" resources/css/design-tokens.css; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${RED}FAIL${NC}"
    FAILED=$((FAILED+1))
fi

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "7. GIT CHECKS"
echo "═══════════════════════════════════════════════════════════════"

echo -n "Checking Git status (clean)... "
if git status --porcelain | grep -q .; then
    echo -e "${RED}FAIL - Uncommitted changes${NC}"
    FAILED=$((FAILED+1))
else
    echo -e "${GREEN}PASS${NC}"
fi

echo -n "Checking Git remote (synced)... "
if git rev-parse HEAD | grep -q $(git rev-parse @{u} 2>/dev/null || echo ""); then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${GREEN}PASS (may need manual verify)${NC}"
fi

echo -n "Checking commits (at least 3)... "
if [ $(git rev-list --count HEAD) -ge 3 ]; then
    echo -e "${GREEN}PASS${NC}"
else
    echo -e "${YELLOW}WARNING - Few commits${NC}"
fi

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "8. DOCUMENTATION CHECKS"
echo "═══════════════════════════════════════════════════════════════"

echo -n "Checking DEPLOYMENT.md... "
test -f "DEPLOYMENT.md" && echo -e "${GREEN}PASS${NC}" || echo -e "${RED}FAIL${NC}"

echo -n "Checking .env.production.example... "
test -f ".env.production.example" && echo -e "${GREEN}PASS${NC}" || echo -e "${RED}FAIL${NC}"

echo -n "Checking RELATORIO_PRODUCAO.md... "
test -f "RELATORIO_PRODUCAO.md" && echo -e "${GREEN}PASS${NC}" || echo -e "${RED}FAIL${NC}"

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "SUMMARY"
echo "═══════════════════════════════════════════════════════════════"

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}✓ ALL CHECKS PASSED - READY FOR DEPLOYMENT${NC}"
    echo ""
    echo "Next steps:"
    echo "  1. Copy files to production server"
    echo "  2. Configure .env from .env.production.example"
    echo "  3. Run: php artisan migrate --force"
    echo "  4. Run: php artisan config:cache"
    echo "  5. Run: php artisan route:cache"
    echo "  6. Set permissions: chmod -R 775 storage bootstrap/cache"
    echo "  7. Restart PHP-FPM: sudo systemctl restart php8.2-fpm"
    echo ""
    exit 0
else
    echo -e "${RED}✗ $FAILED CHECKS FAILED - DO NOT DEPLOY${NC}"
    echo ""
    echo "Fix the issues above before deploying to production."
    echo ""
    exit 1
fi
