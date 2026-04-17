# 🚀 Hostinger Deployment Guide
## HexaTP Consultation System

Complete step-by-step guide to deploy your HexaTP project on Hostinger.

---

## 📋 Table of Contents
1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Hostinger Setup](#hostinger-setup)
3. [File Upload](#file-upload)
4. [Database Configuration](#database-configuration)
5. [Environment Configuration](#environment-configuration)
6. [Testing](#testing)
7. [Troubleshooting](#troubleshooting)

---

## ✅ Pre-Deployment Checklist

Before deploying, ensure you have:

- [ ] Hostinger account with active hosting plan
- [ ] Domain name (or use Hostinger subdomain)
- [ ] All project files ready
- [ ] Database credentials from Hostinger
- [ ] FTP/File Manager access
- [ ] MongoDB Atlas connection string (if using MongoDB)

---

## 🔧 Hostinger Setup

### Step 1: Access Hostinger Control Panel

1. Log in to your Hostinger account: https://www.hostinger.com/
2. Go to **Hosting** → Select your hosting plan
3. Click **Manage** to access hPanel

### Step 2: Prepare Your Domain

**Option A: Use Your Domain**
- Go to **Domains** section
- Point your domain to Hostinger nameservers (if not already done)
- Wait for DNS propagation (up to 24 hours)

**Option B: Use Hostinger Subdomain**
- Use the default subdomain provided (e.g., `yoursite.hostingersite.com`)

---

## 📤 File Upload

### Method 1: File Manager (Recommended for Beginners)

1. **Access File Manager**
   - In hPanel, go to **Files** → **File Manager**
   - Navigate to `public_html` folder

2. **Upload Files**
   - Click **Upload Files** button
   - Select all your project files EXCEPT:
     - `.git` folder
     - `.vscode` folder
     - `node_modules` folder (if exists)
     - `.env.example` (create `.env` instead)
     - All `.md` documentation files (optional)

3. **Files to Upload:**
   ```
   ✅ index.html
   ✅ contact.html
   ✅ aboutus.html
   ✅ All other .html files
   ✅ admin_consultations.php
   ✅ save_inquiry.php
   ✅ db_config.php (will be edited)
   ✅ setup_database.php
   ✅ All image files (.jpg, .png)
   ✅ api/ folder (if using Node.js)
   ✅ package.json (if using Node.js)
   ```

### Method 2: FTP (Recommended for Advanced Users)

1. **Get FTP Credentials**
   - In hPanel, go to **Files** → **FTP Accounts**
   - Note down:
     - FTP Host
     - FTP Username
     - FTP Password
     - Port (usually 21)

2. **Connect via FTP Client**
   - Download FileZilla: https://filezilla-project.org/
   - Open FileZilla
   - Enter FTP credentials
   - Connect to server

3. **Upload Files**
   - Navigate to `public_html` on remote side
   - Drag and drop your project files
   - Exclude `.git`, `.vscode`, `node_modules`

---

## 🗄️ Database Configuration

### For MySQL/PHP Setup

#### Step 1: Create MySQL Database

1. **Access Database Manager**
   - In hPanel, go to **Databases** → **MySQL Databases**
   - Click **Create New Database**

2. **Create Database**
   - Database Name: `u123456789_hexatp` (Hostinger adds prefix automatically)
   - Click **Create**
   - Note down the full database name

3. **Create Database User**
   - Username: `u123456789_hexatp_user`
   - Password: Generate a strong password
   - Click **Create**
   - **IMPORTANT**: Save these credentials securely!

4. **Grant Privileges**
   - Select the database
   - Select the user
   - Grant **ALL PRIVILEGES**
   - Click **Add User to Database**

#### Step 2: Update db_config.php

1. **Edit db_config.php via File Manager**
   - Navigate to `public_html/db_config.php`
   - Right-click → **Edit**

2. **Update Credentials**
   ```php
   <?php
   /**
    * Database Configuration File - HOSTINGER
    * HexaTP Consultation System
    */

   // Hostinger Database credentials
   define('DB_HOST', 'localhost');  // Usually 'localhost' on Hostinger
   define('DB_USER', 'u123456789_hexatp_user');  // Your Hostinger DB user
   define('DB_PASS', 'YOUR_STRONG_PASSWORD');     // Your DB password
   define('DB_NAME', 'u123456789_hexatp');        // Your DB name

   // Create connection
   $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   // Check connection
   if ($conn->connect_error) {
       die(json_encode([
           'success' => false,
           'message' => 'Database connection failed: ' . $conn->connect_error
       ]));
   }

   // Set charset to utf8
   $conn->set_charset("utf8");
   ?>
   ```

3. **Save the file**

#### Step 3: Initialize Database

1. **Run Setup Script**
   - Open browser
   - Navigate to: `https://yourdomain.com/setup_database.php`
   - You should see: "✅ Database setup completed successfully!"

2. **Verify in phpMyAdmin**
   - In hPanel, go to **Databases** → **phpMyAdmin**
   - Select your database
   - Check that `consultations` table exists

3. **Delete Setup File (Security)**
   ```bash
   # After successful setup, delete:
   setup_database.php
   ```

---

### For MongoDB Setup (Optional)

If you're using MongoDB Atlas with Node.js:

#### Step 1: Create .env File

1. **Create .env file in public_html**
   - File Manager → New File → `.env`

2. **Add Environment Variables**
   ```env
   # MongoDB Configuration
   MONGODB_URI=mongodb+srv://sakshidhawale5004_db_user:F3HhLhR9dKAVlfD0@cluster0.zmdcesr.mongodb.net/hexatp_db?retryWrites=true&w=majority
   
   # Database Name
   DB_NAME=hexatp_db
   
   # Server Configuration
   PORT=3000
   NODE_ENV=production
   
   # CORS Settings
   ALLOWED_ORIGINS=https://yourdomain.com,https://www.yourdomain.com
   ```

3. **Save the file**

#### Step 2: Install Node.js (if needed)

1. **Check Node.js Availability**
   - In hPanel, check if Node.js is available
   - Hostinger Business/Premium plans support Node.js

2. **Setup Node.js Application**
   - Go to **Advanced** → **Node.js**
   - Create new Node.js application
   - Set entry point: `server.js` or `api/index.js`
   - Install dependencies

---

## ⚙️ Environment Configuration

### Step 1: Configure PHP Settings (if needed)

1. **Create/Edit .htaccess**
   - In `public_html`, create `.htaccess` file

2. **Add Configuration**
   ```apache
   # Enable error reporting (disable in production)
   # php_flag display_errors off
   
   # Set default file
   DirectoryIndex index.html index.php
   
   # Security headers
   <IfModule mod_headers.c>
       Header set X-Content-Type-Options "nosniff"
       Header set X-Frame-Options "SAMEORIGIN"
       Header set X-XSS-Protection "1; mode=block"
   </IfModule>
   
   # Protect sensitive files
   <FilesMatch "^\.env">
       Order allow,deny
       Deny from all
   </FilesMatch>
   
   <FilesMatch "^db_config\.php$">
       Order allow,deny
       Deny from all
   </FilesMatch>
   
   # Enable CORS (if needed for API)
   <IfModule mod_headers.c>
       Header set Access-Control-Allow-Origin "*"
       Header set Access-Control-Allow-Methods "GET, POST, OPTIONS"
       Header set Access-Control-Allow-Headers "Content-Type"
   </IfModule>
   ```

### Step 2: Set File Permissions

1. **Recommended Permissions**
   - Folders: `755`
   - PHP files: `644`
   - .htaccess: `644`

2. **Set via File Manager**
   - Right-click file/folder → **Permissions**
   - Set appropriate permissions

---

## 🧪 Testing

### Step 1: Test Homepage

1. Visit: `https://yourdomain.com`
2. Verify homepage loads correctly
3. Check all links work

### Step 2: Test Consultation Form

1. Visit: `https://yourdomain.com/contact.html`
2. Fill out the form:
   - Name: Test User
   - Email: test@example.com
   - Phone: 1234567890
   - Select date and time
   - Choose consultation type
   - Add message
3. Submit form
4. Check for success message

### Step 3: Test Admin Dashboard

1. Visit: `https://yourdomain.com/admin_consultations.php`
2. Verify your test consultation appears
3. Test filtering and viewing details

### Step 4: Test Database Connection

1. **Check phpMyAdmin**
   - Go to phpMyAdmin
   - Select your database
   - Check `consultations` table
   - Verify test data is inserted

### Step 5: Test on Mobile

1. Open site on mobile device
2. Test form submission
3. Verify responsive design

---

## 🐛 Troubleshooting

### Issue 1: "500 Internal Server Error"

**Causes:**
- Incorrect file permissions
- PHP syntax errors
- .htaccess misconfiguration

**Solutions:**
```bash
✓ Check error logs in hPanel → Error Logs
✓ Set file permissions: folders 755, files 644
✓ Temporarily rename .htaccess to test
✓ Check PHP version compatibility
```

### Issue 2: "Database Connection Failed"

**Causes:**
- Incorrect database credentials
- Database not created
- User privileges not granted

**Solutions:**
```bash
✓ Verify DB_HOST is 'localhost'
✓ Check database name includes Hostinger prefix
✓ Verify user has ALL PRIVILEGES
✓ Test connection in phpMyAdmin
```

### Issue 3: "404 Not Found"

**Causes:**
- Files not uploaded to correct directory
- Incorrect file paths

**Solutions:**
```bash
✓ Ensure files are in public_html
✓ Check file names (case-sensitive)
✓ Verify .htaccess DirectoryIndex
```

### Issue 4: Form Not Submitting

**Causes:**
- CORS issues
- PHP file not processing
- JavaScript errors

**Solutions:**
```bash
✓ Check browser console (F12)
✓ Verify save_inquiry.php exists
✓ Check CORS headers in .htaccess
✓ Test with browser network tab
```

### Issue 5: "Access Denied" for Database

**Causes:**
- Incorrect username/password
- User not added to database

**Solutions:**
```bash
✓ Re-check credentials in db_config.php
✓ Recreate database user if needed
✓ Grant ALL PRIVILEGES again
```

### Issue 6: MongoDB Connection Timeout

**Causes:**
- Incorrect connection string
- IP not whitelisted in MongoDB Atlas

**Solutions:**
```bash
✓ Verify MONGODB_URI in .env
✓ Add 0.0.0.0/0 to MongoDB Atlas IP whitelist
✓ Check MongoDB Atlas user credentials
✓ Test connection string locally first
```

---

## 🔒 Security Best Practices

### After Deployment:

1. **Delete Sensitive Files**
   ```bash
   ✓ setup_database.php (after running once)
   ✓ .env.example
   ✓ All .md documentation files
   ```

2. **Protect Configuration Files**
   - Ensure `.htaccess` blocks access to:
     - `.env`
     - `db_config.php`
     - `.git` (if uploaded accidentally)

3. **Enable HTTPS**
   - In hPanel, go to **Security** → **SSL**
   - Install free Let's Encrypt SSL certificate
   - Force HTTPS redirect

4. **Regular Backups**
   - In hPanel, go to **Files** → **Backups**
   - Enable automatic backups
   - Download manual backup after deployment

5. **Update Passwords**
   - Use strong database passwords
   - Change default admin credentials
   - Store passwords securely

---

## 📊 Post-Deployment Checklist

- [ ] Homepage loads correctly
- [ ] All HTML pages accessible
- [ ] Consultation form submits successfully
- [ ] Admin dashboard displays data
- [ ] Database connection working
- [ ] Mobile responsive design verified
- [ ] SSL certificate installed
- [ ] HTTPS redirect enabled
- [ ] Error logs checked
- [ ] Backup created
- [ ] Sensitive files deleted
- [ ] File permissions set correctly
- [ ] .htaccess configured
- [ ] Contact email working
- [ ] All images loading
- [ ] Cross-browser testing done

---

## 🎯 Quick Reference

### Hostinger Database Info
```
Host: localhost
Database: u123456789_hexatp
User: u123456789_hexatp_user
Password: [Your secure password]
```

### MongoDB Atlas Info
```
Connection String: mongodb+srv://sakshidhawale5004_db_user:F3HhLhR9dKAVlfD0@cluster0.zmdcesr.mongodb.net/hexatp_db?retryWrites=true&w=majority
Database: hexatp_db
```

### Important URLs
```
Homepage: https://yourdomain.com
Contact Form: https://yourdomain.com/contact.html
Admin Dashboard: https://yourdomain.com/admin_consultations.php
phpMyAdmin: [Access via hPanel]
```

---

## 📞 Support

**Hostinger Support:**
- Live Chat: Available 24/7 in hPanel
- Email: support@hostinger.com
- Knowledge Base: https://support.hostinger.com

**HexaTP Support:**
- Email: md@hexatp.com
- Phone: +91-8288800341

---

## 📝 Notes

- Hostinger adds a prefix to database names (e.g., `u123456789_`)
- Always use `localhost` as DB_HOST on Hostinger
- Free SSL certificates are available via Let's Encrypt
- Node.js support varies by hosting plan
- MongoDB must be hosted externally (MongoDB Atlas)

---

**Status**: ✅ Ready for Deployment  
**Last Updated**: April 17, 2026  
**Version**: 1.0.0

---

Good luck with your deployment! 🚀
