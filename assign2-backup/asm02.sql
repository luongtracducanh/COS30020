-- Truncate friends table
TRUNCATE TABLE friends;

-- Truncate myfriends table
TRUNCATE TABLE myfriends;

-- Insert data into friends table
INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friends)
VALUES
    ('friend1@example.com', 'password1', 'John Doe', '2023-01-01', 4),
    ('friend2@example.com', 'password2', 'Jane Smith', '2023-02-15', 4),
    ('friend3@example.com', 'password3', 'Michael Johnson', '2023-03-10', 4),
    ('friend4@example.com', 'password4', 'Sarah Thompson', '2023-04-22', 4),
    ('friend5@example.com', 'password5', 'David Lee', '2023-05-05', 4),
    ('friend6@example.com', 'password6', 'Emily Davis', '2023-06-18', 4),
    ('friend7@example.com', 'password7', 'Daniel Wilson', '2023-07-07', 4),
    ('friend8@example.com', 'password8', 'Olivia Brown', '2023-08-12', 4),
    ('friend9@example.com', 'password9', 'James Taylor', '2023-09-25', 4),
    ('friend10@example.com', 'password10', 'Sophia Anderson', '2023-10-31', 4)

-- Insert data into myfriends table
INSERT INTO myfriends (friend_id1, friend_id2)
VALUES
    (1, 2),
    (2, 3),
    (3, 4),
    (4, 5),
    (5, 6),
    (6, 7),
    (7, 8),
    (8, 9),
    (9, 10),
    (10, 1),
    (1, 3),
    (2, 4),
    (3, 5),
    (4, 6),
    (5, 7),
    (6, 8),
    (7, 9),
    (8, 10),
    (9, 1),
    (10, 2);

-- Query people who are not friends with id 1
SELECT
    f.friend_id,
    f.profile_name
FROM
    friends f
WHERE
    f.friend_id != 1 AND f.friend_id NOT IN(
    SELECT
        mf.friend_id1
    FROM
        myfriends mf
    WHERE
        mf.friend_id2 = 1
) AND f.friend_id NOT IN(
    SELECT
        mf.friend_id2
    FROM
        myfriends mf
    WHERE
        mf.friend_id1 = 1
);

-- Query people who are friends with id 1
SELECT
    friend_id1
FROM
    myfriends
WHERE
    friend_id2 = 1
UNION
SELECT
    friend_id2
FROM
    myfriends
WHERE
    friend_id1 = 1;

-- Query people who are mutual friends with id 1
SELECT
    friend_id,
    COUNT(*) AS mutual_friends_count
FROM
    friends AS f
JOIN myfriends AS mf
ON
    (
        f.friend_id = mf.friend_id1 AND mf.friend_id2 = 5
    ) OR(
        f.friend_id = mf.friend_id2 AND mf.friend_id1 = 5
    )
WHERE
    f.friend_id != 1 AND f.friend_id IN(
    SELECT
        friend_id1
    FROM
        myfriends
    WHERE
        friend_id2 = 1
    UNION
SELECT
    friend_id2
FROM
    myfriends
WHERE
    friend_id1 = 1
);
