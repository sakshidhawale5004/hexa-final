-- Migration: Create country_overview table
-- Description: Stores overview text sections for each country (left and right columns)

CREATE TABLE IF NOT EXISTS country_overview (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    overview_text_left TEXT,
    overview_text_right TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    INDEX idx_country_id (country_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
