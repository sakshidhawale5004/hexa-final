# Hostinger Database Setup Guide

## Step-by-Step Instructions to Create All Tables

### Prerequisites
✅ You have already created a database on Hostinger
✅ You have the database name, username, and password

---

## Method 1: Using phpMyAdmin (Recommended - Easiest)

### Step 1: Access phpMyAdmin
1. Go to your Hostinger control panel
2. Navigate to **Databases** → **phpMyAdmin**
3. Click on your database name in the left sidebar to select it

### Step 2: Execute Migration Scripts (One by One)

Execute these SQL scripts **in order** (the order is important because of foreign key dependencies):

#### 1. Create Countries Table
```sql
-- Migration: Create countries table
-- Description: Main table storing country information and metadata

CREATE TABLE IF NOT EXISTS countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_name VARCHAR(100) NOT NULL UNIQUE,
    country_code VARCHAR(10) NOT NULL,
    flag_url VARCHAR(255),
    hero_title VARCHAR(255),
    hero_description TEXT,
    meta_title VARCHAR(255),
    meta_description VARCHAR(500),
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_country_code (country_code),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**How to execute:**
- Click the **SQL** tab at the top
- Copy and paste the SQL above
- Click **Go** button
- You should see "✓ Query executed successfully"

---

#### 2. Create Users Table
```sql
-- Migration: Create users table
-- Description: Stores admin and editor user accounts for CMS access

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'editor',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Execute the same way:** SQL tab → Paste → Go

---

#### 3. Create Country Overview Table
```sql
-- Migration: Create country_overview table
-- Description: Stores overview text sections for each country (left and right columns)

CREATE TABLE IF NOT EXISTS country_overview (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    overview_text_left TEXT,
    overview_text_right TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    INDEX idx_country_id (country_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

#### 4. Create Regulatory Frameworks Table
```sql
-- Migration: Create regulatory_frameworks table
-- Description: Stores key regulatory framework boxes for each country (typically 3 per country)

CREATE TABLE IF NOT EXISTS regulatory_frameworks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    INDEX idx_country_display (country_id, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

#### 5. Create Documentation Cards Table
```sql
-- Migration: Create documentation_cards table
-- Description: Stores expandable documentation cards with detailed content for each country

CREATE TABLE IF NOT EXISTS documentation_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    short_description TEXT,
    detailed_content LONGTEXT,
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    INDEX idx_country_display (country_id, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

#### 6. Create Content Revisions Table
```sql
-- Migration: Create content_revisions table
-- Description: Tracks all content changes for audit and rollback purposes

CREATE TABLE IF NOT EXISTS content_revisions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    content_type ENUM('country', 'overview', 'regulatory_framework', 'documentation_card') NOT NULL,
    content_id INT NOT NULL,
    field_name VARCHAR(100) NOT NULL,
    old_value LONGTEXT,
    new_value LONGTEXT,
    changed_by INT NOT NULL,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    FOREIGN KEY (changed_by) REFERENCES users(id),
    INDEX idx_country_date (country_id, changed_at),
    INDEX idx_content (content_type, content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

#### 7. Create Audit Log Table
```sql
-- Migration: Create audit_log table
-- Description: Logs all administrative actions for security and compliance tracking

CREATE TABLE IF NOT EXISTS audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    entity_type VARCHAR(50) NOT NULL,
    entity_id INT,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_date (user_id, created_at),
    INDEX idx_entity (entity_type, entity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### Step 3: Verify All Tables Were Created

After executing all 7 scripts:

1. Click on your database name in the left sidebar
2. You should see all 7 tables listed:
   - ✓ countries
   - ✓ users
   - ✓ country_overview
   - ✓ regulatory_frameworks
   - ✓ documentation_cards
   - ✓ content_revisions
   - ✓ audit_log

---

## Method 2: Using Remote MySQL (Alternative)

If you prefer using a MySQL client:

1. Go to **Databases** → **Remote MySQL**
2. Add your IP address to the whitelist
3. Use a MySQL client (like MySQL Workbench, DBeaver, or command line)
4. Connect using the credentials from Hostinger
5. Execute the migration scripts in order

---

## Method 3: Upload and Run migrate.php (Automated)

### Step 1: Update Database Configuration

First, update your `db_config.php` with your Hostinger database credentials:

```php
<?php
// Hostinger Database Configuration
define('DB_HOST', 'localhost'); // Usually 'localhost' on Hostinger
define('DB_NAME', 'u852823366__hexatp_db'); // Your actual database name
define('DB_USER', 'u852823366__hexatp_user'); // Your actual database username
define('DB_PASS', 'Hexatp_2026'); // Your actual database password
define('DB_CHARSET', 'utf8mb4');
```

### Step 2: Upload Files to Hostinger

Upload these files via FTP or File Manager:
- `migrations/` folder (all 7 .sql files)
- `migrations/migrate.php`
- `db_config.php`

### Step 3: Run Migration Script

Visit in your browser:
```
https://hexatp.com/migrations/migrate.php
```

This will automatically execute all migrations in order.

**⚠️ IMPORTANT:** Delete or secure the `migrations/` folder after running to prevent unauthorized access!

---

## Troubleshooting

### Error: "Table already exists"
- This is fine! The `CREATE TABLE IF NOT EXISTS` will skip existing tables
- Continue with the next migration

### Error: "Cannot add foreign key constraint"
- Make sure you created the `countries` and `users` tables first
- These must exist before creating tables that reference them

### Error: "Access denied"
- Verify your database credentials are correct
- Make sure you selected the correct database in phpMyAdmin

### Error: "Unknown collation: utf8mb4_unicode_ci"
- Your MySQL version might be old
- Change `utf8mb4_unicode_ci` to `utf8_general_ci` in all scripts

---

## Next Steps After Tables Are Created

1. ✅ **Create an admin user** - Run `scripts/create_admin_user.php`
2. ✅ **Test database connection** - Visit your test_connection.php page
3. ✅ **Upload remaining PHP files** - Upload all API, admin, and model files
4. ✅ **Test the admin panel** - Try logging in at `/admin/login.php`

---

## Quick Verification Checklist

After running all migrations, verify:

- [ ] All 7 tables exist in your database
- [ ] Each table has the correct columns (check in phpMyAdmin Structure tab)
- [ ] Foreign key relationships are established
- [ ] Indexes are created (check in phpMyAdmin Structure tab)
- [ ] Character set is utf8mb4 for all tables

---

## Need Help?

If you encounter any errors:
1. Take a screenshot of the error message
2. Note which migration script failed
3. Check the phpMyAdmin error log
4. Share the error details for troubleshooting

---

**Good luck! 🚀**
