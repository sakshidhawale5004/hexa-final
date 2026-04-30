<?php
/**
 * Migration Validation Script
 * Validates SQL syntax and structure of migration files
 */

define('COLOR_GREEN', "\033[32m");
define('COLOR_RED', "\033[31m");
define('COLOR_YELLOW', "\033[33m");
define('COLOR_BLUE', "\033[34m");
define('COLOR_RESET', "\033[0m");

function printMessage($message, $color = COLOR_RESET) {
    echo $color . $message . COLOR_RESET . PHP_EOL;
}

printMessage("\n" . str_repeat("=", 60), COLOR_BLUE);
printMessage("  Migration Files Validation", COLOR_BLUE);
printMessage(str_repeat("=", 60) . "\n", COLOR_BLUE);

$migrations = glob(__DIR__ . '/*.sql');
sort($migrations);

if (empty($migrations)) {
    printMessage("✗ No migration files found!", COLOR_RED);
    exit(1);
}

$validations = [
    'total' => 0,
    'passed' => 0,
    'failed' => 0,
    'issues' => []
];

foreach ($migrations as $filepath) {
    $filename = basename($filepath);
    $validations['total']++;
    
    printMessage("Validating: $filename", COLOR_YELLOW);
    
    $issues = [];
    
    // Check file exists and is readable
    if (!is_readable($filepath)) {
        $issues[] = "File is not readable";
    }
    
    // Read file content
    $content = file_get_contents($filepath);
    
    if (empty($content)) {
        $issues[] = "File is empty";
    }
    
    // Check for required SQL keywords
    if (!preg_match('/CREATE\s+TABLE/i', $content)) {
        $issues[] = "Missing CREATE TABLE statement";
    }
    
    // Check for IF NOT EXISTS clause
    if (!preg_match('/IF\s+NOT\s+EXISTS/i', $content)) {
        $issues[] = "Missing IF NOT EXISTS clause (recommended for idempotency)";
    }
    
    // Check for ENGINE specification
    if (!preg_match('/ENGINE\s*=\s*InnoDB/i', $content)) {
        $issues[] = "Missing or incorrect ENGINE specification (should be InnoDB)";
    }
    
    // Check for charset specification
    if (!preg_match('/CHARSET\s*=\s*utf8mb4/i', $content)) {
        $issues[] = "Missing or incorrect CHARSET specification (should be utf8mb4)";
    }
    
    // Check for collation specification
    if (!preg_match('/COLLATE\s*=\s*utf8mb4_unicode_ci/i', $content)) {
        $issues[] = "Missing or incorrect COLLATE specification (should be utf8mb4_unicode_ci)";
    }
    
    // Check for PRIMARY KEY
    if (!preg_match('/PRIMARY\s+KEY/i', $content)) {
        $issues[] = "Missing PRIMARY KEY definition";
    }
    
    // Check for AUTO_INCREMENT on primary key
    if (!preg_match('/AUTO_INCREMENT/i', $content)) {
        $issues[] = "Missing AUTO_INCREMENT on primary key";
    }
    
    // Check for timestamps
    if (!preg_match('/created_at/i', $content) && !preg_match('/migrations/i', $filename)) {
        $issues[] = "Missing created_at timestamp field";
    }
    
    // Check for foreign keys in dependent tables
    $dependent_tables = ['country_overview', 'regulatory_frameworks', 'documentation_cards', 'content_revisions', 'audit_log'];
    foreach ($dependent_tables as $table) {
        if (preg_match("/$table/i", $filename)) {
            if (!preg_match('/FOREIGN\s+KEY/i', $content)) {
                $issues[] = "Missing FOREIGN KEY constraint for dependent table";
            }
            if (!preg_match('/ON\s+DELETE\s+CASCADE/i', $content) && !preg_match('/audit_log|users/i', $filename)) {
                $issues[] = "Missing ON DELETE CASCADE for foreign key";
            }
        }
    }
    
    // Check for indexes
    if (preg_match('/country_id|user_id|display_order/i', $content)) {
        if (!preg_match('/INDEX/i', $content)) {
            $issues[] = "Consider adding INDEX for foreign key or frequently queried columns";
        }
    }
    
    // Report results for this file
    if (empty($issues)) {
        printMessage("  ✓ Valid - No issues found\n", COLOR_GREEN);
        $validations['passed']++;
    } else {
        printMessage("  ⚠ Issues found:", COLOR_YELLOW);
        foreach ($issues as $issue) {
            printMessage("    - $issue", COLOR_YELLOW);
        }
        echo "\n";
        $validations['failed']++;
        $validations['issues'][$filename] = $issues;
    }
}

// Print summary
printMessage(str_repeat("=", 60), COLOR_BLUE);
printMessage("Validation Summary:", COLOR_BLUE);
printMessage("  Total files: " . $validations['total'], COLOR_BLUE);
printMessage("  Passed: " . $validations['passed'], COLOR_GREEN);

if ($validations['failed'] > 0) {
    printMessage("  With issues: " . $validations['failed'], COLOR_YELLOW);
}

printMessage(str_repeat("=", 60) . "\n", COLOR_BLUE);

// Check expected number of migrations
$expected_count = 7;
if ($validations['total'] !== $expected_count) {
    printMessage("⚠ Warning: Expected $expected_count migration files, found " . $validations['total'], COLOR_YELLOW);
}

// List expected tables
printMessage("Expected tables to be created:", COLOR_BLUE);
$expected_tables = [
    'countries',
    'users',
    'country_overview',
    'regulatory_frameworks',
    'documentation_cards',
    'content_revisions',
    'audit_log'
];

foreach ($expected_tables as $table) {
    $found = false;
    foreach ($migrations as $migration) {
        if (preg_match("/$table/i", basename($migration))) {
            $found = true;
            break;
        }
    }
    
    if ($found) {
        printMessage("  ✓ $table", COLOR_GREEN);
    } else {
        printMessage("  ✗ $table (migration file not found)", COLOR_RED);
    }
}

printMessage("\n✓ Validation complete!", COLOR_GREEN);

// Exit with appropriate code
exit($validations['failed'] > 0 ? 1 : 0);

?>
