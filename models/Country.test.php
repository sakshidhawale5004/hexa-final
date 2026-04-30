<?php

require_once __DIR__ . '/Country.php';
require_once __DIR__ . '/ValidationResult.php';

/**
 * Unit tests for Country model
 */
class CountryTest {
    private int $testsPassed = 0;
    private int $testsFailed = 0;
    private array $failures = [];
    
    public function runAllTests(): void {
        echo "Running Country Model Tests...\n\n";
        
        // Validation tests
        $this->testValidCountryPassesValidation();
        $this->testMissingCountryNameFailsValidation();
        $this->testMissingCountryCodeFailsValidation();
        $this->testHeroTitleExceedsMaxLengthFailsValidation();
        $this->testHeroDescriptionExceedsMaxLengthFailsValidation();
        $this->testInvalidStatusFailsValidation();
        $this->testOptionalFieldsCanBeNull();
        $this->testAllFieldLengthValidations();
        
        // Serialization tests
        $this->testToArrayConvertsAllFields();
        $this->testToArrayIncludesIdWhenSet();
        $this->testToArrayIncludesRelationships();
        
        // Deserialization tests
        $this->testFromArrayCreatesValidCountry();
        $this->testFromArrayHandlesOptionalFields();
        $this->testFromArrayHandlesTimestamps();
        $this->testFromArrayHandlesRelationships();
        
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
    
    private function testValidCountryPassesValidation(): void {
        $country = new Country();
        $country->country_name = "Australia";
        $country->country_code = "AU";
        $country->status = "draft";
        
        $result = $country->validate();
        $this->assert($result->is_valid, "Valid country should pass validation");
        $this->assert(empty($result->errors), "Valid country should have no errors");
    }
    
    private function testMissingCountryNameFailsValidation(): void {
        $country = new Country();
        $country->country_code = "AU";
        
        $result = $country->validate();
        $this->assert(!$result->is_valid, "Country without name should fail validation");
        $this->assert(isset($result->errors['country_name']), "Should have country_name error");
    }
    
    private function testMissingCountryCodeFailsValidation(): void {
        $country = new Country();
        $country->country_name = "Australia";
        
        $result = $country->validate();
        $this->assert(!$result->is_valid, "Country without code should fail validation");
        $this->assert(isset($result->errors['country_code']), "Should have country_code error");
    }
    
    private function testHeroTitleExceedsMaxLengthFailsValidation(): void {
        $country = new Country();
        $country->country_name = "Australia";
        $country->country_code = "AU";
        $country->hero_title = str_repeat("a", 101); // 101 characters (exceeds 100)
        
        $result = $country->validate();
        $this->assert(!$result->is_valid, "Hero title exceeding 100 chars should fail validation");
        $this->assert(isset($result->errors['hero_title']), "Should have hero_title error");
        $this->assert(
            strpos($result->errors['hero_title'], '100') !== false,
            "Error message should mention 100 character limit"
        );
    }
    
    private function testHeroDescriptionExceedsMaxLengthFailsValidation(): void {
        $country = new Country();
        $country->country_name = "Australia";
        $country->country_code = "AU";
        $country->hero_description = str_repeat("a", 501); // 501 characters (exceeds 500)
        
        $result = $country->validate();
        $this->assert(!$result->is_valid, "Hero description exceeding 500 chars should fail validation");
        $this->assert(isset($result->errors['hero_description']), "Should have hero_description error");
        $this->assert(
            strpos($result->errors['hero_description'], '500') !== false,
            "Error message should mention 500 character limit"
        );
    }
    
    private function testInvalidStatusFailsValidation(): void {
        $country = new Country();
        $country->country_name = "Australia";
        $country->country_code = "AU";
        $country->status = "invalid_status";
        
        $result = $country->validate();
        $this->assert(!$result->is_valid, "Invalid status should fail validation");
        $this->assert(isset($result->errors['status']), "Should have status error");
    }
    
    private function testOptionalFieldsCanBeNull(): void {
        $country = new Country();
        $country->country_name = "Australia";
        $country->country_code = "AU";
        $country->flag_url = null;
        $country->hero_title = null;
        $country->hero_description = null;
        $country->meta_title = null;
        $country->meta_description = null;
        
        $result = $country->validate();
        $this->assert($result->is_valid, "Country with null optional fields should pass validation");
    }
    
    private function testAllFieldLengthValidations(): void {
        $country = new Country();
        $country->country_name = str_repeat("a", 101); // Exceeds 100
        $country->country_code = str_repeat("a", 11);  // Exceeds 10
        $country->flag_url = str_repeat("a", 256);     // Exceeds 255
        $country->meta_title = str_repeat("a", 256);   // Exceeds 255
        $country->meta_description = str_repeat("a", 501); // Exceeds 500
        
        $result = $country->validate();
        $this->assert(!$result->is_valid, "Country with multiple length violations should fail");
        $this->assert(count($result->errors) >= 5, "Should have at least 5 field length errors");
    }
    
    // Serialization Tests
    
    private function testToArrayConvertsAllFields(): void {
        $country = new Country();
        $country->country_name = "Australia";
        $country->country_code = "AU";
        $country->flag_url = "https://example.com/flag.png";
        $country->hero_title = "Transfer Pricing Australia";
        $country->hero_description = "Comprehensive guide";
        $country->meta_title = "Australia TP";
        $country->meta_description = "Meta description";
        $country->status = "published";
        
        $array = $country->toArray();
        
        $this->assert($array['country_name'] === "Australia", "toArray should include country_name");
        $this->assert($array['country_code'] === "AU", "toArray should include country_code");
        $this->assert($array['flag_url'] === "https://example.com/flag.png", "toArray should include flag_url");
        $this->assert($array['hero_title'] === "Transfer Pricing Australia", "toArray should include hero_title");
        $this->assert($array['status'] === "published", "toArray should include status");
    }
    
    private function testToArrayIncludesIdWhenSet(): void {
        $country = new Country();
        $country->id = 42;
        $country->country_name = "Australia";
        $country->country_code = "AU";
        
        $array = $country->toArray();
        
        $this->assert(isset($array['id']), "toArray should include id when set");
        $this->assert($array['id'] === 42, "toArray should include correct id value");
    }
    
    private function testToArrayIncludesRelationships(): void {
        $country = new Country();
        $country->country_name = "Australia";
        $country->country_code = "AU";
        $country->overview = ['overview_text_left' => 'Left text'];
        $country->regulatory_frameworks = [
            ['title' => 'Framework 1'],
            ['title' => 'Framework 2']
        ];
        $country->documentation_cards = [
            ['title' => 'Card 1']
        ];
        
        $array = $country->toArray();
        
        $this->assert(isset($array['overview']), "toArray should include overview");
        $this->assert(isset($array['regulatory_frameworks']), "toArray should include regulatory_frameworks");
        $this->assert(isset($array['documentation_cards']), "toArray should include documentation_cards");
        $this->assert(count($array['regulatory_frameworks']) === 2, "toArray should include all frameworks");
    }
    
    // Deserialization Tests
    
    private function testFromArrayCreatesValidCountry(): void {
        $data = [
            'country_name' => 'Australia',
            'country_code' => 'AU',
            'flag_url' => 'https://example.com/flag.png',
            'hero_title' => 'Transfer Pricing Australia',
            'hero_description' => 'Comprehensive guide',
            'status' => 'published'
        ];
        
        $country = Country::fromArray($data);
        
        $this->assert($country->country_name === 'Australia', "fromArray should set country_name");
        $this->assert($country->country_code === 'AU', "fromArray should set country_code");
        $this->assert($country->flag_url === 'https://example.com/flag.png', "fromArray should set flag_url");
        $this->assert($country->status === 'published', "fromArray should set status");
    }
    
    private function testFromArrayHandlesOptionalFields(): void {
        $data = [
            'country_name' => 'Australia',
            'country_code' => 'AU'
        ];
        
        $country = Country::fromArray($data);
        
        $this->assert($country->flag_url === null, "fromArray should set missing optional fields to null");
        $this->assert($country->hero_title === null, "fromArray should set missing hero_title to null");
        $this->assert($country->status === 'draft', "fromArray should default status to draft");
    }
    
    private function testFromArrayHandlesTimestamps(): void {
        $data = [
            'country_name' => 'Australia',
            'country_code' => 'AU',
            'created_at' => '2024-01-15 10:30:00',
            'updated_at' => '2024-01-15 11:45:00'
        ];
        
        $country = Country::fromArray($data);
        
        $this->assert($country->created_at instanceof DateTime, "fromArray should convert created_at to DateTime");
        $this->assert($country->updated_at instanceof DateTime, "fromArray should convert updated_at to DateTime");
        $this->assert(
            $country->created_at->format('Y-m-d H:i:s') === '2024-01-15 10:30:00',
            "fromArray should preserve created_at value"
        );
    }
    
    private function testFromArrayHandlesRelationships(): void {
        $data = [
            'country_name' => 'Australia',
            'country_code' => 'AU',
            'overview' => ['overview_text_left' => 'Left text'],
            'regulatory_frameworks' => [
                ['title' => 'Framework 1']
            ],
            'documentation_cards' => [
                ['title' => 'Card 1']
            ]
        ];
        
        $country = Country::fromArray($data);
        
        $this->assert($country->overview !== null, "fromArray should set overview");
        $this->assert(count($country->regulatory_frameworks) === 1, "fromArray should set regulatory_frameworks");
        $this->assert(count($country->documentation_cards) === 1, "fromArray should set documentation_cards");
    }
    
    // Round-trip Tests
    
    private function testRoundTripConversion(): void {
        $original = new Country();
        $original->id = 1;
        $original->country_name = "Australia";
        $original->country_code = "AU";
        $original->flag_url = "https://example.com/flag.png";
        $original->hero_title = "Transfer Pricing Australia";
        $original->hero_description = "Comprehensive guide to Australian TP";
        $original->meta_title = "Australia TP | HexaTP";
        $original->meta_description = "Complete guide to Australian transfer pricing";
        $original->status = "published";
        
        $array = $original->toArray();
        $restored = Country::fromArray($array);
        
        $this->assert($restored->id === $original->id, "Round-trip should preserve id");
        $this->assert($restored->country_name === $original->country_name, "Round-trip should preserve country_name");
        $this->assert($restored->country_code === $original->country_code, "Round-trip should preserve country_code");
        $this->assert($restored->flag_url === $original->flag_url, "Round-trip should preserve flag_url");
        $this->assert($restored->hero_title === $original->hero_title, "Round-trip should preserve hero_title");
        $this->assert($restored->hero_description === $original->hero_description, "Round-trip should preserve hero_description");
        $this->assert($restored->status === $original->status, "Round-trip should preserve status");
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
    $test = new CountryTest();
    $test->runAllTests();
}
