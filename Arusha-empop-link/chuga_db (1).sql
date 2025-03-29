-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2025 at 09:13 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chuga_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_qualifications`
--

CREATE TABLE `academic_qualifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `education_level` varchar(100) NOT NULL,
  `institution_name` varchar(255) NOT NULL,
  `programme_category` varchar(100) NOT NULL,
  `programme_name` varchar(255) DEFAULT NULL,
  `date_from` date NOT NULL,
  `date_to` date DEFAULT NULL,
  `certificate_file_path` varchar(255) DEFAULT NULL,
  `certificate_original_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academic_qualifications`
--

INSERT INTO `academic_qualifications` (`id`, `user_id`, `education_level`, `institution_name`, `programme_category`, `programme_name`, `date_from`, `date_to`, `certificate_file_path`, `certificate_original_name`) VALUES
(1, 1, 'Diploma', 'ATC', 'Science', 'IT', '2025-03-06', '2025-03-12', 'uploads/certificates/67e5532683578.pdf', 'hj.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `declarations`
--

CREATE TABLE `declarations` (
  `user_id` int(11) NOT NULL,
  `is_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `accept_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personal_details`
--

CREATE TABLE `personal_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `particular` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `region_of_birth` varchar(100) DEFAULT NULL,
  `district_of_birth` varchar(100) DEFAULT NULL,
  `originality` varchar(100) DEFAULT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `government_employment_status` varchar(100) DEFAULT NULL,
  `disability` varchar(100) DEFAULT NULL,
  `contacts` varchar(50) DEFAULT NULL,
  `current_region` varchar(100) DEFAULT NULL,
  `current_district` varchar(100) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_details`
--

INSERT INTO `personal_details` (`id`, `user_id`, `particular`, `full_name`, `gender`, `date_of_birth`, `country`, `region_of_birth`, `district_of_birth`, `originality`, `marital_status`, `government_employment_status`, `disability`, `contacts`, `current_region`, `current_district`, `zip_code`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Haji Rajabu Musa', 'Male', '2025-03-27', 'Tanzania', 'Manyara', 'Babati', '', 'Single', 'No', 'NO', '0693116952', 'Arusha', 'Arusha CBD', '23105', '2025-03-27 12:45:16', '2025-03-27 12:45:16'),
(2, 2, NULL, 'Admin', 'Female', '2024-04-30', 'Tanzania', 'Manyara', 'Babati', '', 'Married', 'Yes', 'NO', '0693116959', 'Dar', 'Temeke', '23105', '2025-03-28 16:51:09', '2025-03-28 16:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `referees`
--

CREATE TABLE `referees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `referees`
--

INSERT INTO `referees` (`id`, `user_id`, `full_name`, `title`, `email`, `institution`, `address`, `telephone`, `created_at`) VALUES
(3, 2, 'paul pastory', 'manager', 'ppastory@simbanet.co.tz', 'Simbanet', 'Arusha', '0693116952', '2025-03-28 16:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `institution` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `certificate_filename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_token_expires` timestamp NULL DEFAULT NULL,
  `verification_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `is_active`, `created_at`, `last_login`, `reset_token`, `reset_token_expires`, `verification_token`) VALUES
(1, 'hajimusa', 'hrajabu701@gmail.com', '$2y$10$nurfoqjBFB/j3t1W9aWQf.iCA3ARwNomSdnBGfENr77Iy47G4R27G', 0, '2025-03-27 12:12:57', NULL, NULL, NULL, NULL),
(2, 'admin', 'chahamamosesmeshack@gmail.com', '$2y$10$gs4UWp.Smbw/C4cih/kRguGTpQAVaRs6qv/YCeMWyXz5yYtY8dyPi', 0, '2025-03-28 09:05:06', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_experience`
--

CREATE TABLE `work_experience` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `institution_organization` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `supervisor_name` varchar(255) DEFAULT NULL,
  `supervisor_telephone` varchar(20) DEFAULT NULL,
  `supervisor_address` text DEFAULT NULL,
  `institution_address` text DEFAULT NULL,
  `duties_responsibilities` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `is_current_job` tinyint(1) DEFAULT 0,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_experience`
--

INSERT INTO `work_experience` (`id`, `user_id`, `institution_organization`, `job_title`, `supervisor_name`, `supervisor_telephone`, `supervisor_address`, `institution_address`, `duties_responsibilities`, `start_date`, `is_current_job`, `end_date`, `created_at`, `updated_at`, `file_path`) VALUES
(1, 1, 'Simbanet', 'IT', 'Paul', '0693116952', 'Arusha', 'clocktower', 'GPON', '2025-03-18', 0, '2025-03-18', '2025-03-28 08:16:54', '2025-03-28 08:16:54', NULL),
(2, 1, 'zuku', 'IT', 'pascal', '0693116952', 'Arusha', 'plza', 'fundi', '2025-01-09', 0, '2025-02-26', '2025-03-28 08:32:20', '2025-03-28 08:32:20', NULL),
(3, 1, 'Simbanet', 'IT', 'pascal', '0693116952', 'Arusha', 'wrjnh', 'uytrtyu', '2025-02-12', 0, '0000-00-00', '2025-03-28 08:47:08', '2025-03-28 08:47:08', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `declarations`
--
ALTER TABLE `declarations`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `personal_details`
--
ALTER TABLE `personal_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `referees`
--
ALTER TABLE `referees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_details`
--
ALTER TABLE `personal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `referees`
--
ALTER TABLE `referees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_experience`
--
ALTER TABLE `work_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  ADD CONSTRAINT `academic_qualifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `declarations`
--
ALTER TABLE `declarations`
  ADD CONSTRAINT `declarations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `personal_details` (`id`);

--
-- Constraints for table `personal_details`
--
ALTER TABLE `personal_details`
  ADD CONSTRAINT `personal_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referees`
--
ALTER TABLE `referees`
  ADD CONSTRAINT `referees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `personal_details` (`id`);

--
-- Constraints for table `trainings`
--
ALTER TABLE `trainings`
  ADD CONSTRAINT `trainings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `personal_details` (`id`);

--
-- Constraints for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD CONSTRAINT `work_experience_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `personal_details` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
