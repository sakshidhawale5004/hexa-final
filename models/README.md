# Country Content CMS - Data Models

This directory contains the PHP data models for the Country Content Management System.

## Models

### Country Model (`Country.php`)

The `Country` model represents a country entity with all its properties, including hero section content, SEO metadata, and relationships to other content types.

#### Properties

- `id` (int): Primary key
- `country_name` (string): Country name (required, max 100 chars)
- `country_code` (string): Country code (required, max 10 chars)
- `flag_url` (string|null): URL to country flag image (max 255 chars)
- `hero_title` (string|null): Hero section title (max 100 chars)
- `hero_description` (string|null): Hero section description (max 500 chars)
- `meta_title` (string|null): SEO meta title (max 255 chars)
- `meta_description` (string|null): SEO meta description (max 500 chars)
- `status` (string): Publication status ('draft' or 'published')
- `created_at` (DateTime): Creation timestamp
- `updated_at` (DateTime): Last update timestamp

#### Relationships

- `overview`: CountryOverview object or array
- `regulatory_frameworks`: Array of RegulatoryFramework objects
- `documentation_cards`: Array of DocumentationCard objects

#### Methods

##### `validate(): ValidationResult`

Validates all fields according to requirements:
- Required fields: `country_name`, `country_code`
- Field length limits (hero_title ≤ 100 chars, hero_description ≤ 500 chars, etc.)
- Valid status values ('draft' or 'published')

Returns a `ValidationResult` object with validation status and error messages.

##### `toArray(): array`

Converts the Country model to an associative array suitable for JSON serialization or database storage.

##### `fromArray(array $data): Country` (static)

Creates a Country model instance from an associative array. Handles type conversion for timestamps and optional fields.

#### Usage Example

```php
require_once 'models/Country.php';

// Create a new country
$country = new Country();
$country->country_name = "Australia";
$country->country_code = "AU";
$country->hero_title = "Transfer Pricing Australia";
$country->hero_description = "Master the Australian Taxation Office requirements";
$country->status = "published";

// Validate
$result = $country->validate();
if ($result->is_valid) {
    echo "Country is valid!";
} else {
    foreach ($result->errors as $field => $error) {
        echo "$field: $error\n";
    }
}

// Convert to array
$data = $country->toArray();

// Create from array
$restored = Country::fromArray($data);
```

### ValidationResult Model (`ValidationResult.php`)

The `ValidationResult` model represents the result of a validation operation.

#### Properties

- `is_valid` (bool): Whether validation passed
- `errors` (array): Associative array of field errors ['field_name' => 'error message']
- `warnings` (array): Associative array of field warnings ['field_name' => 'warning message']

#### Methods

##### `addError(string $field, string $message): void`

Adds an error for a specific field and sets `is_valid` to false.

##### `addWarning(string $field, string $message): void`

Adds a warning for a specific field (does not affect `is_valid`).

##### `hasErrors(): bool`

Returns true if there are any validation errors.

##### `getErrorMessages(): array`

Returns all error messages as a simple array (without field names).

## Testing

Unit tests are provided in `Country.test.php`. To run the tests:

```bash
php models/Country.test.php
```

The test suite covers:
- Validation of required fields
- Field length validations (hero_title, hero_description, etc.)
- Status validation
- Optional field handling
- Serialization (toArray)
- Deserialization (fromArray)
- Round-trip conversion

## Requirements Mapping

This implementation satisfies the following requirements:

- **Requirement 1.1**: Database schema for countries table with all specified fields
- **Requirement 11.1**: Validation that hero_title does not exceed 100 characters
- **Requirement 11.2**: Validation that hero_description does not exceed 500 characters
- **Requirement 11.3**: Validation for required fields
- **Requirement 11.4**: Field length validation for all fields
- **Requirement 11.5**: Character counter support (via validation error messages)

## Design Document Reference

See `.kiro/specs/country-content-cms/design.md` for the complete data model specifications and architecture details.
