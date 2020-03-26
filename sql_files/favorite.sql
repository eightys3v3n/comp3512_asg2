--
-- Table structure for table favorite ... Thank you Randy for your example files
--

DROP TABLE IF EXISTS `favorite`;

CREATE TABLE `favorite`(
	   `user_id` INT NOT NULL,
	   `movie_id` INT NOT NULL,
	   FOREIGN KEY (`user_id`) REFERENCES user(`id`),
	   FOREIGN KEY (`movie_id`) REFERENCES movie(`id`),
	   PRIMARY KEY (`user_id`, `movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
