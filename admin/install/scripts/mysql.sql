--
-- Database: `{%database%}`
--

-- --------------------------------------------------------

--
-- Table structure for table `here_users`
--

CREATE TABLE IF NOT EXISTS `here_users` (
  `uid` SMALLINT(8) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `email` VARCHAR(64) NOT NULL,
  `nickname` VARCHAR(32) DEFAULT NULL,
  `avator` varchar(64) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `created` VARCHAR(10) NOT NULL,
  `lastlogin` VARCHAR(10) NOT NULL,
  `status` SMALLINT(8) DEFAULT NULL,
  UNIQUE KEY (`name`),
  UNIQUE KEY (`nickname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `here_options`
--

CREATE TABLE IF NOT EXISTS `here_options` (
  `name` VARCHAR(16) NOT NULL,
  `value` TEXT NOT NULL,
  `for` SMALLINT(8) DEFAULT 0,
  UNIQUE `option` (`name`, `for`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `here_posts`
--

CREATE TABLE IF NOT EXISTS `here_posts` (
  `pid` SMALLINT(8) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `author_id` SMALLINT UNSIGNED NOT NULL,
  `author` VARCHAR(32) NOT NULL,
  `created` VARCHAR(10) NOT NULL,
  `modified` VARCHAR(10) NOT NULL,
  `content` TEXT DEFAULT NULL,
  `type` VARCHAR(16) DEFAULT NULL,
  `access` VARCHAR(16) DEFAULT 'public',
  `password` VARCHAR(32) DEFAULT NULL,
  `comment_cnt` SMALLINT(8) UNSIGNED NOT NULL DEFAULT 0,
  `permission` SET('allowComment', 'allowFeed', 'allowCopy') NOT NULL,
  `parent` SMALLINT(8) UNSIGNED NULL DEFAULT 0,
  UNIQUE KEY (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `here_classify`
--

CREATE TABLE IF NOT EXISTS `here_classify` (
  `cid` SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` VARCHAR(16) NOT NULL DEFAULT 'comment',
  `value` VARCHAR(64) NOT NULL,
  `parent` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  UNIQUE KEY `category` (`type`, `value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `here_comments`
--

CREATE TABLE IF NOT EXISTS `here_comments` (
  `cid` SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `pid` SMALLINT UNSIGNED NOT NULL,
  `author` VARCHAR(32) NOT NULL,
  `email` VARCHAR(64) DEFAULT NULL,
  `url` VARCHAR(64) DEFAULT NULL,
  `created` VARCHAR(10) NOT NULL,
  `ip` VARCHAR(64) DEFAULT NULL,
  `agent` VARCHAR(128) DEFAULT NULL,
  `content` TEXT NOT NULL,
  `approved` VARCHAR(8) NOT NULL DEFAULT 'wait',
  `parent` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  UNIQUE KEY `comment` (`created`, `ip`, `agent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------