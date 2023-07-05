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
    (1010, 'friend10@example.com', 'password10', 'Sophia Anderson', '2023-10-31', 1),
    (1011, 'friend11@example.com', 'password11', 'Matthew Wilson', '2023-11-15', 0),
    (1012, 'friend12@example.com', 'password12', 'Ava Martinez', '2023-12-22', 0),
    (1013, 'friend13@example.com', 'password13', 'William Garcia', '2024-01-08', 0),
    (1014, 'friend14@example.com', 'password14', 'Sofia Johnson', '2024-02-18', 0),
    (1015, 'friend15@example.com', 'password15', 'Benjamin Anderson', '2024-03-03', 0),
    (1016, 'friend16@example.com', 'password16', 'Mia Davis', '2024-04-11', 0),
    (1017, 'friend17@example.com', 'password17', 'Henry Thomas', '2024-05-19', 0),
    (1018, 'friend18@example.com', 'password18', 'Charlotte Moore', '2024-06-29', 0),
    (1019, 'friend19@example.com', 'password19', 'Joseph Jackson', '2024-07-16', 0),
    (1020, 'friend20@example.com', 'password20', 'Scarlett White', '2024-08-27', 0);

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

-- Select people who are not 1001 and not friends with 1001
SELECT
  friend_id,
  profile_name
FROM
  friends
WHERE
  friend_id NOT IN (
    SELECT
      f.friend_id
    FROM
      friends AS f
      INNER JOIN myfriends AS mf ON (f.friend_id = mf.friend_id2)
    WHERE
      mf.friend_id1 = 1001
  )
  AND friend_id != 1001
ORDER BY
  profile_name;

-- Select people who are not 1001 and not friends with 1001 and the number of mutual friends between them and 1001
SELECT
  f.friend_id,
  f.profile_name,
  COUNT(*) AS mutual_friends
FROM
  friends AS f
  INNER JOIN myfriends AS mf ON (f.friend_id = mf.friend_id2)
WHERE
  mf.friend_id1 = 1001
  AND f.friend_id NOT IN (
    SELECT
      f.friend_id
    FROM
      friends AS f
      INNER JOIN myfriends AS mf ON (f.friend_id = mf.friend_id2)
    WHERE
      mf.friend_id1 = 1001
  )
  AND f.friend_id != 1001
GROUP BY
  f.friend_id,
  f.profile_name
ORDER BY
  mutual_friends DESC,
  profile_name;
```