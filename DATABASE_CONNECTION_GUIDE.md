# 🔗 Database Connection Guide

## ✅ Database Connection Setup & Testing

I've created tools to help you connect and test your database connection.

---

## 🚀 Quick Setup (3 Steps)

### Step 1: Start XAMPP Services
1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**
4. Both should show green "Running" status

### Step 2: Create Database & Tables
Open in browser:
```
http://localhost/hexatp-main/create_database.php
```

This will automatically:
- ✅ Create database `hexatp_db`
- ✅ Create `consultations` table
- ✅ Create `inquiries` table
- ✅ Set up proper indexes

### Step 3: Test Connection
Open in browser:
```
http://localhost/hexatp-main/test_connection.php
```

This will verify:
- ✅ MySQL extension loaded
- ✅ MySQL server connection
- ✅ Database exists
- ✅ Tables exist
- ✅ Permissions are correct

---

## 📁 New Files Created

### 1. `create_database.php`
**Purpose**: Automatically creates database and tables  
**URL**: http://localhost/hexatp-main/create_database.php  
**What it does**:
- Creates `hexatp_db` database
- Creates `consultations` table
- Creates `inquiries` table
- Shows success/error messages

### 2. `test_connection.php`
**Purpose**: Tests database connectivity  
**URL**: http://localhost/hexatp-main/test_connection.php  
**What it tests**:
- MySQLi extension
- MySQL server connection
- Database existence
- Table existence
- Read/write permissions

### 3. `db_config.php` (Already exists)
**Purpose**: Database configuration  
**Current settings**:
```php
DB_HOST: localhost
DB_USER: root
DB_PASS: (empty)
DB_NAME: hexatp_db
```

### 4. `save_inquiry.php` (Already exists)
**Purpose**: Handles form submissions  
**Connected to**: contact.html form  
**What it does**:
- Validates form data
- Saves to `consultations` table
- Saves to `inquiries` table
- Returns JSON response

---

## 🔍 How to Test the Connection

### Method 1: Automatic Setup (Recommended)
```
1. http://localhost/hexatp-main/create_database.php
   → Creates everything automatically

2. http://localhost/hexatp-main/test_connection.php
   → Verifies everything works

3. http://localhost/hexatp-main/contact.html
   → Test the contact form
```

### Method 2: Manual Setup
```
1. Open phpMyAdmin: http://localhost/phpmyadmin

2. Create database: hexatp_db

3. Run SQL (see below)

4. Test connection: http://localhost/hexatp-main/test_connection.php
```

---

## 📊 Database Schema

### Table: `consultations`
```sql
CREATE TABLE consultations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    consultation_type VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time VARCHAR(20) NOT NULL,
    message LONGTEXT,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_date (appointment_date),
    INDEX idx_status (status)
);
```

### Table: `inquiries`
```sql
CREATE TABLE inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);
```

---

## 🔧 Troubleshooting

### Issue 1: "MySQL is not running"
**Solution**:
1. Open XAMPP Control Panel
2. Click "Start" next to MySQL
3. Wait for green "Running" status
4. Try again

### Issue 2: "Database connection failed"
**Solution**:
1. Check MySQL is running
2. Verify credentials in `db_config.php`
3. Try: http://localhost/hexatp-main/create_database.php

### Issue 3: "Table doesn't exist"
**Solution**:
1. Run: http://localhost/hexatp-main/create_database.php
2. Or manually create tables in phpMyAdmin

### Issue 4: "Access denied for user 'root'"
**Solution**:
1. Open phpMyAdmin
2. Go to User Accounts
3. Check root user has no password
4. Or update password in `db_config.php`

### Issue 5: "MySQLi extension not loaded"
**Solution**:
1. Open `C:\xampp3\php\php.ini`
2. Find `;extension=mysqli`
3. Remove the semicolon: `extension=mysqli`
4. Restart Apache

### Issue 6: Contact form not working
**Solution**:
1. Check database is created
2. Check tables exist
3. Test: http://localhost/hexatp-main/test_connection.php
4. Check browser console for errors

---

## ✅ Connection Flow

```
Contact Form (contact.html)
    ↓
    Submits to save_inquiry.php
    ↓
    Includes db_config.php
    ↓
    Connects to MySQL (localhost)
    ↓
    Inserts into consultations table
    ↓
    Inserts into inquiries table
    ↓
    Returns success/error JSON
    ↓
    Form shows message to user
```

---

## 🎯 Testing Checklist

Use this checklist to verify everything works:

- [ ] XAMPP Apache is running
- [ ] XAMPP MySQL is running
- [ ] Database `hexatp_db` exists
- [ ] Table `consultations` exists
- [ ] Table `inquiries` exists
- [ ] `test_connection.php` shows all green
- [ ] Contact form loads: http://localhost/hexatp-main/contact.html
- [ ] Form submission works
- [ ] Data appears in database
- [ ] Admin panel shows data: http://localhost/hexatp-main/admin_consultations.php

---

## 📞 Quick URLs

| URL | Purpose |
|-----|---------|
| http://localhost/hexatp-main/ | Homepage |
| http://localhost/hexatp-main/create_database.php | Create database |
| http://localhost/hexatp-main/test_connection.php | Test connection |
| http://localhost/hexatp-main/contact.html | Contact form |
| http://localhost/hexatp-main/admin_consultations.php | Admin panel |
| http://localhost/phpmyadmin | Database management |

---

## 🔐 Database Configuration

Current configuration in `db_config.php`:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hexatp_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

$conn->set_charset("utf8");
?>
```

---

## 📊 How to View Submitted Data

### Method 1: Admin Panel
```
http://localhost/hexatp-main/admin_consultations.php
```
- View all consultations
- Filter by status
- See details

### Method 2: phpMyAdmin
```
http://localhost/phpmyadmin
```
1. Select `hexatp_db` database
2. Click `consultations` table
3. Click "Browse" to see data

---

## 🎉 Success Indicators

Your database is connected when:

1. ✅ `test_connection.php` shows all tests passed
2. ✅ Contact form submits without errors
3. ✅ Success message appears after submission
4. ✅ Data appears in phpMyAdmin
5. ✅ Admin panel shows submissions

---

## 📝 Summary

**Files Created**:
- ✅ `create_database.php` - Auto setup
- ✅ `test_connection.php` - Connection test
- ✅ `DATABASE_CONNECTION_GUIDE.md` - This guide

**Existing Files**:
- ✅ `db_config.php` - Database config
- ✅ `save_inquiry.php` - Form handler
- ✅ `admin_consultations.php` - Admin panel

**Database**:
- ✅ Name: `hexatp_db`
- ✅ Tables: `consultations`, `inquiries`
- ✅ Connection: Configured and ready

---

## 🚀 Quick Start Command

Just open these URLs in order:

1. **Create Database**:  
   http://localhost/hexatp-main/create_database.php

2. **Test Connection**:  
   http://localhost/hexatp-main/test_connection.php

3. **Test Form**:  
   http://localhost/hexatp-main/contact.html

---

**Status**: ✅ Database connection configured and ready to test!

*Last Updated: April 17, 2026*
