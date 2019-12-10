--
-- Here Structure of Database
--

drop database if exists here;
create database here with encoding = 'UTF8';
alter database here owner to postgres;

\connect here;


--
-- Table structure for table `article`
--
create table public.article (
  "article_id" serial4 not null primary key,
  "author_id" integer not null default 0,
  "article_title" varchar(128) not null default '',
  "article_abbr" varchar(255) not null default '',
  "article_outline" text not null default '',
  "article_body" text not null default '',
  "article_public" bool not null default false,
  "article_publish" bool not null default false,
  "article_allow_comment" bool not null default true,
  "article_password" varchar(128) not null default '',
  "article_like" integer not null default 0,
  "article_comments" integer not null default 0,
  "article_views" integer not null default 0,
  "create_time" timestamp without time zone not null default now(),
  "update_time" timestamp without time zone not null default now()
);

alter table public.article owner to postgres;
create index idx_author_id on public.article using btree (author_id);
create index idx_article_title on public.article using btree (article_title);
create index idx_article_abbr on public.article using btree (article_abbr);


--
-- Table structure for table `author`
--
create table public.author (
  "author_id" serial4 not null primary key,
  "author_email" varchar(128) not null default '',
  "author_username" varchar(64) not null default '',
  "author_password" varchar(128) not null default '',
  "author_nickname" varchar(64) not null default '',
  "author_avatar" text not null default '',
  "author_introduction" text not null default '',
  "author_2fa" bool not null default false,
  "author_2fa_code" varchar(64) not null default '',
  "create_time" timestamp without time zone not null default now(),
  "update_time" timestamp without time zone not null default now(),
  "last_login_time" timestamp without time zone not null default now(),
  "last_login_ip" inet not null default '0.0.0.0'
);

alter table public.author owner to postgres;
create index idx_author_email on public.author (author_email);
create index idx_author_username on public.author (author_username);


--
-- Type for type `field_type`
--
create type public.field_type as enum (
  'string', 'integer', 'float', 'boolean'
);

alter type public.field_type owner to postgres;


--
-- Table structure for table `field`
--
create table public.field (
  "field_id" serial4 not null primary key,
  "field_key" varchar(255) not null default '',
  "field_value" text not null default '',
  "field_value_type" public.field_type not null default 'string'::public.field_type
);

alter table public.field owner to postgres;
create index idx_field_key on public.field (field_key);


--
-- Table structure for table `category`
--
create table public.category (
  "category_id" serial4 not null primary key,
  "category_name" varchar(64) not null default '',
  "category_introduction" text not null default '',
  "category_parent" integer not null default 0,
  "create_time" timestamp without time zone not null default now()
);

alter table public.category owner to postgres;
create index idx_category_name on public.category (category_name);
create index idx_category_parent on public.category (category_parent);


--
-- Type for type `field_type`
--
create type public.comment_type as enum (
  'pending', 'auto_spammed', 'spammed', 'commented'
);

alter type public.comment_type owner to postgres;


--
-- Table structure for table `comment`
--
create table public.comment (
  "comment_id" serial4 not null primary key,
  "article_id" integer not null default 0,
  "commentator_nickname" varchar(64) not null default '',
  "commentator_email" varchar(64) not null default '',
  "commentator_ip" inet not null default '0.0.0.0',
  "commentator_browser" varchar(255) not null default '',
  "comment_body" text not null default '',
  "comment_status" public.comment_type not null default 'pending'::public.comment_type,
  "comment_parent" integer not null default 0,
  "create_time" timestamp without time zone not null default now()
);

alter table public.comment owner to postgres;
create index idx_article_id on public.comment (article_id);
create index idx_comment_parent on public.comment (comment_parent);


--
-- Table structure for table `article_category`
--
create table public.article_category (
  "relation_id" serial4 not null primary key,
  "article_id" integer not null default 0,
  "category_id" integer not null default 0
);

alter table public.article_category owner to postgres;
create index idx_relation_article_id on public.article_category (article_id);
create index idx_relation_category_id on public.article_category (category_id);


--
-- Table structure for table `article_category`
--
create table public.viewer (
  "viewer_id" serial4 not null primary key,
  "viewer_key" varchar(64) not null default '',
  "viewer_ip" inet not null default '0.0.0.0',
  "viewer_stay_time" interval not null default '0:0:0',
  "viewer_user_agent" varchar(255) not null default '',
  "create_time" timestamp without time zone not null default now()
);

alter table public.viewer owner to postgres;
create index idx_viewer_key on public.viewer (viewer_key);
