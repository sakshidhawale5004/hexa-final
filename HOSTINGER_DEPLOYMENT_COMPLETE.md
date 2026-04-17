# 🚀 Complete Hostinger Deployment Guide

## ✅ Deploy HexaTP to Hostinger (No Local MySQL Needed!)

Since you have SQL issues locally, let's deploy directly to Hostinger where everything will work perfectly!

---

## 📋 **What You'll Deploy**

**37 Production Files:**
- 24 HTML pages
- 3 PHP files (backend)
- 8 images
- 2 documentation files

**Total Size:** ~19.3 MB

---

## 🚀 **Step-by-Step Deployment**

### **STEP 1: Download Your Files from GitHub**

1. Go to: https://github.com/sakshidhawale5004/hexa-final
2. Click the green **"Code"** button
3. Click **"Download ZIP"**
4. Extract the ZIP file to your desktop
5. Open the extracted folder: `hexa-final-main`

---

### **STEP 2: Login to Hostinger**

1. Go to: https://www.hostinger.com
2. Click **"Login"**
3. Enter your credentials
4. Go to **"Hosting"** → Select your hosting plan

---

### **STEP 3: Upload Files to Hostinger**

#### **Option A: Using File Manager (Recommended)**

1. In Hostinger panel, click **"File Manager"**
2. Navigate to **`public_html`** folder
3. **Delete** any existing files (like index.html, if present)
4. Click **"Upload Files"**
5. Select ALL files from your extracted folder
6. Upload all 37 files
7. Wait for upload to complete

#### **Option B: Using FTP (Advanced)**

1. In Hostinger panel, go to **"FTP Accounts"**
2. Note your FTP credentials
3. Use FileZilla or any FTP client
4. Connect and upload files to `public_html`

---

### **STEP 4: Create MySQL Database on Hostinger** ⭐

This is the most important step!

1. In Hostinger panel, go to **"Databases"** → **"MySQL Databases"**

2. Click **"Create New Database"**

3. **Fill in details:**
   - **Database Name:** `hexatp_db` (or any name you prefer)
   - Click **"Create"**

4. **Create Database User:**
   - **Username:** Choose a username (e.g., `hexatp_user`)
   - **Password:** Create a strong password
   - Click **"Create User"**

5. **Add User to Database:**
   - Select your database: `hexatp_db`
   - Select your user: `hexatp_user`
   - Grant **"All Privileges"**
   - Click **"Add"**

6. **Note Down These Details:** ⚠️ IMPORTANT
   ```
   Database Host: localhost (or provided by Hostinger)
   Database Name: hexatp_db (or your chosen name)
   Database User: hexatp_user (or your chosen username)
   Database Password: [your password]
   ```

---

### **STEP 5: Update Database Configuration**

1. In Hostinger **File Manager**, navigate to `public_html`

2. Find and open **`db_config.php`**

3. Click **"Edit"**

4. **Update these lines:**

   ```php
   <?php
   // OLD (Local XAMPP settings)
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'hexatp_db');
   ```

   **Change to (Hostinger settings):**
   ```php
   <?php
   // Hostinger Database Settings
   define('DB_HOST', 'localhost');  // Or hostname from Hostinger
   define('DB_USER', 'hexatp_user');  // Your database username
   define('DB_PASS', 'your_password_here');  // Your database password
   define('DB_NAME', 'hexatp_db');  // Your database name
   ```

5. Click **"Save"**

---

### **STEP 6: Create Database Tables**

#### **Option A: Using phpMyAdmin (Recommended)**

1. In Hostinger panel, go to **"Databases"** → **"phpMyAdmin"**

2. Click on your database name (e.g., `hexatp_db`) in the left sidebar

3. Click **"SQL"** tab at the top

4. **Copy and paste this SQL code:**

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

6. You should see: **"2 rows affected"** or success message

7. Click **"Structure"** tab to verify both tables are created

#### **Option B: Using create_database.php**

1. Visit: `https://yourdomain.com/create_database.php`
2. It will automatically create the tables
3. You should see success messages

---

### **STEP 7: Test Your Website** ✅

1. **Visit your homepage:**
   ```
   https://yourdomain.com
   ```
   Should load the HexaTP homepage

2. **Test contact form:**
   ```
   https://yourdomain.com/contact.html
   ```
   - Fill out the form
   - Submit
   - Should see success message

3. **Check admin panel:**
   ```
   https://yourdomain.com/admin_consultations.php
   ```
   Should show your test submission

4. **Verify in database:**
   - Go to phpMyAdmin
   - Click `consultations` table
   - Click "Browse"
   - Should see your test data

---

## 🔐 **Security Steps (Important!)**

### **1. Secure Your Admin Panel**

The admin panel is currently open to everyone. Add password protection:

**Create `.htaccess` file in public_html:**
```apache
# Protect admin panel
<Files "admin_consultations.php">
    AuthType Basic
    AuthName "Admin Area"
    AuthUserFile /path/to/.htpasswd
    Require valid-user
</Files>
```

