# Country Migration Quick Checklist

## Before You Start
- [ ] Database credentials verified in `db_config.php`
- [ ] All 19 country HTML files exist in root directory
- [ ] Database tables created (countries, country_overview, regulatory_frameworks, documentation_cards)
- [ ] `migrate_countries.php` uploaded to Hostinger

## Migration Process
- [ ] Visit: `https://hexatp.com/migrate_countries.php`
- [ ] Wait for migration to complete (watch progress bar)
- [ ] Review success/error messages
- [ ] Note: All 19 countries should show "Successfully migrated"

## Verification
- [ ] Click "View Countries in CMS" button
- [ ] Verify all 19 countries appear in list
- [ ] Check each country shows "Published" status
- [ ] Click "Edit" on 2-3 countries to spot-check content
- [ ] Verify hero sections extracted correctly
- [ ] Verify overview content present
- [ ] Verify 3 regulatory frameworks per country
- [ ] Verify documentation cards present

## Post-Migration
- [ ] **DELETE `migrate_countries.php` from server** (SECURITY!)
- [ ] Test frontend country pages: `country.html?code=AE`, `country.html?code=SA`, etc.
- [ ] Verify expandable documentation cards work
- [ ] Check mobile responsiveness
- [ ] Update navigation links to use dynamic country pages

## Countries to Verify

**Gulf Region:**
- [ ] United Arab Emirates (AE)
- [ ] Saudi Arabia (SA)
- [ ] Qatar (QA)
- [ ] Oman (OM)
- [ ] Bahrain (BH)
- [ ] Egypt (EG)

**Asia:**
- [ ] India (IN)
- [ ] Bangladesh (BD)

**South East Asia:**
- [ ] Singapore (SG)
- [ ] Thailand (TH)
- [ ] Malaysia (MY)
- [ ] Australia (AU)
- [ ] Indonesia (ID)
- [ ] Vietnam (VN)

**Africa:**
- [ ] Botswana (BW)
- [ ] Ghana (GH)
- [ ] Kenya (KE)

**Americas:**
- [ ] Canada (CA)
- [ ] United States (US)

## If Errors Occur
- [ ] Check error messages in migration output
- [ ] Verify database connection with `test_db.php`
- [ ] Check file permissions (should be 644)
- [ ] Review MIGRATION_GUIDE.md troubleshooting section
- [ ] Manually add failed countries via admin panel if needed

## Success Criteria
✅ 19 countries migrated  
✅ All set to "published" status  
✅ Content displays correctly on frontend  
✅ No errors in migration output  
✅ Migration script deleted from server  

---

**Quick Command to Delete Migration Script (via SSH):**
```bash
cd /public_html/hexatp.com/
rm migrate_countries.php
```

**Or via Hostinger File Manager:**
1. Navigate to `/public_html/hexatp.com/`
2. Find `migrate_countries.php`
3. Right-click → Delete
