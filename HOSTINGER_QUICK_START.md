# 🚀 Hostinger Quick Start - 7 Simple Steps

## Skip Local MySQL Issues - Deploy Directly to Hostinger!

---

## ✅ **Step 1: Get Your Files** (2 minutes)

1. Go to: https://github.com/sakshidhawale5004/hexa-final
2. Click green **"Code"** button → **"Download ZIP"**
3. Extract ZIP to your desktop
4. You'll have a folder with 37 files

---

## ✅ **Step 2: Login to Hostinger** (1 minute)

1. Go to: https://www.hostinger.com
2. Login with your credentials
3. Click **"Hosting"**
4. Select your hosting plan

---

## ✅ **Step 3: Upload Files** (5 minutes)

1. Click **"File Manager"**
2. Go to **`public_html`** folder
3. Delete any existing files
4. Click **"Upload Files"**
5. Select ALL 37 files from extracted folder
6. Wait for upload to complete

---

## ✅ **Step 4: Create Database** (3 minutes) ⭐ IMPORTANT

1. Go to **"Databases"** → **"MySQL Databases"**

2. Click **"Create New Database"**
   - Name: `hexatp_db`
   - Click Create

3. Click **"Create New User"**
   - Username: `hexatp_user`
   - Password: [create strong password]
   - Click Create

4. **Add User to Database:**
   - Select database: `hexatp_db`
   - Select user: `hexatp_user`
   - Grant "All Privileges"
   - Click Add

5. **WRITE DOWN:**
   ```
   Database: hexatp_db
   Username: hexatp_user
   Password: [your password]
   Host: localhost
   ```

---

## ✅ **Step 5: Update Database Config** (2 minutes)

1. In **File Manager**, open `public_html/db_config.php`

2. Click **"Edit"**

3. **Change these lines:**
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'hexatp_user');     // ← Your username
   define('DB_PASS', 'your_password');   // ← Your password
   define('DB_NAME', 'hexatp_db');       // ← Your database name
   ```

4. Click **"Save"**

---

## ✅ **Step 6: Create Tables** (2 minutes)

### **Option A: Using phpMyAdmin** (Recommended)

1. Go to **"Databases"** → **"phpMyAdmin"**
2. Click your database (`hexatp_db`) in left sidebar
3. Click **"SQL"** tab
4. **Copy and paste this:**

```sql
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

5. Click **"Go"**
6. Should see success message

### **Option B: Automatic** (Easier)

1. Visit: `https://yourdomain.com/create_database.php`
2. Tables will be created automatically

---

## ✅ **Step 7: Test Everything** (3 minutes)

1. **Homepage:**
   ```
   https://yourdomain.com
   ```
   Should load your website

2. **Contact Form:**
   ```
   https://yourdomain.com/contact.html
   ```
   - Fill out form
   - Submit
   - Should see success message

3. **Admin Panel:**
   ```
   https://yourdomain.com/admin_consultations.php
   ```
   Should show your test submission

4. **Verify in Database:**
   - Go to phpMyAdmin
   - Click `consultations` table
   - Click "Browse"
   - See your data!

---

## 🎉 **Done! Your Website is Live!**

```
✅ Files uploaded to Hostinger
✅ Database created on Hostinger
✅ Tables created
✅ Configuration updated
✅ Website is live
✅ Contact form works
✅ No local MySQL needed!
```

---

## 🔐 **Bonus: Enable SSL** (Optional - 2 minutes)

1. In Hostinger panel, go to **"SSL"**
2. Click **"Enable Free SSL"**
3. Wait 10-15 minutes
4. Your site will use HTTPS

---

## 📞 **Quick Help**

### **Can't find something?**
- **File Manager:** Hosting → File Manager
- **Databases:** Hosting → Databases → MySQL Databases
- **phpMyAdmin:** Hosting → Databases → phpMyAdmin
- **SSL:** Hosting → SSL

### **Need support?**
- Click **"Live Chat"** in Hostinger panel (24/7)

---

## 📋 **Quick Checklist**

- [ ] Downloaded files from GitHub
- [ ] Uploaded to Hostinger public_html
- [ ] Created database
- [ ] Created database user
- [ ] Updated db_config.php
- [ ] Created tables (via phpMyAdmin or create_database.php)
- [ ] Tested homepage
- [ ] Tested contact form
- [ ] Verified in admin panel
- [ ] Enabled SSL (optional)

---

## 🎯 **Your URLs**

```
Website:  https://yourdomain.com
Contact:  https://yourdomain.com/contact.html
Admin:    https://yourdomain.com/admin_consultations.php
```

---

**Total Time: ~20 minutes**
**Result: Professional live website! 🚀**

*No local MySQL issues - everything runs on Hostinger!*
