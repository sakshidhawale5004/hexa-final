<?php

require_once __DIR__ . '/CountryOverview.php';
require_once __DIR__ . '/ValidationResult.php';

/**
 * Unit tests for CountryOverview model
 */
class CountryOverviewTest {
    private int $testsPassed = 0;
    private int $testsFailed = 0;
    private array $failures = [];
    
    public function runAllTests(): void {
        echo "Running CountryOverview Model Tests...\n\n";
        
        // Validation tests
        $this->testValidOverviewPassesValidation();
        $this->testMissingCountryIdFailsValidation();
        $this->testEmptyOverviewTextsGeneratesWarning();
        $this->testOverviewWithLeftTextOnlyPassesValidation();
        $this->testOverviewWithRightTextOnlyPassesValidation();
        $this->testOverviewWithBothTextsPassesValidation();
        
        // Serialization tests
        $this->testToArrayConvertsAllFields();
        $this->testToArrayIncludesIdWhenSet();
        $this->testToArrayHandlesNullFields();
        
        // Deserialization tests
        $this->testFromArrayCreatesValidOverview();
        $this->testFromArrayHandlesOptionalFields();
        $this->testFromArrayHandlesTimestamps();
        $this->testFromArrayConvertsCountryIdToInt();
        
        // Round-trip tests
        $this->testRoundTripConversion();
        $this->testRoundTripWithNullFields();
        
        $this->printSummary();
    }
    
    private function assert(bool $condition, string $message): void {
        if ($condition) {
            $this->testsPassed++;
            echo "✓ PASS: $message\n";
        } else {
            $this->testsFailed++;
            $this->failures[] = $message;
            echo "✗ FAIL: $message\n";
        }
    }
    
    // Validation Tests
    
    private function testValidOverviewPassesValidation(): void {
        $overview = new CountryOverview();
        $overview->country_id = 1;
        $overview->overview_text_left = "Left column text";
        $overview->overview_text_right = "Right column text";
        
        $result = $overview->validate();
        $this->assert($result->is_valid, "Valid overview should pass validation");
        $this->assert(empty($result->errors), "Valid overview should have no errors");
    }
    
    private function testMissingCountryIdFailsValidation(): void {
        $overview = new CountryOverview();
        $overview->overview_text_left = "Left column text";
        
        $result = $overview->validate();
        $this->assert(!$result->is_valid, "Overview without country_id should fail validation");
        $this->assert(isset($result->errors['country_id']), "Should have country_id error");
    }
    
    private function testEmptyOverviewTextsGeneratesWarning(): void {
        $overview = new CountryOverview();
        $overview->country_id = 1;
        $overview->overview_text_left = null;
        $overview->overview_text_right = null;
        
        $result = $overview->validate();
        // Should still be valid (for drafts) but have a warning
        $this->assert($result->is_valid, "Overview without text should be valid (for drafts)");
        $this->assert(isset($result->warnings['overview_text']), "Should have overview_text warning");
        $this->assert(
            strpos($result->warnings['overview_text'], 'publication') !== false,
            "Warning should mention publication requirement"
        );
    }
    
    private function testOverviewWithLeftTextOnlyPassesValidation(): void {
        $overview = new CountryOverview();
        $overview->country_id = 1;
        $overview->overview_text_left = "Left column text";
        $overview->overview_text_right = null;
        
        $result = $overview->validate();
        $this->assert($result->is_valid, "Overview with only left text should pass validation");
        $this->assert(empty($result->warnings), "Overview with left text should have no warnings");
    }
    
    private function testOverviewWithRightTextOnlyPassesValidation(): void {
        $overview = new CountryOverview();
        $overview->country_id = 1;
        $overview->overview_text_left = null;
        $overview->overview_text_right = "Right column text";
        
        $result = $overview->validate();
        $this->assert($result->is_valid, "Overview with only right text should pass validation");
        $this->assert(empty($result->warnings), "Overview with right text should have no warnings");
    }
    
    private function testOverviewWithBothTextsPassesValidation(): void {
        $overview = new CountryOverview();
        $overview->country_id = 1;
        $overview->overview_text_left = "Left column text";
        $overview->overview_text_right = "Right column text";
        
        $result = $overview->validate();
        $this->assert($result->is_valid, "Overview with both texts should pass validation");
        $this->assert(empty($result->warnings), "Overview with both texts should have no warnings");
    }
    
    // Serialization Tests
    
    private function testToArrayConvertsAllFields(): void {
        $overview = new CountryOverview();
        $overview->country_id = 1;
        $overview->overview_text_left = "Left column text";
        $overview->overview_text_right = "Right column text";
        
        $array = $overview->toArray();
        
        $this->assert($array['country_id'] === 1, "toArray should include country_id");
        $this->assert($array['overview_text_left'] === "Left column text", "toArray should include overview_text_left");
        $this->assert($array['overview_text_right'] === "Right column text", "toArray should include overview_text_right");
        $this->assert(isset($array['created_at']), "toArray should include created_at");
        $this->assert(isset($array['updated_at']), "toArray should include updated_at");
    }
    
    private function testToArrayIncludesIdWhenSet(): void {
        $overview = new CountryOverview();
        $overview->id = 42;
        $overview->country_id = 1;
        
        $array = $overview->toArray();
        
        $this->assert(isset($array['id']), "toArray should include id when set");
        $this->assert($array['id'] === 42, "toArray should include correct id value");
    }
    
