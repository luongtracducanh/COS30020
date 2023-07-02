CREATE TABLE `s103488117_db`.`friends` (
  `friend_id` INT NOT NULL AUTO_INCREMENT,
  `friend_email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  `profile_name` VARCHAR(30) NOT NULL,
  `date_started` DATE NOT NULL,
  `num_of_friends` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`friend_id`)
) ENGINE = InnoDB;

CREATE TABLE `s103488117_db`.`myfriends` (
  `friend_id1` INT NOT NULL,
  `friend_id2` INT NOT NULL
) ENGINE = InnoDB;