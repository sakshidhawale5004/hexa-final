# 🚀 Hostinger Deployment Guide - CORRECTED & SECURE
## HexaTP Consultation System

**⚠️ IMPORTANT: This is the CORRECTED version with all security fixes!**

---

## 🔴 CRITICAL SECURITY WARNINGS

### ⚠️ WARNING 1: MongoDB Password Exposed!
**YOUR MONGODB PASSWORD WAS EXPOSED IN PREVIOUS FILES!**

**IMMEDIATE ACTION REQUIRED:**
1. Go to MongoDB Atlas: https://cloud.mongodb.com
2. Database Access → Edit User
3. **CHANGE PASSWORD IMMEDIATELY**
4. Update your `.env` file with new password
5. **NEVER commit `.env` to Git**

### ⚠️ WARNING 2: Choose Your Stack Correctly

**Hostinger Shared Hosting Limitations:**

```
✅ PHP + MySQL → Works perfectly on ALL Hostinger plans
❌ Node.js + MongoDB → Only works on:
   - VPS hosting
   - Business/Premium plans with Node.js support
   - External deployment (Vercel, Render, Railway)
```

**👉 RECOMMENDATION FOR YOUR PROJECT:**

Since you have **PHP files** (`save_inquiry.php`, `admin_consultations.php`):

✅ **USE PHP + MySQL ONLY**
- Works on basic Hostinger hosting
- No additional setup needed
- Reliable and fast

❌ **DON'T USE MongoDB on basic Hostinger**
- Won't work properly
- Requires VPS or external hosting
- Adds unnecessary complexity

---

