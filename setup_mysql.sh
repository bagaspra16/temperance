#!/bin/bash

# Setup MySQL Database for Temperance
# Usage: ./setup_mysql.sh

echo "=== Temperance MySQL Setup ==="
echo

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}✓${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_error() {
    echo -e "${RED}✗${NC} $1"
}

# Check if MySQL is installed
check_mysql() {
    if ! command -v mysql &> /dev/null; then
        print_error "MySQL is not installed. Please install MySQL first."
        echo "Ubuntu/Debian: sudo apt-get install mysql-server"
        echo "macOS: brew install mysql"
        echo "CentOS/RHEL: sudo yum install mysql-server"
        exit 1
    fi
    print_status "MySQL is installed"
}

# Check if PHP is installed
check_php() {
    if ! command -v php &> /dev/null; then
        print_error "PHP is not installed. Please install PHP first."
        exit 1
    fi
    print_status "PHP is installed"
}

# Check if Composer is installed
check_composer() {
    if ! command -v composer &> /dev/null; then
        print_error "Composer is not installed. Please install Composer first."
        exit 1
    fi
    print_status "Composer is installed"
}

# Get MySQL credentials
get_mysql_credentials() {
    echo "Enter MySQL root password:"
    read -s MYSQL_PASSWORD
    
    if [ -z "$MYSQL_PASSWORD" ]; then
        print_warning "No password provided, trying without password"
        MYSQL_PASSWORD=""
    fi
}

# Test MySQL connection
test_mysql_connection() {
    if [ -z "$MYSQL_PASSWORD" ]; then
        mysql -u root -e "SELECT 1;" &> /dev/null
    else
        mysql -u root -p"$MYSQL_PASSWORD" -e "SELECT 1;" &> /dev/null
    fi
    
    if [ $? -eq 0 ]; then
        print_status "MySQL connection successful"
    else
        print_error "MySQL connection failed. Please check your credentials."
        exit 1
    fi
}

# Create database
create_database() {
    echo "Creating database 'temperance'..."
    
    if [ -z "$MYSQL_PASSWORD" ]; then
        mysql -u root -e "CREATE DATABASE IF NOT EXISTS temperance CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    else
        mysql -u root -p"$MYSQL_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS temperance CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    fi
    
    if [ $? -eq 0 ]; then
        print_status "Database 'temperance' created successfully"
    else
        print_error "Failed to create database"
        exit 1
    fi
}

# Install dependencies
install_dependencies() {
    echo "Installing PHP dependencies..."
    composer install --no-dev --optimize-autoloader
    
    if [ $? -eq 0 ]; then
        print_status "Dependencies installed successfully"
    else
        print_error "Failed to install dependencies"
        exit 1
    fi
}

# Setup environment file
setup_env() {
    if [ ! -f ".env" ]; then
        if [ -f "mysql.env.example" ]; then
            cp mysql.env.example .env
            print_status "Environment file created from mysql.env.example"
        else
            print_warning "mysql.env.example not found, creating basic .env"
            cat > .env << EOF
APP_NAME=Temperance
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=temperance
DB_USERNAME=root
DB_PASSWORD=$MYSQL_PASSWORD

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
EOF
        fi
    else
        print_warning ".env file already exists, skipping creation"
    fi
}

# Generate application key
generate_key() {
    echo "Generating application key..."
    php artisan key:generate --force
    
    if [ $? -eq 0 ]; then
        print_status "Application key generated"
    else
        print_error "Failed to generate application key"
        exit 1
    fi
}

# Run migrations
run_migrations() {
    echo "Running database migrations..."
    php artisan migrate --force
    
    if [ $? -eq 0 ]; then
        print_status "Database migrations completed"
    else
        print_error "Failed to run migrations"
        exit 1
    fi
}

# Create test user
create_test_user() {
    echo "Creating test user..."
    php artisan tinker --execute="
        \$user = new App\Models\User([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);
        \$user->save();
        echo 'Test user created: ' . \$user->email . ' / password: password';
    "
    
    if [ $? -eq 0 ]; then
        print_status "Test user created successfully"
    else
        print_warning "Failed to create test user (this is optional)"
    fi
}

# Run compatibility tests
run_tests() {
    echo "Running MySQL compatibility tests..."
    php database/scripts/test_mysql_compatibility.php
    
    if [ $? -eq 0 ]; then
        print_status "All compatibility tests passed"
    else
        print_warning "Some compatibility tests failed (check output above)"
    fi
}

# Main setup function
main() {
    echo "Starting Temperance MySQL setup..."
    echo
    
    check_mysql
    check_php
    check_composer
    get_mysql_credentials
    test_mysql_connection
    create_database
    install_dependencies
    setup_env
    generate_key
    run_migrations
    create_test_user
    run_tests
    
    echo
    echo "=== Setup Complete ==="
    echo
    print_status "Temperance is ready to use with MySQL!"
    echo
    echo "Next steps:"
    echo "1. Update .env file with your MySQL credentials if needed"
    echo "2. Run: php artisan serve"
    echo "3. Visit: http://localhost:8000"
    echo "4. Login with: test@example.com / password"
    echo
    echo "For data migration from PostgreSQL, see MIGRATION_STRATEGY.md"
}

# Run main function
main "$@"
