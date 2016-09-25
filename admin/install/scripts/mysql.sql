--
-- Database: `{%database%}`
--

-- --------------------------------------------------------

--
-- Table structure for table `here_users`
--

CREATE TABLE IF NOT EXISTS `here_users` (
  `uid` SMALLINT(4) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `email` VARCHAR(64) NOT NULL,
  `nickname` VARCHAR(32) DEFAULT NULL,
  `avatar` varchar(64) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `created` VARCHAR(10) NOT NULL,
  `lastlogin` VARCHAR(10) NOT NULL,
  `state` ENUM('online', 'offline') DEFAULT NULL,
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
  `for` SMALLINT(8) NOT NULL DEFAULT 0,
  UNIQUE `option` (`name`, `for`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `here_articles`
--

CREATE TABLE IF NOT EXISTS `here_articles` (
  `pid` SMALLINT(8) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL,
-- article url: automatic Translation or custom
  `url` VARCHAR(256) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `author_id` SMALLINT UNSIGNED NOT NULL,
  `author` VARCHAR(32) DEFAULT NULL,
  `created` VARCHAR(10) NOT NULL,
  `modified` VARCHAR(10) NOT NULL,
  `contents` TEXT DEFAULT NULL,
-- article type: eg. article, note(like gist), source code, ...
  `type` VARCHAR(16) DEFAULT NULL,
-- access permissions: public or private
  `access` VARCHAR(16) DEFAULT 'public',
  `password` VARCHAR(32) DEFAULT NULL,
  `comments_cnt` SMALLINT(8) UNSIGNED NOT NULL DEFAULT 0,
  `attribute` SET('closeComment', 'disableReproduce', 'allowCopy') DEFAULT NULL,
-- article category: foreign key constraint, default -> default
  `parent` SMALLINT(4) UNSIGNED NULL DEFAULT 1,
  UNIQUE KEY (`title`, `url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `here_classify`
--

CREATE TABLE IF NOT EXISTS `here_classify` (
  `cid` SMALLINT(4) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `value` VARCHAR(64) NOT NULL,
  `parent` SMALLINT(4) UNSIGNED NOT NULL DEFAULT 0,
  UNIQUE KEY `category` (`value`, `parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `here_comments`
--

CREATE TABLE IF NOT EXISTS `here_comments` (
  `cid` INT(8) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `pid` SMALLINT(8) UNSIGNED NOT NULL,
  `author` VARCHAR(32) NOT NULL,
  `email` VARCHAR(64) DEFAULT NULL,
  `url` VARCHAR(64) DEFAULT NULL,
  `created` VARCHAR(10) NOT NULL,
  `ip` VARCHAR(64) DEFAULT NULL,
  `agent` VARCHAR(128) DEFAULT NULL,
  `content` TEXT NOT NULL,
-- comment state: pending, approved, deny
  `state` VARCHAR(8) NOT NULL DEFAULT 'pending',
-- reply comment
  `parent` INT(8) UNSIGNED NOT NULL DEFAULT 0,
  UNIQUE KEY `comment` (`created`, `ip`, `agent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------