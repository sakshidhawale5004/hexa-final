<?php

require_once __DIR__ . '/RegulatoryFramework.php';
require_once __DIR__ . '/ValidationResult.php';

/**
 * Unit tests for RegulatoryFramework model
 */
class RegulatoryFrameworkTest {
    private int $testsPassed = 0;
    private int $testsFailed = 0;
    private array $failures = [];
    
    public function runAllTests(): void {
        echo "Running RegulatoryFramework Model Tests...\n\n";
        
        // Validation tests
        $this->testValidFrameworkPassesValidation();
        $this->testMissingCountryIdFailsValidation();
        $this->testMissingTitleFailsValidation();
        $this->testTitleExceedsMaxLengthFailsValidation();
        $this->testMissingDescriptionGeneratesWarning();
        
        // Serialization tests
        $this->testToArrayConvertsAllFields();
        $this->testToArrayIncludesIdWhenSet();
        
        // Deserialization tests
        $this->testFromArrayCreatesValidFramework();
        $this->testFromArrayHandlesOptionalFields();
        $this->testFromArrayHandlesTimestamps();
        
        // Round-trip tests
        $this->testRoundTripConversion();
        
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
    
    private function testValidFrameworkPassesValidation(): void {
        $framework = new RegulatoryFramework();
        $framework->country_id = 1;
        $framework->title = "Transfer Pricing Documentation";
        $framework->description = "Requirements for TP documentation";
        
        $result = $framework->validate();
        $this->assert($result->is_valid, "Valid framework should pass validation");
        $this->assert(empty($result->errors), "Valid framework should have no errors");
    }
    
    private function testMissingCountryIdFailsValidation(): void {
        $framework = new RegulatoryFramework();
        $framework->title = "Transfer Pricing Documentation";
        
        $result = $framework->validate();
        $this->assert(!$result->is_valid, "Framework without country_id should fail validation");
        $this->assert(isset($result->errors['country_id']), "Should have country_id error");
    }
    
    private function testMissingTitleFailsValidation(): void {
        $framework = new RegulatoryFramework();
        $framework->country_id = 1;
        
        $result = $framework->validate();
        $this->assert(!$result->is_valid, "Framework without title should fail validation");
        $this->assert(isset($result->errors['title']), "Should have title error");
    }
    
    private function testTitleExceedsMaxLengthFailsValidation(): void {
        $framework = new RegulatoryFramework();
        $framework->country_id = 1;
        $framework->title = str_repeat("a", 256); // 256 characters (exceeds 255)
        
        $result = $framework->validate();
        $this->assert(!$result->is_valid, "Title exceeding 255 chars should fail validation");
        $this->assert(isset($result->errors['title']), "Should have title error");
        $this->assert(
            strpos($result->errors['title'], '255') !== false,
            "Error message should mention 255 character limit"
        );
    }
    
    private function testMissingDescriptionGeneratesWarning(): void {
        $framework = new RegulatoryFramework();
        $framework->country_id = 1;
        $framework->title = "Transfer Pricing Documentation";
        
        $result = $framework->validate();
        $this->assert($result->is_valid, "Framework without description should still be valid");
        $this->assert(isset($result->warnings['description']), "Should have description warning");
    }
    
    // Serialization Tests
    
    private function testToArrayConvertsAllFields(): void {
        $framework = new RegulatoryFramework();
        $framework->country_id = 1;
        $framework->title = "Transfer Pricing Documentation";
        $framework->description = "Requirements for TP documentation";
        $framework->display_order = 1;
        
        $array = $framework->toArray();
        
        $this->assert($array['country_id'] === 1, "toArray should include country_id");
        $this->assert($array['title'] === "Transfer Pricing Documentation", "toArray should include title");
        $this->assert($array['description'] === "Requirements for TP documentation", "toArray should include description");
        $this->assert($array['display_order'] === 1, "toArray should include display_order");
    }
    
    private function testToArrayIncludesIdWhenSet(): void {
        $framework = new RegulatoryFramework();
        $framework->id = 42;
        $framework->country_id = 1;
        $framework->title = "Transfer Pricing Documentation";
        
        $array = $framework->toArray();
        
        $this->assert(isset($array['id']), "toArray should include id when set");
        $this->assert($array['id'] === 42, "toArray should include correct id value");
    }
    
    // Deserialization Tests
    
    private function testFromArrayCreatesValidFramework(): void {
        $data = [
            'country_id' => 1,
            'title' => 'Transfer Pricing Documentation',
            'description' => 'Requirements for TP documentation',
            'display_order' => 1
        ];
        
        $framework = RegulatoryFramework::fromArray($data);
        
        $this->assert($framework->country_id === 1, "fromArray should set country_id");
        $this->assert($framework->title === 'Transfer Pricing Documentation', "fromArray should set title");
        $this->assert($framework->description === 'Requirements for TP documentation', "fromArray should set description");
        $this->assert($framework->display_order === 1, "fromArray should set display_order");
    }
    
    private function testFromArrayHandlesOptionalFields(): void {
        $data = [
            'country_id' => 1,
            'title' => 'Transfer Pricing Documentation'
        ];
        
        $framework = RegulatoryFramework::fromArray($data);
        
        $this->assert($framework->description === null, "fromArray should set missing description to null");
        $this->assert($framework->display_order === 0, "fromArray should default display_order to 0");
    }
    
    private function testFromArrayHandlesTimestamps(): void {
        $data = [
            'country_id' => 1,
            'title' => 'Transfer Pricing Documentation',
            'created_at' => '2024-01-15 10:30:00',
            'updated_at' => '2024-01-15 11:45:00'
        ];
        
        $framework = RegulatoryFramework::fromArray($data);
        
        $this->assert($framework->created_at instanceof DateTime, "fromArray should convert created_at to DateTime");
        $this->assert($framework->updated_at instanceof DateTime, "fromArray should convert updated_at to DateTime");
        $this->assert(
            $framework->created_at->format('Y-m-d H:i:s') === '2024-01-15 10:30:00',
            "fromArray should preserve created_at value"
        );
    }
    
    // Round-trip Tests
    
    private function testRoundTripConversion(): void {
        $original = new RegulatoryFramework();
        $original->id = 1;
        $original->country_id = 1;
        $original->title = "Transfer Pricing Documentation";
        $original->description = "Requirements for TP documentation";
        $original->display_order = 1;
        
        $array = $original->toArray();
        $restored = RegulatoryFramework::fromArray($array);
        
        $this->assert($restored->id === $original->id, "Round-trip should preserve id");
        $this->assert($restored->country_id === $original->country_id, "Round-trip should preserve country_id");
        $this->assert($restored->title === $original->title, "Round-trip should preserve title");
        $this->assert($restored->description === $original->description, "Round-trip should preserve description");
        $this->assert($restored->display_order === $original->display_order, "Round-trip should preserve display_order");
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
    $test = new RegulatoryFrameworkTest();
    $test->runAllTests();
}
