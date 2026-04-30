# Files to Upload for Country Migration

## Quick Summary
Upload `migrate_countries.php` to Hostinger, then visit `https://hexatp.com/migrate_countries.php` to run the migration.

## Files Already on Hostinger (No Action Needed)
These files should already be uploaded from previous tasks:
- ✅ `db_config.php` (database configuration)
- ✅ `models/Country.php` (Country model)
- ✅ `repositories/CountryRepository.php` (database operations)
- ✅ All 19 country HTML files:
  - **Gulf Region:** unitedarab.html, Saudiarabia.html, Qatar.html, oman.html, bahrain.html, egypt.html
  - **Asia:** India.html, bangladesh.html
  - **South East Asia:** singapore.html, thailand.html, malaysia.html, australia.html, indonesia.html, viethnam.html
  - **Africa:** botswana.html, ghana.html, kenya.html
  - **Americas:** canada.html, us.html

## File to Upload NOW

### 1. migrate_countries.php
**Location**: Root directory  
**Upload to**: `/public_html/hexatp.com/migrate_countries.php`  
**Purpose**: Migration script that extracts content from HTML files and populates database  

## Upload Instructions (Hostinger File Manager)

### Step 1: Open File Manager
1. Log in to Hostinger control panel
2. Click "File Manager" in the left sidebar
3. Navigate to `/public_html/hexatp.com/`

### Step 2: Upload Migration Script
1. Click "Upload" button in top toolbar
2. Select `migrate_countries.php` from your local computer
3. Wait for upload to complete
4. Verify file appears in the file list

### Step 3: Set Permissions (if needed)
1. Right-click on `migrate_countries.php`
2. Select "Permissions"
3. Set to `644` (read/write for owner, read for others)
4. Click "Save"

## Run the Migration

### Step 1: Open Browser
Visit: `https://hexatp.com/migrate_countries.php`

### Step 2: Watch Progress
You'll see:
- Progress bar showing migration status
- Real-time updates for each country
- Success/error messages
- Final summary

### Step 3: Verify Results
1. Click "View Countries in CMS" button
2. Verify all 9 countries appear
3. Check that all show "Published" status

### Step 4: Delete Migration Script (IMPORTANT!)
1. Go back to File Manager
2. Navigate to `/public_html/hexatp.com/`
3. Find `migrate_countries.php`
4. Right-click → Delete
5. Confirm deletion

## Alternative Upload Method (FTP)

If you prefer using FTP:

### FTP Credentials (from Hostinger)
- **Host**: ftp.hexatp.com (or your Hostinger FTP host)
- **Username**: Your Hostinger FTP username
- **Password**: Your Hostinger FTP password
- **Port**: 21

### Upload Steps
1. Connect to FTP using FileZilla or similar
2. Navigate to `/public_html/hexatp.com/`
3. Upload `migrate_countries.php`
4. Set permissions to 644
5. Disconnect

## Verification Checklist

Before running migration:
- [ ] `migrate_countries.php` uploaded to root directory
- [ ] File permissions set to 644
- [ ] Database credentials correct in `db_config.php`
- [ ] All 19 country HTML files exist in root directory

After running migration:
- [ ] All 19 countries show "Successfully migrated"
- [ ] No errors in migration output
- [ ] Countries visible in admin panel
- [ ] All countries show "Published" status
- [ ] `migrate_countries.php` deleted from server

## Expected Migration Output

```
🌍 Country Content Migration
Migration Progress: [████████████████████] 100%

✅ Successfully Migrated (9)
- australia.html: Successfully migrated Australia (ID: 1)
- bahrain.html: Successfully migrated Bahrain (ID: 2)
- bangladesh.html: Successfully migrated Bangladesh (ID: 3)
- botswana.html: Successfully migrated Botswana (ID: 4)
- canada.html: Successfully migrated Canada (ID: 5)
- egypt.html: Successfully migrated Egypt (ID: 6)
- ghana.html: Successfully migrated Ghana (ID: 7)
- India.html: Successfully migrated India (ID: 8)
- indonesia.html: Successfully migrated Indonesia (ID: 9)

📊 Summary
Total countries processed: 9
Successfully migrated: 9
Errors: 0

[View Countries in CMS] [Go to Dashboard]
```

## Troubleshooting

### "File not found" error
**Problem**: HTML file missing  
**Solution**: Upload the missing country HTML file to root directory

### "Permission denied" error
**Problem**: File permissions incorrect  
**Solution**: Set `migrate_countries.php` permissions to 644

### "Database connection failed" error
**Problem**: Database credentials incorrect  
**Solution**: Verify credentials in `db_config.php`:
- Database: `u852823366_hexatp_db`
- User: `u852823366_hexatp_user`
- Password: `Hexatp_2026`

### "Table doesn't exist" error
**Problem**: Database tables not created  
**Solution**: Run migration scripts from `migrations/` folder first

## Post-Migration Tasks

1. **Delete migration script** (security!)
2. **Verify countries in admin panel**
3. **Test frontend country pages**
4. **Update navigation links** (if needed)

## Need Help?

📖 **Full Documentation**: See `MIGRATION_GUIDE.md`  
✅ **Quick Checklist**: See `MIGRATION_CHECKLIST.md`  
🚀 **Ready Status**: See `MIGRATION_READY.md`  

---

**Upload**: 1 file (`migrate_countries.php`)  
**Run**: Visit `https://hexatp.com/migrate_countries.php`  
**Duration**: 60-90 seconds  
**Delete**: Remove script after completion  
**Result**: 19 countries migrated ✅
