# 🚀 Quick Start - Corrected & Secure

## ⚠️ READ THIS FIRST!

**3 Critical Actions Before Deployment:**

1. 🔴 **Change MongoDB Password** (if exposed)
   - Go to MongoDB Atlas
   - Change password immediately
   - Update .env file

2. 🔴 **Choose Your Stack**
   - ✅ PHP + MySQL (Recommended for Hostinger)
   - ❌ Node.js + MongoDB (VPS only)

3. 🔴 **Read Security Alert**
   - Open: `SECURITY_ALERT.md`
   - Follow all steps

---

## 🎯 Recommended: PHP + MySQL

**Why?**
- ✅ Works on basic Hostinger
- ✅ Simple deployment
- ✅ Your project uses PHP files
- ✅ Fast and reliable

---

## 📋 5-Minute Deployment

### Step 1: Upload Files (2 min)

**Upload to `public_html`:**
```
✅ All .html files
✅ save_inquiry.php
✅ admin_consultations.php
✅ db_config.php
✅ setup_database.php
✅ Images folder
```

**DON'T upload:**
```
❌ .git folder
❌ .env file
❌ .md files
❌ MongoDB files
❌ Python scripts
```

**⚠️ IMPORTANT:** Files must be DIRECTLY in `public_html`, not in a subfolder!

---

### Step 2: Create Database (1 min)

1. hPanel → **Databases** → **MySQL Databases**
2. Create database: `hexatp_db`
3. Create user: `hexatp_user`
4. Generate strong password
5. Grant ALL PRIVILEGES
6. **Save credentials!**

---

### Step 3: Configure Database (1 min)

Edit `db_config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'u123456789_hexatp_user');  // Your username
define('DB_PASS', 'YOUR_PASSWORD');            // Your password
define('DB_NAME', 'u123456789_hexatp_db');     // Your database
```

---

### Step 4: Initialize Database (30 sec)

1. Visit: `https://yourdomain.com/setup_database.php`
2. See success message
3. 🔴 **DELETE setup_database.php immediately!**

---

### Step 5: Test (30 sec)

1. Visit: `https://yourdomain.com`
2. Test contact form
3. Check admin dashboard
4. Done! ✅

---

## 🔒 Security Checklist

After deployment:

- [ ] Deleted setup_database.php
- [ ] Created .htaccess with protections
- [ ] Installed SSL certificate
- [ ] Enabled HTTPS redirect
- [ ] Changed MongoDB password (if exposed)
- [ ] Verified form action points to save_inquiry.php
- [ ] Set CORS to your domain (not "*")
- [ ] Created backup

---

## 📄 Full Guides

**For detailed instructions:**
- 📖 `HOSTINGER_DEPLOYMENT_CORRECTED.md` - Complete guide
- 🔒 `SECURITY_ALERT.md` - Security warnings
- ✅ `CORRECTIONS_SUMMARY.md` - What was fixed

---

## 🆘 Quick Troubleshooting

### 404 Error?
- Files must be in `public_html` root
- Not in subfolder!

### Database Error?
- Check credentials in db_config.php
- Verify database exists in phpMyAdmin
- Check user has privileges

### Form Not Working?
- Verify `<form action="save_inquiry.php" method="POST">`
- Check browser console (F12)
- Verify save_inquiry.php exists

---

## 📞 Need Help?

**Read these first:**
1. `SECURITY_ALERT.md` - If password was exposed
2. `HOSTINGER_DEPLOYMENT_CORRECTED.md` - Full guide
3. `CORRECTIONS_SUMMARY.md` - What changed

**Still stuck?**
- Hostinger: Live chat in hPanel
- Email: md@hexatp.com

---

**Status**: ✅ Corrected & Secure  
**Time**: 5 minutes  
**Difficulty**: Easy
