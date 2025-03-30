-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 03:45 PM
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
(1, 1, 'Diploma', 'ATC', 'Science', 'IT', '2025-03-06', '2025-03-12', 'uploads/certificates/67e5532683578.pdf', 'hj.pdf'),
(2, 3, 'Diploma', 'ATC', 'Science', 'IT', '2025-02-25', '2025-01-30', '', ''),
(3, 4, 'Diploma', 'mgg', 'Arts', 'lang', '2025-02-25', '2025-03-18', '', ''),
(4, 5, 'Diploma', 'Korea Tech', 'Engineering', 'Agriculture', '2025-02-26', '2025-03-29', '', ''),
(5, 5, 'Secondary', 'Ngarenaro', 'Science', 'PCB', '2025-02-26', '2025-03-26', 'uploads/certificates/67e90d29161c3.pdf', 'hj.pdf'),
(6, 2, 'PhD', 'ATC', 'Science', 'IT', '2025-03-12', '2025-06-21', 'uploads/certificates/67e94701099bc.pdf', 'qua.pdf');

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
  `passport_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_details`
--

INSERT INTO `personal_details` (`id`, `user_id`, `particular`, `full_name`, `gender`, `date_of_birth`, `country`, `region_of_birth`, `district_of_birth`, `originality`, `marital_status`, `government_employment_status`, `disability`, `contacts`, `current_region`, `current_district`, `zip_code`, `passport_image`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Haji Rajabu Musa', 'Male', '2025-03-27', 'Tanzania', 'Manyara', 'Babati', '', 'Single', 'No', 'NO', '0693116952', 'Arusha', 'Arusha CBD', '23105', 'uploads/passports/passport_1743339990_bellig.png', '2025-03-27 12:45:16', '2025-03-30 13:06:30'),
(2, 2, NULL, 'Admin Faraja', 'Male', '2024-04-30', 'Kenya', NULL, NULL, '', 'mingo', 'Yes', 'NO', '0693116932', 'Dar es salaam', 'Temeke', '23105', 'uploads/passports/passport_1743322211_bellig.png', '2025-03-28 16:51:09', '2025-03-30 08:27:07'),
(4, 3, NULL, 'Emryes R Musir', 'Male', '2025-03-10', 'Tanzania', 'Kilimanjaro', 'Moshi', '', '', 'No', 'NO', '0693116952', 'Arusha', 'Arusha CBD', '23105', 'uploads/passports/passport_1743340553_PXL_20250215_141013803(1).jpg', '2025-03-29 12:16:07', '2025-03-30 13:15:53'),
(9, 4, NULL, 'cblack', 'Male', '2025-03-20', 'Tanzania', 'dodom', 'kondoa', '', 'Single', 'Yes', 'NO', '0693116952', 'Dar', 'Temeke', '23105', 'uploads/passports/passport_4_1743273565.jpg', '2025-03-29 18:39:25', '2025-03-29 18:39:25'),
(10, 4, NULL, 'cblack', 'Male', '2025-03-20', 'Tanzania', 'dodoma', 'kona', '', 'Married', 'No', 'NO', '0693116952', 'Dar', 'Temeke', '23105', 'uploads/passports/passport_4_1743274668.jpg', '2025-03-29 18:57:48', '2025-03-29 18:57:48'),
(11, 4, NULL, 'cblack', 'Male', '2025-03-20', 'Tanzania', 'dodoma', 'kondoa', '', 'Single', 'Yes', 'NO', '0693116952', 'Dar es salaam', 'Temeke', '23105', 'uploads/passports/passport_4_1743273565.jpg', '2025-03-29 19:14:06', '2025-03-29 19:14:06'),
(12, 3, NULL, 'Emryes Rajabu Musir', 'Male', '2025-03-10', 'Tanzania', 'Kilimanjaro', 'Moshi', '', '', 'No', 'NO', '0693116952', 'Arusha', 'Arusha CBD', '23105', 'uploads/passports/passport_1743340553_PXL_20250215_141013803(1).jpg', '2025-03-29 19:36:24', '2025-03-30 13:15:53'),
(13, 3, NULL, 'Emryes Rajab Musir', 'Male', '2025-02-25', '', '', '', '', '', 'No', 'NO', '0693116952', 'Arusha', 'Arusha CBD', '23105', 'uploads/passports/passport_1743340553_PXL_20250215_141013803(1).jpg', '2025-03-29 20:27:07', '2025-03-30 13:15:53'),
(14, 3, NULL, 'Emryes Rajabu Musir', 'Male', '2025-02-25', '', '', '', '', '', 'No', 'NO', '0693116952', 'Arusha', 'Arusha CBD', '23105', 'uploads/passports/passport_1743340553_PXL_20250215_141013803(1).jpg', '2025-03-29 20:34:41', '2025-03-30 13:15:53'),
(15, 3, NULL, 'Emryes Rajabu Musir', 'Male', '2023-04-10', '', '', '', '', '', 'No', 'NO', '0693116952', 'Arusha', 'Arusha CBD', '23105', 'uploads/passports/passport_1743340553_PXL_20250215_141013803(1).jpg', '2025-03-29 20:39:43', '2025-03-30 13:15:53'),
(16, 3, NULL, 'Emryes Ra Musir', 'Male', '2025-03-10', '', '', '', '', '', 'No', 'NO', '0693116952', 'Arusha', 'Arusha CBD', '23105', 'uploads/passports/passport_1743340553_PXL_20250215_141013803(1).jpg', '2025-03-29 20:52:45', '2025-03-30 13:15:53'),
(17, 5, NULL, 'Musa hamadi', 'Male', '2024-10-10', 'Tanzania', 'Manyara', 'Babati', NULL, 'single', 'no', 'NO', '0693116959', 'Arusha', 'Arusha CBD', '23105', 'uploads/passports/passport_1743326039_passport.jpg', '2025-03-30 09:13:59', '2025-03-30 13:05:29');

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
(3, 2, 'paul pastory', 'manager', 'ppastory@simbanet.co.tz', 'Simbanet', 'Arusha', '0693116952', '2025-03-28 16:52:04'),
(4, 1, 'Haji Rajabu Musa', 'ws', 'a@c', 'Simbanet', 'Arusha', '0693116952', '2025-03-29 14:05:29'),
(5, 1, 'Haji Rajabu Musa', 'it', 'hrajabu701@gmail.com', 'Simbanet', 'Arusha', '0693116952', '2025-03-29 17:26:14'),
(7, 2, 'paul pastory', 'qwef', 'qwe@df', 'zuku', 'Arusha', '0693116952', '2025-03-29 17:38:07'),
(10, 4, 'Haji Rajabu Musa', 'dfgh', 'rama@ally', 'mgg', 'Arusha', '0693116952', '2025-03-29 17:54:32'),
(12, 5, 'Haji Rajabu Musa', 'Supervisor', 'hrajabu701@gmail.com', 'ATC', 'Arusha', '0693116952', '2025-03-30 13:04:27'),
(13, 3, 'stephen', 'IT engineer', 'hrajabu701@gmail.com', 'ATC', 'm/mairo', '0693116952', '2025-03-30 13:25:49');

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

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`id`, `user_id`, `name`, `description`, `institution`, `start_date`, `end_date`, `certificate_filename`, `created_at`) VALUES
(4, 1, 'Haji Rajabu', 'efvdfv v ', 'Simbanet', '2025-03-12', '2025-04-04', NULL, '2025-03-29 17:25:35'),
(5, 4, 'John Doe', 'wertyui', 'zuku', '2025-03-04', '2025-03-27', NULL, '2025-03-29 18:00:49'),
(7, 5, 'SEEDS preservation', 'wertyukjhgfdscvbn', 'ECHO East Africa', '2025-02-25', '2025-03-27', '1743337192_pic.pdf', '2025-03-30 12:19:52'),
(8, 3, 'GPON', 'CORE NETWORK', 'Simbanet', '2024-12-05', '2025-03-28', '1743340910_isso.pdf', '2025-03-30 13:21:50');

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
(2, 'admin', 'chahamamosesmeshack@gmail.com', '$2y$10$gs4UWp.Smbw/C4cih/kRguGTpQAVaRs6qv/YCeMWyXz5yYtY8dyPi', 0, '2025-03-28 09:05:06', NULL, NULL, NULL, NULL),
(3, 'emryes', 'emryes@outlook.com', '$2y$10$czlv3BlueCm3x5cGkV43GuUOQalm.KA.1Ml9d1eREuf4LLw2taCb6', 0, '2025-03-29 11:27:06', NULL, NULL, NULL, NULL),
(4, 'cblake', 'rama@ally.com', '$2y$10$SIrsj05MtnLiLdaCoP4Be.memHyZR4JLQ5YHBdEB8PpS6UH3nn24S', 0, '2025-03-29 17:42:25', NULL, NULL, NULL, NULL),
(5, 'musahamadi', 'musa@kitundu.com', '$2y$10$pBH1aDT5l/f5jwRShbIrPuajzr8VAjCv3ZWfY.7qwABPWzSZlIBPK', 0, '2025-03-30 09:00:38', NULL, NULL, NULL, NULL);

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
(3, 1, 'Simbanet', 'IT', 'pascal', '0693116952', 'Arusha', 'wrjnh', 'uytrtyu', '2025-02-12', 0, '0000-00-00', '2025-03-28 08:47:08', '2025-03-28 08:47:08', NULL),
(9, 1, 'Simbanet', 'IT', 'Paul', '0693116952', 'Arusha', 'kujynhtbgvfc', 'wdefghg', '2025-02-27', 1, '0000-00-00', '2025-03-29 17:27:22', '2025-03-29 17:27:22', NULL),
(10, 4, 'Simbanet', 'IT', 'Paul', '0693116952', 'Arusha', 'wertyui', 'ertyj', '2025-03-11', 1, '0000-00-00', '2025-03-29 18:02:04', '2025-03-29 18:02:04', NULL),
(12, 5, 'ECHO East Africa', 'Agriculturenist', 'Madam Joyce', '0693116952', 'Arusha', 'Ngaramtoni', 'Nursery management', '2024-10-16', 0, '0000-00-00', '2025-03-30 11:24:27', '2025-03-30 11:24:27', NULL),
(13, 3, 'ATC', 'IT', 'January', '0693116952', 'Chugaa, Ngarnaa', 'hgcvhjlk', 'sdfghj', '2025-03-05', 1, '0000-00-00', '2025-03-30 13:19:47', '2025-03-30 13:19:47', 'uploads/1743340787_pic.pdf'),
(14, 2, 'ATC', 'programer', 'kaaya', '0693116952', 'Arusha, Ngarenaro', 'nairobi road ,moshi junction', 'software', '2025-01-03', 1, '0000-00-00', '2025-03-30 13:31:35', '2025-03-30 13:31:35', NULL);

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
  ADD KEY `referees_ibfk_1` (`user_id`);

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
  ADD KEY `fk_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_details`
--
ALTER TABLE `personal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `referees`
--
ALTER TABLE `referees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `work_experience`
--
ALTER TABLE `work_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  ADD CONSTRAINT `referees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
