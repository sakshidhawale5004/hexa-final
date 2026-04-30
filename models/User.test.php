<?php

require_once __DIR__ . '/User.php';

/**
 * Unit tests for User model
 */
class UserTest {
    private int $testsPassed = 0;
    private int $testsFailed = 0;
    private array $failures = [];
    
    public function runAllTests(): void {
        echo "Running User Model Tests...\n\n";
        
        // Password tests
        $this->testSetPasswordHashesPassword();
        $this->testVerifyPasswordWithCorrectPassword();
        $this->testVerifyPasswordWithIncorrectPassword();
        $this->testPasswordHashUsesSecureAlgorithm();
        
        // Permission tests
        $this->testAdminHasAllPermissions();
        $this->testEditorCanReadAllResources();
        $this->testEditorCanCreateCountryContent();
        $this->testEditorCanUpdateCountryContent();
        $this->testEditorCannotDelete();
        $this->testEditorCannotPublish();
        $this->testEditorCannotManageUsers();
        
        // Serialization tests
        $this->testToArrayExcludesPasswordHash();
        $this->testToArrayIncludesAllOtherFields();
        $this->testToArrayIncludesIdWhenSet();
        
        // Deserialization tests
        $this->testFromArrayCreatesValidUser();
        $this->testFromArrayHandlesPasswordHash();
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
    
    // Password Tests
    
    private function testSetPasswordHashesPassword(): void {
        $user = new User();
        $user->setPassword('mySecurePassword123');
        
        $hash = $user->getPasswordHash();
        $this->assert(!empty($hash), "setPassword should create a password hash");
        $this->assert($hash !== 'mySecurePassword123', "Password should be hashed, not stored in plain text");
        $this->assert(strlen($hash) >= 60, "Bcrypt hash should be at least 60 characters");
    }
    
    private function testVerifyPasswordWithCorrectPassword(): void {
        $user = new User();
        $user->setPassword('mySecurePassword123');
        
        $this->assert($user->verifyPassword('mySecurePassword123'), "verifyPassword should return true for correct password");
    }
    
    private function testVerifyPasswordWithIncorrectPassword(): void {
        $user = new User();
        $user->setPassword('mySecurePassword123');
        
        $this->assert(!$user->verifyPassword('wrongPassword'), "verifyPassword should return false for incorrect password");
        $this->assert(!$user->verifyPassword(''), "verifyPassword should return false for empty password");
    }
    
    private function testPasswordHashUsesSecureAlgorithm(): void {
        $user = new User();
        $user->setPassword('testPassword');
        
        $hash = $user->getPasswordHash();
        // Bcrypt hashes start with $2y$
        $this->assert(strpos($hash, '$2y$') === 0, "Password hash should use bcrypt algorithm");
    }
    
    // Permission Tests
    
    private function testAdminHasAllPermissions(): void {
        $admin = new User();
        $admin->role = User::ROLE_ADMIN;
        
        $this->assert($admin->hasPermission('create', 'country'), "Admin should have create permission");
        $this->assert($admin->hasPermission('read', 'country'), "Admin should have read permission");
        $this->assert($admin->hasPermission('update', 'country'), "Admin should have update permission");
        $this->assert($admin->hasPermission('delete', 'country'), "Admin should have delete permission");
        $this->assert($admin->hasPermission('publish', 'country'), "Admin should have publish permission");
        $this->assert($admin->hasPermission('create', 'user'), "Admin should have user management permission");
    }
    
    private function testEditorCanReadAllResources(): void {
        $editor = new User();
        $editor->role = User::ROLE_EDITOR;
        
        $this->assert($editor->hasPermission('read', 'country'), "Editor should have read permission for country");
        $this->assert($editor->hasPermission('read', 'user'), "Editor should have read permission for user");
        $this->assert($editor->hasPermission('read', 'overview'), "Editor should have read permission for overview");
    }
    
    private function testEditorCanCreateCountryContent(): void {
        $editor = new User();
        $editor->role = User::ROLE_EDITOR;
        
        $this->assert($editor->hasPermission('create', 'country'), "Editor should have create permission for country");
        $this->assert($editor->hasPermission('create', 'overview'), "Editor should have create permission for overview");
        $this->assert($editor->hasPermission('create', 'regulatory_framework'), "Editor should have create permission for regulatory_framework");
        $this->assert($editor->hasPermission('create', 'documentation_card'), "Editor should have create permission for documentation_card");
    }
    
    private function testEditorCanUpdateCountryContent(): void {
        $editor = new User();
        $editor->role = User::ROLE_EDITOR;
        
        $this->assert($editor->hasPermission('update', 'country'), "Editor should have update permission for country");
        $this->assert($editor->hasPermission('update', 'overview'), "Editor should have update permission for overview");
        $this->assert($editor->hasPermission('update', 'regulatory_framework'), "Editor should have update permission for regulatory_framework");
        $this->assert($editor->hasPermission('update', 'documentation_card'), "Editor should have update permission for documentation_card");
    }
    
    private function testEditorCannotDelete(): void {
        $editor = new User();
        $editor->role = User::ROLE_EDITOR;
        
        $this->assert(!$editor->hasPermission('delete', 'country'), "Editor should not have delete permission");
    }
    
    private function testEditorCannotPublish(): void {
        $editor = new User();
        $editor->role = User::ROLE_EDITOR;
        
        $this->assert(!$editor->hasPermission('publish', 'country'), "Editor should not have publish permission");
    }
    
    private function testEditorCannotManageUsers(): void {
        $editor = new User();
        $editor->role = User::ROLE_EDITOR;
        
        $this->assert(!$editor->hasPermission('create', 'user'), "Editor should not have user creation permission");
        $this->assert(!$editor->hasPermission('update', 'user'), "Editor should not have user update permission");
        $this->assert(!$editor->hasPermission('delete', 'user'), "Editor should not have user deletion permission");
    }
    
    // Serialization Tests
    
    private function testToArrayExcludesPasswordHash(): void {
        $user = new User();
        $user->username = "testuser";
        $user->email = "test@example.com";
        $user->setPassword("securePassword123");
        
        $array = $user->toArray();
        
        $this->assert(!isset($array['password_hash']), "toArray should not include password_hash");
        $this->assert(!isset($array['password']), "toArray should not include password");
    }
    
    private function testToArrayIncludesAllOtherFields(): void {
        $user = new User();
        $user->username = "testuser";
        $user->email = "test@example.com";
        $user->role = User::ROLE_ADMIN;
        $user->last_login = new DateTime('2024-01-15 10:30:00');
        
        $array = $user->toArray();
        
        $this->assert($array['username'] === "testuser", "toArray should include username");
        $this->assert($array['email'] === "test@example.com", "toArray should include email");
        $this->assert($array['role'] === User::ROLE_ADMIN, "toArray should include role");
        $this->assert($array['last_login'] === '2024-01-15 10:30:00', "toArray should include last_login");
        $this->assert(isset($array['created_at']), "toArray should include created_at");
    }
    
    private function testToArrayIncludesIdWhenSet(): void {
        $user = new User();
        $user->id = 42;
        $user->username = "testuser";
        $user->email = "test@example.com";
        
        $array = $user->toArray();
        
        $this->assert(isset($array['id']), "toArray should include id when set");
        $this->assert($array['id'] === 42, "toArray should include correct id value");
    }
    
    // Deserialization Tests
    
    private function testFromArrayCreatesValidUser(): void {
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'role' => User::ROLE_ADMIN
        ];
        
        $user = User::fromArray($data);
        
        $this->assert($user->username === 'testuser', "fromArray should set username");
        $this->assert($user->email === 'test@example.com', "fromArray should set email");
        $this->assert($user->role === User::ROLE_ADMIN, "fromArray should set role");
    }
    
