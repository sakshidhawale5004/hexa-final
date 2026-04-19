# 🚀 HexaTP Deployment Checklist

## Current Status: Database Setup Phase

---

## ✅ Phase 1: Database Creation (COMPLETED)

- [x] Created MySQL database on Hostinger
  - Database: `u852823366_hexatp`
  - User: `u852823366_hexatp`
  - Password: `Hexatp_2026`
- [x] Updated `db_config.php` with credentials
- [x] Created test connection script

---

## 🔄 Phase 2: Database Tables Setup (IN PROGRESS)

### Step 1: Create Tables Using phpMyAdmin

1. **Access phpMyAdmin:**
   - Go to: https://hpanel.hostinger.com/websites/hexatp.com
   - Click "Databases" in sidebar
   - Click "Manage" next to `u852823366_hexatp`
   - Click "phpMyAdmin" button

2. **Run SQL Script:**
   - Click "SQL" tab in phpMyAdmin
   - Copy the SQL below and paste it
   - Click "Go" button

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

3. **Verify Tables Created:**
   - You should see success message
   - Tables will appear in left sidebar

### Step 2: Test Database Connection

1. **Upload test_connection.php to Hostinger:**
   - Use Hostinger File Manager
   - Upload to `public_html/` folder

2. **Visit Test Page:**
   - Go to: https://hexatp.com/test_connection.php
   - Check all tests pass ✅

3. **Expected Results:**
   - ✅ Database Configuration File loaded
   - ✅ Database Connection successful
   - ✅ All tables exist
   - ✅ Write permissions working
   - ✅ All PHP files present

---

## 📋 Phase 3: File Upload & Verification

### Files to Upload to Hostinger (public_html/)

Check each file as you upload:

**Core Files:**
- [ ] `index.html` - Homepage
- [ ] `contact.html` - Contact page
- [ ] `aboutus.html` - About page

**Country Pages:**
- [ ] `India.html`
- [ ] `australia.html`
- [ ] `bahrain.html`
- [ ] `bangladesh.html`
- [ ] `botswana.html`
- [ ] `canada.html`
- [ ] `egypt.html`
- [ ] `ghana.html`
- [ ] `indonesia.html`
- [ ] `kenya.html`
- [ ] `malaysia.html`
- [ ] (Add other country pages as needed)

**PHP Backend Files:**
- [ ] `db_config.php` - Database configuration
- [ ] `save_inquiry.php` - Contact form handler
- [ ] `admin_consultations.php` - Admin panel
- [ ] `check_status.php` - Status checker
- [ ] `create_database.php` - Database setup script (temporary)
- [ ] `test_connection.php` - Connection tester (temporary)

**Images:**
- [ ] `gyan.jpg`
- [ ] `gyanf.jpg`
- [ ] `himanshu1.png`
- [ ] `hitansu.png`
- [ ] `manoomet.png`
- [ ] `mohammad.jpg`
- [ ] `mohaneetf.jpg`
- [ ] `business-handshake-with-world-map-background.jpg`
- [ ] `image.png`
- [ ] `image-1.png`

---

## 🧪 Phase 4: Testing

### Test 1: Homepage
- [ ] Visit: https://hexatp.com
- [ ] Check all images load
- [ ] Check navigation works
- [ ] Check responsive design on mobile

### Test 2: Contact Form
- [ ] Visit: https://hexatp.com/contact.html
- [ ] Fill out form with test data
- [ ] Submit form
- [ ] Check for success message
- [ ] Verify data in database (phpMyAdmin)

### Test 3: Admin Panel
- [ ] Visit: https://hexatp.com/admin_consultations.php
- [ ] Check if test submission appears
- [ ] Test status updates
- [ ] Test filtering/search (if available)

### Test 4: Status Checker
- [ ] Visit: https://hexatp.com/check_status.php
- [ ] Enter test email
- [ ] Verify status displays correctly

### Test 5: All Country Pages
- [ ] Click each country link from homepage
- [ ] Verify pages load correctly
- [ ] Check content displays properly

---

## 🔒 Phase 5: Security Hardening

### Step 1: Delete Temporary Files

After all tests pass, delete these files from public_html:

- [ ] `test_connection.php` ⚠️ IMPORTANT
- [ ] `create_database.php` ⚠️ IMPORTANT
- [ ] `DATABASE_SETUP_GUIDE.md`
- [ ] `DEPLOYMENT_CHECKLIST.md` (this file)

### Step 2: Secure db_config.php

**Option A: Move Outside public_html (Recommended)**
1. Move `db_config.php` to parent directory
2. Update include paths in PHP files:
   ```php
   require_once '../db_config.php';
   ```

**Option B: Use .htaccess Protection**
1. Create/edit `.htaccess` in public_html
2. Add these lines:
   ```apache
   <Files "db_config.php">
       Order Allow,Deny
       Deny from all
   </Files>
   ```

### Step 3: Set Proper File Permissions

