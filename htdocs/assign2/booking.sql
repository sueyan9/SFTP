CREATE TABLE booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_ref VARCHAR(10) UNIQUE,
    customer_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(12) NOT NULL,
    unit_number VARCHAR(10),
    street_number VARCHAR(10) NOT NULL,
    street_name VARCHAR(100) NOT NULL,
    suburb VARCHAR(100),
    destination_suburb VARCHAR(100),
    pickup_date DATE NOT NULL,
    pickup_time TIME NOT NULL,
    booking_datetime DATETIME NOT NULL,
    status VARCHAR(20) DEFAULT 'unassigned'
);