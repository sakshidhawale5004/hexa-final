# Implementation Plan: Country Content Management System

## Overview

This implementation plan transforms the HexaTP website from static HTML country pages to a dynamic, database-driven Content Management System. The implementation follows a phased approach: database setup, content migration, backend API development, admin panel creation, frontend dynamic loading, security implementation, and comprehensive testing.

**Technology Stack**: PHP 7.4+, MySQL 8.0+, JavaScript (ES6+), Bootstrap 5.3.2, TinyMCE, Redis

**Key Implementation Areas**:
- Database schema with 7 tables
- Content migration from 15+ static HTML files
- RESTful API with 5 endpoint groups
- Admin panel with WYSIWYG editor
- Dynamic content loading on public pages
- Authentication and authorization system
- Property-based testing for HTML parser

## Tasks

- [x] 1. Set up database schema and migrations
  - Create migration scripts for all 7 tables (countries, country_overview, regulatory_frameworks, documentation_cards, content_revisions, users, audit_log)
  - Add indexes and foreign key constraints
  - Create migration runner script (migrations/migrate.php)
  - Test migrations on clean database
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 1.6_

- [ ]* 1.1 Write unit tests for migration scripts
  - Test table creation with correct schema
  - Test foreign key constraints
  - Test index creation
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5_

- [ ] 2. Create PHP data models and validation
  - [x] 2.1 Implement Country model with validation
    - Create models/Country.php with all properties
    - Implement validate() method checking field lengths and required fields
    - Implement toArray() and fromArray() methods
    - _Requirements: 1.1, 11.1, 11.2, 11.3, 11.4, 11.5_
  
  - [x] 2.2 Implement CountryOverview model
    - Create models/CountryOverview.php
    - Implement validation for overview text fields
    - _Requirements: 1.2, 11.3_
  
  - [x] 2.3 Implement RegulatoryFramework model
    - Create models/RegulatoryFramework.php
    - Implement validation for title and description
    - _Requirements: 1.3, 11.4_
  
  - [x] 2.4 Implement DocumentationCard model
    - Create models/DocumentationCard.php
    - Implement validation for title length and content
    - _Requirements: 1.4, 11.5_
  
  - [x] 2.5 Implement ContentRevision and User models
    - Create models/ContentRevision.php and models/User.php
    - Implement User password hashing methods
    - _Requirements: 1.5, 5.3, 7.1, 7.2_
  
  - [x] 2.6 Implement ValidationResult model
    - Create models/ValidationResult.php
    - Implement error and warning collection methods
    - _Requirements: 11.9_

- [ ]* 2.7 Write unit tests for model validation
  - Test Country validation (hero_title length, required fields)
  - Test DocumentationCard title length validation
  - Test User password hashing and verification
  - _Requirements: 11.1, 11.2, 11.3, 11.4, 11.5_

