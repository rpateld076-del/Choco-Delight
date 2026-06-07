-- Fix orders table to support all status values
-- Run this SQL query in phpMyAdmin or MySQL command line

ALTER TABLE orders 
MODIFY COLUMN status VARCHAR(50) DEFAULT 'pending';

-- Also add missing columns if they don't exist
ALTER TABLE orders 
ADD COLUMN IF NOT EXISTS delivery_person_id INT NULL,
ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
ADD COLUMN IF NOT EXISTS delivery_date TIMESTAMP NULL,
ADD COLUMN IF NOT EXISTS payment_status VARCHAR(50) DEFAULT 'pending',
ADD COLUMN IF NOT EXISTS order_number VARCHAR(50) NULL;

-- Add foreign key for delivery_person_id if delivery_person table exists
-- ALTER TABLE orders 
-- ADD CONSTRAINT fk_delivery_person 
-- FOREIGN KEY (delivery_person_id) REFERENCES delivery_person(id) ON DELETE SET NULL;
