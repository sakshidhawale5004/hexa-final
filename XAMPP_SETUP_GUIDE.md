# HexaTP - XAMPP Setup Guide

## 🎯 Complete Setup Instructions for C:\xampp3\htdocs

### Prerequisites
- XAMPP installed at `C:\xampp3`
- Git installed on your system
- GitHub repository: https://github.com/sakshidhawale5004/hexa-final

---

## 📋 Step 1: Clone/Sync GitHub Repository

### Option A: Fresh Clone (If not already cloned)
```bash
cd C:\xampp3\htdocs
git clone https://github.com/sakshidhawale5004/hexa-final.git hexatp-main
```

### Option B: Update Existing Repository
```bash
cd C:\xampp3\htdocs\hexatp-main
git pull origin main
```

---

## 🗄️ Step 2: Setup MySQL Database

### 2.1 Start XAMPP Services
1. Open XAMPP Control Panel
2. Start **Apache** service
3. Start **MySQL** service

### 2.2 Create Database (Automatic Method)
1. Open your browser
2. Navigate to: `http://localhost/hexatp-main/setup_database.php`
3. This will automatically:
   - Create database `hexatp_db`
   - Create `consultations` table
   - Create `inquiries` table

### 2.3 Create Database (Manual Method via phpMyAdmin)
1. Open: `http://localhost/phpmyadmin`
2. Click "New" to create a database
3. Database name: `hexatp_db`
4. Collation: `utf8_general_ci`
5. Click "Create"
6. Run the SQL script below:

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
);

-- Create inquiries table
CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);
```

---

## ⚙️ Step 3: Configure Database Connection

The database configuration is already set in `db_config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hexatp_db');
```

### If you need to change credentials:
1. Open `hexatp-main/db_config.php`
2. Update the values:
   - `DB_HOST`: Usually `localhost`
   - `DB_USER`: Your MySQL username (default: `root`)
   - `DB_PASS`: Your MySQL password (default: empty)
   - `DB_NAME`: Database name (default: `hexatp_db`)

---

## 🧹 Step 4: Remove MongoDB Dependencies (IMPORTANT)

MongoDB packages are not needed since this project uses MySQL. Remove them:

```bash
cd C:\xampp3\htdocs\hexatp-main
rm -rf node_modules
```

If you need Node.js packages in the future (without MongoDB):
```bash
npm init -y
npm install express cors dotenv --save
```

---

## 🚀 Step 5: Test Your Setup

### 5.1 Test Homepage
Open: `http://localhost/hexatp-main/index.html`

### 5.2 Test Database Connection
Open: `http://localhost/hexatp-main/setup_database.php`
- Should show: "✓ Database setup completed successfully!"

### 5.3 Test Contact Form
1. Go to: `http://localhost/hexatp-main/contact.html`
2. Fill out the consultation form
3. Submit and check for success message

### 5.4 Test Admin Panel
Open: `http://localhost/hexatp-main/admin_consultations.php`
- View all consultation requests
- Filter by status
- View details

---

## 📁 Project Structure

```
C:\xampp3\htdocs\hexatp-main\
├── index.html              # Homepage
├── contact.html            # Contact/Consultation form
├── aboutus.html           # About page
├── solution.html          # Solutions page
├── db_config.php          # Database configuration
├── save_inquiry.php       # Form submission handler
├── setup_database.php     # Database setup script
├── admin_consultations.php # Admin dashboard
├── *.html                 # Country-specific pages
└── images/                # Image assets
```

---

## 🔧 Troubleshooting

### Issue: "Database connection failed"
**Solution:**
1. Check if MySQL is running in XAMPP
2. Verify credentials in `db_config.php`
3. Ensure database `hexatp_db` exists

### Issue: "Table doesn't exist"
**Solution:**
Run `http://localhost/hexatp-main/setup_database.php`

### Issue: "Access denied for user 'root'"
**Solution:**
1. Open phpMyAdmin
2. Go to User Accounts
3. Set password for root user
4. Update `DB_PASS` in `db_config.php`

### Issue: 404 Not Found
**Solution:**
1. Verify files are in `C:\xampp3\htdocs\hexatp-main\`
2. Check Apache is running
3. Use correct URL: `http://localhost/hexatp-main/`

---

## 🔐 Security Recommendations

### For Production Deployment:
1. **Change database credentials**
   ```php
   define('DB_USER', 'your_secure_username');
   define('DB_PASS', 'your_strong_password');
   ```

2. **Add authentication to admin panel**
   - Implement login system for `admin_consultations.php`

3. **Enable HTTPS**
   - Use SSL certificate

4. **Backup database regularly**
   ```bash
   mysqldump -u root -p hexatp_db > backup.sql
   ```

---

## 📊 Database Schema

### Consultations Table
| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary key |
| name | VARCHAR(100) | Client name |
| email | VARCHAR(100) | Client email |
| phone | VARCHAR(20) | Phone number |
| consultation_type | VARCHAR(100) | Type of consultation |
| appointment_date | DATE | Appointment date |
| appointment_time | VARCHAR(20) | Appointment time |
| message | LONGTEXT | Additional message |
| status | ENUM | pending/confirmed/completed/cancelled |
| created_at | TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | Last update timestamp |

### Inquiries Table
| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary key |
| name | VARCHAR(100) | Client name |
| email | VARCHAR(100) | Client email |
| phone | VARCHAR(20) | Phone number |
| message | LONGTEXT | Inquiry message |
| created_at | TIMESTAMP | Creation timestamp |

---

## 🔗 Useful Links

- **Local Website**: http://localhost/hexatp-main/
- **phpMyAdmin**: http://localhost/phpmyadmin
- **Admin Panel**: http://localhost/hexatp-main/admin_consultations.php
- **GitHub Repo**: https://github.com/sakshidhawale5004/hexa-final

---

## ✅ Quick Checklist

- [ ] XAMPP installed and running
- [ ] Repository cloned to `C:\xampp3\htdocs\hexatp-main`
- [ ] MySQL service started
- [ ] Database `hexatp_db` created
- [ ] Tables created (run setup_database.php)
- [ ] MongoDB node_modules removed
- [ ] Website accessible at http://localhost/hexatp-main/
- [ ] Contact form working
- [ ] Admin panel accessible

---

## 📞 Support

If you encounter any issues:
1. Check XAMPP error logs: `C:\xampp3\apache\logs\error.log`
2. Check PHP errors in browser console
3. Verify all services are running in XAMPP Control Panel

---

**Setup Complete! Your HexaTP website is now running on XAMPP with MySQL database.**
