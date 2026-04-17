# HexaTP Consultation System

A modern, secure, and mobile-responsive consultation booking system for HexaTP's transfer pricing services.

## 🎯 Overview

This system enables clients to:
- 📅 Book consultation appointments with an interactive calendar
- ⏰ Select preferred time slots
- 📝 Choose consultation types
- 💬 Provide additional information
- 📊 Track consultation status

## ✨ Key Features

### 🎨 User Interface
- **Modern Design**: Glass-morphism UI with dark theme
- **Mobile Responsive**: Works perfectly on all devices
- **Interactive Calendar**: Easy date selection with visual feedback
- **Time Slot Selection**: 6 available time slots (9 AM - 4 PM)
- **Form Validation**: Real-time input validation

### 🔒 Security
- **SQL Injection Prevention**: Prepared statements
- **Input Validation**: Email and required field validation
- **Sanitized Output**: XSS protection
- **Error Handling**: Graceful error messages

### 📱 Responsive Design
- Desktop (1200px+)
- Tablet (768px-992px)
- Mobile (576px-768px)
- Small Mobile (400px-576px)
- Extra Small (<400px)

### 🗄️ Database
- Secure MySQL connection
- Indexed queries for performance
- Status tracking (pending, confirmed, completed, cancelled)
- Timestamp tracking

### 👨‍💼 Admin Dashboard
- View all consultations
- Filter by status
- Detailed consultation view
- Statistics overview

## 📁 Project Structure

```
hexatp-project/
├── contact.html                    # Consultation form (mobile responsive)
├── save_inquiry.php                # Form submission handler
├── db_config.php                   # Database configuration
├── setup_database.php              # Database initialization
├── admin_consultations.php         # Admin dashboard
├── README.md                       # This file
├── QUICK_START.md                  # Quick start guide
├── DATABASE_SETUP.md               # Detailed setup instructions
├── IMPLEMENTATION_SUMMARY.md       # Implementation details
├── DEPLOYMENT_CHECKLIST.md         # Deployment verification
└── [other project files]
```

## 🚀 Quick Start

### 1. Setup Database (2 minutes)
```bash
# Navigate to project directory
cd C:\xampp3\htdocs\hexatp-project

# Run setup script in browser
http://localhost/xampp3/htdocs/hexatp-project/setup_database.php
```

### 2. Test Consultation Form (1 minute)
```
http://localhost/xampp3/htdocs/hexatp-project/contact.html
```

### 3. View Admin Dashboard (1 minute)
```
http://localhost/xampp3/htdocs/hexatp-project/admin_consultations.php
```

## 🔧 Configuration

### Database Credentials
Edit `db_config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hexatp_db');
```

## 📊 Database Schema

### consultations Table
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
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_date (appointment_date),
    INDEX idx_status (status)
);
```

## 🎯 Consultation Types

Users can select from:
1. **Transfer Pricing Consultation** - Expert guidance on transfer pricing strategies
2. **Tax Strategy Review** - Comprehensive tax planning review
3. **Compliance Audit** - Ensure compliance with regulations
4. **General Inquiry** - General questions about services

## ⏰ Available Time Slots

- 09:00 AM
- 10:00 AM
- 11:00 AM
- 02:00 PM
- 03:00 PM
- 04:00 PM

## 🔐 Security Features

### Input Validation
- Email format validation
- Required field validation
- Type checking

### SQL Injection Prevention
- Prepared statements
- Parameterized queries
- Input sanitization

### Error Handling
- Graceful error messages
- No sensitive information exposed
- JSON error responses

## 📱 Mobile Responsiveness

The system is fully responsive with optimized layouts for:

| Device | Width | Layout |
|--------|-------|--------|
| Desktop | 1200px+ | Full side-by-side |
| Tablet | 768px-992px | Adjusted spacing |
| Mobile | 576px-768px | Single column |
| Small Mobile | 400px-576px | Compact |
| Extra Small | <400px | Minimal |

## 🧪 Testing

### Test the Consultation Form
1. Open `contact.html`
2. Select a date from the calendar
3. Select a time slot
4. Choose consultation type
5. Fill in contact information
6. Submit the form

### Verify Data in Admin Dashboard
1. Open `admin_consultations.php`
2. Check that your consultation appears
3. Click "View" to see details
4. Test filtering by status

## 📚 Documentation

- **QUICK_START.md** - Get started in 3 steps
- **DATABASE_SETUP.md** - Detailed setup instructions
- **IMPLEMENTATION_SUMMARY.md** - Full implementation details
- **DEPLOYMENT_CHECKLIST.md** - Pre-deployment verification

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

## 🔄 API Endpoints

### POST /save_inquiry.php
Submit a consultation request.

**Parameters:**
```json
{
  "name": "string (required)",
  "email": "string (required, valid email)",
  "phone": "string (required)",
  "subject": "string (required)",
  "appointment_date": "date (required, YYYY-MM-DD)",
  "appointment_time": "string (required)",
  "message": "string (optional)"
}
```

**Response:**
```json
{
  "success": true/false,
  "message": "Success or error message"
}
```

## 🚀 Deployment

### Prerequisites
- XAMPP installed
- MySQL running
- PHP 7.4+

### Deployment Steps
1. Copy files to `C:\xampp3\htdocs\hexatp-project\`
2. Run `setup_database.php`
3. Test consultation form
4. Verify admin dashboard
5. Monitor error logs

See `DEPLOYMENT_CHECKLIST.md` for detailed verification steps.

## 📈 Future Enhancements

- [ ] Email notifications
- [ ] Calendar integration (Google Calendar)
- [ ] Payment integration
- [ ] Analytics dashboard
- [ ] Multi-language support
- [ ] SMS notifications
- [ ] Video consultation support

## 📞 Support

**Email**: md@hexatp.com  
**Phone**: +91-8288800341  
**Emergency**: +91-8288800381

## 📄 License

© 2026 HexaTP – Transfer Pricing Intelligence Platform

## 🤝 Contributing

For bug reports or feature requests, please contact the development team.

## 📝 Changelog

### Version 1.0.0 (April 16, 2026)
- ✅ Initial release
- ✅ Database connectivity
- ✅ Mobile responsive design
- ✅ Admin dashboard
- ✅ Security features
- ✅ Comprehensive documentation

---

**Status**: ✅ Production Ready  
**Last Updated**: April 16, 2026  
**Maintained By**: HexaTP Development Team
