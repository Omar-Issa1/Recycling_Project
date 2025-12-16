<?php
require_once 'config.php'; // فيه Database class

$db = new Database();

$migrations = [

"CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    balance NUMERIC(15,2) DEFAULT 0,
    points INTEGER DEFAULT 0,
    qr_code VARCHAR(100) UNIQUE
);",

"CREATE TABLE IF NOT EXISTS materials (
    id SERIAL PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    quantity INTEGER NOT NULL,
    user_id INTEGER REFERENCES users(id) ON DELETE SET NULL,
    qr_code VARCHAR(100)
);",

"CREATE TABLE IF NOT EXISTS factories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    location TEXT,
    qr_code VARCHAR(100) UNIQUE
);",

"CREATE TABLE IF NOT EXISTS drivers (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    name VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    qr_code VARCHAR(100) UNIQUE
);"

];

foreach ($migrations as $sql) {
    $db->query($sql);
}

echo "✅ Migration completed successfully";
