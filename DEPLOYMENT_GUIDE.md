# HexaTP CMS - Deployment Guide for Hostinger

## Overview

This guide will help you deploy the Country Content CMS to Hostinger hosting. The deployment process takes approximately 30-45 minutes.

## Prerequisites

Before you begin, ensure you have:

- ✅ Hostinger hosting account with PHP 7.4+ support
- ✅ MySQL database access
- ✅ FTP/SFTP access or File Manager access
- ✅ SSH access (optional, but recommended)

## Deployment Steps

### Step 1: Prepare Your Database

#### 1.1 Create MySQL Database

1. Login to Hostinger control panel (hPanel)
2. Go to **Databases** → **MySQL Databases**
3. Click **Create New Database**
4. Database name: `hexatp_cms` (or your preferred name)
5. Create a database user with a strong password
6. Grant **ALL PRIVILEGES** to the user
7. **Save the credentials**:
   - Database name: `_________________`
   - Database user: `_________________`
   - Database password: `_________________`
   - Database host: `localhost` (usually)

#### 1.2 Note Your Database Connection Details

You'll need these for the next step:
```
DB_HOST: localhost
DB_NAME: your_database_name
DB_USER: your_database_user
DB_PASS: your_database_password
```

---

### Step 2: Upload Files to Hostinger

#### Option A: Using File Manager (Easier)

1. Login to Hostinger hPanel
2. Go to **Files** → **File Manager**
3. Navigate to `public_html` directory
4. Upload all project files:
   - `admin/` folder
   - `api/` folder
   - `migrations/` folder
   - `models/` folder
   - `repositories/` folder
   - `services/` folder
   - `scripts/` folder
   - `db_config.php`
   - All country HTML files (australia.html, egypt.html, etc.)

#### Option B: Using FTP/SFTP (Recommended)

1. Use FileZilla or any FTP client
2. Connect to your Hostinger account:
   - Host: Your domain or FTP hostname
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21 (FTP) or 22 (SFTP)
3. Upload all files to `public_html` directory

---

### Step 3: Configure Database Connection

#### 3.1 Edit db_config.php

1. Open `db_config.php` in File Manager or FTP
2. Update the database credentials:

```php
<?php
/**
 * Database Configuration
 */

// Database credentials
define('DB_HOST', 'localhost');           // Change if needed
define('DB_NAME', 'your_database_name');  // Your database name
define('DB_USER', 'your_database_user');  // Your database user
define('DB_PASS', 'your_database_password'); // Your database password

/**
 * Get database connection
 */
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    
    return $conn;
}
```

3. Save the file

---

### Step 4: Run Database Migrations

#### Option A: Using SSH (Recommended)

1. Connect to your server via SSH:
   ```bash
   ssh your_username@your_domain.com
   ```

2. Navigate to your project directory:
   ```bash
   cd public_html
   ```

3. Run migrations:
   ```bash
   php migrations/migrate.php
   ```

4. You should see:
   ```
   ✓ Migration 001_create_countries_table.sql completed
   ✓ Migration 002_create_users_table.sql completed
   ✓ Migration 003_create_country_overview_table.sql completed
   ✓ Migration 004_create_regulatory_frameworks_table.sql completed
   ✓ Migration 005_create_documentation_cards_table.sql completed
   ✓ Migration 006_create_content_revisions_table.sql completed
   ✓ Migration 007_create_audit_log_table.sql completed
   
   All migrations completed successfully!
   ```

#### Option B: Using phpMyAdmin (Alternative)

1. Login to Hostinger hPanel
2. Go to **Databases** → **phpMyAdmin**
3. Select your database
4. Click **SQL** tab
5. Copy and paste the content of each migration file in order:
   - `migrations/001_create_countries_table.sql`
   - `migrations/002_create_users_table.sql`
   - `migrations/003_create_country_overview_table.sql`
   - `migrations/004_create_regulatory_frameworks_table.sql`
   - `migrations/005_create_documentation_cards_table.sql`
   - `migrations/006_create_content_revisions_table.sql`
   - `migrations/007_create_audit_log_table.sql`
