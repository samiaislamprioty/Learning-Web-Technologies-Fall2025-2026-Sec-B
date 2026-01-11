Run with XAMPP/WAMP:

1) Put folder 'med-verify' inside:
   xampp/htdocs/med-verify

2) Create DB + table in phpMyAdmin (SQL):

CREATE DATABASE IF NOT EXISTS med_verify;
USE med_verify;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(60) NOT NULL,
  last_name  VARCHAR(60) NOT NULL,
  email      VARCHAR(120) NOT NULL UNIQUE,
  phone      VARCHAR(20) NOT NULL,
  dob        DATE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

3) Open:
   http://localhost/med-verify/register.php

Flow:
Register -> Login -> Dashboard -> Logout

API:
api/check_email.php?email=test@example.com
