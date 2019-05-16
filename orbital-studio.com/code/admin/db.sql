drop database if exists orb_news;
create database orb_news;
use orb_news;
create table news (
	news_id	int primary key auto_increment,
	author  varchar(16) not null,
	headline text,
	created	int,
	modified int,
	news_text text
);
create table authors (
	username int(16) primary key,
	password int(16) not null,
	permission int not null,
	user_info	text
);
