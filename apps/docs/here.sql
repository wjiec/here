--
-- database `here`
--


-- ----------------------------------------------


--
-- Table structure for table `here_users`
--
drop table if exists `here_users`;
create table if not exists `here_users` (
  `serial_id` serial not null primary key auto_increment,
  `username` varchar(64) not null,
  `password` varchar(128) not null,
  `email` varchar(64) not null,
  `nickname` varchar(64) default null,
  `user_avator` text default null,
  `user_introduce` text default null,
  `create_time` datetime not null default now(),
  `last_login_time` datetime not null default now(),
  `ip_address` int not null default 0,
  `two_factor_auth` bool not null default false,

  unique key `user_unique` (`username`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `here_articles`
--
drop table if exists `here_articles`;
create table if not exists `here_articles` (
  `serial_id` serial not null primary key auto_increment,
  `article_title` varchar(128) not null,
  `article_description` text default null,
  `author_id` int not null,
  `create_time` datetime not null default now(),
  `update_time` datetime not null default now(),
  `contents` text default null,
  `category_id` int not null default 0,
  `accessible` boolean not null default true,
  `article_status` enum('DRAFT', 'PUBLISHED') not null default 'DRAFT',
  `password` varchar(64) default null,
  `close_comment` boolean not null default false,
  `license_id` int default null,
  `group_id` int default null
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `here_categories`
--
drop table if exists here_article_categories;
create table if not exists `here_categories` (
  `serial_id` serial not null primary key auto_increment,
  `category_name` varchar(128) not null,
  `category_description` text default null,
  `create_time` datetime not null default now(),
  `parent_id` int not null default 0
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `here_article_groups`
--
drop table if exists `here_article_groups`;
create table if not exists `here_article_groups` (
  `serial_id` serial not null primary key auto_increment,
  `group_name` varchar(128) not null,
  `group_description` text default null,
  `create_time` datetime not null default now()
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `here_licenses`
--
drop table if exists here_article_licenses;
create table if not exists `here_licenses` (
  `serial_id` serial not null primary key auto_increment,
  `license_name` varchar(128) not null,
  `license_icon` text default null,
  `license_dispaly` varchar(255) default null,
  `license_contents` text default null
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `here_article_comments`
--
drop table if exists `here_article_comments`;
create table if not exists `here_article_comments` (
  `serial_id` serial not null primary key auto_increment,
  `article_id` int not null,
  `author_name` varchar(128) not null,
  `email` varchar(128) not null,
  `create_time` datetime not null default now(),
  `ip_address` int not null default 0,
  `user_agent` varchar(255) default null,
  `comment_contents` text not null,
  `status` enum('PENDING', 'SPAMMING', 'COMMENTED') not null default 'PENDING',
  `parent_id` int default null,

  unique key `comment_unique` (`article_id`, `author_name`)
) engine=Innodb default charset=utf8mb4 auto_increment=1;


-- ----------------------------------------------


--
-- Table structure for table `here_site_comments`
--
drop table if exists `here_site_comments`;
create table if not exists `here_site_comments` (
  `serial_id` serial not null primary key auto_increment,
  `author_name` varchar(128) not null,
  `email` varchar(128) not null,
  `create_time` datetime not null default now(),
  `ip_address` int not null default 0,
  `user_agent` varchar(255) default null,
  `comment_contents` text not null,
  `status` enum('PENDING', 'SPAMMING', 'COMMENTED') not null default 'PENDING'
) engine=Innodb default charset=utf8mb4 auto_increment=1;