**Or use Hostinger's "Password Protect Directories" feature:**
1. Go to **"Advanced"** → **"Directory Privacy"**
2. Select `public_html`
3. Enable protection for admin files

### **2. Enable SSL Certificate**

1. In Hostinger panel, go to **"SSL"**
2. Enable **"Free SSL Certificate"**
3. Wait 10-15 minutes for activation
4. Your site will use HTTPS

### **3. Set Up Backups**

1. Go to **"Backups"** in Hostinger panel
2. Enable **"Automatic Backups"**
3. Or manually backup weekly

---

## 📊 **File Structure on Hostinger**

```
public_html/
├── index.html              # Homepage
├── contact.html            # Contact form
├── aboutus.html           # About page
├── solution.html          # Solutions
├── admin_consultations.php # Admin panel
├── db_config.php          # Database config (UPDATED)
├── save_inquiry.php       # Form handler
├── create_database.php    # Database setup
├── test_connection.php    # Connection test
├── check_status.php       # Status checker
├── quick_links.html       # Quick links
├── README.md              # Documentation
├── HOSTINGER_DEPLOYMENT_READY.md
├── [20 country pages].html
└── [8 images]
```

---

## 🔍 **Troubleshooting**

### **Issue 1: "Database connection failed"**

**Solution:**
1. Check `db_config.php` has correct credentials
2. Verify database user has privileges
3. Check database host (might not be 'localhost')
4. Contact Hostinger support for correct hostname

### **Issue 2: "Table doesn't exist"**

**Solution:**
1. Go to phpMyAdmin
2. Run the SQL script from Step 6
3. Or visit: `yourdomain.com/create_database.php`

### **Issue 3: "500 Internal Server Error"**

**Solution:**
1. Check file permissions (should be 644 for files, 755 for folders)
2. Check for PHP errors in error logs
3. Verify PHP version is 7.4 or higher

### **Issue 4: "Form not submitting"**

**Solution:**
1. Check browser console for errors (F12)
2. Verify `save_inquiry.php` has correct database credentials
3. Test database connection: `yourdomain.com/test_connection.php`

### **Issue 5: "Images not loading"**

**Solution:**
1. Verify images are uploaded to `public_html`
2. Check file names match exactly (case-sensitive)
3. Check file permissions

---

## ✅ **Deployment Checklist**

Use this checklist to ensure everything is done:

- [ ] Downloaded files from GitHub
- [ ] Logged into Hostinger
- [ ] Uploaded all files to `public_html`
- [ ] Created MySQL database
- [ ] Created database user
- [ ] Granted user privileges
- [ ] Updated `db_config.php` with Hostinger credentials
- [ ] Created database tables (via phpMyAdmin or create_database.php)
- [ ] Tested homepage loads
- [ ] Tested contact form submission
- [ ] Verified data in phpMyAdmin
- [ ] Checked admin panel works
- [ ] Enabled SSL certificate
- [ ] Set up backups
- [ ] Protected admin panel (optional but recommended)

---

## 🎯 **Quick Reference**

### **Your Hostinger URLs:**
```
Homepage:     https://yourdomain.com
Contact:      https://yourdomain.com/contact.html
Admin:        https://yourdomain.com/admin_consultations.php
phpMyAdmin:   [Access from Hostinger panel]
```

### **Database Info:**
```
Host:     localhost (or from Hostinger)
Database: hexatp_db (or your chosen name)
User:     hexatp_user (or your chosen username)
Password: [your password]
```

### **Files to Update:**
```
db_config.php - Update with Hostinger database credentials
```

---

## 📞 **Need Help?**

### **Hostinger Support:**
- Live Chat: Available 24/7 in Hostinger panel
- Email: support@hostinger.com
- Knowledge Base: https://support.hostinger.com

### **Common Hostinger Locations:**
- **File Manager:** Hosting → File Manager
- **Databases:** Hosting → Databases → MySQL Databases
- **phpMyAdmin:** Hosting → Databases → phpMyAdmin
- **SSL:** Hosting → SSL
- **Backups:** Hosting → Backups

---

## 🎉 **Success!**

Once you complete all steps:

✅ Your website will be live at your domain
✅ Contact form will save to Hostinger database
✅ Admin panel will show submissions
✅ No local MySQL needed!
✅ Professional hosting with SSL

---

## 📝 **Summary**

**What You Did:**
1. ✅ Downloaded files from GitHub
2. ✅ Uploaded to Hostinger
3. ✅ Created MySQL database on Hostinger
4. ✅ Updated db_config.php
5. ✅ Created database tables
6. ✅ Tested everything works

**What You Have:**
- ✅ Live website on Hostinger
- ✅ Working contact form
- ✅ Database on Hostinger servers
- ✅ Admin panel to view submissions
- ✅ No local setup needed!

---

**Your website is now live and professional! 🚀**

*Deployment Guide - April 17, 2026*
