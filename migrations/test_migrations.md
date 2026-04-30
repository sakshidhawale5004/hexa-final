# Migration Testing Guide

This document provides instructions for testing the database migrations on a clean database.

## Prerequisites

Before testing, ensure you have:
- MySQL/MariaDB server running
- PHP CLI installed (version 7.0+)
- Database `hexatp_db` created
- Proper database credentials configured in `db_config.php`

## Testing Steps

### 1. Verify Database Connection

Test that PHP can connect to the database:

```bash
php -r "
require 'db_config.php';
if (\$conn->connect_error) {
    die('Connection failed: ' . \$conn->connect_error);
}
echo 'Database connection successful!' . PHP_EOL;
\$conn->close();
"
```

### 2. Check Migration Files

Verify all 7 migration files exist:

```bash
ls -la migrations/*.sql
```

Expected files:
- 001_create_countries_table.sql
- 002_create_users_table.sql
- 003_create_country_overview_table.sql
- 004_create_regulatory_frameworks_table.sql
- 005_create_documentation_cards_table.sql
- 006_create_content_revisions_table.sql
- 007_create_audit_log_table.sql

### 3. Run Migrations

Execute the migration runner:

```bash
php migrations/migrate.php
```

Expected output:
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

### 4. Verify Tables Created

Check that all tables were created:

```bash
mysql -u root hexatp_db -e "SHOW TABLES;"
```

Expected output:
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

### 5. Verify Table Structures

Check the structure of each table:

```bash
# Countries table
mysql -u root hexatp_db -e "DESCRIBE countries;"

# Users table
mysql -u root hexatp_db -e "DESCRIBE users;"

# Country overview table
mysql -u root hexatp_db -e "DESCRIBE country_overview;"

# Regulatory frameworks table
mysql -u root hexatp_db -e "DESCRIBE regulatory_frameworks;"

# Documentation cards table
mysql -u root hexatp_db -e "DESCRIBE documentation_cards;"

# Content revisions table
mysql -u root hexatp_db -e "DESCRIBE content_revisions;"

# Audit log table
mysql -u root hexatp_db -e "DESCRIBE audit_log;"
```

### 6. Verify Indexes

Check that indexes were created correctly:

```bash
mysql -u root hexatp_db -e "SHOW INDEX FROM countries;"
mysql -u root hexatp_db -e "SHOW INDEX FROM country_overview;"
mysql -u root hexatp_db -e "SHOW INDEX FROM regulatory_frameworks;"
mysql -u root hexatp_db -e "SHOW INDEX FROM documentation_cards;"
mysql -u root hexatp_db -e "SHOW INDEX FROM content_revisions;"
mysql -u root hexatp_db -e "SHOW INDEX FROM users;"
mysql -u root hexatp_db -e "SHOW INDEX FROM audit_log;"
```

### 7. Verify Foreign Key Constraints

Check that foreign key relationships are properly established:

```bash
mysql -u root hexatp_db -e "
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
    REFERENCED_TABLE_SCHEMA = 'hexatp_db'
    AND REFERENCED_TABLE_NAME IS NOT NULL;
"
```

Expected foreign keys:
- country_overview.country_id → countries.id
- regulatory_frameworks.country_id → countries.id
- documentation_cards.country_id → countries.id
- content_revisions.country_id → countries.id
- content_revisions.changed_by → users.id
- audit_log.user_id → users.id

### 8. Test Idempotency

Run migrations again to verify they don't execute twice:

```bash
php migrations/migrate.php
```

Expected output:
```
✓ Migrations tracking table ready
✓ No pending migrations. Database is up to date!

Executed migrations: 7
```

### 9. Test Rollback (Optional)

**⚠️ WARNING: This will delete all tables and data!**

```bash
php migrations/migrate.php --rollback
```

You will be prompted to type 'yes' to confirm. This will drop all CMS tables.

After rollback, you can re-run migrations to verify they work on a clean database:

```bash
php migrations/migrate.php
```

## Validation Checklist

- [ ] All 7 migration files exist
- [ ] Migration runner executes without errors
- [ ] All 8 tables created (7 CMS tables + 1 migrations tracking table)
- [ ] All indexes created correctly
- [ ] All foreign key constraints established
- [ ] Character set is utf8mb4 for all tables
- [ ] Migrations are idempotent (safe to run multiple times)
- [ ] Rollback functionality works correctly

## Common Issues

### Issue: "Access denied for user"
**Solution**: Update database credentials in `db_config.php`

### Issue: "Unknown database 'hexatp_db'"
**Solution**: Create the database first:
```bash
mysql -u root -e "CREATE DATABASE hexatp_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Issue: "Cannot add foreign key constraint"
**Solution**: Ensure migrations run in order. The migration runner handles this automatically.

### Issue: Migration runner shows no output
**Solution**: Check PHP error logs or run with error reporting:
```bash
php -d display_errors=1 -d error_reporting=E_ALL migrations/migrate.php
```

## Success Criteria

The migrations are considered successful when:

1. ✅ All 7 migration files execute without errors
2. ✅ All 8 tables exist in the database (including migrations tracking table)
3. ✅ All indexes are created as specified in the design document
4. ✅ All foreign key constraints are properly established
5. ✅ Tables use utf8mb4 character encoding
6. ✅ Running migrations again shows "No pending migrations"
7. ✅ Rollback successfully drops all tables

## Next Steps

After successful migration testing:

1. Document any issues encountered and resolutions
2. Proceed to Task 2: Create API endpoints for country data operations
3. Keep migrations directory in version control
4. Update this document if new migrations are added
