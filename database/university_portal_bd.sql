-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 04:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_portal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL COMMENT 'id of the announcement',
  `user_id` int(11) NOT NULL COMMENT 'id of the teacher',
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'the time the announcement was posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'present/ absent',
  `scaned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `session_id`, `status`, `scaned_at`) VALUES
(0, 1, 1, 'present', '2026-03-25 09:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_session`
--

CREATE TABLE `attendance_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qr_token` varchar(100) NOT NULL COMMENT 'UNIQUE QR CODE FOR THIS SESSION',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'WHEN THE QR WAS GENERATED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_session`
--

INSERT INTO `attendance_session` (`id`, `user_id`, `qr_token`, `created_at`) VALUES
(1, 2, 'ABC123', '2026-03-25 09:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `value` float NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'technical id for the db',
  `identifier` varchar(20) NOT NULL COMMENT 'employee id/ matricule',
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'timestamp for creation of the account'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `identifier`, `password`, `role`, `first_name`, `last_name`, `email`, `created`) VALUES
(1, 'S001', '1234', 'student', 'ali', 'ben', 'ali@test.com', '2026-03-25 09:37:54'),
(2, 'T001', '1234', 'teacher', 'sara', 'prof', 'sara@test.com', '2026-03-25 09:39:32'),
(19, '242431577219', 'Dekrah', 'Lakehal', 'lakehaldekrah@test.com', NOW()),
(20, '232335330411', 'Imen', 'Zighed', 'zighedimen@test.com', NOW()),
(21, '242431422801', 'Meriem', 'Ramoul', 'ramoulmeriem@test.com', NOW()),
(22, '232331412506', 'Issam', 'Bearcia', 'bearciaissam@test.com', NOW()),
(23, '232335117207', 'Abderrahmane', 'Lagraa', 'lagraaabderrahmane@test.com', NOW()),
(24, '232334477208', 'Abderraouf', 'Meziani', 'mezianiabderraouf@test.com', NOW()),
(25, '232335477209', 'Yasser', 'Boukhari', 'boukhariyasser@test.com', NOW()),
(26, '232335817210', 'Djalil', 'Laib', 'laibdjalil@test.com', NOW()),
(27, '232335487211', 'Sarah', 'Moussous', 'moussoussarah@test.com', NOW()),
(28, '232335677212', 'Israa', 'Haif', 'haifisraa@test.com', NOW()),
(29, '232335477213', 'Litissia', 'Idjoubar', 'idjoubarlitissia@test.com', NOW()),
(30, '232331531201', 'Lina', 'Larbi', 'larbilina@test.com', NOW()),
(31, '232335477214', 'Noura', 'Lasledj', 'lasledjnoura@test.com', NOW()),
(32, '232335477215', 'Ichrak', 'Souidi', 'souidiichrak@test.com', NOW()),
(33, '232335477216', 'Chaima', 'Boutrah', 'boutrahchaima@test.com', NOW()),
(34, '232335477217', 'Fatima', 'Boudani', 'boudanifatima@test.com', NOW()),
(35, '232335477218', 'Marwa', 'Boulahbal', 'boulahbalmarwa@test.com', NOW()),
(36, '232335477219', 'Bouchra', 'Benaissa', 'benaissabouchra@test.com', NOW()),
(37, '242431433019', 'Lyna', 'Bousbaa', 'bousbaalyna@test.com', NOW()),
(38, '242431433013', 'Ikram', 'Boutine', 'boutineikram@test.com', NOW()),
(39, '232331740411', 'Haoua', 'Bouhadda', 'bouhaddahaoua@test.com', NOW()),
(40, '232331418809', 'Aicha', 'Gharbi', 'gharbiaicha@test.com', NOW()),
(41, '232335477220', 'Lina', 'Boumediene', 'boumedienelina@test.com', NOW()),
(42, '232335477221', 'Hadil', 'Khalfoun', 'khalfounhadil@test.com', NOW()),
(43, '232335477222', 'Amina', 'Rouibah', 'rouibahamina@test.com', NOW()),
(44, '232335477223', 'Salsabil', 'Doudou', 'doudousalsabil@test.com', NOW()),
(45, '232335477224', 'Farah', 'Benguesmia', 'benguesmiafarah@test.com', NOW()),
(46, '232335477225', 'Nessrine', 'Tsamda', 'tsamdanessrine@test.com', NOW()),
(47, '232335477226', 'Serine', 'Meziani', 'mezianiserine@test.com', NOW()),
(48, '232335477227', 'Ikram', 'Aktouf', 'aktoufikram@test.com', NOW()),
(49, '232335477228', 'Nourelhouda', 'Bouhadja', 'bouhadjanourelhouda@test.com', NOW()),
(50, '232335477429', 'Fatima', 'Mekki', 'mekkifatima@test.com', NOW()),
(51, '202334546565', 'Douaa', 'Baouz', 'baouzdouaa@test.com', NOW()),
(52, '242431777702', 'Ines', 'Hammadou', 'hammadouines@test.com', NOW()),
(53, '232431531515', 'Celina', 'Rebehi', 'rebehicelina@test.com', NOW()),
(54, '232331503216', 'Yasmine', 'Memmeri', 'memmeriyasmine@test.com', NOW()),
(55, '242431777714', 'Nour', 'Medjdoubi', 'medjdoubinour@test.com', NOW()),
(56, '202356912311', 'Mohamed', 'Temam', 'temammohamed@test.com', NOW()),
(57, '232432127761', 'Adlane', 'Boukhari', 'boukhariadlane@test.com', NOW()),
(58, '242431232454', 'Younes', 'Amor', 'amoryounes@test.com', NOW()),
(59, '242435521162', 'Oussama', 'Ferrani', 'ferranioussama@test.com', NOW()),
(60, '242431475712', 'Melina', 'Mahdi', 'mahdimelina@test.com', NOW()),
(61, '232331717713', 'Mohamed', 'Mahdi', 'mahdimohamed@test.com', NOW()),
(62, '242431622106', 'Wassim', 'Messaoudi', 'messaoudiwassim@test.com', NOW()),
(63, '232331698617', 'Mohyiddine', 'Boudraf', 'boudrafmohyiddine@test.com', NOW()),
(64, '242431368913', 'Abdelmalek', 'Ait Kaci', 'aitkaciabdelmalek@test.com', NOW()),
(65, '242431244569', 'Abde Allah', 'Chaouadi', 'chaouadiabdeallah@test.com', NOW()),
(66, '234256421211', 'Ahmed', 'Remram', 'remramahmed@test.com', NOW()),
(67, '232454321519', 'Abderrahmane', 'Derradji', 'derradjiabderrahmane@test.com', NOW()),
(68, '212431859912', 'Melissa', 'Abaoui', 'abaouimelissa@test.com', NOW()),
(69, '232335477206', 'Maroua', 'Bouderraz', 'bouderrazmaroua@test.com', NOW()),
(70, '242431438719', 'Aya', 'Aitouamar', 'aitouamaraya@test.com', NOW()),
(71, '232331413601', 'Yousra', 'Aissaoui', 'aissaouiyousra@test.com', NOW()),
(72, '242431414302', 'Rahma', 'Cherifi', 'cherifirahma@test.com', NOW()),
(73, '232333087110', 'Melissa', 'Azzoug', 'azzougmelissa@test.com', NOW()),
(74, '232335051703', 'Ayat', 'Diafi', 'diafiayat@test.com', NOW()),
(75, '222231345706', 'Aya', 'Ben Aissa Cherif', 'benaissacherifaya@test.com', NOW()),
(76, '232331734515', 'Imededdine', 'Khettab', 'khettabimededdine@test.com', NOW()),
(77, '242431370909', 'Imededdine', 'Aissaoui', 'aissaouiimededdine@test.com', NOW()),
(78, '242431696012', 'Wassim', 'Selama', 'selamawassim@test.com', NOW()),
(79, '232331734201', 'Oussama', 'Temlali', 'temlalioussama@test.com', NOW()),
(80, '232331532706', 'Racim', 'Laidi', 'laidiracim@test.com', NOW()),
(81, '232431844615', 'Zakaria', 'Madi', 'madizakaria@test.com', NOW()),
(82, '242439340418', 'Anes', 'Nasri', 'nasrianes@test.com', NOW()),
(83, '242435427010', 'Abdelhak', 'Yessad', 'yessadabdelhak@test.com', NOW()),
(84, '232331481012', 'Ilyes', 'Zergoun', 'zergounilyes@test.com', NOW()),
(85, '232331394803', 'Rayan', 'Zahed', 'zahedrayan@test.com', NOW()),
(86, '232431546203', 'Maya', 'Abbas', 'abbasmaya@test.com', NOW()),
(87, '232331544604', 'Hanane', 'Boukerdous', 'boukerdoushanane@test.com', NOW()),
(88, '242431618608', 'Melyna', 'Lamara', 'lamaramelyna@test.com', NOW()),
(89, '242431731319', 'Yousef', 'Menia', 'meniayousef@test.com', NOW()),
(90, '242431624311', 'Anes', 'Tata', 'tataanes@test.com', NOW()),
(91, '242431370913', 'Mohamed', 'Saidani', 'saidanimohamed@test.com', NOW()),
(92, '242431577510', 'Abdenour', 'Akacem', 'akacemabdenour@test.com', NOW()),
(93, '242431596506', 'Nacim', 'Tayeb', 'tayebnacim@test.com', NOW()),
(94, '242431748813', 'Maya', 'Zeraia', 'zeraiamaya@test.com', NOW()),
(95, '242431597817', 'Imene', 'Belabed', 'belabedimene@test.com', NOW()),
(96, '242431616006', 'Cerine', 'Guettache', 'guettachecerine@test.com', NOW()),
(97, '242431679715', 'Anais', 'Dahmani', 'dahmanianais@test.com', NOW()),
(98, '242431676416', 'Sara', 'Abdellatif', 'abdellatifsara@test.com', NOW()),
(99, '242431486807', 'Maria', 'Khellas', 'khellasmaria@test.com', NOW()),
(100, '232331698506', 'Islam', 'Saadi', 'saadiislam@test.com', NOW()),
(101, '232331595914', 'Chaima', 'Ouldedine', 'ouldedinechaima@test.com', NOW()),
(102, '242456893215', 'Imene', 'Seray', 'serayimene@test.com', NOW()),
(103, '242431617181', 'Nihad', 'Aissa', 'aissanihad@test.com', NOW()),
(104, '232354621982', 'Yasmine', 'Belabrik', 'belabrikyasmine@test.com', NOW()),
(105, '232332170007', 'Nour', 'Ammiche', 'ammichenour@test.com', NOW()),
(106, '242431460816', 'Mohamed', 'Benbachir', 'benbachirmohamed@test.com', NOW()),
(107, '242431572917', 'Islam', 'Tas', 'tasislam@test.com', NOW()),
(108, '242431597707', 'Achraf', 'Djennadi', 'djennadiachraf@test.com', NOW()),
(109, '242431598307', 'Fares', 'Cherfaoui', 'cherfaouifares@test.com', NOW()),
(110, '222231412710', 'Ayoub', 'Lamara', 'lamaraayoub@test.com', NOW()),
(111, '232331431614', 'Mohamed', 'Mekdam', 'mekdammohamed@test.com', NOW()),
(112, '232331602210', 'Ouiam', 'Mechai', 'mechaiouiam@test.com', NOW()),
(113, '232346621132', 'Houssem', 'Ferkous', 'ferkoushoussem@test.com', NOW()),
(114, '242431575703', 'Meriem', 'Khelil', 'khelilmeriem@test.com', NOW()),
(115, '242431591407', 'Ikram', 'Merar', 'merarikram@test.com', NOW()),
(116, '9dza20982', 'Malak', 'Madjen', 'madjenmalak@test.com', NOW()),
(117, '232331388007', 'Imadeddine', 'Bara', 'baraimadeddine@test.com', NOW()),
(118, '242431453208', 'Kamel', 'Alim', 'alimkamel@test.com', NOW()),
(119, '242431596411', 'Nada', 'Bencheikh', 'bencheikhnada@test.com', NOW()),
(120, '232331692611', 'Rania', 'Benamara', 'benamararania@test.com', NOW()),
(121, '232331430814', 'Douaa', 'Ramdani', 'ramdanidouaa@test.com', NOW()),
(122, '232331601509', 'Sirine', 'Hamiti', 'hamitisirine@test.com', NOW()),
(123, '232331406306', 'Yousra', 'Djahel', 'djahelyousra@test.com', NOW()),
(124, '232431847516', 'Damia', 'Ziane', 'zianedamia@test.com', NOW()),
(125, '242431423103', 'Nihal', 'Ferrah', 'ferrahnihal@test.com', NOW()),
(126, '242431621102', 'Abderraouf', 'Hafi', 'hafiabderraouf@test.com', NOW()),
(127, '242431624503', 'Hocine', 'Hasni', 'hasnihocine@test.com', NOW()),
(128, '242431622804', 'Sid Aali', 'Bettayeb', 'bettayebsidaali@test.com', NOW()),
(129, '242431621819', 'Mehdi', 'Ouferhat', 'ouferhatmehdi@test.com', NOW()),
(130, '242431461919', 'Imad', 'Slimani', 'slimaniimad@test.com', NOW()),
(131, '242431577705', 'Mohamed', 'Bouktite', 'bouktitemohamed@test.com', NOW()),
(132, '232331621308', 'Lina', 'Boukhalfa', 'boukhalfalina@test.com', NOW()),
(133, '242431559810', 'Imene', 'Meddour', 'meddourimene@test.com', NOW()),
(134, '232331453804', 'Yasmine', 'Hersous', 'hersousyasmine@test.com', NOW()),
(135, '232331488404', 'Safia', 'Chergui', 'cherguisafia@test.com', NOW()),
(136, '232431535911', 'Kenza', 'Mouzaoui', 'mouzaouikenza@test.com', NOW()),
(137, '232331553511', 'Abdelkrim', 'Brahimi', 'brahimiabdelkrim@test.com', NOW()),
(138, '222231609707', 'Youcef', 'Abdellaoui', 'abdellaouiyoucef@test.com', NOW()),
(139, '232431652101', 'Mouhamed', 'Bessaa', 'bessaamouhamed@test.com', NOW()),
(140, '232432511703', 'Mohamed', 'Khelifa', 'khelifamohamed@test.com', NOW()),
(141, '242431398806', 'Hichem', 'Ouarezki', 'ouarezkihichem@test.com', NOW()),
(142, '232331740006', 'Yakoub', 'Beddiaf', 'beddiafyakoub@test.com', NOW()),
(143, '232331430512', 'Aouis', 'Kadri', 'kadriaouis@test.com', NOW()),
(144, '232331674811', 'Mohamed', 'Mostefa', 'mostefamohamed@test.com', NOW()),
(145, '242431367805', 'Ahmed', 'Nedir', 'nedirahmed@test.com', NOW()),
(146, '242431454420', 'Walid', 'Dridi', 'dridiwalid@test.com', NOW()),
(147, '242431680417', 'Walid', 'Zerkouk', 'zerkoukwalid@test.com', NOW()),
(148, '242431562616', 'Mohammed', 'Maouche', 'maouchemohammed@test.com', NOW()),
(149, '242431680215', 'Mohammed', 'Touat', 'touatmohammed@test.com', NOW()),
(150, '212334476891', 'Souheil', 'Nid', 'nidsouheil@test.com', NOW()),
(151, '232335457288', 'Newfel', 'Skender', 'skendernewfel@test.com', NOW()),
(152, '232421065798', 'Mehdi', 'Azzouzi', 'azzouzimehdi@test.com', NOW()),
(153, '212445520678', 'Salem', 'Madiou', 'madiousalem@test.com', NOW()),
(154, '232331659203', 'Anis', 'Slimani', 'slimanianis@test.com', NOW()),
(155, '242431675005', 'El Walid', 'Benyahia', 'benyahiaelwalid@test.com', NOW()),
(156, '242431599204', 'Akram', 'Abdelhamid', 'abdelhamidakram@test.com', NOW()),
(157, '232331650909', 'Zitouni', 'Saber', 'saberzitouni@test.com', NOW());
--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `attendance_session`
--
ALTER TABLE `attendance_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_session`
--
ALTER TABLE `attendance_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'technical id for the db', AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `attendance_session` (`id`);

--
-- Constraints for table `attendance_session`
--
ALTER TABLE `attendance_session`
  ADD CONSTRAINT `attendance_session_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`);

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;