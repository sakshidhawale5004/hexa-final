# 🗄️ Database Setup Guide for Hostinger

## Step-by-Step Instructions

### 1️⃣ Create Database on Hostinger

1. **Login to Hostinger Dashboard**
   - Go to: https://hpanel.hostinger.com/websites/hexatp.com

2. **Navigate to Databases**
   - Click "Databases" in the left sidebar
   - Click "Create Database" button

3. **Fill Database Details**
   ```
   Database Name: hexatp_db
   Database User: hexatp_user (or any name you prefer)
   Password: [Create a strong password]
   ```

4. **Save Credentials**
   After creation, Hostinger will show:
   ```
   Database Host: localhost (or mysql.hexatp.com)
   Database Name: u123456789_hexatp (with prefix)
   Database User: u123456789_user (with prefix)
   Database Password: [your password]
   ```

### 2️⃣ Update db_config.php

1. **Open File Manager** in Hostinger
   - Navigate to: `public_html/db_config.php`

2. **Edit the file** and replace these lines:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'YOUR_DATABASE_USERNAME');  // Replace with actual username
   define('DB_PASS', 'YOUR_DATABASE_PASSWORD');  // Replace with actual password
   define('DB_NAME', 'YOUR_DATABASE_NAME');      // Replace with actual database name
   ```

3. **Example** (with your actual credentials):
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'u123456789_hexatp');
   define('DB_PASS', 'YourStrongPassword123!');
   define('DB_NAME', 'u123456789_hexatp_db');
   ```

### 3️⃣ Create Database Tables

**Option A: Using phpMyAdmin (Recommended)**

1. Go to **Databases** → Click **"Manage"** next to your database
2. Click **"phpMyAdmin"** button
3. Click **"SQL"** tab
4. Copy and paste this SQL:

```sql
-- Create consultations table
CREATE TABLE IF NOT EXISTS consultations (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create inquiries table
CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

5. Click **"Go"** button

**Option B: Using create_database.php**

1. Upload `create_database.php` to your Hostinger public_html folder
2. Visit: `https://hexatp.com/create_database.php`
3. The script will automatically create tables

### 4️⃣ Test Connection

1. Upload `test_connection.php` to public_html
2. Visit: `https://hexatp.com/test_connection.php`
3. Check if all tests pass ✓

### 5️⃣ Security (IMPORTANT!)

After setup is complete:

1. **Delete setup files** from public_html:
   ```
   - create_database.php
   - test_connection.php
   - DATABASE_SETUP_GUIDE.md
   ```

2. **Secure db_config.php**:
   - Make sure it's NOT in a publicly accessible folder
   - Or add this to .htaccess:
   ```apache
   <Files "db_config.php">
       Order Allow,Deny
       Deny from all
   </Files>
   ```

## 📋 Quick Reference

### Database Files in Your Project:
- `db_config.php` - Database connection configuration
- `save_inquiry.php` - Handles contact form submissions
- `admin_consultations.php` - View consultation requests
- `check_status.php` - Check consultation status

### Contact Form Integration:
Your contact form in `contact.html` should POST to `save_inquiry.php`

### Admin Panel:
Access consultation requests at: `https://hexatp.com/admin_consultations.php`

## 🆘 Troubleshooting

### Error: "Connection failed"
- Check database credentials in db_config.php
- Verify database exists in Hostinger panel
- Check if MySQL service is running

### Error: "Table doesn't exist"
- Run the SQL script in phpMyAdmin
- Or visit create_database.php

### Error: "Access denied"
- Verify database username and password
- Check if user has proper permissions

## 📞 Need Help?

If you encounter issues:
1. Check Hostinger's database logs
2. Contact Hostinger support
3. Verify all credentials are correct

---

**Last Updated**: April 18, 2026
**Project**: HexaTP Transfer Pricing Solutions
