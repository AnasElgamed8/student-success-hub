-- Database: student_success_db
-- Purpose: Store user accounts, semesters, and course grades for GPA tracking.

CREATE DATABASE IF NOT EXISTS student_success_db;
USE student_success_db;

-- 1. USERS TABLE: Stores account information.
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. SEMESTERS TABLE: Each user can have multiple semesters.
CREATE TABLE IF NOT EXISTS semesters (
    semester_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    semester_name VARCHAR(50) NOT NULL, -- e.g., 'Semester 1', 'Fall 2024'
    semester_date VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 3. COURSES TABLE: Each semester has multiple courses.
CREATE TABLE IF NOT EXISTS courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    semester_id INT NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    grade DECIMAL(3,2) NOT NULL, -- Store as 4.0, 3.7, etc.
    credits INT NOT NULL,
    FOREIGN KEY (semester_id) REFERENCES semesters(semester_id) ON DELETE CASCADE
);
