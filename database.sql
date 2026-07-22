-- StudentPulse Database Schema

CREATE DATABASE IF NOT EXISTS studentpulse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE studentpulse;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(120) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Events Table
CREATE TABLE IF NOT EXISTS events (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    venue VARCHAR(150) NOT NULL,
    event_date DATETIME NOT NULL,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX (event_date, status)
) ENGINE=InnoDB;

-- RSVPs Table
CREATE TABLE IF NOT EXISTS rsvps (
    user_id INT UNSIGNED NOT NULL,
    event_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, event_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Default Users
-- admin: admin@studentpulse.test / password
-- student: student@studentpulse.test / password
-- samuel: samuelkangethe825@gmail.com / !Ve*$p1tt@
INSERT INTO users (username, email, password_hash, role) VALUES
('samuel', 'samuelkangethe825@gmail.com', '$2y$10$KBKTWl6u.UF.XdT/NtNBZexhwb5Vqtj7fG8IM0ETlqQExm.q4gTwC', 'admin'),
('admin', 'admin@studentpulse.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'admin'),
('student', 'student@studentpulse.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'student')
ON DUPLICATE KEY UPDATE password_hash=VALUES(password_hash), role=VALUES(role);

-- Sample Events
INSERT INTO events (title, description, category, venue, event_date, status, created_by) VALUES
('Innovation & AI Workshop', 'A practical workshop about responsible AI and campus innovation.', 'Technology', 'Innovation Lab', '2026-08-05 10:00:00', 'published', 1),
('Career Readiness Forum', 'Meet mentors and strengthen your CV, portfolio and interview skills.', 'Career', 'Main Auditorium', '2026-08-12 14:00:00', 'published', 1),
('Inter-Faculty Sports Day', 'Join football, basketball and athletics across faculties.', 'Sports', 'University Grounds', '2026-08-20 08:30:00', 'published', 1);

-- Sample RSVPs and Messages
INSERT IGNORE INTO rsvps (user_id, event_id) VALUES (2, 1);
INSERT INTO contact_messages (user_id, name, email, subject, message) VALUES 
(2, 'Student', 'student@studentpulse.test', 'Event idea', 'Please add a coding competition next month.');