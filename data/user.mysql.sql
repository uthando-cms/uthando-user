
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
    `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
     `firstname` varchar(128) NOT NULL,
    `lastname` varchar(128) NOT NULL,
    `email` varchar(255) NOT NULL,
    `passwd` char(40) NOT NULL,
    `role` varchar(100) NOT NULL DEFAULT 'registered',
    `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`userId`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `userRegistration` (
    `userId` int(10) unsigned NOT NULL,
    `token` varchar(16) NOT NULL,
    `requestTime` datetime NOT NULL,
    `responded` tinyint(4) NOT NULL DEFAULT 0,
    PRIMARY KEY (`userId`),
    UNIQUE KEY `userId_UNIQUE` (`userId`),
    UNIQUE KEY `token_UNIQUE` (`token`),
    CONSTRAINT `userRegistration_fk1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8