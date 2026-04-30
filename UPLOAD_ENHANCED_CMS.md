# Upload Enhanced CMS Files - Edit Law Sections Feature

## What's New

The CMS edit page has been enhanced to allow editing of:
- **Overview Section** (left and right columns)
- **Regulatory Frameworks** (3 law section boxes)
- **Documentation Cards** (expandable cards with detailed content)

All the migrated country data can now be edited through the admin panel!

## Files to Upload

Upload these files to your Hostinger server at `/public_html/hexatp.com/`:

### 1. Admin Interface (Updated)
- `admin/country_edit.php` - Enhanced edit form with all sections

### 2. Backend Services (Updated)
- `services/ContentService.php` - Updated to save overview, frameworks, and cards
- `repositories/CountryRepository.php` - Added methods for saving related content
- `api/country.php` - Updated to handle additional data

## Upload Instructions

### Using Hostinger File Manager:

1. **Log in to Hostinger**
   - Go to https://hpanel.hostinger.com
   - Navigate to File Manager

2. **Navigate to the correct directory**
   - Go to `/public_html/hexatp.com/`

3. **Upload the files** (one by one or in folders):

   **Admin folder:**
   - Upload `admin/country_edit.php` → Replace existing file

   **Services folder:**
   - Upload `services/ContentService.php` → Replace existing file

   **Repositories folder:**
   - Upload `repositories/CountryRepository.php` → Replace existing file

   **API folder:**
   - Upload `api/country.php` → Replace existing file

4. **Verify permissions**
   - All files should have 644 permissions (read/write for owner, read for others)

## Testing the New Features

After uploading, test the enhanced CMS:

1. **Log in to the admin panel**
   - Go to https://hexatp.com/admin/login.php
   - Username: `admin`
   - Password: `Admin123!`

2. **Edit a country**
   - Go to Countries List
   - Click "Edit" on any country (e.g., Qatar)

3. **You should now see these new sections:**
   - ✅ **Overview Section** - Two-column text editor
   - ✅ **Key Regulatory Frameworks** - 3 editable law boxes
   - ✅ **Documentation Cards** - Add/edit/remove expandable cards

4. **Test editing:**
   - Scroll down to "Key Regulatory Frameworks"
   - Edit the title and description of Framework 1
   - Click "Save & Publish"
   - Verify the changes saved successfully

5. **View on the public page:**
   - Go to the country page (e.g., https://hexatp.com/qatar.html)
   - Verify your changes appear on the live page

## What You Can Now Edit

### Overview Section
- Left column text (general information)
- Right column text (additional details)
- Rich text formatting (bold, italic, lists, links)

### Regulatory Frameworks (Law Sections)
- **Framework 1**: Title and description
- **Framework 2**: Title and description
- **Framework 3**: Title and description
- These are the 3 main law boxes on each country page

### Documentation Cards
- Add new cards
- Edit existing cards (title, short description, detailed content)
- Remove cards
- Reorder cards (drag and drop - coming soon)
- Rich text formatting for detailed content

## Rich Text Editor (WYSIWYG)

The enhanced CMS includes TinyMCE editor for:
- Overview sections
- Regulatory framework descriptions
- Documentation card detailed content

**Supported formatting:**
- Bold, italic
- Bullet lists, numbered lists
- Links
- Headings (H1-H6)
- Paragraphs

**Security:**
- Dangerous HTML tags (script, iframe) are automatically removed
- Content is sanitized before saving to database

## Troubleshooting

### If you see "Note: Overview, Regulatory Frameworks, and Documentation Cards can be added after creating the country"
- This means you're still viewing the old version
- Clear your browser cache (Ctrl+Shift+R or Cmd+Shift+R)
- Verify the files were uploaded correctly

### If the WYSIWYG editor doesn't load
- Check browser console for errors (F12)
- Verify TinyMCE CDN is accessible
- Try a different browser

### If save fails
- Check that all 4 files were uploaded correctly
- Verify database connection is working
- Check PHP error logs in Hostinger

## Next Steps

After uploading and testing:

1. ✅ Edit the law sections for your countries
2. ✅ Update overview content
3. ✅ Add or modify documentation cards
4. ✅ Publish changes to make them live

## Important Notes

- **Backup**: The old files are automatically backed up by Hostinger
- **Migration data**: All your migrated country data is safe in the database
- **No data loss**: This update only adds editing capabilities, doesn't change existing data
- **Rollback**: If needed, you can restore the old files from Hostinger backups

## Support

If you encounter any issues:
1. Check the troubleshooting section above
2. Verify all files were uploaded correctly
3. Check file permissions (should be 644)
4. Review PHP error logs in Hostinger

---

**Ready to upload?** Follow the steps above and you'll be able to edit all law sections through the CMS! 🎉
