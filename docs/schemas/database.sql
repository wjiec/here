--
-- Table structure for table `authors`
--
drop table if exists `authors`;
create table if not exists `authors` (
  `author_id` serial not null primary key auto_increment,
  `author_email` varchar(64) not null default '',
  `author_username` varchar(64) not null default '',
  `author_password` varchar(128) not null default '',
  `author_nickname` varchar(64) not null default '',
  `author_avatar` varchar(255) not null default '',
  `author_introduction` varchar(255) not null default '',
  `two_factor_auth` bool not null default false,
  `author_create_time` datetime not null default now(),
  `last_login_time` datetime not null default now(),
  `last_login_address` varchar(64) not null default '',

  index (`author_email`),
  unique key (`author_username`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `configuration_options`
--
drop table if exists `configuration_options`;
create table if not exists `configuration_options` (
  `option_id` serial not null primary key auto_increment,
  `option_name` varchar(128) not null,
  `option_value` varchar(255) not null,
  `create_time` datetime not null default now()
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `articles`
--
drop table if exists `articles`;
create table if not exists `articles` (
  `article_id` serial not null primary key auto_increment,
  `author_id` int not null,
  -- article info
  `article_title` varchar(128) not null,
  `article_description` varchar(255) not null default '',
  `article_contents` text not null,
  -- category info
  `group_id` int default null,
  `category_id` int not null default 0,
  -- meta info
  `private` boolean not null default true,
  `article_status` enum('DRAFT', 'PUBLISHED') not null default 'DRAFT',
  `view_password` varchar(64) default null,
  `close_comment` boolean not null default false,
  `license_id` int default null default 0,
  -- time info
  `create_time` datetime not null default now(),
  `update_time` datetime not null default now(),

  index (`author_id`),
  index (`group_id`),
  index (`category_id`),
  index (`license_id`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_categories`
--
drop table if exists `article_categories`;
create table if not exists `article_categories` (
  `category_id` serial not null primary key auto_increment,
  `category_name` varchar(128) not null,
  `category_description` varchar(255) not null default '',
  `create_time` datetime not null default now(),
  `parent_id` int not null default 0,

  index (`parent_id`),
  unique key (`category_name`, `parent_id`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_groups`
--
drop table if exists `article_groups`;
create table if not exists `article_groups` (
  `group_id` serial not null primary key auto_increment,
  `group_name` varchar(128) not null,
  `group_description` varchar(255) not null default '',
  `create_time` datetime not null default now(),
  `parent_id` int not null default 0,

  index (`parent_id`),
  unique key (`group_name`, `parent_id`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_licenses`
--
drop table if exists `article_licenses`;
create table if not exists `article_licenses` (
  `license_id` serial not null primary key auto_increment,
  `license_key` varchar(64) not null,
  `license_name` varchar(255) default null,
  `license_contents` text not null,

  unique key (`license_key`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_comments`
--
drop table if exists `article_comments`;
create table if not exists `article_comments` (
  `comment_id` serial not null primary key auto_increment,
  `article_id` int not null,
  `author_name` varchar(128) not null,
  `email` varchar(128) not null,
  `ip_address` varchar(64) not null default '',
  `user_agent` varchar(255) not null default '',
  `comment_contents` text not null,
  `status` enum('PENDING', 'AUTO_SPAMMED', 'USER_SPAMMED', 'COMMENTED') not null default 'PENDING',
  `parent_id` int not null default 0,
  `create_time` datetime not null default now(),

  index (`article_id`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_analyses`
--
drop table if exists `article_analyses`;
create table if not exists `article_analyses` (
  `analysis_id` serial not null primary key auto_increment,
  `article_id` int not null,
  `view_count` int not null default 0,
  `like_count` int not null default 0,
  `create_time` datetime not null default now(),

  unique key (`article_id`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `viewer_analyses`
--
drop table if exists `viewer_analyses`;
create table if not exists `viewer_analyses` (
  `viewer_id` serial not null primary key auto_increment,
  `viewer_ip_address` varchar(64) not null default '',
  `viewer_user_agent` varchar(255) not null default '',
  `viewer_view_page` varchar(255) not null default '',
  `viewer_referer` varchar(255) not null default '',
  `create_time` datetime not null default now()
) engine=Innodb default charset=utf8mb4 auto_increment=1;
