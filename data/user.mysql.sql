
SET FOREIGN_KEY_CHECKS=0;

--
-- Database: `charisma-beads`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `userId` int(10) UNSIGNED NOT NULL,
    `firstname` varchar(128) NOT NULL,
    `lastname` varchar(128) NOT NULL,
    `email` varchar(255) NOT NULL,
    `passwd` varchar(128) NOT NULL,
    `role` varchar(100) NOT NULL DEFAULT 'registered',
    `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `active` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONS FOR TABLE `user`:
--

-- --------------------------------------------------------

--
-- Table structure for table `userRegistration`
--

DROP TABLE IF EXISTS `userRegistration`;
CREATE TABLE `userRegistration` (
    `userRegistrationId` int(11) UNSIGNED NOT NULL,
    `userId` int(10) UNSIGNED NOT NULL,
    `token` varchar(16) NOT NULL,
    `requestTime` datetime NOT NULL,
    `responded` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONS FOR TABLE `userRegistration`:
--   `userId`
--       `user` -> `userId`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
ADD PRIMARY KEY (`userId`),
ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `userRegistration`
--
ALTER TABLE `userRegistration`
ADD PRIMARY KEY (`userRegistrationId`),
ADD UNIQUE KEY `token_UNIQUE` (`token`),
ADD UNIQUE KEY `userId` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2813;
--
-- AUTO_INCREMENT for table `userRegistration`
--
ALTER TABLE `userRegistration`
MODIFY `userRegistrationId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `userRegistration`
--
ALTER TABLE `userRegistration`
ADD CONSTRAINT `userRegistration_fk1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
