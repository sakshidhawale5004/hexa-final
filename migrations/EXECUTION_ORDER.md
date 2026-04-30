# Migration Execution Order

This document explains the order in which migrations are executed and why this order is important.

## Execution Sequence

```
1. countries          (No dependencies)
   ↓
2. users              (No dependencies)
   ↓
3. country_overview   (Depends on: countries)
   ↓
4. regulatory_frameworks (Depends on: countries)
   ↓
5. documentation_cards (Depends on: countries)
   ↓
6. content_revisions  (Depends on: countries, users)
   ↓
7. audit_log          (Depends on: users)
```

## Why This Order?

### Phase 1: Base Tables (001-002)
**No foreign key dependencies**

1. **countries** - Must be created first because all content tables reference it
2. **users** - Must be created before audit tables that track user actions

### Phase 2: Content Tables (003-005)
**Depend on: countries**

3. **country_overview** - References countries(id)
4. **regulatory_frameworks** - References countries(id)
5. **documentation_cards** - References countries(id)

These can technically be created in any order relative to each other, but must come after `countries`.

### Phase 3: Audit Tables (006-007)
**Depend on: countries AND users**

6. **content_revisions** - References both countries(id) and users(id)
7. **audit_log** - References users(id)

These must come last because they have foreign keys to multiple base tables.

## Foreign Key Dependency Graph

```
                    ┌─────────────┐
                    │  countries  │
                    └──────┬──────┘
                           │
           ┌───────────────┼───────────────┐
           │               │               │
           ▼               ▼               ▼
    ┌─────────────┐ ┌─────────────┐ ┌─────────────┐
    │   country   │ │ regulatory  │ │documentation│
    │  overview   │ │ frameworks  │ │    cards    │
    └─────────────┘ └─────────────┘ └─────────────┘
                           │
                           │
    ┌─────────────┐        │
    │    users    │        │
    └──────┬──────┘        │
           │               │
           │      ┌────────┘
           │      │
           ▼      ▼
    ┌─────────────────┐
    │    content      │
    │   revisions     │
    └─────────────────┘
           │
           ▼
    ┌─────────────┐
    │  audit_log  │
    └─────────────┘
```

## Rollback Order

When rolling back (dropping tables), the order is **reversed** to respect foreign key constraints:

```
7. audit_log          (Drop first - no dependencies)
   ↓
6. content_revisions  (Drop before users and countries)
   ↓
5. documentation_cards (Drop before countries)
   ↓
4. regulatory_frameworks (Drop before countries)
   ↓
3. country_overview   (Drop before countries)
   ↓
2. users              (Drop before base cleanup)
   ↓
1. countries          (Drop last - many tables depend on it)
```

## Migration Runner Behavior

The `migrate.php` script:

1. **Automatically sorts** migration files by filename (001, 002, 003, etc.)
2. **Checks** which migrations have already been executed
3. **Runs only pending** migrations in order
4. **Stops on error** to prevent partial migrations
5. **Records** each successful migration in the `migrations` table

## Adding New Migrations

When adding new migrations:

1. **Use the next number** in sequence (008, 009, etc.)
2. **Consider dependencies**: If your table has foreign keys, ensure referenced tables are created in earlier migrations
3. **Test the order**: Run migrations on a clean database to verify

### Example: Adding a new table

If you want to add a `country_images` table that references `countries`:

```sql
-- 008_create_country_images_table.sql
CREATE TABLE IF NOT EXISTS country_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    caption TEXT,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    INDEX idx_country_id (country_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

This would automatically run after all existing migrations because it's numbered 008.

## Troubleshooting Order Issues

### Error: "Cannot add foreign key constraint"

**Cause**: Trying to create a foreign key to a table that doesn't exist yet.

**Solution**: 
1. Check that the referenced table's migration has a lower number
2. Verify the referenced table was created successfully
3. Ensure the referenced column exists and has the correct type

### Error: "Cannot drop table (foreign key constraint)"

**Cause**: Trying to drop a table that other tables reference.

**Solution**:
1. Drop dependent tables first
2. Use the `--rollback` option which handles the correct order
3. Temporarily disable foreign key checks (not recommended):
   ```sql
   SET FOREIGN_KEY_CHECKS = 0;
   DROP TABLE table_name;
   SET FOREIGN_KEY_CHECKS = 1;
   ```

## Best Practices

1. ✅ **Number migrations sequentially** (001, 002, 003...)
2. ✅ **Create base tables first** (tables with no foreign keys)
3. ✅ **Create dependent tables after** their referenced tables
4. ✅ **Use IF NOT EXISTS** for idempotency
5. ✅ **Test on clean database** before committing
6. ✅ **Never modify executed migrations** - create new ones instead
7. ✅ **Document dependencies** in migration comments

## Summary

The migration order is carefully designed to:
- ✅ Respect foreign key constraints
- ✅ Allow clean rollbacks
- ✅ Enable idempotent execution
- ✅ Prevent partial migrations
- ✅ Support incremental schema changes

The `migrate.php` script handles all of this automatically, so you just need to ensure new migrations are numbered correctly.
