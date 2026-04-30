-- Migration: Create content_revisions table
-- Description: Tracks all content changes for audit and rollback purposes

CREATE TABLE IF NOT EXISTS content_revisions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    content_type ENUM('country', 'overview', 'regulatory_framework', 'documentation_card') NOT NULL,
    content_id INT NOT NULL,
    field_name VARCHAR(100) NOT NULL,
    old_value LONGTEXT,
    new_value LONGTEXT,
    changed_by INT NOT NULL,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    FOREIGN KEY (changed_by) REFERENCES users(id),
    INDEX idx_country_date (country_id, changed_at),
    INDEX idx_content (content_type, content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
