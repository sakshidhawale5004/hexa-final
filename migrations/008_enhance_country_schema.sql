-- ============================================================================
-- CMS Schema Enhancement - Services, CTA, and Footer
-- ============================================================================

-- Add CTA and Footer fields to countries table
ALTER TABLE countries 
ADD COLUMN cta_title VARCHAR(255) AFTER meta_description,
ADD COLUMN cta_button_text VARCHAR(100) AFTER cta_title,
ADD COLUMN footer_title VARCHAR(255) AFTER cta_button_text,
ADD COLUMN footer_email VARCHAR(255) AFTER footer_title;

-- Create table for Country Services (4 boxes per country)
CREATE TABLE IF NOT EXISTS country_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    INDEX idx_country_display (country_id, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Update content_revisions enum to include the new table
ALTER TABLE content_revisions 
MODIFY COLUMN content_type ENUM('country', 'overview', 'regulatory_framework', 'documentation_card', 'country_service') NOT NULL;
