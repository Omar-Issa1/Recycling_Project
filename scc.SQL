
CREATE TABLE IF NOT EXISTS serial_number (
    qr_code BIGINT PRIMARY KEY
);


CREATE TABLE IF NOT EXISTS user_information (
    user_id SERIAL PRIMARY KEY,

    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,

    user_email VARCHAR(100),
    user_phone VARCHAR(20),
    user_address VARCHAR(100),

    balance DECIMAL(10,2) DEFAULT 0,
    points INTEGER DEFAULT 0,

    qr_code BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_user_qr
        FOREIGN KEY (qr_code)
        REFERENCES serial_number(qr_code)
        ON DELETE SET NULL
);


CREATE TABLE IF NOT EXISTS material (
    material_id SERIAL PRIMARY KEY,

    user_id INTEGER NOT NULL,
    material_type VARCHAR(50) NOT NULL,
    quantity INTEGER NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_material_user
        FOREIGN KEY (user_id)
        REFERENCES user_information(user_id)
        ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS factory (
    factory_id SERIAL PRIMARY KEY,

    factory_name VARCHAR(200) NOT NULL,
    factory_location VARCHAR(200),

    qr_code BIGINT,

    CONSTRAINT fk_factory_qr
        FOREIGN KEY (qr_code)
        REFERENCES serial_number(qr_code)
        ON DELETE SET NULL
);


CREATE TABLE IF NOT EXISTS driver (
    driver_id SERIAL PRIMARY KEY,

    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,

    driver_name VARCHAR(50),
    driver_phone VARCHAR(20),
    driver_email VARCHAR(100),

    qr_code BIGINT,

    CONSTRAINT fk_driver_qr
        FOREIGN KEY (qr_code)
        REFERENCES serial_number(qr_code)
        ON DELETE SET NULL
);