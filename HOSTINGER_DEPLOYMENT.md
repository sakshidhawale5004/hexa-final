# 🚀 Hostinger Deployment Guide - FIX 404 ERROR

## ⚠️ CURRENT ISSUE: 404 Not Found Error

**Cause:** Files are not properly uploaded or database is not configured.

---

## 📋 **STEP-BY-STEP FIX** (15 minutes)

### **STEP 1: Upload Files to Hostinger** (5 minutes)

#### Option A: Using File Manager (Recommended)

1. **Login to Hostinger hPanel**
   - Go to: https://hpanel.hostinger.com
   - Login with your credentials

2. **Open File Manager**
   - Click "File Manager" in hPanel
   - Navigate to `public_html` folder

3. **Upload ALL These Files:**
   ```
   ✅ contact.html
   ✅ save_inquiry.php
   ✅ admin_consultations.php
   ✅ setup_database.php
   ✅ db_config.php (update with Hostinger credentials first!)
   ✅ test_hostinger.php (for testing)
   ✅ All other HTML files (aboutus.html, australia.html, etc.)
   ```

4. **Upload Method:**
   - Click "Upload" button in File Manager
   - Select all files from your local `hexatp-main` folder
   - Wait for upload to complete

#### Option B: Using FTP (Alternative)

1. **Get FTP Credentials from hPanel:**
   - Go to: Files → FTP Accounts
   - Note: Hostname, Username, Password

2. **Use FTP Client (FileZilla):**
   - Download FileZilla: https://filezilla-project.org
   - Connect using credentials
   - Upload files to `/public_html/` directory

---

### **STEP 2: Configure Database** (5 minutes)

#### 2.1 Create MySQL Database

1. **In Hostinger hPanel:**
   - Go to: **Databases → MySQL Databases**
   - Click "Create New Database"

2. **Fill in Details:**
   ```
   Database Name: hexatp_db
   Username: hexatp_user
   Password: [Create a strong password]
   ```

3. **Save Credentials:**
   ```
   Host: localhost
   Database: u852823366_hexatp_db (actual name shown in hPanel)
   Username: u852823366_hexatp_user (actual username shown)
   Password: [your password]
   ```

#### 2.2 Update db_config.php

1. **Open `db_config.php` in File Manager**
2. **Click "Edit"**
3. **Replace with:**

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'u852823366_hexatp_user');  // ← Your actual username
define('DB_PASS', 'YOUR_PASSWORD_HERE');       // ← Your actual password
define('DB_NAME', 'u852823366_hexatp_db');     // ← Your actual database name

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
```

4. **Save the file**

---

### **STEP 3: Test the Setup** (2 minutes)

#### 3.1 Run Test File

1. **Visit in browser:**
   ```
   https://your-domain.com/test_hostinger.php
   ```

2. **Check Results:**
   - ✅ PHP Version should show
   - ✅ All files should be found
   - ✅ Database connection should succeed

3. **If errors appear:**
   - Red "✗" = File missing or database error
   - Check error messages
   - Fix issues and refresh

#### 3.2 Setup Database Tables

1. **Visit:**
   ```
   https://your-domain.com/setup_database.php
   ```

2. **You should see:**
   ```
   ✓ Database setup completed successfully!
   ✓ Tables created: consultations, inquiries
   ```

---

### **STEP 4: Test the System** (3 minutes)

#### 4.1 Test Consultation Form

1. **Visit:**
   ```
   https://your-domain.com/contact.html
   ```

2. **Fill out the form:**
   - Select a date
   - Choose a time slot
   - Enter your details
   - Submit

3. **You should see:**
   ```
   ✓ Consultation request submitted successfully!
   ```

#### 4.2 Test Admin Panel

1. **Visit:**
   ```
   https://your-domain.com/admin_consultations.php
   ```

2. **You should see:**
   - Statistics dashboard
   - Your test consultation listed
   - Filter buttons working

---

## 🔧 **TROUBLESHOOTING 404 ERRORS**

### Problem 1: "404 Not Found" on PHP files

**Cause:** File not uploaded or wrong location

**Fix:**
1. Check File Manager → public_html
2. Verify file exists
3. Check file name (case-sensitive!)
   - ✅ `contact.html` (lowercase)
   - ✗ `Contact.html` (uppercase)

### Problem 2: "404 Not Found" on all pages

**Cause:** Files in wrong directory

**Fix:**
1. Files MUST be in `public_html` folder
2. NOT in `public_html/hexatp-main/`
3. Move files to root of public_html

### Problem 3: "Database connection failed"

**Cause:** Wrong credentials in db_config.php

**Fix:**
1. Go to hPanel → Databases
2. Copy EXACT database name, username
3. Update db_config.php
4. Save and test again

### Problem 4: "Table doesn't exist"

**Cause:** Database tables not created

**Fix:**
1. Visit: `https://your-domain.com/setup_database.php`
2. This creates the tables automatically

### Problem 5: Blank white page

**Cause:** PHP error

**Fix:**
1. Check error_log in File Manager
2. Or add to top of PHP file:
   ```php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```

---

## 📁 **FILE STRUCTURE ON HOSTINGER**

```
public_html/
├── index.html (your homepage)
├── contact.html ← Consultation form
├── save_inquiry.php ← Form handler
├── admin_consultations.php ← Admin panel
├── setup_database.php ← Database setup
├── db_config.php ← Database config
├── test_hostinger.php ← Test file
├── aboutus.html
├── australia.html
└── [all other HTML files]
```

**⚠️ IMPORTANT:** Files must be in `public_html` root, NOT in a subfolder!

---

## ✅ **VERIFICATION CHECKLIST**

After deployment, verify:

- [ ] test_hostinger.php shows all green checkmarks
- [ ] setup_database.php runs successfully
- [ ] contact.html loads without 404
- [ ] Form submission works
- [ ] admin_consultations.php shows dashboard
- [ ] No 404 errors on any page

---

## 🔒 **SECURITY - AFTER DEPLOYMENT**

1. **Delete test file:**
   ```
   Delete: test_hostinger.php
   ```

2. **Secure admin panel:**
   - Add password protection
   - Or move to /admin/ folder with .htaccess

3. **Update db_config.php:**
   - Remove any debug code
   - Ensure no passwords are visible in error messages

---

## 📞 **NEED HELP?**

### Check These First:
1. ✅ All files uploaded to public_html?
2. ✅ Database created in hPanel?
3. ✅ db_config.php updated with correct credentials?
4. ✅ setup_database.php executed successfully?

### Still Having Issues?

**Contact Support:**
- Email: md@hexatp.com
- Phone: +91-8288800341

**Or Check:**
- Hostinger Knowledge Base: https://support.hostinger.com
- Error logs in File Manager → error_log

---

## 🎯 **QUICK REFERENCE**

### Important URLs:
```
Test File:    https://your-domain.com/test_hostinger.php
Setup DB:     https://your-domain.com/setup_database.php
Contact Form: https://your-domain.com/contact.html
Admin Panel:  https://your-domain.com/admin_consultations.php
```

### Database Credentials Template:
```php
DB_HOST: localhost
DB_USER: u852823366_hexatp_user
DB_PASS: [your password]
DB_NAME: u852823366_hexatp_db
```

---

**Last Updated:** April 17, 2026  
**Status:** Ready for Deployment
