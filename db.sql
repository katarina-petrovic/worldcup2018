-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 14, 2019 at 11:05 AM
-- Server version: 10.1.37-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostsav_football2018`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `type_of_event` varchar(50) NOT NULL,
  `player` varchar(70) NOT NULL,
  `time` varchar(10) NOT NULL,
  `home_team` tinyint(1) NOT NULL,
  `match_id` int(11) NOT NULL,
  `team_code` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `fifa_id` int(11) NOT NULL,
  `venue` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `status` varchar(30) NOT NULL,
  `time` varchar(50) NOT NULL,
  `attendance` mediumint(9) NOT NULL,
  `officials` text NOT NULL,
  `stage_name` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  `winner_code` char(3) NOT NULL,
  `winner` varchar(50) NOT NULL,
  `last_score_update_at` datetime NOT NULL,
  `last_event_update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `match_statistics`
--

CREATE TABLE `match_statistics` (
  `id` int(11) NOT NULL,
  `team_code` char(3) NOT NULL,
  `match_id` int(11) NOT NULL,
  `home_team` tinyint(1) NOT NULL,
  `attempts_on_goal` tinyint(4) NOT NULL,
  `on_target` tinyint(4) NOT NULL,
  `off_target` tinyint(4) NOT NULL,
  `blocked` tinyint(4) NOT NULL,
  `woodwork` tinyint(4) NOT NULL,
  `corners` tinyint(4) NOT NULL,
  `offsides` tinyint(4) NOT NULL,
  `ball_possession` tinyint(4) NOT NULL,
  `pass_accuracy` tinyint(4) NOT NULL,
  `num_passes` smallint(6) NOT NULL,
  `passes_completed` smallint(4) NOT NULL,
  `distance_covered` tinyint(4) NOT NULL,
  `balls_recovered` tinyint(4) NOT NULL,
  `tackles` tinyint(4) NOT NULL,
  `clearances` tinyint(4) NOT NULL,
  `yellow_cards` tinyint(4) NOT NULL,
  `red_cards` tinyint(4) NOT NULL,
  `fouls_committed` tinyint(4) NOT NULL,
  `tactics` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `match_teams`
--

CREATE TABLE `match_teams` (
  `id` int(11) NOT NULL,
  `country` varchar(50) NOT NULL,
  `code` char(3) NOT NULL,
  `goals` tinyint(2) NOT NULL,
  `penalties` tinyint(2) NOT NULL,
  `home_team` tinyint(1) NOT NULL,
  `match_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `captain` tinyint(1) NOT NULL,
  `shirt_number` tinyint(4) NOT NULL,
  `position` varchar(20) NOT NULL,
  `starting_eleven` tinyint(1) NOT NULL,
  `team_id` char(3) NOT NULL,
  `match_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` tinyint(4) NOT NULL,
  `fifa_code` char(3) NOT NULL,
  `country` varchar(50) NOT NULL,
  `alternate_name` varchar(50) NOT NULL,
  `group_id` tinyint(2) NOT NULL,
  `group_letter` char(1) NOT NULL,
  `wins` tinyint(4) NOT NULL,
  `losses` tinyint(4) NOT NULL,
  `draws` tinyint(4) NOT NULL,
  `games_played` tinyint(4) NOT NULL,
  `points` tinyint(4) NOT NULL,
  `goals_for` tinyint(4) NOT NULL,
  `goals_against` tinyint(4) NOT NULL,
  `goal_differential` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `weather`
--

CREATE TABLE `weather` (
  `id` int(11) NOT NULL,
  `humidity` tinyint(4) NOT NULL,
  `temp_celsius` tinyint(4) NOT NULL,
  `temp_farenheit` tinyint(4) NOT NULL,
  `wind_speed` tinyint(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  `match_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_id_frk` (`match_id`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`fifa_id`);

--
-- Indexes for table `match_statistics`
--
ALTER TABLE `match_statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `match_id_frk` (`match_id`);

--
-- Indexes for table `match_teams`
--
ALTER TABLE `match_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `match_teams_id_frk` (`match_id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `match_player_id_frk` (`match_id`),
  ADD KEY `team_players_id_frk` (`team_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`),
  ADD UNIQUE KEY `fifa_code` (`fifa_code`);

--
-- Indexes for table `weather`
--
ALTER TABLE `weather`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `match_id` (`match_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `match_statistics`
--
ALTER TABLE `match_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7015;

--
-- AUTO_INCREMENT for table `match_teams`
--
ALTER TABLE `match_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3161;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53558;

--
-- AUTO_INCREMENT for table `weather`
--
ALTER TABLE `weather`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1189;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_id_frk` FOREIGN KEY (`match_id`) REFERENCES `matches` (`fifa_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `match_statistics`
--
ALTER TABLE `match_statistics`
  ADD CONSTRAINT `match_id_frk` FOREIGN KEY (`match_id`) REFERENCES `matches` (`fifa_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `match_teams`
--
ALTER TABLE `match_teams`
  ADD CONSTRAINT `match_teams_id_frk` FOREIGN KEY (`match_id`) REFERENCES `matches` (`fifa_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `match_player_id_frk` FOREIGN KEY (`match_id`) REFERENCES `matches` (`fifa_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `team_players_id_frk` FOREIGN KEY (`team_id`) REFERENCES `teams` (`fifa_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `weather`
--
ALTER TABLE `weather`
  ADD CONSTRAINT `match_weather_id_frk` FOREIGN KEY (`match_id`) REFERENCES `matches` (`fifa_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