- [ ] 3. Implement HTML Parser Service with property-based testing
  - [x] 3.1 Create HTMLParserService class
    - Create services/HTMLParserService.php
    - Implement parse() method using DOMDocument
    - Implement sanitize() method to remove dangerous tags
    - Implement prettyPrint() method for formatted output
    - Implement validate() method for HTML validation
    - _Requirements: 13.1, 13.2, 13.5, 13.6, 13.7, 13.9_
  
  - [x] 3.2 Create ParsedHTML data structure
    - Create models/ParsedHTML.php
    - Implement tag filtering and whitespace normalization
    - _Requirements: 13.3, 13.8, 13.10_
  
  - [ ]* 3.3 Write property test for valid HTML parsing success
    - **Property 1: Valid HTML parsing success**
    - **Validates: Requirements 13.1**
    - Generate random valid HTML with allowed tags
    - Assert parse(html)->isValid() === true
    - Tag: @group Feature: country-content-cms, Property 1: Valid HTML parsing success
  
  - [ ]* 3.4 Write property test for invalid HTML error reporting
    - **Property 2: Invalid HTML error reporting**
    - **Validates: Requirements 13.2, 13.7**
    - Generate invalid HTML with known defects
    - Assert parse(html)->isValid() === false and errors are descriptive
    - Tag: @group Feature: country-content-cms, Property 2: Invalid HTML error reporting
  
  - [ ]* 3.5 Write property test for round-trip preservation (CRITICAL)
    - **Property 3: Round-trip preservation**
    - **Validates: Requirements 13.4, 13.3, 13.9**
    - Generate random valid HTML
    - Assert parse(prettyPrint(parse(html))) ≡ parse(html)
    - Tag: @group Feature: country-content-cms, Property 3: Round-trip preservation
  
  - [ ]* 3.6 Write property test for tag filtering and sanitization
    - **Property 4: Tag filtering and sanitization**
    - **Validates: Requirements 13.5, 13.6**
    - Generate HTML with mixed allowed and dangerous tags
    - Assert output contains only allowed tags, zero dangerous tags
    - Tag: @group Feature: country-content-cms, Property 4: Tag filtering and sanitization
  
  - [ ]* 3.7 Write property test for whitespace normalization
    - **Property 5: Whitespace normalization with preservation**
    - **Validates: Requirements 13.8**
    - Generate HTML with excessive whitespace
    - Assert whitespace normalized while preserving intentional breaks
    - Tag: @group Feature: country-content-cms, Property 5: Whitespace normalization
  
  - [ ]* 3.8 Write property test for deep nesting performance
    - **Property 6: Deep nesting performance**
    - **Validates: Requirements 13.10**
    - Generate HTML with nesting depths 1-10
    - Assert parsing completes in <100ms for all depths
    - Tag: @group Feature: country-content-cms, Property 6: Deep nesting performance

- [ ] 4. Create database repository layer
  - [x] 4.1 Implement CountryRepository
    - Create repositories/CountryRepository.php
    - Implement CRUD methods using prepared statements
    - Implement getCountryWithRelations() with optimized JOIN query
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 3.8_
  
  - [x] 4.2 Implement UserRepository and RevisionRepository
    - Create repositories/UserRepository.php
    - Create repositories/RevisionRepository.php
    - Implement query methods with proper indexing
    - _Requirements: 5.1, 5.2, 7.1, 7.2, 7.9_
  
  - [ ]* 4.3 Write integration tests for repository layer
    - Test CountryRepository CRUD operations against test database
    - Test foreign key constraints and cascade deletes
    - Test transaction rollback on errors
    - _Requirements: 1.5, 3.7_

- [ ] 5. Implement service layer
  - [x] 5.1 Create ContentService
    - Create services/ContentService.php
    - Implement getCountry(), getAllCountries(), createCountry(), updateCountry(), deleteCountry()
    - Implement publishCountry() and duplicateCountry()
    - _Requirements: 2.2, 2.3, 3.1, 3.2, 3.3, 3.4, 3.5, 8.6_
  
  - [x] 5.2 Create ValidationService
    - Create services/ValidationService.php
    - Implement validation methods for all models
    - Implement checkBrokenLinks() for HTML content
    - _Requirements: 11.1, 11.2, 11.3, 11.4, 11.5, 11.6, 11.7, 11.8, 11.9, 11.10_
  
  - [ ] 5.3 Create CacheService
    - Create services/CacheService.php
    - Implement Redis integration with get(), set(), delete()
    - Implement invalidateCountry() method
    - _Requirements: 10.2, 10.3_
  
  - [x] 5.4 Create AuthService
    - Create services/AuthService.php
    - Implement login(), logout(), checkSession(), verifyCsrfToken()
    - Implement rate limiting for login attempts
    - _Requirements: 5.1, 5.2, 5.3, 5.4, 5.5, 5.6, 5.7, 5.8, 5.10_
  
  - [ ]* 5.5 Write unit tests for service layer
    - Test ContentService with mocked repository
    - Test ValidationService business rules
    - Test CacheService cache hit/miss scenarios
    - Test AuthService password hashing and session management
    - _Requirements: 5.3, 5.4, 10.2, 11.9_