## 📋 Table of Contents
1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Stack Decision](#stack-decision)
3. [File Upload](#file-upload)
4. [Database Setup (MySQL)](#database-setup-mysql)
5. [Security Configuration](#security-configuration)
6. [Testing](#testing)
7. [Troubleshooting](#troubleshooting)

---

## ✅ Pre-Deployment Checklist

Before deploying, ensure you have:

- [ ] Hostinger account with active hosting plan
- [ ] Domain name (or use Hostinger subdomain)
- [ ] All project files ready
- [ ] **Decided on stack: PHP+MySQL (recommended)**
- [ ] FTP/File Manager access
- [ ] **Changed MongoDB password if it was exposed**

---

## 🎯 Stack Decision

### Option 1: PHP + MySQL (✅ RECOMMENDED)

**Best for:**
- Basic Hostinger hosting
- Simple deployment
- Your current project (you have PHP files)

**What you need:**
- ✅ `save_inquiry.php`
- ✅ `admin_consultations.php`
- ✅ `db_config.php`
- ✅ `setup_database.php`
- ✅ MySQL database (created in Hostinger)

**What to REMOVE:**
- ❌ `db_config_mongodb.js`
- ❌ `.env` file (not needed for PHP)
- ❌ `api/` folder (if it's Node.js)
- ❌ `package.json` (if it's for Node.js)

### Option 2: Node.js + MongoDB (⚠️ ADVANCED)

**Only if you have:**
- VPS hosting OR
- Hostinger Business/Premium plan with Node.js support

**Better alternatives:**
- Deploy Node.js backend on Vercel/Render
- Deploy frontend (HTML) on Hostinger
- Connect via API

**👉 For this guide, we'll use PHP + MySQL (Option 1)**

---

## 📤 File Upload

### Step 1: Access File Manager

1. Log in to Hostinger: https://hpanel.hostinger.com
2. Go to **Files** → **File Manager**
3. Navigate to `public_html` folder

### Step 2: Upload Files

**✅ Files to Upload:**
```
HTML Files:
✅ index.html
✅ contact.html
✅ aboutus.html
✅ solution.html
✅ All country pages (.html)

PHP Files:
✅ save_inquiry.php
✅ admin_consultations.php
✅ db_config.php (will be edited)
✅ setup_database.php

Assets:
✅ All images (.jpg, .png)
✅ CSS files (if separate)
✅ JS files (if separate)
```

**❌ Files to EXCLUDE:**
```
❌ .git/ folder
❌ .vscode/ folder
❌ node_modules/ folder
❌ .env file (if using PHP)
❌ .env.example
❌ All .md documentation files
❌ db_config_mongodb.js
❌ api/ folder (if Node.js)
❌ package.json (if Node.js)
❌ Python scripts (.py files)
```

### Step 3: Verify File Structure

**✅ CORRECT Structure:**
```
public_html/
├── index.html ← Must be HERE (not in subfolder!)
├── contact.html
├── aboutus.html
├── save_inquiry.php
├── admin_consultations.php
├── db_config.php
├── setup_database.php
├── images/
└── .htaccess
```

**❌ WRONG Structure:**
```
public_html/
└── hexatp-main/ ← DON'T put files in subfolder!
    ├── index.html
    └── ...
```

**⚠️ If your site shows 404:**
- Files must be DIRECTLY in `public_html`
- NOT inside another folder

---

## 🗄️ Database Setup (MySQL)

### Step 1: Create MySQL Database

1. **In hPanel, go to:**
   - **Databases** → **MySQL Databases**

2. **Click "Create New Database"**
   - Database Name: `hexatp_db`
   - Hostinger will add prefix: `u123456789_hexatp_db`
   - Click **Create**

3. **Create Database User**
   - Username: `hexatp_user`
   - Full name: `u123456789_hexatp_user`
   - Password: **Generate STRONG password** (20+ characters)
   - Click **Create**

4. **Save Credentials Securely:**
   ```
   Host: localhost
   Database: u123456789_hexatp_db
   Username: u123456789_hexatp_user
   Password: [Your strong password]
   ```
   **⚠️ SAVE THESE - You'll need them!**

5. **Grant Privileges**
   - Select database
   - Select user
   - Grant **ALL PRIVILEGES**
   - Click **Add User to Database**

### Step 2: Update db_config.php

1. **In File Manager, edit `db_config.php`**
   - Right-click → **Edit**

2. **Replace with:**
   ```php
   <?php
   /**
    * Database Configuration - HOSTINGER
    * HexaTP Consultation System
    */

   // ⚠️ IMPORTANT: Replace these with YOUR actual Hostinger credentials
   define('DB_HOST', 'localhost');  // Always 'localhost' on Hostinger
   define('DB_USER', 'u123456789_hexatp_user');  // ← YOUR username
   define('DB_PASS', 'YOUR_STRONG_PASSWORD_HERE'); // ← YOUR password
   define('DB_NAME', 'u123456789_hexatp_db');     // ← YOUR database name

   // Create connection
   $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   // Check connection
   if ($conn->connect_error) {
       // Don't expose connection details in production
       error_log("Database connection failed: " . $conn->connect_error);
       die(json_encode([
           'success' => false,
           'message' => 'Database connection failed. Please contact support.'
       ]));
   }

   // Set charset
   $conn->set_charset("utf8mb4");
   ?>
   ```

3. **Save the file**

### Step 3: Initialize Database

1. **Run Setup Script**
   - Open browser
   - Go to: `https://yourdomain.com/setup_database.php`
   - You should see: "✅ Database setup completed successfully!"

2. **Verify in phpMyAdmin**
   - hPanel → **Databases** → **phpMyAdmin**
   - Select your database
   - Check tables exist:
     - `consultations`
     - `inquiries`

3. **🔴 DELETE setup_database.php IMMEDIATELY**
   ```
   ❗ CRITICAL: Delete this file after running!
   
   Why? It can be accessed by anyone and:
   - Recreate/delete your tables
   - Expose database structure
   - Security risk
   
   How to delete:
   - File Manager → Right-click setup_database.php → Delete
   ```

---

## 🔒 Security Configuration

### Step 1: Create .htaccess File

1. **In `public_html`, create `.htaccess`**
   - File Manager → New File → `.htaccess`

2. **Add this content:**
   ```apache
   # ========== SECURITY CONFIGURATION ==========
   
   # Disable directory browsing
   Options -Indexes
   
   # Set default file
   DirectoryIndex index.html index.php
   
   # Protect sensitive files
   <FilesMatch "^\.env$">
       Order allow,deny
       Deny from all
   </FilesMatch>
   
   <FilesMatch "^db_config\.php$">
       Order allow,deny
       Deny from all
   </FilesMatch>
   
   <FilesMatch "^setup_database\.php$">
       Order allow,deny
       Deny from all
   </FilesMatch>
   
   # Security headers
   <IfModule mod_headers.c>
       Header set X-Content-Type-Options "nosniff"
       Header set X-Frame-Options "SAMEORIGIN"
       Header set X-XSS-Protection "1; mode=block"
       Header set Referrer-Policy "strict-origin-when-cross-origin"
   </IfModule>
   
   # CORS - IMPORTANT: Replace with YOUR domain!
   <IfModule mod_headers.c>
       # ⚠️ CHANGE THIS to your actual domain:
       Header set Access-Control-Allow-Origin "https://yourdomain.com"
       # DON'T use "*" - it's insecure!
       
       Header set Access-Control-Allow-Methods "GET, POST, OPTIONS"
       Header set Access-Control-Allow-Headers "Content-Type"
   </IfModule>
   
   # Force HTTPS (after SSL is installed)
   # Uncomment these lines after installing SSL:
   # RewriteEngine On
   # RewriteCond %{HTTPS} off
   # RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   
   # Prevent access to .git folder
   <DirectoryMatch "\.git">
       Order allow,deny
       Deny from all
   </DirectoryMatch>
   ```

3. **Save the file**

### Step 2: Verify Form Connection

1. **Check contact.html**
   - Open `contact.html` in File Manager
   - Find the `<form>` tag
   - Verify:
     ```html
     <form action="save_inquiry.php" method="POST">
     ```
   - ✅ `action` must point to `save_inquiry.php`
   - ✅ `method` must be `POST`

2. **If form doesn't have action:**
   - Add it to the `<form>` tag
   - Or check JavaScript for AJAX submission

### Step 3: Install SSL Certificate

1. **In hPanel, go to:**
   - **Security** → **SSL**

2. **Install Free SSL**
   - Select your domain
   - Click **Install SSL** (Let's Encrypt)
   - Wait 5-10 minutes

3. **Enable Force HTTPS**
   - After SSL is installed
   - Uncomment the RewriteRule lines in `.htaccess`

### Step 4: Set File Permissions

**Recommended permissions:**
```
Folders: 755
PHP files: 644
.htaccess: 644
HTML files: 644
```

**How to set:**
- Right-click file/folder → **Permissions**
- Enter: `755` for folders, `644` for files

---

## 🧪 Testing

### Test 1: Homepage

1. Visit: `https://yourdomain.com`
2. ✅ Homepage loads
3. ✅ No 404 errors
4. ✅ Images load
5. ✅ Navigation works

### Test 2: Contact Form

1. Visit: `https://yourdomain.com/contact.html`
2. Fill form:
   - Name: Test User
   - Email: test@example.com
   - Phone: 1234567890
   - Select date/time
   - Choose consultation type
3. Submit
4. ✅ Success message appears
5. ✅ No errors in browser console (F12)

### Test 3: Database

1. **Check phpMyAdmin:**
   - hPanel → phpMyAdmin
   - Select database
   - Open `consultations` table
   - ✅ Test data is there

### Test 4: Admin Dashboard

1. Visit: `https://yourdomain.com/admin_consultations.php`
2. ✅ Dashboard loads
3. ✅ Test consultation appears
4. ✅ Filtering works
5. ✅ View details works

### Test 5: Mobile

1. Open site on mobile device
2. ✅ Hamburger menu works
3. ✅ Form submits
4. ✅ Layout is responsive

### Test 6: Security

1. Try to access: `https://yourdomain.com/db_config.php`
   - ✅ Should show "403 Forbidden"
2. Try to access: `https://yourdomain.com/setup_database.php`
   - ✅ Should show "403 Forbidden" or 404 (if deleted)
3. Check HTTPS:
   - ✅ Padlock icon in browser
   - ✅ Certificate is valid

---

## 🐛 Troubleshooting

### Issue 1: 404 Not Found

**Cause:** Files in wrong location

**Fix:**
```
✓ Files must be DIRECTLY in public_html
✓ NOT in public_html/hexatp-main/
✓ Check file names (case-sensitive on Linux)
✓ Verify index.html exists in public_html
```

### Issue 2: Database Connection Failed

**Cause:** Wrong credentials

**Fix:**
```
✓ Check DB_HOST is 'localhost'
✓ Verify database name has Hostinger prefix
✓ Check username has prefix
✓ Verify password is correct
✓ Test in phpMyAdmin first
```

### Issue 3: Form Not Submitting

**Cause:** Missing action or CORS

**Fix:**
```
✓ Check <form action="save_inquiry.php" method="POST">
✓ Verify save_inquiry.php exists
✓ Check browser console (F12) for errors
✓ Verify CORS headers in .htaccess
✓ Check Network tab in DevTools
```

### Issue 4: 500 Internal Server Error

**Cause:** PHP error or .htaccess issue

**Fix:**
```
✓ Check error logs: hPanel → Error Logs
✓ Temporarily rename .htaccess to test
✓ Check PHP syntax errors
✓ Verify file permissions (644 for PHP)
```

### Issue 5: Images Not Loading

**Cause:** Wrong paths or permissions

**Fix:**
```
✓ Check image paths in HTML
✓ Verify images uploaded
✓ Check file permissions (644)
✓ Use relative paths: images/logo.png
```

---

## 📊 Post-Deployment Checklist

### Security:
- [ ] setup_database.php deleted
- [ ] .htaccess configured
- [ ] SSL certificate installed
- [ ] HTTPS redirect enabled
- [ ] CORS set to your domain (not "*")
- [ ] File permissions set correctly
- [ ] MongoDB password changed (if exposed)

### Functionality:
- [ ] Homepage loads
- [ ] All pages accessible
- [ ] Contact form submits
- [ ] Data saves to database
- [ ] Admin dashboard works
- [ ] Mobile responsive
- [ ] Images load
- [ ] Navigation works

### Testing:
- [ ] Tested on desktop
- [ ] Tested on mobile
- [ ] Tested form submission
- [ ] Tested admin panel
- [ ] Checked browser console (no errors)
- [ ] Verified database entries

### Backup:
- [ ] Created manual backup
- [ ] Enabled automatic backups
- [ ] Saved database credentials securely

---

## 🎯 Quick Reference

### Your Hostinger Database:
```
Host: localhost
Database: u123456789_hexatp_db  ← (with YOUR prefix)
Username: u123456789_hexatp_user ← (with YOUR prefix)
Password: [Your secure password]
```

### Important URLs:
```
Homepage: https://yourdomain.com
Contact: https://yourdomain.com/contact.html
Admin: https://yourdomain.com/admin_consultations.php
phpMyAdmin: [Access via hPanel]
```

### Files to Delete After Setup:
```
❌ setup_database.php (CRITICAL!)
❌ .env.example
❌ All .md files
❌ db_config_mongodb.js
❌ Python scripts
```

---

## 📞 Support

**Hostinger Support:**
- Live Chat: 24/7 in hPanel
- Knowledge Base: https://support.hostinger.com

**HexaTP Support:**
- Email: md@hexatp.com
- Phone: +91-8288800341

---

## ⚠️ FINAL SECURITY REMINDERS

1. **🔴 CHANGE MongoDB password if it was exposed**
2. **🔴 DELETE setup_database.php after running**
3. **🔴 Set CORS to your domain, NOT "*"**
4. **🔴 Never commit .env or db_config.php to Git**
5. **🔴 Use HTTPS only (install SSL)**
6. **🔴 Keep database credentials secure**
7. **🔴 Enable automatic backups**

---

**Status**: ✅ Corrected & Secure  
**Last Updated**: April 17, 2026  
**Version**: 2.0.0 (CORRECTED)

---

**Good luck with your secure deployment!** 🚀🔒
