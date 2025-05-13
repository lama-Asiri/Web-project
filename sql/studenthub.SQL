-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 06:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studenthub`
--

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faq_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `question` text NOT NULL,
  `answer` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `subject`, `email`, `question`, `answer`, `created_at`) VALUES
(12, 'Change profile', 'g1.1@std.com', 'How do I update my profile image?', NULL, '2025-04-01 13:21:59'),
(13, 'Grading info', 'g1.2@std.com', 'Where can I find the grading rubric?', NULL, '2025-04-20 09:21:59'),
(14, 'Enroll options', 'g1.3@std.com', 'Can I enroll in two subjects at once?', NULL, '2025-04-10 13:25:59'),
(15, 'Lecture access', 'g1.3@std.com', 'How long are the recorded lectures available?', NULL, '2025-04-30 18:21:59'),
(16, 'App Download', 'g1.3@tch.com', 'Where do I download the mobile app?', NULL, '2025-04-08 17:15:59'),
(17, 'Change Grade', 'g1.3@tch.com', 'Is it possible to change my grade level?', NULL, '2025-04-14 07:45:59'),
(18, 'Quiz Policies', 'g1.2@tch.com', 'What happens if I miss a quiz deadline?', NULL, '2025-03-05 15:15:59'),
(19, 'Teacher Contact', 'g1.3@tch.com', 'How do I communicate with my teacher?', NULL, '2025-04-28 13:35:59'),
(20, 'Wishlist', 'g1.1@std.com', 'Can I save courses to a wishlist?', NULL, '2025-04-02 14:00:59'),
(21, 'Report issue', 'g1.2@std.com', 'Where do I report inappropriate content?', NULL, '2025-04-30 13:21:59'),
(22, 'Upload rules', 'g1.3@std.com', 'What are the file size limits for uploads?', NULL, '2025-02-03 13:21:59'),
(23, 'Live classes', 'g1.3@std.com', 'Are live sessions recorded?', NULL, '2025-04-04 13:26:59'),
(24, 'Discussion Boards', 'g1.1@tch.com', 'How do I join a group discussion?', NULL, '2025-04-20 13:21:59'),
(25, 'Progress Tracking', 'g1.3@tch.com', 'Can I track my progress in detail?', NULL, '2025-04-03 10:21:59'),
(26, 'Platform News', 'g1.1@tch.com', 'Where do I find platform updates?', NULL, '2025-04-16 13:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approve_date` timestamp(6) NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `title`, `description`, `subject`, `grade`, `file_path`, `uploaded_by`, `status`, `upload_date`, `approve_date`) VALUES
(17, 'History Timeline', 'Timeline of important 20th-century events.', 'History', 'Grade 10', '68050ae0c7b43_History Timeline.txt', 112, 'approved', '2025-04-20 14:55:28', '2025-04-20 14:55:28.819175'),
(18, 'calculus review', 'Comprehensive notes on derivatives and integrals.', 'Mathematics', 'Grade 10', '68050c2726f39_calculus_review.txt', 112, 'pending', '2025-04-20 15:00:55', '2025-04-20 15:00:55.160155'),
(19, 'Math101', 'math', 'Mathematics', 'Grade 10', '6805161eca739_math101.pdf', 124, 'approved', '2025-04-20 15:43:26', '2025-04-20 15:43:26.830616'),
(20, 'Math202', 'math', 'Mathematics', 'Grade 11', '6805164853b32_math202.pdf', 124, 'approved', '2025-04-20 15:44:08', '2025-04-20 15:44:08.344134'),
(21, 'Mathematical analysis', 'math', 'Mathematics', 'Grade 10', '680516c1c63b9_Mathmatical Analysis.pdf', 124, 'approved', '2025-04-20 15:46:09', '2025-04-20 15:46:09.813288'),
(22, 'Physics101', 'physics', 'Physics', 'Grade 9', '68051789ceae3_Physics101.pdf', 125, 'approved', '2025-04-20 15:49:29', '2025-04-20 15:49:29.847725'),
(23, 'Physics202', 'physics', 'Physics', 'Grade 11', '680517b5b1c26_Physics202.pdf', 125, 'approved', '2025-04-20 15:50:13', '2025-04-20 15:50:13.729100'),
(24, 'biochemical101', 'biochemical', 'Chemistry', 'Grade 9', '68051882c5de4_biochemical.pdf', 126, 'approved', '2025-04-20 15:53:38', '2025-04-20 15:53:38.812973'),
(25, 'Chemical Engineering101', 'chemical engineering', 'Chemistry', 'Grade 11', '680518ac349e0_chemical engineering.pdf', 126, 'approved', '2025-04-20 15:54:20', '2025-04-20 15:54:20.216534'),
(26, 'Mechanics Explained', 'Detailed explanation of Newton’s laws and motion.', 'Physics', 'Grade 9', '68050d4a3b0c4_mechanics_explained.txt', 113, 'approved', '2025-04-20 12:05:46', '2025-04-20 12:05:46.242857'),
(27, 'Organic Chemistry', 'Summary of reactions and functional groups.', 'Chemistry', 'Grade 9', '68050d93906df_organic_chem.docx', 113, 'pending', '2025-04-20 12:06:59', '2025-04-20 12:06:59.592843'),
(28, 'Plant Cell Guide', 'Structure and function of plant cell organelles.', 'Biology', 'Grade 12', '68050df0cd8aa_plant_cell_guide.docx', 114, 'pending', '2025-04-20 12:08:32', '2025-04-20 12:08:32.843378'),
(29, 'Genetics Summary', 'Overview of Mendelian genetics and inheritance.', 'Biology', 'Grade 12', '68050e1add0f5_genetics_summary.pptx', 114, 'approved', '2025-04-20 12:09:14', '2025-04-20 12:09:14.907566'),
(30, 'Poetry Analysis', 'Techniques for analyzing classical Arabic poetry.', 'Literature', 'Grade 12', '68050e491bd14_poetry_analysis.docx', 114, 'approved', '2025-04-20 12:10:01', '2025-04-20 12:10:01.116003'),
(31, 'Prose Breakdown', 'Themes and characters in modern Arabic prose.', 'Literature', 'Grade 11', '68050ea21269a_prose_breakdown.docx', 115, 'approved', '2025-04-20 12:11:30', '2025-04-20 12:11:30.076510'),
(32, 'World War II', 'Major events and outcomes of WWII.', 'History', 'Grade 11', '68050ef38103d_ww2_overview.docx', 115, 'approved', '2025-04-20 12:12:51', '2025-04-20 12:12:51.529429'),
(33, 'Ancient Civilizations', 'Summary of Mesopotamian and Egyptian civilizations.', 'History', 'Grade 11', '68050f046c4b3_ancient_civ.docx', 115, 'pending', '2025-04-20 12:13:08', '2025-04-20 12:13:08.444592');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `theme_preference` varchar(20) DEFAULT NULL,
  `notification_enabled` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `user_id`, `two_factor_enabled`, `theme_preference`, `notification_enabled`) VALUES