- [ ] 6. Checkpoint - Ensure all tests pass
  - Run all unit tests and property tests
  - Verify code coverage ≥ 80%
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 7. Build RESTful API endpoints
  - [x] 7.1 Create Countries API (GET /api/countries.php)
    - Create api/countries.php
    - Implement GET endpoint returning all countries with filtering
    - Support query parameters: status, sort, order
    - Return JSON response with proper error handling
    - _Requirements: 3.1, 3.6, 3.7, 3.10_
  
  - [x] 7.2 Create Country API (GET /api/country.php?id={id})
    - Create api/country.php for single country operations
    - Implement GET endpoint returning complete country data
    - Include overview, regulatory frameworks, and documentation cards
    - Implement caching with 15-minute TTL
    - _Requirements: 3.2, 3.6, 3.7, 3.10, 10.2_
  
  - [x] 7.3 Implement Country CREATE endpoint (POST /api/country.php)
    - Implement POST endpoint for creating new countries
    - Validate input data using ValidationService
    - Return 201 Created with new country ID
    - _Requirements: 3.3, 3.6, 3.8, 3.9_
  
  - [x] 7.4 Implement Country UPDATE endpoint (PUT /api/country.php?id={id})
    - Implement PUT endpoint for updating countries
    - Create revision records before updating
    - Invalidate cache after successful update
    - _Requirements: 3.4, 3.6, 3.8, 7.2, 10.3_
  
  - [x] 7.5 Implement Country DELETE endpoint (DELETE /api/country.php?id={id})
    - Implement DELETE endpoint with cascade delete
    - Verify admin role before allowing deletion
    - Invalidate cache after deletion
    - _Requirements: 3.5, 3.6, 3.7, 5.10_
  
  - [x] 7.6 Create Authentication API (POST /api/auth.php)
    - Create api/auth.php
    - Implement login action with session creation
    - Implement logout action with session destruction
    - Return proper error codes (401, 403)
    - _Requirements: 5.1, 5.2, 5.4, 5.5, 5.6, 5.7_
  
  - [ ] 7.7 Create Revisions API (GET /api/revisions.php)
    - Create api/revisions.php
    - Implement GET endpoint for revision history
    - Implement POST endpoint for restoring revisions
    - Support pagination with limit and offset
    - _Requirements: 7.3, 7.4, 7.5, 7.6, 7.8_
  
  - [ ] 7.8 Create Bulk Operations API (POST /api/bulk.php)
    - Create api/bulk.php
    - Implement bulk status update
    - Implement bulk export to JSON
    - Implement bulk delete with confirmation
    - _Requirements: 8.2, 8.3, 8.4_
  
  - [ ]* 7.9 Write integration tests for API endpoints
    - Test GET /api/countries.php returns correct JSON
    - Test POST /api/country.php creates database record
    - Test PUT /api/country.php updates and invalidates cache
    - Test DELETE /api/country.php cascades properly
    - Test authentication on protected endpoints
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 5.6, 5.7, 10.3_

- [ ] 8. Implement content migration from static HTML
  - [ ] 8.1 Create ContentMigrator class
    - Create services/MigrationService.php
    - Implement migrateCountryFile() method
    - Implement extraction methods for hero, overview, frameworks, cards
    - Use DOMDocument and XPath for HTML parsing
    - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5, 6.6, 6.7_
  
  - [ ] 8.2 Create migration runner script
    - Create scripts/migrate_content.php
    - Scan all country HTML files in public directory
    - Migrate each file and log results
    - Create backup of original HTML files
    - _Requirements: 6.1, 6.8, 6.9, 6.10_
  
  - [ ] 8.3 Run migration and validate results
    - Execute migration script on all country files
    - Verify all countries migrated successfully
    - Verify all regulatory frameworks have 3 entries per country
    - Verify HTML formatting preserved
    - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5, 6.6, 6.7, 6.8_
  
  - [ ]* 8.4 Write integration tests for migration
    - Test extraction of hero section from sample HTML
    - Test extraction of regulatory frameworks
    - Test extraction of documentation cards
    - Test HTML formatting preservation
    - _Requirements: 6.2, 6.3, 6.4, 6.5, 6.6_

