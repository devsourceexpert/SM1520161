--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `academic_year_id` int(11) NOT NULL,
  `from_year` year(4) NOT NULL,
  `to_year` year(4) NOT NULL,
  `institute_id` bigint(20) NOT NULL,
  `active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`academic_year_id`, `from_year`, `to_year`, `institute_id`, `active`) VALUES
(1, 2015, 2016, 0, 'Y'),
(3, 2014, 2018, 0, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `education_boards`
--

CREATE TABLE `education_boards` (
  `board_id` bigint(20) NOT NULL,
  `board_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `education_boards`
--

INSERT INTO `education_boards` (`board_id`, `board_name`, `active`, `date_created`) VALUES
(3, 'Test Boad JithieeshRRR', 'Y', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `institute_id` bigint(20) NOT NULL,
  `institute_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`institute_id`, `institute_name`, `active`, `date_created`) VALUES
(2, 'TESY Indian', 'Y', '0000-00-00 00:00:00'),
(5, 'My Institute Jithieesh Vad', 'Y', '0000-00-00 00:00:00'),
(6, 'TESY Indian TES ', 'Y', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` bigint(20) NOT NULL,
  `institute_id` bigint(20) NOT NULL,
  `section_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `institute_id`, `section_name`, `active`, `date_created`) VALUES
(1, 0, 'Test Section Jithieesh', 1, '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`academic_year_id`);

--
-- Indexes for table `education_boards`
--
ALTER TABLE `education_boards`
  ADD PRIMARY KEY (`board_id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`institute_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `academic_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `education_boards`
--
ALTER TABLE `education_boards`
  MODIFY `board_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `institute_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- Saravanan 31-JAN-2016 8L39PM 

CREATE TABLE `academic_courses` (
  `academic_course_id` bigint(20) NOT NULL,
  `academic_year_id` bigint(20) NOT NULL COMMENT 'refer academic_years',
  `course_name` varchar(100) NOT NULL,
  `from_month` int(11) NOT NULL,
  `to_month` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `academic_subjects` (
  `academic_subject_id` bigint(20) NOT NULL,
  `academic_year_id` bigint(20) NOT NULL,
  `subject_name` varchar(150) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `courses_subjects` (
  `course_subject_id` bigint(20) NOT NULL,
  `academic_course_id` bigint(20) NOT NULL,
  `academic_subject_id` bigint(20) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_courses`
--
ALTER TABLE `academic_courses`
  ADD PRIMARY KEY (`academic_course_id`);

--
-- Indexes for table `academic_subjects`
--
ALTER TABLE `academic_subjects`
  ADD PRIMARY KEY (`academic_subject_id`);

--
-- Indexes for table `courses_subjects`
--
ALTER TABLE `courses_subjects`
  ADD PRIMARY KEY (`course_subject_id`);

-- Saravanan -06-FEB-2016
ALTER TABLE `users` ADD `institute_id` BIGINT NOT NULL AFTER `active`;

-- Vadivel -16-FEB-2016
ALTER TABLE `users`  ADD `user_type` INT(1) NOT NULL COMMENT '0-dse_admin/1-Institute(admin)/2-Student/3-Parent'  AFTER `institute_id`;