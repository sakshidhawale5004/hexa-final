-- ============================================================================
-- Country Content Management System - Complete Database Setup
-- ============================================================================
-- This script creates all 7 tables required for the CMS
-- Execute this entire script in phpMyAdmin or MySQL client
-- 
-- Tables created (in order):
-- 1. countries - Main country information
-- 2. users - Admin and editor accounts
-- 3. country_overview - Overview text sections
-- 4. regulatory_frameworks - Key regulatory framework boxes
-- 5. documentation_cards - Expandable documentation cards
-- 6. content_revisions - Content change tracking
-- 7. audit_log - Administrative action logging
-- ============================================================================

-- Set character set for the session
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- ============================================================================
-- TABLE 1: countries
-- ============================================================================
-- Description: Main table storing country information and metadata
-- ============================================================================

CREATE TABLE IF NOT EXISTS countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_name VARCHAR(100) NOT NULL UNIQUE,
    country_code VARCHAR(10) NOT NULL,
    flag_url VARCHAR(255),
    hero_title VARCHAR(255),
    hero_description TEXT,
    meta_title VARCHAR(255),
    meta_description VARCHAR(500),
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_country_code (country_code),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 2: users
-- ============================================================================
-- Description: Stores admin and editor user accounts for CMS access
-- ============================================================================

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'editor',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 3: country_overview
-- ============================================================================
-- Description: Stores overview text sections for each country (left and right columns)
-- ============================================================================

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

-- ============================================================================
-- TABLE 4: regulatory_frameworks
-- ============================================================================
-- Description: Stores key regulatory framework boxes for each country (typically 3 per country)
-- ============================================================================

CREATE TABLE IF NOT EXISTS regulatory_frameworks (
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

-- ============================================================================
-- TABLE 5: documentation_cards
-- ============================================================================
-- Description: Stores expandable documentation cards with detailed content for each country
-- ============================================================================

CREATE TABLE IF NOT EXISTS documentation_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    short_description TEXT,
    detailed_content LONGTEXT,
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    INDEX idx_country_display (country_id, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 6: content_revisions
-- ============================================================================
-- Description: Tracks all content changes for audit and rollback purposes
-- ============================================================================

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

-- ============================================================================
-- TABLE 7: audit_log
-- ============================================================================
-- Description: Logs all administrative actions for security and compliance tracking
-- ============================================================================

CREATE TABLE IF NOT EXISTS audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    entity_type VARCHAR(50) NOT NULL,
    entity_id INT,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_date (user_id, created_at),
    INDEX idx_entity (entity_type, entity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- VERIFICATION QUERIES
-- ============================================================================
-- Uncomment these to verify tables were created successfully
-- ============================================================================

-- SHOW TABLES;
-- DESCRIBE countries;
-- DESCRIBE users;
-- DESCRIBE country_overview;
-- DESCRIBE regulatory_frameworks;
-- DESCRIBE documentation_cards;
-- DESCRIBE content_revisions;
-- DESCRIBE audit_log;

-- ============================================================================
-- SUCCESS MESSAGE
-- ============================================================================
SELECT 'All 7 tables created successfully!' AS Status;
