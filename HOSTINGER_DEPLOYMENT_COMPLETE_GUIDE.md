# 🚀 Complete Hostinger Deployment Guide for HexaTP Website

## 📋 **Website Status Check**

### ✅ **What's Working:**
- ✅ HTML/CSS/JavaScript files are ready
- ✅ MongoDB Atlas is configured correctly
- ✅ Database connection string is set up
- ✅ All static pages (index.html, contact.html, etc.) are ready
- ✅ Bootstrap and styling are working

### ⚠️ **What Needs Attention:**
- Your website is primarily **static HTML** (no server.js needed for basic deployment)
- MongoDB connection is configured but only needed if you have backend forms
- Contact form needs backend API to save to MongoDB

---

## 🎯 **Deployment Options for Hostinger**

### **Option 1: Static Website Deployment (Recommended for Now)**
Deploy your HTML files directly - fastest and simplest.

### **Option 2: Full Stack Deployment (If you need MongoDB forms)**
Deploy with Node.js backend for contact forms and database integration.

---

## 📦 **Option 1: Static Website Deployment**

### **Step 1: Prepare Files**
You need to upload these files:
```
- index.html
- contact.html
- aboutus.html
- solution.html
- All country HTML files (australia.html, canada.html, etc.)
- All images (world-map.png, etc.)
- CSS files (if separate)
- JavaScript files (if separate)
```

### **Step 2: Access Hostinger**
1. Log in to **Hostinger Control Panel**: https://hpanel.hostinger.com
2. Go to **File Manager** or use **FTP**

### **Step 3: Upload Files**
1. Navigate to `public_html` folder
2. Delete default `index.html` if exists
3. Upload all your HTML files
4. Upload all images and assets
5. Make sure `index.html` is in the root of `public_html`

### **Step 4: Test Your Website**
1. Visit your domain: `https://yourdomain.com`
2. Check all pages load correctly
3. Test navigation links
4. Verify images display

### **✅ Done! Your static website is live!**

---

## 🔧 **Option 2: Full Stack Deployment (With Node.js & MongoDB)**

### **Prerequisites:**
- Hostinger plan with **Node.js support** (Business or higher)
- SSH access enabled

### **Step 1: Create server.js File**

Since your project references `server.js` but it doesn't exist, I'll create one for you:

```javascript
// server.js
require('dotenv').config();
const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const path = require('path');
const { connectDB } = require('./db_config_mongodb');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Serve static files
app.use(express.static(__dirname));

// API Routes
app.post('/api/contact', async (req, res) => {
    try {
        const db = await connectDB();
        const collection = db.collection('contacts');
        
        const contactData = {
            name: req.body.name,
            email: req.body.email,
            phone: req.body.phone,
            subject: req.body.subject,
            message: req.body.message,
            createdAt: new Date()
        };
        
        await collection.insertOne(contactData);
        
        res.json({ success: true, message: 'Contact form submitted successfully!' });
    } catch (error) {
        console.error('Error:', error);
        res.status(500).json({ success: false, message: 'Server error' });
    }
});

// Serve HTML files
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

// Start server
app.listen(PORT, () => {
    console.log(`✅ Server running on port ${PORT}`);
    console.log(`🌐 Visit: http://localhost:${PORT}`);
});
```

### **Step 2: Upload to Hostinger via SSH**

1. **Connect via SSH:**
```bash
ssh username@yourdomain.com
```

2. **Navigate to your domain folder:**
```bash
cd domains/yourdomain.com/public_html
```

3. **Upload files using FTP or Git:**

**Option A: Using FTP (FileZilla)**
- Host: ftp.yourdomain.com
- Username: Your Hostinger FTP username
- Password: Your FTP password
- Upload all files to `public_html`

**Option B: Using Git**
```bash
git clone https://github.com/sakshidhawale5004/hexatp.git
cd hexatp
cd "Hexa tp 2"
```

### **Step 3: Install Dependencies**
```bash
npm install
```

### **Step 4: Create .env File on Server**
```bash
nano .env
```

Paste this content:
```env
MONGODB_URI=mongodb+srv://sakshidhawale5004_db_user:F3HhLhR9dKAVlfD0@cluster0.zmdcesr.mongodb.net/hexatp_db?retryWrites=true&w=majority&appName=Cluster0
DB_NAME=hexatp_db
PORT=3000
NODE_ENV=production
```

Save: `Ctrl + X`, then `Y`, then `Enter`

### **Step 5: Start the Server**

**Option A: Using PM2 (Recommended)**
```bash
npm install -g pm2
pm2 start server.js --name hexatp
pm2 save
pm2 startup
```

**Option B: Using Node directly**
```bash
node server.js
```

### **Step 6: Configure Hostinger to Use Node.js**

1. Go to **Hostinger Control Panel**
2. Navigate to **Advanced** → **Node.js**
3. Click **Create Application**
4. Set:
   - **Application Root:** `/public_html`
   - **Application URL:** Your domain
   - **Application Startup File:** `server.js`
   - **Node.js Version:** 18.x or higher
5. Click **Create**

### **Step 7: Test Your Website**
Visit: `https://yourdomain.com`

---

## 🔍 **Troubleshooting**

### **Issue: Website not loading**
- Check if files are in `public_html` folder
- Verify `index.html` exists in root
- Check file permissions (should be 644 for files, 755 for folders)

### **Issue: MongoDB connection failed**
- Verify `.env` file exists on server
- Check MongoDB Atlas IP whitelist includes `0.0.0.0/0`
- Test connection: `node test_connection.js`

### **Issue: Node.js app not starting**
- Check logs: `pm2 logs hexatp`
- Verify Node.js version: `node --version`
- Check if port 3000 is available

### **Issue: 404 errors**
- Ensure all HTML files are uploaded
- Check file names match exactly (case-sensitive)
- Verify links in HTML use correct paths

---

## 📊 **Website Structure**

```
public_html/
├── index.html              # Homepage
├── contact.html            # Contact page
├── aboutus.html           # About page
├── solution.html          # Solutions page
├── australia.html         # Country pages
├── canada.html
├── ... (other country pages)
├── world-map.png          # Images
├── server.js              # Node.js server (if using backend)
├── db_config_mongodb.js   # MongoDB config
├── .env                   # Environment variables
├── package.json           # Dependencies
└── node_modules/          # Installed packages
```

---

## ✅ **Final Checklist**

### **Before Deployment:**
- [ ] All HTML files are ready
- [ ] Images are optimized
- [ ] Links are tested locally
- [ ] MongoDB connection string is correct
- [ ] `.env` file is created (not committed to Git)

### **After Deployment:**
- [ ] Website loads at your domain
- [ ] All pages are accessible
- [ ] Images display correctly
- [ ] Navigation works
- [ ] Contact form submits (if using backend)
- [ ] MongoDB connection works (if using backend)

---

## 🎉 **Your Website is Ready!**

### **Static Website (Option 1):**
✅ Upload HTML files → Done!

### **Full Stack Website (Option 2):**
✅ Upload files → Install dependencies → Start server → Done!

---

## 📞 **Need Help?**

- **Hostinger Support:** https://www.hostinger.com/contact
- **MongoDB Atlas Support:** https://www.mongodb.com/support
- **Your Repository:** https://github.com/sakshidhawale5004/hexatp

---

## 🔐 **Security Reminders**

⚠️ **Important:**
1. Change your MongoDB password (currently public on GitHub)
2. Add `.env` to `.gitignore` (already done)
3. Use HTTPS for your domain
4. Keep Node.js and dependencies updated

---

**Last Updated:** April 17, 2026
**Status:** ✅ Ready for Deployment
