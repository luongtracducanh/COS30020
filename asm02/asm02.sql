-- Create friends table
CREATE TABLE `s103488117_db`.`friends` (
  `friend_id` INT NOT NULL AUTO_INCREMENT,
  `friend_email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  `profile_name` VARCHAR(30) NOT NULL,
  `date_started` DATE NOT NULL,
  `num_of_friends` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`friend_id`)
) ENGINE = InnoDB;

-- Create myfriends table
CREATE TABLE `s103488117_db`.`myfriends` (
  `friend_id1` INT NOT NULL,
  `friend_id2` INT NOT NULL
) ENGINE = InnoDB;

-- Truncate friends table
TRUNCATE TABLE friends;

-- Truncate myfriends table
TRUNCATE TABLE myfriends;

-- Insert data into friends table
INSERT INTO friends (friend_id, friend_email, password, profile_name, date_started, num_of_friends)
VALUES
    (1001, 'friend1@example.com', 'password1', 'John Doe', '2023-01-01', 3),
    (1002, 'friend2@example.com', 'password2', 'Jane Smith', '2023-02-15', 2),
    (1003, 'friend3@example.com', 'password3', 'Michael Johnson', '2023-03-10', 2),
    (1004, 'friend4@example.com', 'password4', 'Sarah Thompson', '2023-04-22', 2),
    (1005, 'friend5@example.com', 'password5', 'David Lee', '2023-05-05', 2),
    (1006, 'friend6@example.com', 'password6', 'Emily Davis', '2023-06-18', 2),
    (1007, 'friend7@example.com', 'password7', 'Daniel Wilson', '2023-07-07', 2),
    (1008, 'friend8@example.com', 'password8', 'Olivia Brown', '2023-08-12', 2),
    (1009, 'friend9@example.com', 'password9', 'James Taylor', '2023-09-25', 2),
    (1010, 'friend10@example.com', 'password10', 'Sophia Anderson', '2023-10-31', 1);

-- Insert data into myfriends table
INSERT INTO
  myfriends (friend_id1, friend_id2)
VALUES
  (1001, 1002),
  (1002, 1001),
  (1003, 1004),
  (1004, 1003),
  (1005, 1006),
  (1006, 1005),
  (1007, 1008),
  (1008, 1007),
  (1009, 1010),
  (1010, 1009),
  (1001, 1003),
  (1003, 1001),
  (1002, 1004),
  (1004, 1002),
  (1005, 1007),
  (1007, 1005),
  (1006, 1008),
  (1008, 1006),
  (1009, 1001),
  (1001, 1009);