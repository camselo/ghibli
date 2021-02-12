DROP DATABASE `Ghibli`;

CREATE DATABASE IF NOT EXISTS `Ghibli`;

USE `Ghibli`;

CREATE TABLE IF NOT EXISTS `Movie`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `director` VARCHAR(255) NOT NULL,
    `release_date` DATE NOT NULL,
    `genre` VARCHAR(255) NOT NULL,
    `poster` VARCHAR(255) NOT NULL
);

INSERT INTO `Movie`(`title`, `director`, `release_date`, `genre`, `poster`) VALUES ("O Meu Vizinho Totoro", "Hayao Miyazaki", "1995-03-08", "Animação", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTAZish2n99p_FbSsSv5zNzK0X3clcQhQmC1Zimm-HAtDQiYod7")

SELECT * FROM Movie;