6. Click **Go** after each one

---

### Step 5: Create Admin User

#### Option A: Using SSH (Recommended)

1. Connect via SSH
2. Navigate to project directory:
   ```bash
   cd public_html
   ```

3. Run the admin user creation script:
   ```bash
   php scripts/create_admin_user.php
   ```

4. Follow the prompts:
   ```
   Username: admin
   Email: your-email@example.com
   Password: YourSecurePassword123!
   Confirm Password: YourSecurePassword123!
   Role (admin/editor) [admin]: admin
   ```

5. You should see:
   ```
   ✓ User created successfully!
   
   User Details:
     ID:       1
     Username: admin
     Email:    your-email@example.com
     Role:     admin
   
   You can now login at: /admin/login.php
   ```

#### Option B: Using phpMyAdmin (Alternative)

1. Go to phpMyAdmin
2. Select your database
3. Click **SQL** tab
4. Run this query (change the values):

```sql
INSERT INTO users (username, password_hash, email, role, created_at)
VALUES (
    'admin',
    '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5GyYzS4HWBw1u',
    'your-email@example.com',
    'admin',
    NOW()
);
```

**Note**: The password hash above is for `admin123`. You should change it after first login.

---

### Step 6: Set File Permissions

#### Using File Manager

1. Go to File Manager
2. Right-click on folders and set permissions:
   - `admin/` → 755
   - `api/` → 755
   - `migrations/` → 755
   - `scripts/` → 755
   - `db_config.php` → 644

#### Using SSH

```bash
chmod 755 admin/ api/ migrations/ scripts/
chmod 644 db_config.php
chmod 644 admin/*.php
chmod 644 api/*.php
```

---

### Step 7: Test Your Installation

#### 7.1 Test Database Connection

1. Create a test file `test_db.php` in your root directory:

```php
<?php
require_once 'db_config.php';

try {
    $conn = getDBConnection();
    echo "✓ Database connection successful!<br>";
    echo "✓ Database: " . DB_NAME . "<br>";
    
    // Test if tables exist
    $result = $conn->query("SHOW TABLES");
    echo "✓ Tables found: " . $result->num_rows . "<br>";
    
    $conn->close();
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage();
}
?>
```

2. Visit: `https://yourdomain.com/test_db.php`
3. You should see: "✓ Database connection successful!"
4. **Delete this file after testing**

#### 7.2 Test Admin Login

1. Visit: `https://yourdomain.com/admin/login.php`
2. Login with your admin credentials
3. You should see the dashboard

#### 7.3 Test API Endpoints

1. Visit: `https://yourdomain.com/api/countries.php`
2. You should see: `{"success":true,"data":[],"count":0}`

---

### Step 8: Create Your First Country

1. Login to admin panel
2. Click **"Add New Country"**
3. Fill in the form:
   - Country Name: Australia
   - Country Code: AU
   - Hero Title: Transfer Pricing Australia
   - Hero Description: Master the Australian Taxation Office requirements
   - Status: Published
4. Click **"Save & Publish"**
5. You should see: "Country saved successfully!"

---

### Step 9: Security Hardening (Important!)

#### 9.1 Change Default Password

If you used the default password (`admin123`), change it immediately:

1. Create a new admin user with a strong password
2. Delete the default admin user

#### 9.2 Secure Your Database

1. Use a strong database password
2. Don't use default database names
3. Limit database user privileges if possible

#### 9.3 Enable HTTPS

