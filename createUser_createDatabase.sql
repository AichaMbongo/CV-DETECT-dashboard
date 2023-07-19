-- --------------------------------------------------------

-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: cv-detect
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- REVOKE ALL PRIVILEGES, GRANT OPTION FROM `student`@`%`;
-- DROP USER IF EXISTS `student`@`%`;

CREATE USER IF NOT EXISTS `student`@`%` IDENTIFIED BY '5trathm0re' 
WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 ;

GRANT USAGE ON * . * TO `student`@`%`;
GRANT EXECUTE, SELECT ON `cv-detect`.* TO `student`@`%`;

--
-- Database: `cv-detect
--
CREATE DATABASE IF NOT EXISTS `cv-detect` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cv-detect`;

-- --------------------------------------------------------

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2023 at 10:12 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cv-detect`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCostSavings` (IN `targetSavings` DECIMAL(10,2))   BEGIN
  SELECT
    `quarter`,
    `cost_savings`
  FROM
    `cost_savings`
  WHERE
    `cost_savings` >= targetSavings;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetDataErrorsAndInconsistencies` (IN `currentYear` INT)   BEGIN
  SELECT
    `month`,
    `data_errors`
  FROM
    `data_errors`
  WHERE
    YEAR(`year`) = currentYear
  ORDER BY `month`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetDataProcessingTimePerPatient` (IN `currentYear` INT)   BEGIN
  SELECT
    CONCAT(`age`, ' (', `gender`, ')') AS `patient_info`,
    AVG(`processing_time`) AS `avg_processing_time`
  FROM
    `patient_data`
  WHERE
    YEAR(`year`) = currentYear
  GROUP BY `patient_info`
  ORDER BY `avg_processing_time` DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetInnovativeIdeasCount` ()   BEGIN
  SELECT
    `quarter`,
    `idea_count`
  FROM
    `innovative_ideas`
  WHERE
    YEAR(`quarter`) = 2023
  ORDER BY `quarter`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetPatientSatisfactionScores` ()   BEGIN
  SELECT
    `id`,
    `satisfaction_score`
  FROM
    `patient_satisfaction`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProcessingTimeForYear` ()   BEGIN
  SELECT
    `quarter`,
    `processing_time`
  FROM
    `data_processing_time`
  WHERE
    YEAR(`quarter`) = 2023
  ORDER BY `quarter`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetReductionData` ()   BEGIN
  SELECT
    `category`,
    `hospitalizations`,
    `expenditures`
  FROM
    `reductions`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetSuccessfulInterventions` (IN `targetCount` INT)   BEGIN
  SELECT
    `quarter`,
    `intervention_count`
  FROM
    `interventions`
  WHERE
    `intervention_count` >= targetCount;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cost_savings`
--