In Hostinger File Manager, set permissions:
- [ ] PHP files: 644
- [ ] HTML files: 644
- [ ] Image files: 644
- [ ] Directories: 755

### Step 4: Enable HTTPS

- [ ] Go to Hostinger → SSL
- [ ] Enable SSL certificate
- [ ] Force HTTPS redirect

### Step 5: Add Security Headers

Add to `.htaccess`:
```apache
# Security Headers
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"
Header set Referrer-Policy "strict-origin-when-cross-origin"

# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 📧 Phase 6: Email Configuration (Optional)

If you want email notifications for form submissions:

### Step 1: Configure Email in PHP Files

Update `save_inquiry.php` to send emails:
```php
// Add after successful database insert
$to = "your-email@hexatp.com";
$subject = "New Contact Form Submission";
$message = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
$headers = "From: noreply@hexatp.com";

mail($to, $subject, $message, $headers);
```

### Step 2: Test Email Delivery

- [ ] Submit test form
- [ ] Check email inbox
- [ ] Check spam folder if not received

---

## 🎯 Phase 7: Final Verification

### Pre-Launch Checklist

- [ ] All pages load without errors
- [ ] Contact form works and saves to database
- [ ] Admin panel accessible and functional
- [ ] All images display correctly
- [ ] Mobile responsive design works
- [ ] HTTPS enabled and working
- [ ] Security files deleted
- [ ] Database credentials secured
- [ ] Email notifications working (if configured)
- [ ] Browser testing (Chrome, Firefox, Safari, Edge)

### Performance Check

- [ ] Test page load speed: https://pagespeed.web.dev/
- [ ] Check mobile usability: https://search.google.com/test/mobile-friendly
- [ ] Verify SSL: https://www.ssllabs.com/ssltest/

---

## 🆘 Troubleshooting Guide

### Issue: "Connection Failed" Error

**Solution:**
1. Check `db_config.php` credentials
2. Verify database exists in Hostinger panel
3. Check if MySQL service is running
4. Test connection using `test_connection.php`

### Issue: "Table doesn't exist" Error

**Solution:**
1. Run SQL script in phpMyAdmin
2. Verify tables created: `SHOW TABLES;`
3. Check table structure: `DESCRIBE tablename;`

### Issue: Form Submission Not Working

**Solution:**
1. Check browser console for JavaScript errors
2. Verify form action points to correct PHP file
3. Check PHP error logs in Hostinger
4. Test with `test_connection.php`

### Issue: Images Not Loading

**Solution:**
1. Verify images uploaded to correct folder
2. Check file names match HTML references (case-sensitive)
3. Check file permissions (should be 644)
4. Clear browser cache

### Issue: Admin Panel Not Accessible

**Solution:**
1. Check if `admin_consultations.php` uploaded
2. Verify database connection working
3. Check PHP error logs
4. Add authentication if needed

---

## 📞 Support Resources

### Hostinger Support
- Help Center: https://support.hostinger.com
- Live Chat: Available 24/7 in Hostinger panel
- Email: support@hostinger.com

### Database Issues
- phpMyAdmin documentation: https://docs.phpmyadmin.net/
- MySQL documentation: https://dev.mysql.com/doc/

### PHP Issues
- PHP documentation: https://www.php.net/docs.php
- Error log location: Check Hostinger panel → Files → Error Logs

---

## 🎉 Launch Checklist

When everything is ready:

- [ ] All tests passed
- [ ] Security measures implemented
- [ ] Backup created
- [ ] DNS configured (if using custom domain)
- [ ] Google Analytics added (optional)
- [ ] Sitemap submitted to Google (optional)
- [ ] Social media links updated
- [ ] Contact information verified

---

**Deployment Date:** April 18, 2026  
**Project:** HexaTP Transfer Pricing Solutions  
**Domain:** https://hexatp.com

**Status:** 🔄 IN PROGRESS - Database Tables Setup Phase

---

## Quick Command Reference

### Upload Files via FTP (if using FTP client)
```
Host: ftp.hexatp.com
Username: u852823366
Password: [Your Hostinger Password]
Port: 21
```

### MySQL Connection Details
```
Host: localhost
Database: u852823366_hexatp
Username: u852823366_hexatp
Password: Hexatp_2026
```

### Important URLs
- Website: https://hexatp.com
- Admin Panel: https://hexatp.com/admin_consultations.php
- Test Connection: https://hexatp.com/test_connection.php (delete after testing)
- Hostinger Panel: https://hpanel.hostinger.com
- phpMyAdmin: Access via Hostinger → Databases → Manage

---

**Next Immediate Steps:**
1. ✅ Create database tables in phpMyAdmin (SQL provided above)
2. ✅ Upload test_connection.php to Hostinger
3. ✅ Visit test page to verify setup
4. ✅ Upload all website files
5. ✅ Test contact form
6. ✅ Delete security-sensitive files
