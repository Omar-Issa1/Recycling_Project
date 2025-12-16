<?php
require_once 'config.php'; // فيه Database class

$db = new Database();

$sql = [

"CREATE TABLE IF NOT EXISTS serial_number (
    Qr_code BIGINT PRIMARY KEY
);",

"CREATE TABLE IF NOT EXISTS user_information (
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    user_email VARCHAR(50),
    user_phone VARCHAR(50),
    user_address VARCHAR(50) NOT NULL,
    balance DECIMAL(15, 2) DEFAULT 0,
    points INTEGER DEFAULT 0,
    Qr_code BIGINT,
    CONSTRAINT fk_user_qr FOREIGN KEY (Qr_code)
        REFERENCES serial_number(Qr_code)
        ON DELETE SET NULL
);",

"CREATE TABLE IF NOT EXISTS material (
    material_id SERIAL PRIMARY KEY,
    material_type VARCHAR(50) NOT NULL,
    material_quantity INTEGER NOT NULL,
    Qr_code BIGINT,
    CONSTRAINT fk_material_qr FOREIGN KEY (Qr_code)
        REFERENCES serial_number(Qr_code)
        ON DELETE SET NULL
);",

"CREATE TABLE IF NOT EXISTS factory (
    factory_id SERIAL PRIMARY KEY,
    factory_name VARCHAR(50),
    location VARCHAR(50),
    Qr_code BIGINT,
    CONSTRAINT fk_factory_qr FOREIGN KEY (Qr_code)
        REFERENCES serial_number(Qr_code)
        ON DELETE SET NULL
);",

"CREATE TABLE IF NOT EXISTS driver (
    driver_id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    driver_name VARCHAR(50),
    driver_phone VARCHAR(50),
    driver_email VARCHAR(50),
    Qr_code BIGINT,
    CONSTRAINT fk_driver_qr FOREIGN KEY (Qr_code)
        REFERENCES serial_number(Qr_code)
        ON DELETE SET NULL
);"

];

foreach ($sql as $query) {
    $db->query($query);
}

echo "✅ Old schema migration completed successfully";
