# HexaTP Consultation System - Quick Start Guide

## 🚀 Get Started in 3 Steps

### Step 1: Setup Database (2 minutes)
```bash
# Open browser and navigate to:
http://localhost/xampp3/htdocs/hexatp-project/setup_database.php

# You should see:
✓ Database 'hexatp_db' created successfully or already exists.
✓ Table 'consultations' created successfully or already exists.
✓ Table 'inquiries' created successfully or already exists.
✓ Database setup completed successfully!
```

### Step 2: Test the Consultation Form (1 minute)
```
1. Open: http://localhost/xampp3/htdocs/hexatp-project/contact.html
2. Select a date from the calendar
3. Select a time slot
4. Choose consultation type
5. Fill in your details
6. Click "Schedule Consultation"
```

### Step 3: View Admin Dashboard (1 minute)
```
1. Open: http://localhost/xampp3/htdocs/hexatp-project/admin_consultations.php
2. View all consultation requests
3. Filter by status
4. Click "View" to see details
```

---

## 📋 File Structure

```
hexatp-project/
├── contact.html                 ← Consultation form (mobile responsive)
├── save_inquiry.php             ← Form submission handler
├── db_config.php                ← Database configuration
├── setup_database.php           ← Database setup script
├── admin_consultations.php      ← Admin dashboard
├── DATABASE_SETUP.md            ← Detailed setup guide
├── IMPLEMENTATION_SUMMARY.md    ← Full implementation details
├── QUICK_START.md               ← This file
└── [other project files]
```

---

## 🔧 Configuration

### Change Database Credentials
Edit `db_config.php`:
```php
define('DB_HOST', 'localhost');      // Your host
define('DB_USER', 'root');           // Your username
define('DB_PASS', '');               // Your password
define('DB_NAME', 'hexatp_db');      // Your database name
```

---

## 📱 Mobile Responsive

The consultation form is fully responsive:
- ✅ Desktop (1200px+)
- ✅ Tablet (768px-992px)
- ✅ Mobile (576px-768px)
- ✅ Small Mobile (400px-576px)
- ✅ Extra Small (<400px)

Test on your phone or use browser DevTools (F12).

---

## 🔒 Security Features

- ✅ SQL Injection Prevention (Prepared Statements)
- ✅ Input Validation
- ✅ Email Validation
- ✅ Error Handling
- ✅ Sanitized Output

---

## 📊 Consultation Types

Users can select from:
1. Transfer Pricing Consultation
2. Tax Strategy Review
3. Compliance Audit
4. General Inquiry

---

## ⏰ Available Time Slots

- 09:00 AM
- 10:00 AM
- 11:00 AM
- 02:00 PM
- 03:00 PM
- 04:00 PM

---

## 🐛 Troubleshooting

### "Connection Failed" Error
```
✓ Ensure MySQL is running in XAMPP
✓ Check database credentials in db_config.php
✓ Verify database name is hexatp_db
```

### "Table doesn't exist" Error
```
✓ Run setup_database.php again
✓ Check phpMyAdmin for table creation
```

### Form Not Submitting
```
✓ Check browser console (F12)
✓ Verify save_inquiry.php exists
✓ Ensure PHP is processing the file
```

---

## 📞 Contact Information

**Email**: md@hexatp.com  
**Phone**: +91-8288800341  
**Website**: https://hexatp.com

---

## 🎯 What's Included

### Consultation Form Features
- 📅 Interactive calendar date picker
- ⏰ Time slot selection
- 📝 Consultation type dropdown
- 👤 Contact information fields
- 💬 Optional message field
- ✅ Form validation
- 📧 Email validation

### Admin Dashboard Features
- 📊 Statistics overview
- 📋 Consultation list
- 🔍 Filter by status
- 👁️ Detailed view modals
- 📱 Responsive design

### Database Features
- 🔐 Secure connection
- 🛡️ SQL injection prevention
- 📝 Prepared statements
- 🔍 Indexed queries
- 📊 Status tracking

---

## 🚀 Next Steps

1. ✅ Run setup_database.php
2. ✅ Test the consultation form
3. ✅ View admin dashboard
4. ✅ Customize consultation types (edit contact.html)
5. ✅ Add email notifications (optional)

---

## 📚 Documentation

- **DATABASE_SETUP.md** - Detailed setup instructions
- **IMPLEMENTATION_SUMMARY.md** - Full implementation details
- **QUICK_START.md** - This file

---

## ✨ Features at a Glance

| Feature | Status |
|---------|--------|
| Database Setup | ✅ Complete |
| Consultation Form | ✅ Complete |
| Mobile Responsive | ✅ Complete |
| Admin Dashboard | ✅ Complete |
| Security | ✅ Complete |
| Documentation | ✅ Complete |
| Email Notifications | ⏳ Optional |
| Payment Integration | ⏳ Optional |

---

**Last Updated**: April 16, 2026  
**Status**: Ready for Production
