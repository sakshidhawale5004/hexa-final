<?php

require_once __DIR__ . '/DocumentationCard.php';
require_once __DIR__ . '/ValidationResult.php';

/**
 * Unit tests for DocumentationCard model
 */
class DocumentationCardTest {
    private int $testsPassed = 0;
    private int $testsFailed = 0;
    private array $failures = [];
    
    public function runAllTests(): void {
        echo "Running DocumentationCard Model Tests...\n\n";
        
        // Validation tests
        $this->testValidCardPassesValidation();
        $this->testMissingCountryIdFailsValidation();
        $this->testMissingTitleFailsValidation();
        $this->testTitleExceedsMaxLengthFailsValidation();
        $this->testMissingContentGeneratesWarning();
        
        // Serialization tests
        $this->testToArrayConvertsAllFields();
        $this->testToArrayIncludesIdWhenSet();
        
        // Deserialization tests
        $this->testFromArrayCreatesValidCard();
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
    
    private function testValidCardPassesValidation(): void {
        $card = new DocumentationCard();
        $card->country_id = 1;
        $card->title = "Master File Requirements";
        $card->short_description = "Overview of master file requirements";
        $card->detailed_content = "Detailed content about master file requirements";
        
        $result = $card->validate();
        $this->assert($result->is_valid, "Valid card should pass validation");
        $this->assert(empty($result->errors), "Valid card should have no errors");
    }
    
    private function testMissingCountryIdFailsValidation(): void {
        $card = new DocumentationCard();
        $card->title = "Master File Requirements";
        
        $result = $card->validate();
        $this->assert(!$result->is_valid, "Card without country_id should fail validation");
        $this->assert(isset($result->errors['country_id']), "Should have country_id error");
    }
    
    private function testMissingTitleFailsValidation(): void {
        $card = new DocumentationCard();
        $card->country_id = 1;
        
        $result = $card->validate();
        $this->assert(!$result->is_valid, "Card without title should fail validation");
        $this->assert(isset($result->errors['title']), "Should have title error");
    }
    
    private function testTitleExceedsMaxLengthFailsValidation(): void {
        $card = new DocumentationCard();
        $card->country_id = 1;
        $card->title = str_repeat("a", 151); // 151 characters (exceeds 150)
        
        $result = $card->validate();
        $this->assert(!$result->is_valid, "Title exceeding 150 chars should fail validation");
        $this->assert(isset($result->errors['title']), "Should have title error");
        $this->assert(
            strpos($result->errors['title'], '150') !== false,
            "Error message should mention 150 character limit"
        );
    }
    
    private function testMissingContentGeneratesWarning(): void {
        $card = new DocumentationCard();
        $card->country_id = 1;
        $card->title = "Master File Requirements";
        
        $result = $card->validate();
        $this->assert($result->is_valid, "Card without content should still be valid");
        $this->assert(isset($result->warnings['content']), "Should have content warning");
    }
    
    // Serialization Tests
    
    private function testToArrayConvertsAllFields(): void {
        $card = new DocumentationCard();
        $card->country_id = 1;
        $card->title = "Master File Requirements";
        $card->short_description = "Overview of master file requirements";
        $card->detailed_content = "Detailed content about master file requirements";
        $card->display_order = 1;
        
        $array = $card->toArray();
        
        $this->assert($array['country_id'] === 1, "toArray should include country_id");
        $this->assert($array['title'] === "Master File Requirements", "toArray should include title");
        $this->assert($array['short_description'] === "Overview of master file requirements", "toArray should include short_description");
        $this->assert($array['detailed_content'] === "Detailed content about master file requirements", "toArray should include detailed_content");
        $this->assert($array['display_order'] === 1, "toArray should include display_order");
    }
    
    private function testToArrayIncludesIdWhenSet(): void {
        $card = new DocumentationCard();
        $card->id = 42;
        $card->country_id = 1;
        $card->title = "Master File Requirements";
        
        $array = $card->toArray();
        
        $this->assert(isset($array['id']), "toArray should include id when set");
        $this->assert($array['id'] === 42, "toArray should include correct id value");
    }
    
    // Deserialization Tests
    
    private function testFromArrayCreatesValidCard(): void {
        $data = [
            'country_id' => 1,
            'title' => 'Master File Requirements',
            'short_description' => 'Overview of master file requirements',
            'detailed_content' => 'Detailed content about master file requirements',
            'display_order' => 1
        ];
        
        $card = DocumentationCard::fromArray($data);
        
        $this->assert($card->country_id === 1, "fromArray should set country_id");
        $this->assert($card->title === 'Master File Requirements', "fromArray should set title");
        $this->assert($card->short_description === 'Overview of master file requirements', "fromArray should set short_description");
        $this->assert($card->detailed_content === 'Detailed content about master file requirements', "fromArray should set detailed_content");
        $this->assert($card->display_order === 1, "fromArray should set display_order");
    }
    
    private function testFromArrayHandlesOptionalFields(): void {
        $data = [
            'country_id' => 1,
            'title' => 'Master File Requirements'
        ];
        
        $card = DocumentationCard::fromArray($data);
        
        $this->assert($card->short_description === null, "fromArray should set missing short_description to null");
        $this->assert($card->detailed_content === null, "fromArray should set missing detailed_content to null");
        $this->assert($card->display_order === 0, "fromArray should default display_order to 0");
    }
    
    private function testFromArrayHandlesTimestamps(): void {
        $data = [
            'country_id' => 1,
            'title' => 'Master File Requirements',
            'created_at' => '2024-01-15 10:30:00',
            'updated_at' => '2024-01-15 11:45:00'
        ];
        
        $card = DocumentationCard::fromArray($data);
        
        $this->assert($card->created_at instanceof DateTime, "fromArray should convert created_at to DateTime");
        $this->assert($card->updated_at instanceof DateTime, "fromArray should convert updated_at to DateTime");
        $this->assert(
            $card->created_at->format('Y-m-d H:i:s') === '2024-01-15 10:30:00',
            "fromArray should preserve created_at value"
        );
    }
    
    // Round-trip Tests
    
    private function testRoundTripConversion(): void {
        $original = new DocumentationCard();
        $original->id = 1;
        $original->country_id = 1;
        $original->title = "Master File Requirements";
        $original->short_description = "Overview of master file requirements";
        $original->detailed_content = "Detailed content about master file requirements";
        $original->display_order = 1;
        
        $array = $original->toArray();
        $restored = DocumentationCard::fromArray($array);
        
        $this->assert($restored->id === $original->id, "Round-trip should preserve id");
        $this->assert($restored->country_id === $original->country_id, "Round-trip should preserve country_id");
        $this->assert($restored->title === $original->title, "Round-trip should preserve title");
        $this->assert($restored->short_description === $original->short_description, "Round-trip should preserve short_description");
        $this->assert($restored->detailed_content === $original->detailed_content, "Round-trip should preserve detailed_content");
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
    $test = new DocumentationCardTest();
    $test->runAllTests();
}