- [ ] 9. Checkpoint - Verify migration and API functionality
  - Verify all countries migrated to database
  - Test API endpoints manually with Postman or curl
  - Verify cache invalidation works correctly
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 10. Build admin panel UI
  - [x] 10.1 Create admin login page
    - Create admin/login.php
    - Implement login form with CSRF protection
    - Style with dark theme matching admin_consultations.php
    - Implement client-side validation
    - _Requirements: 5.1, 5.2, 5.8, 9.1, 9.2_
  
  - [x] 10.2 Create admin dashboard
    - Create admin/dashboard.php
    - Display navigation menu (Countries List, Add New Country, Manage Content)
    - Display count of total, published, and draft countries
    - Implement session check and redirect if not authenticated
    - _Requirements: 2.1, 5.2, 5.4, 8.10_
  
  - [x] 10.3 Create countries list page
    - Create admin/countries_list.php
    - Display countries in sortable table with DataTables
    - Implement search and filter functionality
    - Add action buttons (Edit, View, Delete)
    - Implement bulk selection checkboxes
    - _Requirements: 2.2, 8.2, 8.8, 8.9, 9.1, 9.6_
  
  - [x] 10.4 Create country edit form
    - Create admin/country_edit.php
    - Implement form sections: Hero, SEO, Overview, Frameworks, Cards
    - Integrate TinyMCE WYSIWYG editor for rich text fields
    - Implement character counters for limited fields
    - Add Save Draft and Publish buttons
    - _Requirements: 2.3, 2.4, 2.5, 2.6, 2.7, 2.8, 2.9, 2.10, 11.8, 12.2_
  
  - [ ] 10.5 Implement WYSIWYG editor integration
    - Create admin/assets/js/wysiwyg-init.js
    - Configure TinyMCE with allowed tags only
    - Implement paste-as-text by default
    - Add character counter callback
    - _Requirements: 2.4, 13.5, 13.6_
  
  - [ ] 10.6 Create country edit form JavaScript logic
    - Create admin/assets/js/country-editor.js
    - Implement auto-save drafts every 2 minutes
    - Implement preview modal functionality
    - Implement add/remove/reorder documentation cards with SortableJS
    - Implement client-side validation with error highlighting
    - _Requirements: 2.6, 2.7, 2.8, 2.9, 11.9_
  
  - [ ] 10.7 Create revision history viewer
    - Create admin/revisions.php
    - Display revision timeline with date, user, field changed
    - Implement side-by-side diff view using diff-match-patch
    - Add restore button for each revision
    - _Requirements: 7.3, 7.4, 7.5, 7.8_
  
  - [ ] 10.8 Style admin panel with dark theme
    - Create admin/assets/css/admin.css
    - Match existing admin_consultations.php aesthetic
    - Implement glass-card styling
    - Ensure responsive design for mobile devices
    - _Requirements: 2.10, 9.1, 9.2, 9.3, 9.4, 9.5, 9.6_

- [ ] 11. Implement dynamic content loading on public pages
  - [ ] 11.1 Create DynamicContentLoader JavaScript class
    - Create public/js/country-loader.js
    - Implement loadContent() method with AJAX fetch
    - Implement browser caching with 1-hour TTL
    - Implement loading spinner and error handling
    - _Requirements: 4.1, 4.2, 4.8, 10.1_
  
  - [ ] 11.2 Modify country HTML pages for dynamic loading
    - Update australia.html, egypt.html, etc. to use DynamicContentLoader
    - Add loading indicators
    - Preserve existing CSS styling and page structure
    - _Requirements: 4.1, 4.3, 4.4, 4.5, 4.7, 4.9_
  
  - [ ] 11.3 Implement ExpandableDocumentationCard component
    - Add expandable card logic to country-loader.js
    - Implement lazy loading of detailed content on first expand
    - Implement smooth expand/collapse animations
    - Maintain state in URL hash for deep linking
    - _Requirements: 4.6, 4.7, 10.4_
  
  - [ ]* 11.4 Write E2E tests for dynamic content loading
    - Test country page loads content from API
    - Test loading indicator displays during fetch
    - Test error handling when API fails
    - Test documentation card expand/collapse
    - _Requirements: 4.1, 4.2, 4.6, 4.8_

