-- Task 1: Creating a table and entering data
-- Using your existing database ‘s<7-digit Swinburne id>_db’, create a new table cars for a used car dealership.
-- Include the following fields in the cars table:
--     car_id (AUTO_INCREMENT PRIMARY KEY),
--     make,
--     model,
--     price, and
--     yom (year of manufacture).
CREATE TABLE `s103488117_db`.`cars` (
    `car_id` INT(10) NOT NULL AUTO_INCREMENT,
    `make` VARCHAR(255) NOT NULL,
    `model` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `yom` INT(10) NOT NULL,
    PRIMARY KEY (`car_id`)
) ENGINE = InnoDB;

-- Enter at least 10 records into the table.
INSERT INTO cars (make, model, price, yom)
VALUES ('Holden', 'Astra', 14000.00, 2005),
    ('BMW', 'X3', 35000.00, 2004),
    ('Ford', 'Falcon', 39000.00, 2011),
    ('Toyota', 'Corolla', 20000.00, 2012),
    ('Holden', 'Commodore', 13500.00, 2005),
    ('Holden', 'Astra', 8000.00, 2001),
    ('Holden', 'Commodore', 28000.00, 2009),
    ('Ford', 'Falcon', 14000.00, 2007),
    ('Ford', 'Falcon', 7000.00, 2003),
    ('Ford', 'Laser', 10000.00, 2010),
    ('Mazda', 'RX-7', 26000.00, 2000),
    ('Toyota', 'Corolla', 12000.00, 2001),
    ('Mazda', '3', 14500.00, 2009);

-- Task 2: Querying the table
-- Write queries that return the following:
-- 1. All records
SELECT * FROM cars;

-- 2. Make, model, and price, sorted by make and model
SELECT make, model, price FROM cars ORDER BY make, model;

-- 3. The make and model of the cars which cost $20,000.00 or more.
SELECT make, model FROM cars WHERE price >= 20000.00;

-- 4. The make and model of the cars which cost below $15,000.00.
SELECT make, model FROM cars WHERE price < 15000.00;

-- 5. The average price of cars for similar make.
SELECT make, AVG(price) FROM cars GROUP BY make;
