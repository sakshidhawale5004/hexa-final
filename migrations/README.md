# Database Migrations

This directory contains database migration scripts for the HexaTP Country Content CMS.

## Overview

The migration system creates and manages the database schema for the Country Content Management System. It includes 7 tables:

1. **countries** - Main country information and metadata
2. **users** - Admin and editor user accounts
3. **country_overview** - Overview text sections for each country
4. **regulatory_frameworks** - Key regulatory framework boxes
5. **documentation_cards** - Expandable documentation cards
6. **content_revisions** - Content change tracking for audit
7. **audit_log** - Administrative action logging

## Migration Files

- `001_create_countries_table.sql` - Creates countries table with indexes
- `002_create_users_table.sql` - Creates users table for authentication
- `003_create_country_overview_table.sql` - Creates country overview table
- `004_create_regulatory_frameworks_table.sql` - Creates regulatory frameworks table
- `005_create_documentation_cards_table.sql` - Creates documentation cards table
- `006_create_content_revisions_table.sql` - Creates content revisions tracking table
- `007_create_audit_log_table.sql` - Creates audit log table

## Usage

### Running Migrations

To execute all pending migrations:

```bash
php migrations/migrate.php
```

The script will:
- Create a `migrations` tracking table if it doesn't exist
- Check which migrations have already been executed
- Run any pending migrations in order
- Display colored output showing progress and results

### Rolling Back Migrations

To drop all CMS tables and reset the database:

```bash
php migrations/migrate.php --rollback
```

**⚠️ WARNING:** This will permanently delete all CMS tables and data. You will be prompted to confirm before proceeding.

## Features

- **Idempotent**: Safe to run multiple times - only executes pending migrations
- **Tracking**: Maintains a `migrations` table to track executed migrations
- **Ordered Execution**: Migrations run in numerical order (001, 002, 003, etc.)
- **Foreign Key Support**: Tables are created in the correct order to respect dependencies
- **UTF-8 Support**: All tables use utf8mb4 character set for international content
- **Colored Output**: Easy-to-read terminal output with color-coded status messages

## Database Configuration

The migration runner uses the database connection settings from `db_config.php`:

- **Host**: localhost
- **Database**: hexatp_db
- **User**: root
- **Password**: (empty)

Update `db_config.php` if your database credentials differ.

## Requirements

- PHP 7.0 or higher
- MySQL 5.7 or higher (or MariaDB 10.2+)
- MySQLi extension enabled
- Database user with CREATE, DROP, and ALTER privileges

## Testing Migrations

To test migrations on a clean database:

1. **Backup existing data** (if any):
   ```bash
   mysqldump -u root hexatp_db > backup.sql
   ```

2. **Run migrations**:
   ```bash
   php migrations/migrate.php
   ```

3. **Verify tables were created**:
   ```bash
   mysql -u root hexatp_db -e "SHOW TABLES;"
   ```

4. **Check table structure**:
   ```bash
   mysql -u root hexatp_db -e "DESCRIBE countries;"
   ```

## Troubleshooting

### "Table already exists" errors

If you see errors about tables already existing, either:
- Run `--rollback` to drop all tables first
- Manually drop the conflicting tables
- The migrations use `CREATE TABLE IF NOT EXISTS` so this shouldn't normally occur

### Foreign key constraint errors

Ensure migrations run in order. The migration runner automatically sorts files numerically.

### Connection errors

Verify your database credentials in `db_config.php` and ensure MySQL is running:
```bash
mysql -u root -p -e "SELECT 1;"
```

## Adding New Migrations

To add a new migration:

1. Create a new `.sql` file with the next number: `008_description.sql`
2. Write your SQL statements
3. Run `php migrations/migrate.php` to execute it

The migration system will automatically detect and run new migration files.
