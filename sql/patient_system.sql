CREATE DATABASE IF NOT EXISTS patient_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE patient_system;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','employee') NOT NULL DEFAULT 'employee',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS referrers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('doctor','asha') NOT NULL,
    name VARCHAR(120) NOT NULL,
    phone VARCHAR(30),
    hospital_clinic VARCHAR(180),
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    age INT NOT NULL,
    gender VARCHAR(10) NOT NULL,
    contact VARCHAR(30) NOT NULL,
    imaging VARCHAR(255),
    referred_by_id INT NULL,
    aadhaar VARCHAR(25),
    fees DECIMAL(10,2) DEFAULT 0,
    discount DECIMAL(10,2) DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_patients_ref FOREIGN KEY (referred_by_id) REFERENCES referrers(id) ON DELETE SET NULL
);

-- demo admin and employee (password: admin123 / emp123)
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@example.com', '$2y$10$1w8Gc6E1vDLteA94ppIqh.YapMI2vlA38nSxrdbidKfnUSsfx8bqO', 'admin'),
('Employee One', 'emp@example.com', '$2y$10$skS8jHG0Wf9eQh9G7Eysue2bXqIuAv89xDSHLVQQP4Jrped1IovnS', 'employee');