(77, 112, 0, NULL, 1),
(78, 113, 0, NULL, 1),
(79, 114, 0, NULL, 1),
(80, 115, 0, NULL, 1),
(81, 116, 0, NULL, 1),
(83, 123, 0, NULL, 1),
(84, 124, 0, NULL, 1),
(85, 125, 0, NULL, 1),
(86, 126, 0, NULL, 1),
(87, 127, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teach_id` int(11) NOT NULL,
  `major` varchar(255) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `cv` varchar(255) NOT NULL,
  `certi` varchar(255) NOT NULL,
  `about` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teach_id`, `major`, `degree`, `cv`, `certi`, `about`) VALUES
(123, 'Computer Science', 'Bachelor\'s', '68050f0c131a0_1745161996.pdf', '68050f0c13d81_1745161996.pdf', ''),
(124, 'Math', 'Master\'s', '68050f4fe6958_1745162063.pdf', '68050f4fe75ba_1745162063.pdf', ''),
(125, 'Physics', 'Ph.D.', '68050f7b59fdd_1745162107.pdf', '68050f7b5abb2_1745162107.pdf', ''),
(126, 'Chemistry', 'Ph.D.', '68050fa61e40b_1745162150.pdf', '68050fa61ed87_1745162150.pdf', ''),
(127, 'Computer Science', 'Master\'s', '6805100194819_1745162241.pdf', '68051001986a3_1745162241.pdf', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','teacher') DEFAULT 'student',
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approve_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `profile_image`, `created_at`, `approve_date`, `status`) VALUES
(112, 'sara', 'g1.1@std.com', '$2y$10$8zQTMU2isyE1zQoxiar/Cejfjhy3XW1TohBNKMQ8PINTcBJemIPyy', 'student', NULL, '2025-04-20 14:24:57', '2025-04-20 14:24:57.423301', 'approved'),
(113, 'ahmed', 'g1.2@std.com', '$2y$10$bQPEer7lrW0MtJYbEXqhrugUf/FixausznYLbRfbcGPLviBUiqWxe', 'student', NULL, '2025-04-20 14:25:12', '2025-04-20 14:25:12.133052', 'approved'),
(114, 'adam', 'g1.3@std.com', '$2y$10$HjAv0pR88ERW3MdH7BOQ6ex7qbqRBY6PiS../SAb8K271MOwibdVS', 'student', NULL, '2025-04-20 14:26:49', '2025-04-20 14:26:49.421097', 'approved'),
(115, 'mona', 'g1.4@std.com', '$2y$10$3epaMUrSSSDb.QIPAVbn3OwNtg44QNnlCrSCd5ZX3/Nwhp2MIHiI.', 'student', NULL, '2025-04-20 14:27:04', '2025-04-20 14:27:04.294241', 'approved'),
(116, 'noah', 'g1.5@std.com', '$2y$10$2bz4h1SDkO1GIOXE9QQuGu3LEEy2.R8VfHC8ckq7A9hemyXuPTiHG', 'student', NULL, '2025-04-20 14:28:09', '2025-04-20 14:28:09.834555', 'pending'),
(117, 'reem', 'reem@adm.com', '$2y$10$j3QmAsIoWiTW9R45qypp7.T71XNR2jgi0BUAsh3p3rv681Xi7eN/G', 'admin', NULL, '2025-04-20 14:31:02', '2025-04-20 14:31:02.495262', 'approved'),
(118, 'lama', 'lama@adm.com', '$2y$10$VHHATn4pv2VM8WwmPOsoDuDr9GkL4T0UD0nF5hOoSikNAuYafsnVK', 'admin', NULL, '2025-04-20 14:31:20', '2025-04-20 14:31:20.994781', 'approved'),
(119, 'abeer', 'abeer@adm.com', '$2y$10$.r6Eo7vfD1Gnk6VORu6zMO2DW1SnpbWI8KfJe2TT/Vn.QnAAqu6oq', 'admin', NULL, '2025-04-20 14:32:22', '2025-04-20 14:32:22.091263', 'approved'),
(120, 'joseph', 'g1.1@adm.com', '$2y$10$bZVtsvPK41Pv3RoliFldbuCdgIM5SUtURMaLGS.GHMGC6kzkRiAGe', 'admin', NULL, '2025-04-20 14:34:02', '2025-04-20 14:34:02.426796', 'approved'),
(121, 'nour', 'g1.2@adm.com', '$2y$10$Av9Jts19pTKPPX00VJt32ulSJbY5VbMuv9Db4xnnZWUo26m9RiTUO', 'admin', NULL, '2025-04-20 14:35:14', '2025-04-20 14:35:14.660084', 'pending'),
(123, 'omar', 'g1.1@teach.com', '$2y$10$OKH9WPMVvX6VazEAZdag7u4oX2d0Pu9nDiW0OIHnrDwd9XgCZiF6W', 'teacher', NULL, '2025-04-20 15:13:16', '2025-04-20 15:13:16.070297', 'pending'),
(124, 'bander', 'g1.2@teach.com', '$2y$10$08E7WPjKMXa.f0Abc0ebCull8Rp50u2lci8A26Bq8cgHqpAjaH3Nq', 'teacher', NULL, '2025-04-20 15:14:23', '2025-04-20 15:14:23.938110', 'approved'),
(125, 'sarah', 'g1.3@teach.com', '$2y$10$p7MzH9DGmVf5W4ymb6ID/.TtEvnrg5NH2O8FGOOgcmO/5fRTmWOr2', 'teacher', NULL, '2025-04-20 15:15:07', '2025-04-20 15:15:07.358867', 'approved'),
(126, 'reema', 'g1.4@teach.com', '$2y$10$1omAosPUeTYWnYHGGZOTmO6JC4fu4Jpc2myEaeAE4uOmiCMtoWvLy', 'teacher', NULL, '2025-04-20 15:15:50', '2025-04-20 15:15:50.118228', 'approved'),
(127, 'manal', 'g1.5@teach.com', '$2y$10$hvCm7/hYSNm8gy4wNqvrLOMWnZ52cR3ZQZr25oNB6VfU1kHUORj8a', 'teacher', NULL, '2025-04-20 15:17:21', '2025-04-20 15:17:21.602850', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teach_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teach_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `fk_uploaded_by` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `fk_teach_id` FOREIGN KEY (`teach_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`teach_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
