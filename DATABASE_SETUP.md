# HexaTP Consultation System - Database Setup Guide

## Overview
This guide explains how to set up the database for the HexaTP consultation booking system.

## Prerequisites
- XAMPP installed (C:\xampp3)
- MySQL running
- PHP 7.4 or higher

## Setup Steps

### 1. Start XAMPP Services
- Open XAMPP Control Panel
- Start **Apache** and **MySQL** services

### 2. Create Database
Navigate to the project directory and run the setup script:

```bash
# Option A: Using browser
http://localhost/hexatp-project/setup_database.php

# Option B: Using command line
cd C:\xampp3\htdocs\hexatp-project
php setup_database.php
```

You should see:
```
✓ Database 'hexatp_db' created successfully or already exists.
✓ Table 'consultations' created successfully or already exists.
✓ Table 'inquiries' created successfully or already exists.
✓ Database setup completed successfully!
```

### 3. Verify Database (Optional)
Open phpMyAdmin:
```
http://localhost/phpmyadmin
```

- Login with username: `root` (no password)
- Check that `hexatp_db` database exists
- Verify tables: `consultations` and `inquiries`

## Database Schema

### consultations Table
```sql
- id (INT, Primary Key, Auto Increment)
- name (VARCHAR 100)
- email (VARCHAR 100)
- phone (VARCHAR 20)
- consultation_type (VARCHAR 100)
- appointment_date (DATE)
- appointment_time (VARCHAR 20)
- message (LONGTEXT)
- status (ENUM: pending, confirmed, completed, cancelled)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### inquiries Table (Backward Compatibility)
```sql
- id (INT, Primary Key, Auto Increment)
- name (VARCHAR 100)
- email (VARCHAR 100)
- phone (VARCHAR 20)
- message (LONGTEXT)
- created_at (TIMESTAMP)
```

## Configuration

The database configuration is stored in `db_config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hexatp_db');
```

**To change credentials:**
1. Edit `db_config.php`
2. Update the constants with your database credentials
3. Run `setup_database.php` again

## Features

### Consultation Form
- **Date Selection**: Interactive calendar with date picker
- **Time Slots**: 6 available time slots (9 AM - 4 PM)
- **Consultation Types**:
  - Transfer Pricing Consultation
  - Tax Strategy Review
  - Compliance Audit
  - General Inquiry

### Security Features
- SQL Injection Prevention (Prepared Statements)
- Email Validation
- Input Sanitization
- CSRF Protection Ready

### Mobile Responsive
- Fully responsive design
- Works on all devices (mobile, tablet, desktop)
- Touch-friendly interface

## Testing the Form

1. Navigate to: `http://localhost/hexatp-project/contact.html`
2. Fill in the consultation form:
   - Select a date
   - Select a time
   - Choose consultation type
   - Enter name, email, phone
   - Add optional message
3. Click "Schedule Consultation"
4. Check phpMyAdmin to verify data was saved

## Troubleshooting

### "Connection Failed" Error
- Ensure MySQL is running in XAMPP
- Check database credentials in `db_config.php`
- Verify database name is `hexatp_db`

### "Table doesn't exist" Error
- Run `setup_database.php` again
- Check phpMyAdmin for table creation

### Form Not Submitting
- Check browser console for errors (F12)
- Verify `save_inquiry.php` is in the same directory
- Ensure PHP is processing the file

## File Structure
```
hexatp-project/
├── contact.html              # Consultation form (mobile responsive)
├── save_inquiry.php          # Form submission handler
├── db_config.php             # Database configuration
├── setup_database.php        # Database setup script
├── DATABASE_SETUP.md         # This file
└── [other project files]
```

## Next Steps

1. ✅ Run `setup_database.php` to create database
2. ✅ Test the consultation form
3. ✅ Create admin panel to view submissions (optional)
4. ✅ Set up email notifications (optional)

## Support
For issues or questions, contact: md@hexatp.com
