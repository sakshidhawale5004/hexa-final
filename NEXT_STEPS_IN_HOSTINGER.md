# 🎯 Next Steps in Hostinger - Complete Guide

## Current Status
✅ You have created your database  
✅ You are now in phpMyAdmin  
✅ You have the SQL file ready (`migrations/create_all_tables.sql`)

---

## STEP 1: Select Your Database

Looking at your screenshot, you have 3 databases. You need to select the correct one:

1. **Click on one of your databases** in the left sidebar:
   - `u852823366__hexatp_db` (this looks like your main database)
   - OR whichever database you created for the CMS

2. The database name will be **highlighted** when selected

---

## STEP 2: Open the SQL Tab

1. After selecting your database, look at the **top menu bar**
2. Click on the **"SQL"** tab (it's usually the second or third tab)

---

## STEP 3: Copy and Paste the SQL Script

### 3.1 Open the SQL File
Open this file in your code editor:
```
migrations/create_all_tables.sql
```

### 3.2 Copy Everything
- Press `Ctrl+A` (select all)
- Press `Ctrl+C` (copy)

### 3.3 Paste into phpMyAdmin
1. Go back to phpMyAdmin
2. You should see a large text box under the SQL tab
3. Click inside the text box
4. Press `Ctrl+V` (paste)
5. You should see all the SQL code appear

---

## STEP 4: Execute the SQL

1. Scroll down to the bottom of the page
2. Click the **"Go"** button (usually blue, bottom right)
3. Wait 2-3 seconds for execution

---

## STEP 5: Verify Success

### You Should See:
✅ Green checkmark with message: "Query executed successfully"  
✅ Message: "All 7 tables created successfully!"

### Check the Tables:
1. Look at the **left sidebar** in phpMyAdmin
2. Click on your database name to expand it
3. You should now see **7 tables**:
   - countries
   - users
   - country_overview
   - regulatory_frameworks
   - documentation_cards
   - content_revisions
   - audit_log

---

## STEP 6: Create an Admin User

After tables are created, you need to create your first admin user.

### Option A: Using phpMyAdmin (Quick Method)

1. Click on the **"users"** table in the left sidebar
2. Click the **"Insert"** tab at the top
3. Fill in these fields:

| Field | Value |
|-------|-------|
| username | `admin` |
| password_hash | Leave empty for now - we'll add it via script |
| email | `your-email@example.com` |
| role | Select `admin` from dropdown |
| created_at | Leave as default |

4. Click **"Go"** to insert

**⚠️ IMPORTANT:** You'll need to update the password_hash using the PHP script because it needs to be bcrypt hashed.

### Option B: Using PHP Script (Recommended)

1. Upload the file `scripts/create_admin_user.php` to your Hostinger via File Manager
2. Visit: `https://hexatp.com/scripts/create_admin_user.php`
3. Follow the on-screen instructions to create your admin user

---

## STEP 7: Update Database Configuration

Update your `db_config.php` file with your actual Hostinger credentials:

```php
<?php
// Hostinger Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'u852823366__hexatp_db'); // Your actual database name
define('DB_USER', 'u852823366__hexatp_user'); // Your actual username
define('DB_PASS', 'Hexatp_2026'); // Your actual password
define('DB_CHARSET', 'utf8mb4');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset(DB_CHARSET);
?>
```

---

## STEP 8: Upload Files to Hostinger

Upload these folders/files via **File Manager** or **FTP**:

### Essential Folders:
- ✅ `admin/` - Admin panel files
- ✅ `api/` - API endpoints
- ✅ `models/` - PHP data models
- ✅ `repositories/` - Database repositories
- ✅ `services/` - Business logic services
- ✅ `scripts/` - Utility scripts

### Essential Files:
- ✅ `db_config.php` - Database configuration
- ✅ All country HTML files (australia.html, egypt.html, etc.)
- ✅ `index.html` - Homepage
- ✅ `contact.html`, `aboutus.html`, etc.

### DO NOT Upload:
- ❌ `node_modules/` folder
- ❌ `.kiro/` folder
- ❌ `.vscode/` folder
- ❌ Test files (*.test.php)
- ❌ Documentation files (*.md)

---

## STEP 9: Test the Setup

### Test 1: Database Connection
Create a test file `test_connection.php`:

```php
<?php
require_once 'db_config.php';

echo "<h1>Database Connection Test</h1>";

// Test connection
if ($conn->ping()) {
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // Test tables exist
    $tables = ['countries', 'users', 'country_overview', 'regulatory_frameworks', 
               'documentation_cards', 'content_revisions', 'audit_log'];
    
    echo "<h2>Tables Check:</h2>";
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "<p style='color: green;'>✅ Table '$table' exists</p>";
        } else {
            echo "<p style='color: red;'>❌ Table '$table' NOT found</p>";
        }
    }
} else {
    echo "<p style='color: red;'>❌ Database connection failed!</p>";
}

$conn->close();
?>
```

Visit: `https://hexatp.com/test_connection.php`

### Test 2: Admin Login
Visit: `https://hexatp.com/admin/login.php`

Try logging in with the admin credentials you created.

---

## STEP 10: Security Cleanup

After everything works:

1. **Delete test files:**
   - `test_connection.php`
   - `scripts/create_admin_user.php` (after creating admin)

2. **Secure the migrations folder:**
   - Delete the `migrations/` folder from Hostinger
   - OR add `.htaccess` to block access:
   ```apache
   Deny from all
   ```

3. **Update db_config.php permissions:**
   - Set file permissions to `644` or `640`

---

## 🎯 Quick Checklist

- [ ] Database selected in phpMyAdmin
- [ ] SQL script executed successfully
- [ ] All 7 tables visible in phpMyAdmin
- [ ] Admin user created
- [ ] db_config.php updated with correct credentials
- [ ] Files uploaded to Hostinger
- [ ] Database connection test passes
- [ ] Admin login works
- [ ] Test files deleted
- [ ] Security measures applied

---

## 🆘 Troubleshooting

### Error: "No database selected"
- Make sure you clicked on your database name in the left sidebar before going to SQL tab

### Error: "Table already exists"
- This is OK! The script uses `CREATE TABLE IF NOT EXISTS`
- It will skip existing tables

### Error: "Cannot add foreign key constraint"
- Make sure you're running the complete script (all tables at once)
- The script creates tables in the correct order

### Error: "Access denied for user"
- Check your database credentials in `db_config.php`
- Make sure the username and password match what Hostinger gave you

### Can't see tables after execution
- Refresh phpMyAdmin (F5)
- Click on your database name again in the left sidebar

---

## 📞 Need Help?

If you encounter any errors:
1. Take a screenshot of the error message
2. Note which step you're on
3. Check the phpMyAdmin error log
4. Share the details for troubleshooting

---

**You're almost done! 🚀**

The next message should be: "Tables created successfully!" 
Then we'll move on to creating your admin user and testing the system.
