--
-- Βάση δεδομένων: `school-exams`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `controller`
--

CREATE TABLE `controller` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `proponent`
--

CREATE TABLE `proponent` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `question`
--

CREATE TABLE `question` (
  `ID` int(10) NOT NULL,
  `presentation` text NOT NULL,
  `situation` varchar(30) NOT NULL,
  `difficalty` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `question_choices`
--

CREATE TABLE `question_choices` (
  `ID` int(10) NOT NULL,
  `question_ID` int(10) NOT NULL,
  `choice` text NOT NULL,
  `right_response` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `question_turnon`
--

CREATE TABLE `question_turnon` (
  `ID` int(10) NOT NULL,
  `question_ID` int(10) NOT NULL,
  `classroom` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `student`
--

CREATE TABLE `student` (
  `username` int(30) NOT NULL,
  `password` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `district` varchar(30) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `school` int(10) NOT NULL,
  `classroom` varchar(20) NOT NULL,
  `department` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `student_do_test`
--

CREATE TABLE `student_do_test` (
  `ID` int(10) NOT NULL,
  `student_username` varchar(30) NOT NULL,
  `test_ID` int(10) NOT NULL,
  `degree` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `teacher`
--

CREATE TABLE `teacher` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `test`
--

CREATE TABLE `test` (
  `ID` int(10) NOT NULL,
  `teacher_username` varchar(30) NOT NULL,
  `classroom` varchar(30) NOT NULL,
  `negative_rating` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `test_has_question`
--

CREATE TABLE `test_has_question` (
  `ID` int(10) NOT NULL,
  `test_ID` int(10) NOT NULL,
  `question_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `controller`
--
ALTER TABLE `controller`
  ADD PRIMARY KEY (`username`);

--
-- Ευρετήρια για πίνακα `proponent`
--
ALTER TABLE `proponent`
  ADD PRIMARY KEY (`username`);

--
-- Ευρετήρια για πίνακα `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`ID`);

--
-- Ευρετήρια για πίνακα `question_choices`
--
ALTER TABLE `question_choices`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `question_ID` (`question_ID`);

--
-- Ευρετήρια για πίνακα `question_turnon`
--
ALTER TABLE `question_turnon`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `question_ID` (`question_ID`);

--
-- Ευρετήρια για πίνακα `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`username`);

--
-- Ευρετήρια για πίνακα `student_do_test`
--
ALTER TABLE `student_do_test`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `student_username` (`student_username`),
  ADD KEY `test_ID` (`test_ID`);

--
-- Ευρετήρια για πίνακα `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`username`);

--
-- Ευρετήρια για πίνακα `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `teacher_username` (`teacher_username`);

--
-- Ευρετήρια για πίνακα `test_has_question`
--
ALTER TABLE `test_has_question`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `question_choices`
--
ALTER TABLE `question_choices`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `question_turnon`
--
ALTER TABLE `question_turnon`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `student_do_test`
--
ALTER TABLE `student_do_test`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `test`
--
ALTER TABLE `test`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `test_has_question`
--
ALTER TABLE `test_has_question`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
