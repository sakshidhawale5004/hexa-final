# Requirements Document

## Introduction

The Country Content Management System (CMS) is a feature that enables HexaTP administrators to manage country-specific transfer pricing law content through a web-based admin interface. Currently, all country law sections are hardcoded in static HTML files (australia.html, bahrain.html, egypt.html, etc.), requiring direct HTML editing to update content. This CMS will transform the static content into database-driven dynamic content, allowing non-technical users to edit, update, and manage law sections without touching code.

The system will support three main content types per country: Overview sections, Key Regulatory Framework boxes, and Documentation/Mandatory Documentation expandable cards. The CMS will integrate with the existing HexaTP database (hexatp_db) and admin panel infrastructure (admin_consultations.php) while preserving the current page design and user experience.

## Glossary

- **CMS**: Content Management System - the administrative interface for managing country content
- **Admin_Panel**: The web-based interface where administrators manage content
- **Country_Page**: Individual HTML pages displaying transfer pricing laws for specific countries (e.g., australia.html, egypt.html)
- **Overview_Section**: The introductory text section describing general transfer pricing information for a country
- **Regulatory_Framework_Box**: One of three boxes displaying key regulations with title and description
- **Documentation_Card**: Expandable card containing title, short description, and detailed content
- **Database**: The MySQL database (hexatp_db) storing all country content
- **WYSIWYG_Editor**: What You See Is What You Get editor for rich text content editing
- **API_Endpoint**: Backend PHP script that handles data operations (save, retrieve, update, delete)
- **Dynamic_Content**: Content loaded from database rather than hardcoded in HTML
- **Authentication**: The process of verifying administrator identity before allowing CMS access

## Requirements

### Requirement 1: Database Schema for Country Content Storage

**User Story:** As a system administrator, I want a structured database schema to store country content, so that all law sections can be managed dynamically.

#### Acceptance Criteria

1. THE Database SHALL contain a table named "countries" with columns: id (INT, PRIMARY KEY, AUTO_INCREMENT), country_name (VARCHAR 100, UNIQUE), country_code (VARCHAR 10), flag_url (VARCHAR 255), hero_title (VARCHAR 255), hero_description (TEXT), created_at (TIMESTAMP), updated_at (TIMESTAMP)

2. THE Database SHALL contain a table named "country_overview" with columns: id (INT, PRIMARY KEY, AUTO_INCREMENT), country_id (INT, FOREIGN KEY), overview_text_left (TEXT), overview_text_right (TEXT), created_at (TIMESTAMP), updated_at (TIMESTAMP)

3. THE Database SHALL contain a table named "regulatory_frameworks" with columns: id (INT, PRIMARY KEY, AUTO_INCREMENT), country_id (INT, FOREIGN KEY), title (VARCHAR 255), description (TEXT), display_order (INT), created_at (TIMESTAMP), updated_at (TIMESTAMP)

4. THE Database SHALL contain a table named "documentation_cards" with columns: id (INT, PRIMARY KEY, AUTO_INCREMENT), country_id (INT, FOREIGN KEY), title (VARCHAR 255), short_description (TEXT), detailed_content (LONGTEXT), display_order (INT), created_at (TIMESTAMP), updated_at (TIMESTAMP)

5. THE Database SHALL enforce referential integrity through foreign key constraints linking all content tables to the countries table

6. THE Database SHALL support UTF-8 character encoding for all text fields to handle international characters

### Requirement 2: Admin Interface for Content Management

**User Story:** As a content administrator, I want a user-friendly admin interface, so that I can edit country content without technical knowledge.

#### Acceptance Criteria

1. THE Admin_Panel SHALL display a navigation menu with links to "Countries List", "Add New Country", and "Manage Content"

2. WHEN an administrator accesses the countries list page, THE Admin_Panel SHALL display all countries in a table with columns: country name, country code, last updated date, and action buttons (Edit, View, Delete)

3. WHEN an administrator clicks "Edit" on a country, THE Admin_Panel SHALL load a content management form with sections for: Hero Section, Overview, Regulatory Frameworks (3 boxes), and Documentation Cards

4. THE Admin_Panel SHALL provide a WYSIWYG_Editor for all text fields that support rich formatting (bold, italic, lists, links)

5. WHEN editing Regulatory Framework boxes, THE Admin_Panel SHALL display exactly 3 editable boxes with fields for title and description

6. WHEN editing Documentation Cards, THE Admin_Panel SHALL allow administrators to add, edit, reorder, and delete cards with fields for title, short description, and detailed content

7. THE Admin_Panel SHALL provide a "Preview" button that displays content as it will appear on the country page before saving

