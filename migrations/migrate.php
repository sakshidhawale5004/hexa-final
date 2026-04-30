<?php
/**
 * Database Migration Runner
 * HexaTP Country Content CMS
 * 
 * This script runs all migration files in order to set up the database schema.
 * Usage: php migrations/migrate.php [--rollback]
 */

// Include database configuration
require_once __DIR__ . '/../db_config.php';

// ANSI color codes for terminal output
define('COLOR_GREEN', "\033[32m");
define('COLOR_RED', "\033[31m");
define('COLOR_YELLOW', "\033[33m");
define('COLOR_BLUE', "\033[34m");
define('COLOR_RESET', "\033[0m");

/**
 * Print colored message to console
 */
function printMessage($message, $color = COLOR_RESET) {
    echo $color . $message . COLOR_RESET . PHP_EOL;
}

/**
 * Create migrations tracking table if it doesn't exist
 */
function createMigrationsTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration_name VARCHAR(255) NOT NULL UNIQUE,
        executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === TRUE) {
        printMessage("✓ Migrations tracking table ready", COLOR_GREEN);
        return true;
    } else {
        printMessage("✗ Error creating migrations table: " . $conn->error, COLOR_RED);
        return false;
    }
}

/**
 * Get list of executed migrations
 */
function getExecutedMigrations($conn) {
    $executed = [];
    $result = $conn->query("SELECT migration_name FROM migrations ORDER BY id");
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $executed[] = $row['migration_name'];
        }
    }
    
    return $executed;
}

/**
 * Get list of migration files
 */
function getMigrationFiles() {
    $migrations = [];
    $files = glob(__DIR__ . '/*.sql');
    
    sort($files); // Ensure migrations run in order
    
    foreach ($files as $file) {
        $migrations[] = basename($file);
    }
    
    return $migrations;
}

/**
 * Execute a migration file
 */
function executeMigration($conn, $filename) {
    $filepath = __DIR__ . '/' . $filename;
    
    if (!file_exists($filepath)) {
        printMessage("✗ Migration file not found: $filename", COLOR_RED);
        return false;
    }
    
    $sql = file_get_contents($filepath);
    
    // Remove comments and split by semicolons
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && !preg_match('/^--/', $stmt);
        }
    );
    
    // Execute each statement
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            if ($conn->query($statement) === FALSE) {
                printMessage("✗ Error executing migration $filename: " . $conn->error, COLOR_RED);
                return false;
            }
        }
    }
    
    // Record migration as executed
    $stmt = $conn->prepare("INSERT INTO migrations (migration_name) VALUES (?)");
    $stmt->bind_param("s", $filename);
    
    if ($stmt->execute()) {
        printMessage("✓ Executed: $filename", COLOR_GREEN);
        return true;
    } else {
        printMessage("✗ Error recording migration: " . $stmt->error, COLOR_RED);
        return false;
    }
}

/**
 * Rollback all migrations (drop all tables)
 */
function rollbackMigrations($conn) {
    printMessage("\n⚠ WARNING: This will drop all CMS tables!", COLOR_YELLOW);
    printMessage("Tables to be dropped: content_revisions, audit_log, documentation_cards, regulatory_frameworks, country_overview, users, countries, migrations", COLOR_YELLOW);
    
    echo "\nType 'yes' to confirm rollback: ";
    $handle = fopen("php://stdin", "r");
    $line = trim(fgets($handle));
    fclose($handle);
    
    if ($line !== 'yes') {
        printMessage("Rollback cancelled.", COLOR_BLUE);
        return;
    }
    
    printMessage("\nRolling back migrations...", COLOR_BLUE);
    
    // Drop tables in reverse order (respecting foreign key constraints)
    $tables = [
        'content_revisions',
        'audit_log',
        'documentation_cards',
        'regulatory_frameworks',
        'country_overview',
        'users',
        'countries',
        'migrations'
    ];
    
    foreach ($tables as $table) {
        if ($conn->query("DROP TABLE IF EXISTS $table") === TRUE) {
            printMessage("✓ Dropped table: $table", COLOR_GREEN);
        } else {
            printMessage("✗ Error dropping table $table: " . $conn->error, COLOR_RED);
        }
    }
    
    printMessage("\n✓ Rollback complete!", COLOR_GREEN);
}

/**
 * Run pending migrations
 */
function runMigrations($conn) {
    printMessage("\n" . str_repeat("=", 60), COLOR_BLUE);
    printMessage("  HexaTP Country CMS - Database Migration Runner", COLOR_BLUE);
    printMessage(str_repeat("=", 60) . "\n", COLOR_BLUE);
    
    // Create migrations tracking table
    if (!createMigrationsTable($conn)) {
        return;
    }
    
    // Get executed and pending migrations
    $executed = getExecutedMigrations($conn);
    $available = getMigrationFiles();
    $pending = array_diff($available, $executed);
    
    if (empty($pending)) {
        printMessage("✓ No pending migrations. Database is up to date!", COLOR_GREEN);
        printMessage("\nExecuted migrations: " . count($executed), COLOR_BLUE);
        return;
    }
    
    printMessage("Found " . count($pending) . " pending migration(s):\n", COLOR_YELLOW);
    
    foreach ($pending as $migration) {
        printMessage("  → $migration", COLOR_YELLOW);
    }
    
    printMessage("\nExecuting migrations...\n", COLOR_BLUE);
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($pending as $migration) {
        if (executeMigration($conn, $migration)) {
            $success_count++;
        } else {
            $error_count++;
            printMessage("\n✗ Migration failed. Stopping execution.", COLOR_RED);
            break;
        }
    }
    
    printMessage("\n" . str_repeat("=", 60), COLOR_BLUE);
    printMessage("Migration Summary:", COLOR_BLUE);
    printMessage("  Successful: $success_count", COLOR_GREEN);
    if ($error_count > 0) {
        printMessage("  Failed: $error_count", COLOR_RED);
    }
    printMessage("  Total executed: " . (count($executed) + $success_count), COLOR_BLUE);
    printMessage(str_repeat("=", 60) . "\n", COLOR_BLUE);
}

// Main execution
try {
    // Check for rollback flag
    if (isset($argv[1]) && $argv[1] === '--rollback') {
        rollbackMigrations($conn);
    } else {
        runMigrations($conn);
    }
} catch (Exception $e) {
    printMessage("✗ Fatal error: " . $e->getMessage(), COLOR_RED);
    exit(1);
} finally {
    // Close database connection
    if (isset($conn)) {
        $conn->close();
    }
}

?>