    private function testToArrayHandlesNullFields(): void {
        $overview = new CountryOverview();
        $overview->country_id = 1;
        $overview->overview_text_left = null;
        $overview->overview_text_right = null;
        
        $array = $overview->toArray();
        
        $this->assert(array_key_exists('overview_text_left', $array), "toArray should include overview_text_left key");
        $this->assert($array['overview_text_left'] === null, "toArray should preserve null for overview_text_left");
        $this->assert(array_key_exists('overview_text_right', $array), "toArray should include overview_text_right key");
        $this->assert($array['overview_text_right'] === null, "toArray should preserve null for overview_text_right");
    }
    
    // Deserialization Tests
    
    private function testFromArrayCreatesValidOverview(): void {
        $data = [
            'country_id' => 1,
            'overview_text_left' => 'Left column text',
            'overview_text_right' => 'Right column text'
        ];
        
        $overview = CountryOverview::fromArray($data);
        
        $this->assert($overview->country_id === 1, "fromArray should set country_id");
        $this->assert($overview->overview_text_left === 'Left column text', "fromArray should set overview_text_left");
        $this->assert($overview->overview_text_right === 'Right column text', "fromArray should set overview_text_right");
    }
    
    private function testFromArrayHandlesOptionalFields(): void {
        $data = [
            'country_id' => 1
        ];
        
        $overview = CountryOverview::fromArray($data);
        
        $this->assert($overview->overview_text_left === null, "fromArray should set missing overview_text_left to null");
        $this->assert($overview->overview_text_right === null, "fromArray should set missing overview_text_right to null");
    }
    
    private function testFromArrayHandlesTimestamps(): void {
        $data = [
            'country_id' => 1,
            'created_at' => '2024-01-15 10:30:00',
            'updated_at' => '2024-01-15 11:45:00'
        ];
        
        $overview = CountryOverview::fromArray($data);
        
        $this->assert($overview->created_at instanceof DateTime, "fromArray should convert created_at to DateTime");
        $this->assert($overview->updated_at instanceof DateTime, "fromArray should convert updated_at to DateTime");
        $this->assert(
            $overview->created_at->format('Y-m-d H:i:s') === '2024-01-15 10:30:00',
            "fromArray should preserve created_at value"
        );
        $this->assert(
            $overview->updated_at->format('Y-m-d H:i:s') === '2024-01-15 11:45:00',
            "fromArray should preserve updated_at value"
        );
    }
    
    private function testFromArrayConvertsCountryIdToInt(): void {
        $data = [
            'country_id' => '42', // String value
            'overview_text_left' => 'Left text'
        ];
        
        $overview = CountryOverview::fromArray($data);
        
        $this->assert($overview->country_id === 42, "fromArray should convert country_id string to int");
        $this->assert(is_int($overview->country_id), "fromArray should ensure country_id is int type");
    }
    
    // Round-trip Tests
    
    private function testRoundTripConversion(): void {
        $original = new CountryOverview();
        $original->id = 1;
        $original->country_id = 42;
        $original->overview_text_left = "Left column text with <strong>HTML</strong>";
        $original->overview_text_right = "Right column text with <em>formatting</em>";
        
        $array = $original->toArray();
        $restored = CountryOverview::fromArray($array);
        
        $this->assert($restored->id === $original->id, "Round-trip should preserve id");
        $this->assert($restored->country_id === $original->country_id, "Round-trip should preserve country_id");
        $this->assert($restored->overview_text_left === $original->overview_text_left, "Round-trip should preserve overview_text_left");
        $this->assert($restored->overview_text_right === $original->overview_text_right, "Round-trip should preserve overview_text_right");
        $this->assert(
            $restored->created_at->format('Y-m-d H:i:s') === $original->created_at->format('Y-m-d H:i:s'),
            "Round-trip should preserve created_at"
        );
        $this->assert(
            $restored->updated_at->format('Y-m-d H:i:s') === $original->updated_at->format('Y-m-d H:i:s'),
            "Round-trip should preserve updated_at"
        );
    }
    
    private function testRoundTripWithNullFields(): void {
        $original = new CountryOverview();
        $original->id = 1;
        $original->country_id = 42;
        $original->overview_text_left = null;
        $original->overview_text_right = null;
        
        $array = $original->toArray();
        $restored = CountryOverview::fromArray($array);
        
        $this->assert($restored->overview_text_left === null, "Round-trip should preserve null overview_text_left");
        $this->assert($restored->overview_text_right === null, "Round-trip should preserve null overview_text_right");
    }
    
    private function printSummary(): void {
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "Test Summary\n";
        echo str_repeat("=", 60) . "\n";
        echo "Total Tests: " . ($this->testsPassed + $this->testsFailed) . "\n";
        echo "Passed: " . $this->testsPassed . "\n";
        echo "Failed: " . $this->testsFailed . "\n";
        
        if ($this->testsFailed > 0) {
            echo "\nFailed Tests:\n";
            foreach ($this->failures as $failure) {
                echo "  - $failure\n";
            }
        }
        
        echo str_repeat("=", 60) . "\n";
        
        if ($this->testsFailed === 0) {
            echo "✓ All tests passed!\n";
        } else {
            echo "✗ Some tests failed.\n";
        }
    }
}

// Run tests if this file is executed directly
if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($_SERVER['PHP_SELF'])) {
    $test = new CountryOverviewTest();
    $test->runAllTests();
}