8. THE Admin_Panel SHALL provide "Save Draft" and "Publish" buttons where drafts are not visible on public pages

9. WHEN an administrator saves changes, THE Admin_Panel SHALL display a success confirmation message with timestamp

10. THE Admin_Panel SHALL match the existing admin_consultations.php design aesthetic (dark theme, glass-card styling, accent colors)

### Requirement 3: API Endpoints for Data Operations

**User Story:** As a developer, I want RESTful API endpoints, so that the admin interface can communicate with the database securely.

#### Acceptance Criteria

1. THE API_Endpoint SHALL provide a GET endpoint "/api/countries.php" that returns all countries in JSON format

2. THE API_Endpoint SHALL provide a GET endpoint "/api/country.php?id={country_id}" that returns complete content for a specific country including overview, regulatory frameworks, and documentation cards

3. THE API_Endpoint SHALL provide a POST endpoint "/api/country.php" that creates a new country record and returns the created country ID

4. THE API_Endpoint SHALL provide a PUT endpoint "/api/country.php?id={country_id}" that updates existing country content and returns success status

5. THE API_Endpoint SHALL provide a DELETE endpoint "/api/country.php?id={country_id}" that removes a country and all associated content

6. WHEN invalid data is submitted, THE API_Endpoint SHALL return HTTP 400 status with descriptive error messages in JSON format

7. WHEN database operations fail, THE API_Endpoint SHALL return HTTP 500 status with error details logged server-side

8. THE API_Endpoint SHALL validate all input data for SQL injection prevention using prepared statements

9. THE API_Endpoint SHALL validate required fields and return specific error messages for missing data

10. THE API_Endpoint SHALL set appropriate CORS headers to allow requests from the admin panel domain

### Requirement 4: Dynamic Content Loading on Country Pages

**User Story:** As a website visitor, I want to see up-to-date country information, so that I have access to current transfer pricing regulations.

#### Acceptance Criteria

1. WHEN a Country_Page loads, THE Country_Page SHALL fetch content from the database via AJAX request to the API endpoint

2. THE Country_Page SHALL display a loading indicator while content is being fetched from the database

3. WHEN content is successfully loaded, THE Country_Page SHALL populate the hero section with hero_title and hero_description from the database

4. THE Country_Page SHALL populate the overview section with overview_text_left and overview_text_right in a two-column layout

5. THE Country_Page SHALL render exactly 3 Regulatory_Framework_Boxes with titles and descriptions in the order specified by display_order

6. THE Country_Page SHALL render Documentation_Cards as expandable elements with titles, short descriptions, and collapsible detailed content

7. THE Country_Page SHALL maintain all existing CSS styling, animations, and interactive behaviors (expand/collapse functionality)

8. WHEN content fails to load, THE Country_Page SHALL display a user-friendly error message and fallback content

9. THE Country_Page SHALL preserve the existing page structure including header, navigation, footer, and consultation booking modal

10. THE Country_Page SHALL load content within 2 seconds on standard broadband connections (measured at 50th percentile)

### Requirement 5: Authentication and Authorization

**User Story:** As a system administrator, I want secure access controls, so that only authorized users can edit country content.

#### Acceptance Criteria

1. THE Admin_Panel SHALL require username and password authentication before displaying any content management features

2. WHEN an unauthenticated user attempts to access admin pages, THE Admin_Panel SHALL redirect to a login page

3. THE Admin_Panel SHALL store passwords using bcrypt hashing with a minimum cost factor of 10

4. WHEN a user enters correct credentials, THE Admin_Panel SHALL create a secure session with a timeout of 30 minutes of inactivity

5. THE Admin_Panel SHALL provide a "Logout" button that destroys the session and redirects to the login page

6. THE API_Endpoint SHALL verify session authentication before processing any POST, PUT, or DELETE requests

7. WHEN an unauthenticated API request is received, THE API_Endpoint SHALL return HTTP 401 status with an authentication required message

8. THE Admin_Panel SHALL implement CSRF token protection for all form submissions

9. THE Admin_Panel SHALL log all content modification actions with username, timestamp, and action type to an audit table

10. THE Admin_Panel SHALL support role-based access where "admin" role has full access and "editor" role can only edit existing content

### Requirement 6: Content Migration from Static HTML

**User Story:** As a system administrator, I want existing country content migrated to the database, so that no content is lost during the transition.

#### Acceptance Criteria

1. THE Database SHALL be populated with content from all existing country HTML files (australia.html, bahrain.html, egypt.html, India.html, UAE, etc.)

2. WHEN the migration script runs, THE Database SHALL extract hero titles and descriptions from each country HTML file

3. THE Database SHALL extract overview section text (left and right columns) from each country HTML file

