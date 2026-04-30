# 🚀 Quick Start: Migrate All 19 Countries

## One-Page Guide

### What You're Migrating
**19 countries** from HTML files → CMS database

### Countries Included
- **Gulf**: UAE, Saudi Arabia, Qatar, Oman, Bahrain, Egypt (6)
- **Asia**: India, Bangladesh (2)
- **SE Asia**: Singapore, Thailand, Malaysia, Australia, Indonesia, Vietnam (6)
- **Africa**: Botswana, Ghana, Kenya (3)
- **Americas**: Canada, United States (2)

### 3 Simple Steps

#### Step 1: Upload
Upload `migrate_countries.php` to:
```
/public_html/hexatp.com/migrate_countries.php
```

#### Step 2: Run
Open browser and visit:
```
https://hexatp.com/migrate_countries.php
```

#### Step 3: Delete
After success, delete the script from server!

### What to Expect
- ⏱️ Takes 60-90 seconds
- 📊 Shows progress bar
- ✅ Lists each country as it migrates
- 🎉 Shows final summary

### Success Looks Like
```
✅ Successfully Migrated (19)
Total countries processed: 19
Successfully migrated: 19
Errors: 0
```

### After Migration
1. Click "View Countries in CMS"
2. Verify all 19 countries appear
3. Check they're all "Published"
4. **DELETE migrate_countries.php**

### Test Frontend
Visit any country page:
```
country.html?code=AE  (UAE)
country.html?code=IN  (India)
country.html?code=AU  (Australia)
country.html?code=US  (United States)
```

### Troubleshooting
- **Error: File not found** → Upload missing HTML file
- **Error: Database connection** → Check db_config.php
- **Error: Permission denied** → Set file permissions to 644

### Security Warning
⚠️ **CRITICAL**: Delete `migrate_countries.php` after running!

### Need More Details?
- 📖 Full guide: `MIGRATION_GUIDE.md`
- ✅ Checklist: `MIGRATION_CHECKLIST.md`
- 📋 Complete list: `ALL_COUNTRIES_MIGRATION_SUMMARY.md`

---

**Ready?** Upload → Run → Delete → Done! 🎉
