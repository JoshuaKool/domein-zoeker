DROP DATABASE IF EXISTS opdracht_domein_zoeker;

CREATE DATABASE opdracht_domein_zoeker;

USE opdracht_domein_zoeker;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subtotal DECIMAL(10, 2) NOT NULL,
    vat DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    domain VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    order_id INT,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);