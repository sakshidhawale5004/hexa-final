# Country Content Migration Guide

## Overview
This guide will help you migrate existing country HTML files into your CMS database. The migration script extracts content from 19 country HTML files and populates the database with all necessary data.

## Countries to be Migrated

**Gulf Region:**
✅ United Arab Emirates  
✅ Saudi Arabia  
✅ Qatar  
✅ Oman  
✅ Bahrain  
✅ Egypt  

**Asia:**
✅ India  
✅ Bangladesh  

**South East Asia:**
✅ Singapore  
✅ Thailand  
✅ Malaysia  
✅ Australia  
✅ Indonesia  
✅ Vietnam  

**Africa:**
✅ Botswana  
✅ Ghana  
✅ Kenya  

**Americas:**
✅ Canada  
✅ United States  

**Total: 19 Countries**  

## Pre-Migration Checklist

### 1. Verify Database Connection
Make sure your `db_config.php` has the correct credentials:
- Database: `u852823366_hexatp_db`
- User: `u852823366_hexatp_user`
- Password: `Hexatp_2026`

### 2. Verify Required Files Exist
The following files must be uploaded to Hostinger:
- ✅ `migrate_countries.php` (migration script)
- ✅ `db_config.php` (database configuration)
- ✅ `models/Country.php` (Country model)
- ✅ `repositories/CountryRepository.php` (database operations)
- ✅ All 19 country HTML files (unitedarab.html, Saudiarabia.html, Qatar.html, oman.html, bahrain.html, egypt.html, India.html, bangladesh.html, singapore.html, thailand.html, malaysia.html, australia.html, indonesia.html, viethnam.html, botswana.html, ghana.html, kenya.html, canada.html, us.html)

### 3. Verify Database Tables Exist
The migration requires these tables:
- `countries` (main country data)
- `country_overview` (overview sections)
- `regulatory_frameworks` (3 framework boxes)
- `documentation_cards` (expandable documentation sections)

If tables don't exist, run the migration scripts first from the `migrations/` folder.

## Migration Steps

### Step 1: Upload the Migration Script
Upload `migrate_countries.php` to your Hostinger root directory:
```
/public_html/hexatp.com/migrate_countries.php
```

### Step 2: Run the Migration
Open your browser and visit:
```
https://hexatp.com/migrate_countries.php
```

### Step 3: Monitor Progress
The script will display:
- ✅ Real-time progress bar
- ✅ Status updates for each country
- ✅ Success/error messages
- ✅ Final summary with counts

Expected output:
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
```

### Step 4: Verify Migration Results
After successful migration, click "View Countries in CMS" to verify:
1. All 9 countries appear in the countries list
2. Each country shows "Published" status
3. Click "Edit" on any country to verify content was extracted correctly

### Step 5: Delete Migration Script (IMPORTANT!)
For security reasons, delete `migrate_countries.php` after successful migration:
```bash
# Via Hostinger File Manager or FTP
Delete: /public_html/hexatp.com/migrate_countries.php
```

## What the Migration Script Does

### 1. Hero Section Extraction
- Extracts hero title (h1)
- Extracts hero description (first paragraph)
- Example: "Transfer Pricing Australia" + description

### 2. Overview Section Extraction
- Extracts left column content
- Extracts right column content
- Preserves HTML formatting

### 3. Regulatory Frameworks Extraction
- Extracts up to 3 regulatory framework boxes
- Each box includes title (h5) and description (p)
- Maintains display order

### 4. Documentation Cards Extraction
- Extracts all expandable documentation cards
- Each card includes:
  - Title (from arrow span)
  - Short description (visible text)
  - Detailed content (expandable content)
- Maintains display order

### 5. Metadata Generation
- Sets country name and code
- Adds flag URL (from Wikimedia Commons)
- Generates SEO meta title and description
- Sets status to "published"

## Troubleshooting

### Error: "File not found"
**Cause**: HTML file doesn't exist in the root directory  
**Solution**: Upload the missing HTML file to `/public_html/hexatp.com/`

### Error: "Could not read file"
**Cause**: File permissions issue  
**Solution**: Set file permissions to 644 via File Manager

### Error: "Failed to create country record"
**Cause**: Database connection or table structure issue  
**Solution**: 
1. Verify database credentials in `db_config.php`
2. Check that all required tables exist
3. Run migration scripts from `migrations/` folder

### Error: "Duplicate entry"
**Cause**: Country already exists in database  
**Solution**: 
1. Delete existing countries from admin panel
2. Or modify migration script to skip existing countries

### Partial Migration (Some countries failed)
**Cause**: HTML structure varies between files  
**Solution**: 
1. Check error messages for specific countries
2. Manually add missing countries via admin panel
3. Or adjust HTML parsing logic in migration script

## Post-Migration Tasks

### 1. Verify Content Accuracy
- Check each country page on the frontend
- Verify all sections display correctly
- Test expandable documentation cards

### 2. Update Country Pages (if needed)
Use the admin panel to:
- Edit any incorrectly extracted content
- Add missing information
- Adjust formatting

### 3. Test Frontend Display
Visit each country page:
```
https://hexatp.com/country.html?code=AU
https://hexatp.com/country.html?code=EG
https://hexatp.com/country.html?code=IN
... etc
```

### 4. Update Navigation Links
Ensure all country links in navigation point to the dynamic country page:
```html
<!-- Old static links -->
<a href="australia.html">Australia</a>

<!-- New dynamic links -->
<a href="country.html?code=AU">Australia</a>
```

## Migration Script Features

✅ **Safe Execution**: Uses prepared statements to prevent SQL injection  
✅ **Progress Tracking**: Real-time visual progress bar  
✅ **Error Handling**: Detailed error messages for debugging  
✅ **HTML Parsing**: Uses DOMDocument and XPath for reliable extraction  
✅ **Relationship Management**: Automatically creates all related records  
✅ **Status Setting**: Sets all migrated countries to "published"  
✅ **Execution Time**: 5-minute timeout for large migrations  

## Expected Results

After successful migration, you should have:
- ✅ 19 countries in the database
- ✅ All countries set to "published" status
- ✅ Complete hero sections with titles and descriptions
- ✅ Overview content (left and right columns)
- ✅ 3 regulatory frameworks per country
- ✅ Multiple documentation cards per country
- ✅ SEO metadata for each country
- ✅ Flag URLs from Wikimedia Commons

## Need Help?

If you encounter issues:
1. Check the error messages in the migration output
2. Verify database connection via `test_db.php`
3. Check file permissions in Hostinger File Manager
4. Review the troubleshooting section above
5. Contact support with specific error messages

## Security Note

⚠️ **IMPORTANT**: Always delete `migrate_countries.php` after successful migration. This script has direct database access and should not remain accessible on your production server.

---

**Last Updated**: April 24, 2026  
**Script Version**: 1.0.0  
**Requirements**: PHP 7.4+, MySQL 5.7+, DOMDocument extension