- [ ] 12. Implement SEO features
  - [ ] 12.1 Add SEO meta tags to country pages
    - Dynamically set page title from meta_title
    - Dynamically set meta description from meta_description
    - Add Open Graph tags for social sharing
    - Add canonical URL tag
    - _Requirements: 12.3, 12.4, 12.7, 12.8_
  
  - [ ] 12.2 Generate structured data markup
    - Add JSON-LD for Organization and Article types
    - Include country-specific data in structured format
    - _Requirements: 12.6_
  
  - [ ] 12.3 Generate XML sitemap
    - Create scripts/generate_sitemap.php
    - Include all published country pages
    - Include last modified dates from database
    - _Requirements: 12.9_
  
  - [ ]* 12.4 Write unit tests for SEO features
    - Test meta tag generation
    - Test structured data format
    - Test sitemap generation
    - _Requirements: 12.3, 12.4, 12.6, 12.9_

- [ ] 13. Implement security features
  - [ ] 13.1 Add CSRF protection to all forms
    - Generate CSRF tokens in session
    - Add hidden CSRF token fields to all forms
    - Verify tokens in AuthService
    - _Requirements: 5.8_
  
  - [ ] 13.2 Implement rate limiting for login
    - Track failed login attempts by IP and username
    - Lock out after 5 failed attempts for 15 minutes
    - Log security events
    - _Requirements: 5.9_
  
  - [ ] 13.3 Add security headers
    - Set X-Frame-Options, X-Content-Type-Options, X-XSS-Protection
    - Set Content-Security-Policy
    - Set Referrer-Policy
    - _Requirements: 3.8, 11.7_
  
  - [ ] 13.4 Implement audit logging
    - Create services/AuditService.php
    - Log all content modifications to audit_log table
    - Include user ID, action, entity type, IP address
    - _Requirements: 5.9_
  
  - [ ]* 13.5 Write integration tests for security features
    - Test CSRF token validation
    - Test rate limiting blocks after 5 attempts
    - Test audit log entries created on updates
    - _Requirements: 5.8, 5.9_

- [ ] 14. Implement configuration and utilities
  - [ ] 14.1 Create configuration file
    - Create includes/config.php
    - Define all constants (database, Redis, session, security, validation)
    - Set error reporting based on environment
    - _Requirements: 1.6, 5.3, 5.4, 10.2, 11.1, 11.2, 11.3, 11.4, 11.5_
  
  - [x] 14.2 Create utility scripts
    - Create scripts/create_admin_user.php for initial admin setup
    - Create scripts/clear_cache.php for cache management
    - _Requirements: 5.1, 10.2_
  
  - [ ] 14.3 Create database connection helper
    - Update includes/db_config.php if needed
    - Implement connection pooling
    - _Requirements: 1.1, 10.8_

- [ ] 15. Checkpoint - Integration testing and bug fixes
  - Run all integration tests
  - Test complete user workflows (login, create country, edit, publish)
  - Test cache invalidation across all operations
  - Fix any bugs discovered during testing
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 16. Performance optimization
  - [ ] 16.1 Optimize database queries
    - Review and optimize JOIN queries in CountryRepository
    - Ensure all indexes are properly used
    - Test query performance with EXPLAIN
    - _Requirements: 10.5, 10.8_
  
  - [ ] 16.2 Implement lazy loading for documentation cards
    - Modify API to support fetching single card details
    - Update ExpandableDocumentationCard to lazy load
    - _Requirements: 10.4_
  
  - [ ] 16.3 Add compression and minification
    - Implement gzip compression for API responses
    - Minify CSS and JavaScript files
    - _Requirements: 10.6_
  
  - [ ]* 16.4 Run performance tests
    - Measure API response times (target <500ms p95)
    - Measure page load times (target <2s p95)
    - Test with large content (10,000+ character fields)
    - Run Lighthouse performance audit (target 90+ desktop, 80+ mobile)
    - _Requirements: 4.10, 9.9, 10.10_

- [ ] 17. Responsive design and mobile support
  - [ ] 17.1 Implement responsive admin panel
    - Add mobile navigation with hamburger menu
    - Stack form fields vertically on mobile
    - Use card-based layout for countries list on mobile
    - Ensure touch-friendly buttons (44x44px minimum)
    - _Requirements: 9.1, 9.2, 9.3, 9.5, 9.6_
  
  - [ ] 17.2 Optimize WYSIWYG editor for mobile
    - Configure TinyMCE with mobile-optimized toolbar
    - Test on iOS Safari and Chrome Mobile
    - _Requirements: 9.4, 9.8_
  
  - [ ]* 17.3 Test responsive design
    - Test on screen widths 320px to 2560px
    - Test on Chrome, Safari, Firefox, Edge (desktop and mobile)
    - Test form data preservation on orientation change
    - _Requirements: 9.1, 9.7, 9.8, 9.10_

