<?php

/**
 * Test Runner for All Model Tests
 * 
 * This script runs all model tests and provides a comprehensive summary.
 * Run this script from the command line: php models/run_all_tests.php
 */

echo "========================================\n";
echo "Country Content CMS - Model Test Suite\n";
echo "========================================\n\n";

$testFiles = [
    'Country.test.php',
    'CountryOverview.test.php',
    'RegulatoryFramework.test.php',
    'DocumentationCard.test.php',
    'User.test.php'
];

$totalTests = 0;
$totalPassed = 0;
$totalFailed = 0;

foreach ($testFiles as $testFile) {
    $filePath = __DIR__ . '/' . $testFile;
    
    if (!file_exists($filePath)) {
        echo "⚠ WARNING: Test file not found: $testFile\n\n";
        continue;
    }
    
    echo "Running tests from: $testFile\n";
    echo str_repeat("-", 60) . "\n";
    
    // Run the test file
    require_once $filePath;
    
    echo "\n";
}

echo "\n========================================\n";
echo "All Model Tests Complete\n";
echo "========================================\n";
echo "\nTo run individual test files:\n";
echo "  php models/Country.test.php\n";
echo "  php models/CountryOverview.test.php\n";
echo "  php models/RegulatoryFramework.test.php\n";
echo "  php models/DocumentationCard.test.php\n";
echo "  php models/User.test.php\n";
