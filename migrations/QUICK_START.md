# Quick Start Guide - Database Migrations

Get your Country Content CMS database up and running in 3 simple steps.

## Prerequisites

- ✅ MySQL/MariaDB server running
- ✅ PHP 7.0+ installed
- ✅ Database `hexatp_db` created
- ✅ Database credentials configured in `db_config.php`

## Step 1: Create Database (if needed)

If the database doesn't exist yet:

```bash
mysql -u root -p -e "CREATE DATABASE hexatp_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

## Step 2: Run Migrations

Execute the migration runner:

```bash
php migrations/migrate.php
```

**Expected output:**
```
============================================================
  HexaTP Country CMS - Database Migration Runner
============================================================

✓ Migrations tracking table ready
Found 7 pending migration(s):

  → 001_create_countries_table.sql
  → 002_create_users_table.sql
  → 003_create_country_overview_table.sql
  → 004_create_regulatory_frameworks_table.sql
  → 005_create_documentation_cards_table.sql
  → 006_create_content_revisions_table.sql
  → 007_create_audit_log_table.sql

Executing migrations...

✓ Executed: 001_create_countries_table.sql
✓ Executed: 002_create_users_table.sql
✓ Executed: 003_create_country_overview_table.sql
✓ Executed: 004_create_regulatory_frameworks_table.sql
✓ Executed: 005_create_documentation_cards_table.sql
✓ Executed: 006_create_content_revisions_table.sql
✓ Executed: 007_create_audit_log_table.sql

============================================================
Migration Summary:
  Successful: 7
  Total executed: 7
============================================================
```

## Step 3: Verify Installation

Check that all tables were created:

```bash
mysql -u root hexatp_db -e "SHOW TABLES;"
```

**Expected output:**
```
+------------------------+
| Tables_in_hexatp_db    |
+------------------------+
| audit_log              |
| content_revisions      |
| countries              |
| country_overview       |
| documentation_cards    |
| migrations             |
| regulatory_frameworks  |
| users                  |
+------------------------+
```

## ✅ Done!

Your database is now ready for the Country Content CMS.

## What Was Created?

- **8 tables**: 7 CMS tables + 1 migrations tracking table
- **Foreign keys**: Proper relationships between tables
- **Indexes**: Optimized for query performance
- **UTF-8 support**: Ready for international content
- **Audit trail**: Content revisions and action logging

## Next Steps

1. **Create admin user** (Task 2)
2. **Set up API endpoints** (Task 2)
3. **Build admin interface** (Task 3)
4. **Migrate existing country data** (Task 4)

## Common Issues

### "Access denied for user"
**Fix**: Update credentials in `db_config.php`

### "Unknown database 'hexatp_db'"
**Fix**: Run Step 1 to create the database

### "php: command not found"
**Fix**: Install PHP or use full path: `/usr/bin/php migrations/migrate.php`

## Need Help?

- 📖 **Full documentation**: See `README.md`
- 🧪 **Testing guide**: See `test_migrations.md`
- 🔄 **Execution order**: See `EXECUTION_ORDER.md`
- ✅ **Validation**: Run `php migrations/validate_migrations.php`

## Rollback (if needed)

To remove all CMS tables:

```bash
php migrations/migrate.php --rollback
```

⚠️ **Warning**: This will delete all data!

---

**Questions?** Check the full documentation in `README.md` or `MIGRATION_SETUP_COMPLETE.md`
