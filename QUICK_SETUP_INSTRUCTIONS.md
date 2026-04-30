# 🚀 Quick Database Setup - 3 Simple Steps

## What You Need
- ✅ Your Hostinger database already created
- ✅ Access to phpMyAdmin

---

## Step 1: Open phpMyAdmin

1. Go to your **Hostinger Control Panel**
2. Click **Databases** → **phpMyAdmin**
3. Click on your database name in the left sidebar (it should be selected)

---

## Step 2: Run the SQL Script

1. Click the **SQL** tab at the top of phpMyAdmin
2. Open the file: `migrations/create_all_tables.sql`
3. **Copy ALL the content** from that file
4. **Paste it** into the SQL query box in phpMyAdmin
5. Click the **Go** button (bottom right)

---

## Step 3: Verify Success

You should see:
- ✅ Green checkmark with "Query executed successfully"
- ✅ Message: "All 7 tables created successfully!"

Then check the left sidebar - you should see all 7 tables:
- countries
- users
- country_overview
- regulatory_frameworks
- documentation_cards
- content_revisions
- audit_log

---

## ✅ Done!

Your database is now ready! 

### Next Steps:
1. Create an admin user (run `scripts/create_admin_user.php`)
2. Upload your PHP files to Hostinger
3. Test the connection

---

## 🆘 Troubleshooting

**Error: "Table already exists"**
- This is OK! It means some tables were already created
- The script will skip them and continue

**Error: "Cannot add foreign key constraint"**
- Make sure you selected the correct database
- Try running the script again

**Error: "Access denied"**
- Verify you're logged into phpMyAdmin with the correct credentials
- Make sure you selected your database in the left sidebar

---

## 📁 File Location

The complete SQL script is here:
```
migrations/create_all_tables.sql
```

This single file creates all 7 tables at once!