    private function testFromArrayHandlesPasswordHash(): void {
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password_hash' => '$2y$12$abcdefghijklmnopqrstuvwxyz1234567890'
        ];
        
        $user = User::fromArray($data);
        
        $this->assert($user->getPasswordHash() === '$2y$12$abcdefghijklmnopqrstuvwxyz1234567890', "fromArray should set password_hash");
    }
    
    private function testFromArrayHandlesTimestamps(): void {
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'last_login' => '2024-01-15 10:30:00',
            'created_at' => '2024-01-01 08:00:00'
        ];
        
        $user = User::fromArray($data);
        
        $this->assert($user->last_login instanceof DateTime, "fromArray should convert last_login to DateTime");
        $this->assert($user->created_at instanceof DateTime, "fromArray should convert created_at to DateTime");
        $this->assert(
            $user->last_login->format('Y-m-d H:i:s') === '2024-01-15 10:30:00',
            "fromArray should preserve last_login value"
        );
    }
    
    // Round-trip Tests
    
    private function testRoundTripConversion(): void {
        $original = new User();
        $original->id = 1;
        $original->username = "testuser";
        $original->email = "test@example.com";
        $original->role = User::ROLE_ADMIN;
        $original->last_login = new DateTime('2024-01-15 10:30:00');
        
        $array = $original->toArray();
        $restored = User::fromArray($array);
        
        $this->assert($restored->id === $original->id, "Round-trip should preserve id");
        $this->assert($restored->username === $original->username, "Round-trip should preserve username");
        $this->assert($restored->email === $original->email, "Round-trip should preserve email");
        $this->assert($restored->role === $original->role, "Round-trip should preserve role");
        $this->assert(
            $restored->last_login->format('Y-m-d H:i:s') === $original->last_login->format('Y-m-d H:i:s'),
            "Round-trip should preserve last_login"
        );
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
    $test = new UserTest();
    $test->runAllTests();
}