- [ ] 18. Bulk operations and content export
  - [ ] 18.1 Implement bulk edit UI
    - Add bulk selection checkboxes to countries list
    - Add bulk action dropdown (Update Status, Export, Delete)
    - Implement confirmation dialogs for destructive actions
    - _Requirements: 8.1, 8.2_
  
  - [ ] 18.2 Implement import/export functionality
    - Implement JSON export for selected countries
    - Implement JSON import with validation
    - Provide helpful error messages for invalid JSON
    - _Requirements: 8.3, 8.4, 8.5_
  
  - [ ] 18.3 Implement duplicate country feature
    - Add "Duplicate" button to country edit page
    - Prompt for new country name and code
    - Copy all content to new country record
    - _Requirements: 8.6, 8.7_
  
  - [ ]* 18.4 Write integration tests for bulk operations
    - Test bulk status update
    - Test export generates valid JSON
    - Test import validates and creates records
    - Test duplicate country copies all content
    - _Requirements: 8.2, 8.3, 8.4, 8.5, 8.6_

- [ ] 19. Final checkpoint - End-to-end testing
  - [ ]* 19.1 Run complete E2E test suite
    - Test admin login flow
    - Test create country flow
    - Test edit and publish flow
    - Test revision history and restore flow
    - Test bulk operations
    - _Requirements: All requirements_
  
  - [ ] 19.2 Manual testing and QA
    - Test visual design matches existing aesthetic
    - Test keyboard navigation and tab order
    - Test error message clarity
    - Test cross-browser compatibility
    - _Requirements: 2.10, 9.1, 9.8_
  
  - [ ] 19.3 Security audit
    - Review all input validation
    - Review all output encoding
    - Test SQL injection prevention
    - Test XSS prevention
    - Test CSRF protection
    - _Requirements: 3.8, 5.8, 11.7, 13.5, 13.6_

- [ ] 20. Deployment preparation
  - [ ] 20.1 Create deployment checklist
    - Document all deployment steps
    - Create rollback plan
    - Document admin procedures
    - _Requirements: All requirements_
  
  - [ ] 20.2 Set up monitoring and alerts
    - Configure error logging
    - Set up performance monitoring
    - Configure alert thresholds
    - _Requirements: 3.7, 5.9_
  
  - [ ] 20.3 Create admin user and test data
    - Run scripts/create_admin_user.php
    - Verify migration completed successfully
    - Test login with admin credentials
    - _Requirements: 5.1, 6.1, 6.8_
  
  - [ ] 20.4 Final deployment verification
    - Verify all files deployed correctly
    - Verify database migrations ran successfully
    - Verify Redis cache is accessible
    - Verify SSL certificate configured
    - Test all functionality in production environment
    - _Requirements: All requirements_

## Notes

- Tasks marked with `*` are optional testing tasks and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation at key milestones
- Property tests (3.3-3.8) validate universal correctness properties for the HTML Parser
- Unit tests validate specific examples and edge cases
- Integration tests validate database operations and API endpoints
- E2E tests validate complete user workflows
- The implementation follows a bottom-up approach: models → services → repositories → API → UI
- Security is implemented throughout, not as an afterthought
- Performance optimization is done after core functionality is complete
- Deployment preparation includes monitoring, documentation, and verification

## Testing Summary

**Property-Based Tests** (HTML Parser only):
- 6 properties testing parser correctness
- Minimum 100 iterations per property
- Tagged with feature name and property reference

**Unit Tests**:
- Model validation tests
- Service layer tests with mocked dependencies
- Utility function tests
- Target: 80% code coverage

**Integration Tests**:
- Database operations with test database
- API endpoint tests
- Cache integration tests

**End-to-End Tests**:
- Complete user workflows
- Cross-browser compatibility
- Visual regression testing

**Manual Testing**:
- UI/UX validation
- Accessibility testing (WCAG 2.1 AA)
- Performance testing with Lighthouse

