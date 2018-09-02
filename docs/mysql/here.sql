--
-- database `here`
--


-- ----------------------------------------------


--
-- Table structure for table `users`
--
drop table if exists `users`;
create table if not exists `users` (
  `serial_id` serial not null primary key auto_increment,
  `username` varchar(64) not null,
  `password` varchar(128) not null,
  `email` varchar(64) not null,
  `nickname` varchar(64) default null,
  `user_avatar` text default null,
  `user_introduction` text default null,
  `create_time` datetime not null default now(),
  `last_login_time` datetime not null default now(),
  `last_login_ip_address` int not null default 0,
  `two_factor_auth` bool not null default false,

  unique key `user_unique` (`username`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `articles`
--
drop table if exists `articles`;
create table if not exists `articles` (
  `serial_id` serial not null primary key auto_increment,
  `article_title` varchar(128) not null,
  `article_description` text default null,
  `author_id` int not null,
  `create_time` datetime not null default now(),
  `update_time` datetime not null default now(),
  `article_contents` json default null,
  `category_id` int not null default 0,
  `private` boolean not null default true,
  `article_status` enum('DRAFT', 'PUBLISHED') not null default 'DRAFT',
  `password` varchar(64) default null,
  `close_comment` boolean not null default false,
  `license_id` int default null,
  `group_id` int default null
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_categories`
--
drop table if exists `article_categories`;
create table if not exists `article_categories` (
  `serial_id` serial not null primary key auto_increment,
  `category_name` varchar(128) not null,
  `category_description` text default null,
  `create_time` datetime not null default now(),
  `parent_id` int not null default 0,

  unique key `article_category_unique` (`category_name`, `parent_id`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_groups`
--
drop table if exists `article_groups`;
create table if not exists `article_groups` (
  `serial_id` serial not null primary key auto_increment,
  `group_name` varchar(128) not null,
  `group_description` text default null,
  `create_time` datetime not null default now(),
  `parent_id` int not null default 0,

  unique key `article_group_unique` (`group_name`, `parent_id`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_licenses`
--
drop table if exists `article_licenses`;
create table if not exists `article_licenses` (
  `serial_id` serial not null primary key auto_increment,
  `license_key` varchar(64) not null,
  `license_name` varchar(255) default null,
  `license_contents` text default null,

  unique key `article_license_unique` (`license_key`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_comments`
--
drop table if exists `article_comments`;
create table if not exists `article_comments` (
  `serial_id` serial not null primary key auto_increment,
  `article_id` int not null,
  `author_name` varchar(128) not null,
  `email` varchar(128) not null,
  `create_time` datetime not null default now(),
  `ip_address` int not null default 0,
  `user_agent` varchar(255) default null,
  `comment_contents` json not null,
  `status` enum('PENDING', 'AUTO_SPAMMED', 'USER_SPAMMED', 'COMMENTED') not null default 'PENDING',
  `parent_id` int default 0,

  index `article_comment_index` (`article_id`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `article_analyses`
--
drop table if exists `article_analyses`;
create table if not exists `article_analyses` (
  `serial_id` serial not null primary key auto_increment,
  `article_id` int not null,
  `view_count` int not null default 0,
  `like_count` int not null default 0,
  `create_time` datetime not null default now(),

  unique key `article_analysis_unique` (`article_id`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `viewer_analyses`
--
drop table if exists `viewer_analyses`;
create table if not exists `viewer_analyses` (
  `serial_id` serial not null primary key auto_increment,
  `viewer_ip_address` int not null default 0,
  `viewer_user_agent` text default null,
  `view_url` text not null,
  `create_time` datetime not null default now()
) engine=Innodb default charset=utf8mb4 auto_increment=1;
