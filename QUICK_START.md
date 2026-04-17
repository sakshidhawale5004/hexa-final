# 🚀 HexaTP - Quick Start Guide

**Your website is ready to deploy!** Here's what you need to know in 2 minutes.

---

## ✅ Current Status

**Everything is DONE and READY:**
- ✅ MongoDB removed → MySQL configured
- ✅ Images fixed (86 URLs replaced)
- ✅ Contact page updated ("GET IN TOUCH")
- ✅ Mobile responsive with hamburger menu
- ✅ 37 production files ready
- ✅ All changes on GitHub

---

## 🚀 Deploy to Hostinger (Recommended)

### **5 Simple Steps:**

**1. Upload Files**
- Login to Hostinger
- Go to File Manager → `public_html`
- Upload all files from `hexatp-main` folder

**2. Create Database**
- Go to Databases → MySQL Databases
- Create database: `hexatp_db`
- Create user with password
- Grant all privileges

**3. Update Config**
- Edit `db_config.php` in File Manager
- Add your database credentials:
  ```php
  define('DB_HOST', 'localhost');
  define('DB_USER', 'your_username');
  define('DB_PASS', 'your_password');
  define('DB_NAME', 'hexatp_db');
  ```

**4. Create Tables**
- Go to phpMyAdmin
- Select your database
- Click SQL tab
- Run this:
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
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );

  CREATE TABLE inquiries (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(100) NOT NULL,
      email VARCHAR(100) NOT NULL,
      phone VARCHAR(20) NOT NULL,
      message LONGTEXT,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );
  ```

**5. Test**
- Visit your domain
- Test contact form
- Check admin panel: `yourdomain.com/admin_consultations.php`

**Done!** Your website is live! 🎉

---

## 📁 What to Upload (37 Files)

### **HTML (24 files)**
All `.html` files from `hexatp-main` folder

### **PHP (3 files)**
- `db_config.php`
- `save_inquiry.php`
- `admin_consultations.php`

### **Images (8 files)**
- `gyan.jpg`
- `nitin.png`, `nitin1.png`
- `priyanka.png`
- `yishu.png`, `yishu1.png`
- `manoomet.png`
- `himanshu1.png`
- `hitansu.png`

### **Docs (2 files)**
- `README.md`
- `HOSTINGER_DEPLOYMENT_READY.md`

---

## 🔗 Important Links

**GitHub:**
https://github.com/sakshidhawale5004/hexa-final

**After Deployment:**
- Homepage: `https://yourdomain.com`
- Contact: `https://yourdomain.com/contact.html`
- Admin: `https://yourdomain.com/admin_consultations.php`

---

## 📚 Full Documentation

For detailed instructions, see:
- **`PROJECT_STATUS_FINAL.md`** - Complete status report
- **`hexatp-main/HOSTINGER_DEPLOYMENT_COMPLETE.md`** - Full deployment guide
- **`IMAGE_FIX_COMPLETE.md`** - Image fix details

---

## ❓ Need Help?

**Common Issues:**

**Q: Images not showing?**
A: Make sure you uploaded all 8 image files to `public_html`

**Q: Contact form not working?**
A: Check `db_config.php` has correct database credentials

**Q: Database connection failed?**
A: Verify database user has all privileges

**Q: 500 Error?**
A: Check file permissions (644 for files, 755 for folders)

---

## 🎯 What You Have

✅ Professional website  
✅ 24 pages of content  
✅ Working contact form  
✅ Admin panel  
✅ Mobile responsive  
✅ All images working  
✅ Ready to deploy  

---

## 🚀 Next Action

**Deploy to Hostinger now!** Follow the 5 steps above.

**Estimated time:** 30 minutes

**Result:** Live, professional website with working contact form! 🎉

---

*Last Updated: April 18, 2026*
