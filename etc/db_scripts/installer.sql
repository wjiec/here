--
-- Database: `{%database%}`
--

-- --------------------------------------------------------

--
-- Table structure for table `here_users`
--

CREATE TABLE IF NOT EXISTS `here_users` (
-- user id
  `uid` SMALLINT(4) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
-- user name
  `name` VARCHAR(32) NOT NULL,
-- user password
  `password` VARCHAR(64) NOT NULL,
-- user email
  `email` VARCHAR(64) NOT NULL,
-- display name
  `nickname` VARCHAR(32) DEFAULT NULL,
-- avatar address
  `avatar` varchar(128) DEFAULT NULL,
-- user description
  `description` TEXT DEFAULT NULL,
-- register timestamp
  `created` VARCHAR(10) NOT NULL,
-- last login timestamp
  `last_login` VARCHAR(10) NOT NULL,
  UNIQUE KEY (`name`),
  UNIQUE KEY (`nickname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `here_options`
--

CREATE TABLE IF NOT EXISTS `here_options` (
-- key
  `name` VARCHAR(16) NOT NULL,
-- value
  `value` TEXT NOT NULL,
-- for which the user, 0 => 'all users'
  `for` SMALLINT(8) NOT NULL DEFAULT 0,
  UNIQUE `option` (`name`, `for`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `here_articles`
--

CREATE TABLE IF NOT EXISTS `here_articles` (
-- article id
  `aid` SMALLINT(8) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
-- article title
  `title` VARCHAR(128) NOT NULL,
-- article url: automatic Translation or custom
  `url` VARCHAR(128) NOT NULL,
-- article description, allow null
  `description` TEXT DEFAULT NULL,
-- thia article author-id
  `author_id` SMALLINT UNSIGNED NOT NULL,
-- author name
  `author` VARCHAR(32) DEFAULT NULL,
-- created timestamp
  `created` VARCHAR(16) NOT NULL,
-- Last modification timestamp
  `last_modify` VARCHAR(16) NOT NULL,
-- this article contents
  `contents` TEXT DEFAULT NULL,
-- article type: eg. article, note(like gist), source code, ...
  `type` VARCHAR(16) DEFAULT NULL,
-- access permissions: public or private
  `access` VARCHAR(16) DEFAULT 'public',
-- if this article need password
  `password` VARCHAR(32) DEFAULT NULL,
-- number of comments
  `comments_cnt` SMALLINT(8) UNSIGNED NOT NULL DEFAULT 0,
-- article attributes
  `attribute` SET('close_comment', 'disable_reproduce', 'allow_copy') DEFAULT NULL,
-- article category: foreign key constraint, default -> 'default'
  `parent` SMALLINT(4) UNSIGNED NULL DEFAULT 1,
-- previous article id
  `prev_article_id` SMALLINT(8) UNSIGNED DEFAULT NULL,
-- next article id
  `next_article_id` SMALLINT(8) UNSIGNED DEFAULT NULL,
  UNIQUE KEY (`title`, `url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `here_classify`
--

CREATE TABLE IF NOT EXISTS `here_classify` (
-- classify id
  `cid` SMALLINT(4) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
-- classify name
  `classify_name` VARCHAR(64) NOT NULL,
-- classify parent id
  `parent` SMALLINT(4) UNSIGNED NOT NULL DEFAULT 0,
  UNIQUE KEY `category` (`classify_name`, `parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `here_comments`
--

CREATE TABLE IF NOT EXISTS `here_comments` (
  `cid` INT(8) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `aid` SMALLINT(8) UNSIGNED NOT NULL,
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
  UNIQUE KEY `comment` (`aid`, `author`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------