1. In Hostinger hPanel, go to **Security** → **SSL**
2. Enable SSL certificate (free Let's Encrypt)
3. Force HTTPS redirect

#### 9.4 Protect Sensitive Directories

Create `.htaccess` files to protect directories:

**In `migrations/` directory:**
```apache
Order deny,allow
Deny from all
```

**In `scripts/` directory:**
```apache
Order deny,allow
Deny from all
```

**In `models/` directory:**
```apache
Order deny,allow
Deny from all
```

---

## Troubleshooting

### Issue: "Database connection failed"

**Solution**:
1. Check `db_config.php` credentials
2. Verify database exists in phpMyAdmin
3. Check if database user has correct privileges
4. Try `127.0.0.1` instead of `localhost` for DB_HOST

### Issue: "500 Internal Server Error"

**Solution**:
1. Check PHP error logs in hPanel
2. Verify file permissions (755 for directories, 644 for files)
3. Check if PHP version is 7.4 or higher
4. Enable error display temporarily:
   ```php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```

### Issue: "Cannot login to admin panel"

**Solution**:
1. Verify user exists in database:
   ```sql
   SELECT * FROM users WHERE username = 'admin';
   ```
2. Reset password using phpMyAdmin
3. Check if sessions are working (check PHP session settings)

### Issue: "API returns 404"

**Solution**:
1. Check if `.htaccess` is blocking API requests
2. Verify API files are uploaded correctly
3. Check file permissions on `api/` directory

### Issue: "Character encoding issues"

**Solution**:
1. Ensure database charset is `utf8mb4`
2. Check `db_config.php` has `$conn->set_charset("utf8mb4");`
3. Add to `.htaccess`:
   ```apache
   AddDefaultCharset UTF-8
   ```

---

## Post-Deployment Checklist

- [ ] Database connection working
- [ ] Migrations completed successfully
- [ ] Admin user created
- [ ] Can login to admin panel
- [ ] Can create/edit countries
- [ ] API endpoints responding
- [ ] HTTPS enabled
- [ ] Default passwords changed
- [ ] Sensitive directories protected
- [ ] Error logs checked
- [ ] Test file (`test_db.php`) deleted

---

## Maintenance

### Regular Backups

1. **Database Backup** (Weekly):
   - Use Hostinger's backup feature
   - Or export via phpMyAdmin

2. **File Backup** (Monthly):
   - Download all files via FTP
   - Store in secure location

### Monitoring

1. Check error logs regularly
2. Monitor disk space usage
3. Review audit logs for suspicious activity

### Updates

1. Keep PHP version updated
2. Monitor for security patches
3. Test updates in staging environment first

---

## Support

### Getting Help

1. **Documentation**: Check `README.md` and spec files in `.kiro/specs/`
2. **Error Logs**: Check Hostinger error logs in hPanel
3. **Database**: Use phpMyAdmin to inspect data
4. **Hostinger Support**: Contact for hosting-related issues

### Useful Commands

```bash
# Check PHP version
php -v

# Test database connection
php -r "new mysqli('localhost', 'user', 'pass', 'db');"

# List files
ls -la

# Check permissions
ls -l filename.php

# View error logs
tail -f error_log
```

---

## What's Next?

After successful deployment, you can:

1. **Add More Countries**: Use the admin panel to add all your countries
2. **Customize Design**: Modify CSS in admin pages
3. **Add Content**: Fill in overview, frameworks, and documentation cards
4. **Test Thoroughly**: Test all features before going live
5. **Train Users**: Show editors how to use the CMS

---

## Deployment Checklist Summary

```
PREPARATION
[ ] Hostinger account ready
[ ] Database created
[ ] Database credentials saved

UPLOAD
[ ] All files uploaded to public_html
[ ] db_config.php configured

DATABASE
[ ] Migrations run successfully
[ ] All 7 tables created
[ ] Admin user created

TESTING
[ ] Database connection test passed
[ ] Admin login works
[ ] API endpoints respond
[ ] Can create/edit countries

SECURITY
[ ] HTTPS enabled
[ ] Default passwords changed
[ ] Sensitive directories protected
[ ] Test files deleted

DONE!
[ ] CMS is live and ready to use
```

---

**Deployment Guide Version**: 1.0  
**Last Updated**: 2024  
**Estimated Deployment Time**: 30-45 minutes