4. THE Database SHALL extract all 3 regulatory framework boxes (titles and descriptions) from each country HTML file

5. THE Database SHALL extract all documentation cards (titles, short descriptions, detailed content) from each country HTML file

6. THE Database SHALL preserve HTML formatting (bold, italic, lists, links) during content extraction

7. THE Database SHALL assign appropriate display_order values to maintain the original content sequence

8. WHEN migration is complete, THE Database SHALL contain records for all countries currently represented in the website

9. THE Database SHALL log any migration errors or warnings to a migration_log table with details of failed extractions

10. THE Database SHALL provide a rollback mechanism to restore original HTML files if migration validation fails

### Requirement 7: Content Versioning and Revision History

**User Story:** As a content administrator, I want to track content changes over time, so that I can review edit history and restore previous versions if needed.

#### Acceptance Criteria

1. THE Database SHALL contain a table named "content_revisions" with columns: id (INT, PRIMARY KEY, AUTO_INCREMENT), country_id (INT), content_type (ENUM), content_id (INT), field_name (VARCHAR 100), old_value (LONGTEXT), new_value (LONGTEXT), changed_by (VARCHAR 100), changed_at (TIMESTAMP)

2. WHEN any country content is updated, THE Database SHALL automatically create a revision record capturing the previous value

3. THE Admin_Panel SHALL provide a "Revision History" button for each country that displays all changes in chronological order

4. WHEN viewing revision history, THE Admin_Panel SHALL display: date/time of change, username, field changed, and a diff view showing old vs new values

5. THE Admin_Panel SHALL provide a "Restore" button for each revision that reverts content to that previous state

6. WHEN a revision is restored, THE Database SHALL create a new revision record documenting the restoration action

7. THE Database SHALL retain revision history for a minimum of 12 months before archival

8. THE Admin_Panel SHALL allow administrators to compare any two revisions side-by-side

9. THE Database SHALL index revision records by country_id and changed_at for efficient history queries

10. THE Admin_Panel SHALL display the username and timestamp of the last edit on the content management form

### Requirement 8: Bulk Operations and Content Export

**User Story:** As a content administrator, I want to perform bulk operations on country content, so that I can efficiently manage multiple countries.

#### Acceptance Criteria

1. THE Admin_Panel SHALL provide a "Bulk Edit" feature that allows selecting multiple countries via checkboxes

2. WHEN countries are selected for bulk edit, THE Admin_Panel SHALL provide options to: update status (published/draft), export content, or delete

3. THE Admin_Panel SHALL provide an "Export" button that generates a JSON file containing all content for selected countries

4. THE Admin_Panel SHALL provide an "Import" button that accepts JSON files and creates or updates country content

5. WHEN importing content, THE Admin_Panel SHALL validate JSON structure and display detailed error messages for invalid formats

6. THE Admin_Panel SHALL provide a "Duplicate Country" feature that copies all content from one country to create a template for a new country

7. WHEN duplicating a country, THE Admin_Panel SHALL prompt for the new country name and code before creating the duplicate

8. THE Admin_Panel SHALL provide a "Search" feature that filters countries by name, code, or content keywords

9. THE Admin_Panel SHALL provide sorting options for the countries list (alphabetical, last updated, creation date)

10. THE Admin_Panel SHALL display a count of total countries, published countries, and draft countries in the dashboard

### Requirement 9: Responsive Design and Mobile Support

**User Story:** As a content administrator, I want the admin panel to work on mobile devices, so that I can make urgent content updates from anywhere.

#### Acceptance Criteria

1. THE Admin_Panel SHALL be fully functional on devices with screen widths from 320px to 2560px

2. WHEN accessed on mobile devices (screen width < 768px), THE Admin_Panel SHALL display a responsive navigation menu with hamburger icon

3. THE Admin_Panel SHALL stack form fields vertically on mobile devices for optimal touch interaction

4. THE WYSIWYG_Editor SHALL provide a mobile-optimized toolbar with essential formatting options on small screens

5. THE Admin_Panel SHALL use touch-friendly buttons with minimum tap target size of 44x44 pixels

6. WHEN viewing the countries list on mobile, THE Admin_Panel SHALL display a card-based layout instead of a table

7. THE Admin_Panel SHALL support pinch-to-zoom for detailed content review on mobile devices

8. THE Admin_Panel SHALL maintain consistent functionality across Chrome, Safari, Firefox, and Edge browsers on mobile

9. THE Admin_Panel SHALL load within 3 seconds on 4G mobile connections

10. THE Admin_Panel SHALL preserve form data when switching between portrait and landscape orientations