CREATE TABLE `cost_savings` (
  `id` int(11) NOT NULL,
  `quarter` varchar(10) NOT NULL,
  `cost_savings` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cost_savings`
--

INSERT INTO `cost_savings` (`id`, `quarter`, `cost_savings`) VALUES
(1, 'Q1 2022', '250000.00'),
(2, 'Q2 2022', '400000.00'),
(3, 'Q3 2022', '300000.00'),
(4, 'Q4 2022', '350000.00'),
(5, 'Q1 2023', '450000.00'),
(6, 'Q2 2023', '500000.00'),
(7, 'Q3 2023', '600000.00'),
(8, 'Q4 2023', '550000.00');

-- --------------------------------------------------------

--
-- Table structure for table `data_errors`
--

CREATE TABLE `data_errors` (
  `id` int(11) NOT NULL,
  `year` year(4) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `data_errors` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_errors`
--

INSERT INTO `data_errors` (`id`, `year`, `month`, `data_errors`) VALUES
(1, 2022, 'January', 10),
(2, 2022, 'February', 5),
(3, 2022, 'March', 8),
(4, 2022, 'April', 12),
(5, 2023, 'January', 3),
(6, 2023, 'February', 7),
(7, 2023, 'March', 4),
(8, 2023, 'April', 6);

-- --------------------------------------------------------

--
-- Table structure for table `data_processing_time`
--

CREATE TABLE `data_processing_time` (
  `id` int(11) NOT NULL,
  `quarter` date NOT NULL,
  `processing_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_processing_time`
--

INSERT INTO `data_processing_time` (`id`, `quarter`, `processing_time`) VALUES
(1, '2022-01-01', 97),
(2, '2022-04-01', 89),
(3, '2022-07-01', 86),
(4, '2022-10-01', 78),
(5, '2023-01-01', 83),
(6, '2023-04-01', 81),
(7, '2023-07-01', 78),
(8, '2023-10-01', 75);

-- --------------------------------------------------------

--
-- Table structure for table `innovative_ideas`
--

CREATE TABLE `innovative_ideas` (
  `id` int(11) NOT NULL,
  `quarter` date DEFAULT NULL,
  `idea_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `innovative_ideas`
--

INSERT INTO `innovative_ideas` (`id`, `quarter`, `idea_count`) VALUES
(1, '2022-01-01', 100),
(2, '2022-04-01', 120),
(3, '2022-07-01', 110),
(4, '2022-10-01', 140),
(5, '2023-01-01', 130),
(6, '2023-04-01', 150),
(7, '2023-07-01', 160),
(8, '2023-10-01', 180);

-- --------------------------------------------------------

--
-- Table structure for table `interventions`
--

CREATE TABLE `interventions` (
  `id` int(11) NOT NULL,
  `quarter` varchar(10) NOT NULL,
  `intervention_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interventions`
--

INSERT INTO `interventions` (`id`, `quarter`, `intervention_count`) VALUES
(1, 'Q1 2020', 120),
(2, 'Q2 2020', 140),
(3, 'Q3 2020', 160),
(4, 'Q4 2020', 180),
(5, 'Q1 2021', 200),
(6, 'Q2 2021', 220),
(7, 'Q3 2021', 240),
(8, 'Q4 2021', 260),
(9, 'Q1 2022', 280),
(10, 'Q2 2022', 300);

-- --------------------------------------------------------

--
-- Table structure for table `kpi3b_data`
--

CREATE TABLE `kpi3b_data` (
  `id` int(11) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `interventions` int(11) DEFAULT NULL,
  `target` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kpi3b_data`
--

INSERT INTO `kpi3b_data` (`id`, `year`, `interventions`, `target`) VALUES
(1, 2018, 10, 15),
(2, 2018, 15, 15),
(3, 2019, 8, 16),
(4, 2019, 12, 16),
(5, 2020, 20, 18),
(6, 2020, 18, 18),
(7, 2021, 25, 20),
(8, 2021, 22, 20),
(9, 2022, 30, 22),
(10, 2022, 28, 22),
(11, 2023, 35, 25),
(12, 2023, 32, 25);

-- --------------------------------------------------------

--
-- Table structure for table `patient_data`
--

CREATE TABLE `patient_data` (
  `patient_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `processing_time` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_data`
--

INSERT INTO `patient_data` (`patient_id`, `name`, `gender`, `age`, `year`, `processing_time`) VALUES
(1, 'John Doe', 'Male', 30, 2023, 1.5),
(2, 'Jane Smith', 'Female', 25, 2023, 2.25),
(3, 'Michael Johnson', 'Male', 35, 2023, 3.75),
(4, 'Emily Davis', 'Female', 28, 2023, 2.5),
(5, 'John Doe', 'Male', 28, 2023, 3.8),
(6, 'Jane Smith', 'Female', 42, 2023, 4.2),
(7, 'Michael Johnson', 'Male', 38, 2023, 2.1),
(8, 'Emily Brown', 'Female', 45, 2023, 3.5),
(9, 'David Wilson', 'Male', 31, 2023, 2.9),
(10, 'Olivia Davis', 'Female', 36, 2023, 3.7);

-- --------------------------------------------------------

--
-- Table structure for table `patient_satisfaction`
--

CREATE TABLE `patient_satisfaction` (
  `id` int(11) NOT NULL,
  `survey_date` date DEFAULT NULL,
  `satisfaction_score` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_satisfaction`
--

INSERT INTO `patient_satisfaction` (`id`, `survey_date`, `satisfaction_score`) VALUES
(1, '2023-01-01', '9.2'),
(2, '2023-04-01', '8.5'),
(3, '2023-07-01', '7.8'),
(4, '2023-10-01', '8.9'),
(5, '2024-01-01', '8.7'),
(6, '2024-04-01', '9.3'),
(7, '2024-07-01', '8.2'),
(8, '2024-10-01', '9.1'),
(9, '2025-01-01', '8.9'),
(10, '2025-04-01', '9.0'),
(11, '2025-07-01', '8.8'),
(12, '2025-10-01', '9.2');

-- --------------------------------------------------------

--
-- Table structure for table `reductions`
--

CREATE TABLE `reductions` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `subcategory` varchar(50) NOT NULL,
  `hospitalizations` int(11) NOT NULL,
  `expenditures` decimal(10,2) NOT NULL,
  `reduction` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reductions`
--

INSERT INTO `reductions` (`id`, `category`, `subcategory`, `hospitalizations`, `expenditures`, `reduction`) VALUES
(1, 'Age Group', '18-30', 120, '25000.00', '15.20'),
(2, 'Age Group', '31-45', 180, '35000.00', '20.50'),
(3, 'Age Group', '46-60', 90, '15000.00', '8.75'),
(4, 'Age Group', '61+', 60, '10000.00', '6.40'),
(5, 'Gender', 'Male', 250, '45000.00', '19.80'),
(6, 'Gender', 'Female', 210, '38000.00', '16.75'),
(7, 'Region', 'North', 180, '32000.00', '15.60'),
(8, 'Region', 'South', 120, '21000.00', '10.80'),
(9, 'Region', 'East', 140, '26000.00', '12.30'),
(10, 'Region', 'West', 100, '18000.00', '8.50');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `revenue` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `product_id`, `sale_date`, `quantity`, `revenue`) VALUES
(1, 1001, '2023-01-01', 10, '500.00'),
(2, 1002, '2023-01-01', 5, '250.00'),
(3, 1003, '2023-01-02', 8, '400.00'),
(4, 1001, '2023-01-02', 12, '600.00'),
(5, 1002, '2023-01-03', 6, '300.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cost_savings`
--
ALTER TABLE `cost_savings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_errors`
--
ALTER TABLE `data_errors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_processing_time`
--
ALTER TABLE `data_processing_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `innovative_ideas`
--
ALTER TABLE `innovative_ideas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interventions`
--
ALTER TABLE `interventions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kpi3b_data`
--
ALTER TABLE `kpi3b_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_data`
--
ALTER TABLE `patient_data`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `patient_satisfaction`
--
ALTER TABLE `patient_satisfaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reductions`
--
ALTER TABLE `reductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cost_savings`
--
ALTER TABLE `cost_savings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_errors`
--
ALTER TABLE `data_errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `data_processing_time`
--
ALTER TABLE `data_processing_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `innovative_ideas`
--
ALTER TABLE `innovative_ideas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `interventions`
--
ALTER TABLE `interventions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kpi3b_data`
--
ALTER TABLE `kpi3b_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `patient_data`
--
ALTER TABLE `patient_data`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patient_satisfaction`
--
ALTER TABLE `patient_satisfaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reductions`
--
ALTER TABLE `reductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