### Requirement 10: Performance Optimization and Caching

**User Story:** As a website visitor, I want country pages to load quickly, so that I have a smooth browsing experience.

#### Acceptance Criteria

1. THE Country_Page SHALL implement browser caching with a cache lifetime of 1 hour for country content

2. THE API_Endpoint SHALL implement server-side caching using Redis or Memcached with a 15-minute TTL

3. WHEN content is updated in the admin panel, THE API_Endpoint SHALL invalidate the cache for the affected country

4. THE Country_Page SHALL lazy-load documentation card detailed content only when cards are expanded

5. THE Database SHALL use indexed queries on country_id and display_order fields for optimal query performance

6. THE API_Endpoint SHALL compress JSON responses using gzip compression

7. THE Country_Page SHALL prefetch content for the next likely country page based on navigation patterns

8. THE Database SHALL implement connection pooling to reduce database connection overhead

9. WHEN multiple countries are requested, THE API_Endpoint SHALL support batch requests to reduce HTTP overhead

10. THE Country_Page SHALL achieve a Lighthouse performance score of 90+ on desktop and 80+ on mobile

### Requirement 11: Content Validation and Quality Assurance

**User Story:** As a content administrator, I want content validation rules, so that published content meets quality standards.

#### Acceptance Criteria

1. THE Admin_Panel SHALL validate that hero_title does not exceed 100 characters

2. THE Admin_Panel SHALL validate that hero_description does not exceed 500 characters

3. THE Admin_Panel SHALL require at least one overview paragraph (left or right) before allowing publication

4. THE Admin_Panel SHALL validate that all 3 regulatory framework boxes have both title and description before publication

5. THE Admin_Panel SHALL validate that documentation card titles do not exceed 150 characters

6. THE Admin_Panel SHALL check for broken links in rich text content and display warnings

7. THE Admin_Panel SHALL validate that HTML content does not contain potentially dangerous scripts or iframes

8. THE Admin_Panel SHALL provide a character counter for all text fields with length limits

9. WHEN validation fails, THE Admin_Panel SHALL highlight invalid fields in red and display specific error messages

10. THE Admin_Panel SHALL allow saving drafts with validation warnings but prevent publishing until all errors are resolved

### Requirement 12: Search Engine Optimization (SEO) Support

**User Story:** As a marketing manager, I want SEO-friendly country pages, so that our content ranks well in search engines.

#### Acceptance Criteria

1. THE Database SHALL include fields for meta_title (VARCHAR 255) and meta_description (VARCHAR 500) in the countries table

2. THE Admin_Panel SHALL provide dedicated fields for editing meta_title and meta_description with character count indicators

3. THE Country_Page SHALL dynamically set the page title tag using meta_title from the database

4. THE Country_Page SHALL dynamically set the meta description tag using meta_description from the database

5. THE Country_Page SHALL generate semantic HTML with proper heading hierarchy (h1, h2, h3)

6. THE Country_Page SHALL include structured data markup (JSON-LD) for Organization and Article types

7. THE Country_Page SHALL generate a canonical URL tag to prevent duplicate content issues

8. THE Country_Page SHALL include Open Graph meta tags for social media sharing with country flag image

9. THE Country_Page SHALL generate an XML sitemap including all published country pages with last modified dates

10. THE Country_Page SHALL implement proper URL structure using country codes (e.g., /countries/australia or /australia)

## Parser and Serializer Requirements

### Requirement 13: HTML Content Parser and Pretty Printer

**User Story:** As a developer, I want robust HTML parsing and formatting, so that rich text content is consistently handled throughout the system.

#### Acceptance Criteria

1. WHEN HTML content is submitted through the WYSIWYG_Editor, THE Parser SHALL parse it into a validated HTML structure

2. WHEN invalid HTML is provided, THE Parser SHALL return descriptive error messages indicating the specific syntax issues

3. THE Pretty_Printer SHALL format HTML content with consistent indentation and line breaks for database storage

4. FOR ALL valid HTML content objects, parsing then printing then parsing SHALL produce an equivalent object (round-trip property)

5. THE Parser SHALL sanitize HTML content to remove potentially dangerous elements (script, iframe, object tags)

6. THE Parser SHALL preserve allowed HTML tags (p, strong, em, ul, ol, li, a, h1-h6, br) and strip all others

7. THE Parser SHALL validate that all opening tags have corresponding closing tags

8. THE Parser SHALL normalize whitespace while preserving intentional line breaks and paragraph spacing

9. THE Pretty_Printer SHALL escape special characters (&, <, >, ", ') appropriately for safe database storage

10. THE Parser SHALL handle nested HTML structures up to 10 levels deep without performance degradation
