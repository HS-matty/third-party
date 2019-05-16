-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Янв 05 2008 г., 13:28
-- Версия сервера: 5.1.16
-- Версия PHP: 5.1.6
-- 
-- БД: `benefit`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `article_listing`
-- 

CREATE TABLE `article_listing` (
  `article_listing_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_text` text NOT NULL,
  `listing_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`article_listing_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `article_listing`
-- 

INSERT INTO `article_listing` VALUES (1, '<p><strong>ggrgrgrg</strong></p>', 111);

-- --------------------------------------------------------

-- 
-- Структура таблицы `bluser`
-- 

CREATE TABLE `bluser` (
  `bluser_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `phone_number` varchar(64) DEFAULT NULL,
  `login` varchar(64) NOT NULL,
  `sha_password` varchar(128) NOT NULL,
  `user_is_active` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`bluser_id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

-- 
-- Дамп данных таблицы `bluser`
-- 

INSERT INTO `bluser` VALUES (1, 'Hunter', 'Jensen', 'hunter_jensen@hotmail.com', '858-442-0734', 'user_18074698212348925', 'fed07aaa01de0406ab872931f7c0e68a', 0);
INSERT INTO `bluser` VALUES (2, 'Gunther', 'Johnson', 'hunterjensen@gmail.com', '858-243-2608', 'user_489746982637abc0f', '27c2cf4cef8a24fdb2e1f42f0d750112', 0);
INSERT INTO `bluser` VALUES (14, 'fffffdd', 'dqwdwqd', 'byqdes@gmail.com', '222211', '', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 1);
INSERT INTO `bluser` VALUES (4, 'dwedwd', 'wdwdwed', 'dwedwedw@dddd.com', '222', 'user_77346c0d77b2dc6f', '7e7b27d163e6e798d5eea46852f24fcc', 0);
INSERT INTO `bluser` VALUES (7, 'dddddddd', 'dddddddd', 'dddddddd@dd.com', NULL, '', 'd36da3e6884f6d1e9e7983ff13e99cf5c8f5745a', 0);
INSERT INTO `bluser` VALUES (8, 'cccccccc', 'cccccccc', 'cccccccc@dd.com', '22222', '', 'cd19ee9e3fe04fdc3fcc0449a832e8bbd89c022f', 1);
INSERT INTO `bluser` VALUES (9, 'test', 'test', 'test@test.com', '210222', '', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 1);
INSERT INTO `bluser` VALUES (16, 'gggg;&#039;&#039;', 'mmmmm', 'byqdes@tut.by', '2101664', '', '3ed33a44f0d2445fa296581c0dde1c682cd17bb8', 1);
INSERT INTO `bluser` VALUES (17, 'new name', 'mmmmm', 'bysqs@tut.by', '2101664', '', '8cb2237d0679ca88db6464eac60da96345513964', 0);
INSERT INTO `bluser` VALUES (18, 'new name', 'mmmmm', 'bysqws@tut.by', '2101664', '', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0);
INSERT INTO `bluser` VALUES (19, '', NULL, 'byqdes@gmail.com', NULL, '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 0);
INSERT INTO `bluser` VALUES (20, '', '', 'byqdes@gmail.com', '', 'user_211246cdcb4429f67', '6c41b308e0dacbbb76f2b037cc5c4e0e', 0);
INSERT INTO `bluser` VALUES (21, '', '', 'byqdes@gmail.com', '', 'user_2745846cebd7d1e84c', '2138b036d4f96acfb58d3de66934f477', 0);
INSERT INTO `bluser` VALUES (65, 'swqswqsq', 'wsqsq', 'bysss@gmail.by', '2w12w12', 'user_28591473053adb20fe', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0);
INSERT INTO `bluser` VALUES (24, 'ddd', '', 'byq@tuts.by', '', '', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (25, 'ddd', '', 'byq@tufft.by', '', '', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (26, 'dwdqwdqw', 'dqwdqwd', 'dqwdqw@dddd.com', '', 'user_1227446d5a68a501c1', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (27, 'dwdqwdqw', 'dqwdqwd', 'dqwdqw@dddd.com', '', 'user_129446d5a69fe8b28', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (29, 'dwdqwdqw', 'dqwdqwd', 'dqwdqw@dddd.com', '', 'user_1213046d5a6b9a4087', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (30, 'dwdqwdqw', 'dqwdqwd', 'dqwdqw@dddd.com', '', 'user_1213046d5a6b9a4087', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (31, 'dwdqwdqw', 'dqwdqwd', 'dqwdqw@dddd.com', '', 'user_472646d5a6cbe4e1f', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (32, 'dwdqwdqw', 'dqwdqwd', 'dqwdqw@dddd.com', '', 'user_472646d5a6cbe4e1f', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (39, 'sss', 'ssss', 'byqdes2@gmail.com', '2101664', 'user_1312546d5abb0baebc', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 1);
INSERT INTO `bluser` VALUES (40, 'sss', 'ssss', 'byqdes2@gmail.com', '2101664', 'user_1312546d5abb0baebc', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (41, 'zzzzz', 'zzzz', 'zzzz@dot.com', '210777', 'user_2317446d5adde40d9d', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 1);
INSERT INTO `bluser` VALUES (42, 'adqwd', 'dqwdqwd', 'byqdes1234@gmail.com', '', 'user_11946d5afe64c4b8', '4df6f4c86abe0a4152d8f7fe34fd34f8', 0);
INSERT INTO `bluser` VALUES (43, 'sss', '222', 's.volchek@tuta.by', '', 'user_2400246d5b0512dc70', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 1);
INSERT INTO `bluser` VALUES (44, 'nnn', 'nnn', 'nnn@ddd.com', 'dddd', '', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 0);
INSERT INTO `bluser` VALUES (45, 'dqwdqwd', 'dqwdqwdq', 'dddddddd@ddz.com', '', '', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 1);
INSERT INTO `bluser` VALUES (46, 'sergey', 'volchek', 'byq@gmail.by', '', 'user_742546d5c2db2625e', '9490580e9e57524552c7ff9ec9a7a1f22db79960', 1);
INSERT INTO `bluser` VALUES (47, 'mega', 'man', 'bbb@bbb.com', '', '', 'b657bd078964abcc6e9457ccb7fd52d07f63f432', 1);
INSERT INTO `bluser` VALUES (48, '', '', 's.volchek@tut.by', '', '', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 1);
INSERT INTO `bluser` VALUES (49, 'w21w12', 'w12w12w12w', 'byq@kay.by', '2222', 'user_2606246eecae6d9706', 'aa72037e998e0fd9362d8568dcb410a2', 0);
INSERT INTO `bluser` VALUES (50, '', '', 'serge@tut.by', '', 'user_1740446eeedeb4c4b8', 'c0561e5d62ad1b53ba32be65b4d33565', 1);
INSERT INTO `bluser` VALUES (51, '', '', 'sss@tut.by', '', 'user_852546eef124b34aa', 'c2e60d9dd5b10b9c2bf1f25a237baf49', 1);
INSERT INTO `bluser` VALUES (52, '', '', 'abba@tut.by', '', 'user_281146eef534d59fc', '30addde24e0d3ddbae91c0890169c744', 1);
INSERT INTO `bluser` VALUES (53, 'Sergey', '', 'test@tut.by', '2101664', 'user_3195546f01b80baebd', 'b444ac06613fc8d63795be9ad0beaf55011936ac', 1);
INSERT INTO `bluser` VALUES (54, 'sqwsqws', 'sqwsqws', 'by@gmail.com', '', 'user_23936470e3a887de2d', 'e549b67da5166abc1f5a57fd02ce046d', 0);
INSERT INTO `bluser` VALUES (55, '', NULL, 'byqss@gmail.com', NULL, 'user_19312470e3c5c35682', '5f0e1043a3ee4d30a4f68ddb5d7d5444', 0);
INSERT INTO `bluser` VALUES (56, '', NULL, 'byqdswses@gmail.com', NULL, 'user_25804470e3d4daf7a2', '90373e236cdcfebd41ecb73ee596865d', 0);
INSERT INTO `bluser` VALUES (57, '', NULL, 'swsws@gmail.com', NULL, 'user_21323470e3ee77de2c', '89b2d3e8ffefb5212d9920a2d50ed6f0', 0);
INSERT INTO `bluser` VALUES (58, '', '', 'sww@gmail.com', '', 'user_11429470e412f13130', '1542ff5e5a7b022081b766459a119f8c', 0);
INSERT INTO `bluser` VALUES (59, 'fwefewf', 'fwe', 'byq@gmail.com', '', 'user_118470e418044aa6', '845888a688ac9cbb295845e1339fcf8a', 0);
INSERT INTO `bluser` VALUES (60, '', '', 'bb@tut.by', '', 'user_183404714f41e57bd2', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1);
INSERT INTO `bluser` VALUES (61, '', '', 'dssd@tut.by', '', 'user_313204714fb1baf7a1', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 0);
INSERT INTO `bluser` VALUES (62, '', '', 'dwewe@tut.by', '', 'user_110874714fca6c3175', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 0);
INSERT INTO `bluser` VALUES (63, '', '', 'bdddyq@gmail.com', '', 'user_271634714fd0566ff6', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 0);
INSERT INTO `bluser` VALUES (64, 'zzzzz', 'zzz', 'xssxs@gmail.com', 'zzzzz', 'user_105324714fd438d24f', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `category`
-- 

CREATE TABLE `category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `short_description` varchar(128) DEFAULT NULL,
  `cleft` int(10) unsigned NOT NULL DEFAULT '0',
  `cright` int(10) unsigned NOT NULL DEFAULT '0',
  `clevel` int(10) unsigned NOT NULL DEFAULT '0',
  `node_type` enum('category','static_page') NOT NULL DEFAULT 'category',
  `body` text,
  `alias` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `cleft` (`cleft`,`cright`,`clevel`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- 
-- Дамп данных таблицы `category`
-- 

INSERT INTO `category` VALUES (1, NULL, 1, 24, 0, 'category', NULL, NULL);
INSERT INTO `category` VALUES (2, 'Главная страница', 2, 15, 1, 'category', '<p><em><strong>Тестируем стафф</strong></em></p>', 'main');
INSERT INTO `category` VALUES (3, 'test', 3, 4, 2, '', NULL, NULL);
INSERT INTO `category` VALUES (4, 'fff', 5, 6, 2, '', NULL, NULL);
INSERT INTO `category` VALUES (11, 'свехрсвежее предложение', 9, 12, 4, 'category', '<p><font color="#808080">Контент</font></p>', 'cool');
INSERT INTO `category` VALUES (6, 'Услуги', 7, 14, 2, 'category', '<p><strong>Тут у нас услуги<br />\r\n</strong></p>\r\n<p>&nbsp;</p>\r\n<p><strong style="background-color: rgb(128, 128, 128);">вцувцвц</strong></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 'services');
INSERT INTO `category` VALUES (7, 'Страницы', 16, 21, 1, 'category', '<p>Все страницы.</p>', 'pages');
INSERT INTO `category` VALUES (8, 'Предложени от белгазпромбанка', 17, 20, 2, 'category', '<p>Попробуйте новогое предложение от белгазпромбанка. Закачаетесь. всего 15% годовых в валюте. притом что через 400 километор тоже самое за 5%.</p>\r\n<p>удачных покупок.</p>\r\n<p>&nbsp;</p>', 'belgaz');
INSERT INTO `category` VALUES (9, 'Сверхновое предложение', 18, 19, 3, 'category', '<p>Сверх супер новое предложение</p>', 'super_new');
INSERT INTO `category` VALUES (10, 'Самые свежие услуги', 8, 13, 3, 'category', '<p>Самые свежие страницы</p>', '/new_services/');
INSERT INTO `category` VALUES (12, 'Новости', 22, 23, 1, 'category', '<p>Новости</p>', 'news');
INSERT INTO `category` VALUES (13, 'pffkfkwe', 10, 11, 5, 'category', '<p>test</p>', 'wewddwd');

-- --------------------------------------------------------

-- 
-- Структура таблицы `category_listing_assc`
-- 

CREATE TABLE `category_listing_assc` (
  `category_id` int(11) NOT NULL DEFAULT '0',
  `listing_id` int(11) NOT NULL DEFAULT '0',
  KEY `cid` (`category_id`,`listing_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Дамп данных таблицы `category_listing_assc`
-- 

INSERT INTO `category_listing_assc` VALUES (0, 108);
INSERT INTO `category_listing_assc` VALUES (0, 110);
INSERT INTO `category_listing_assc` VALUES (0, 111);
INSERT INTO `category_listing_assc` VALUES (2, 108);
INSERT INTO `category_listing_assc` VALUES (2, 112);
INSERT INTO `category_listing_assc` VALUES (4, 109);
INSERT INTO `category_listing_assc` VALUES (4, 110);
INSERT INTO `category_listing_assc` VALUES (4, 111);
INSERT INTO `category_listing_assc` VALUES (8, 113);
INSERT INTO `category_listing_assc` VALUES (8, 114);
INSERT INTO `category_listing_assc` VALUES (8, 115);
INSERT INTO `category_listing_assc` VALUES (8, 116);
INSERT INTO `category_listing_assc` VALUES (8, 117);
INSERT INTO `category_listing_assc` VALUES (8, 118);
INSERT INTO `category_listing_assc` VALUES (8, 119);
INSERT INTO `category_listing_assc` VALUES (10, 120);
INSERT INTO `category_listing_assc` VALUES (12, 121);
INSERT INTO `category_listing_assc` VALUES (12, 122);
INSERT INTO `category_listing_assc` VALUES (12, 123);
INSERT INTO `category_listing_assc` VALUES (12, 124);
INSERT INTO `category_listing_assc` VALUES (92, 37);
INSERT INTO `category_listing_assc` VALUES (92, 39);
INSERT INTO `category_listing_assc` VALUES (92, 40);
INSERT INTO `category_listing_assc` VALUES (92, 44);
INSERT INTO `category_listing_assc` VALUES (92, 57);
INSERT INTO `category_listing_assc` VALUES (92, 59);
INSERT INTO `category_listing_assc` VALUES (92, 62);
INSERT INTO `category_listing_assc` VALUES (92, 66);
INSERT INTO `category_listing_assc` VALUES (92, 67);
INSERT INTO `category_listing_assc` VALUES (92, 68);
INSERT INTO `category_listing_assc` VALUES (92, 69);
INSERT INTO `category_listing_assc` VALUES (92, 70);
INSERT INTO `category_listing_assc` VALUES (92, 72);
INSERT INTO `category_listing_assc` VALUES (92, 74);
INSERT INTO `category_listing_assc` VALUES (92, 100);
INSERT INTO `category_listing_assc` VALUES (92, 101);
INSERT INTO `category_listing_assc` VALUES (97, 2);
INSERT INTO `category_listing_assc` VALUES (97, 3);
INSERT INTO `category_listing_assc` VALUES (97, 5);
INSERT INTO `category_listing_assc` VALUES (97, 7);
INSERT INTO `category_listing_assc` VALUES (97, 8);
INSERT INTO `category_listing_assc` VALUES (97, 9);
INSERT INTO `category_listing_assc` VALUES (97, 10);
INSERT INTO `category_listing_assc` VALUES (97, 11);
INSERT INTO `category_listing_assc` VALUES (97, 12);
INSERT INTO `category_listing_assc` VALUES (98, 47);
INSERT INTO `category_listing_assc` VALUES (100, 38);
INSERT INTO `category_listing_assc` VALUES (100, 53);
INSERT INTO `category_listing_assc` VALUES (100, 54);
INSERT INTO `category_listing_assc` VALUES (100, 55);
INSERT INTO `category_listing_assc` VALUES (100, 58);
INSERT INTO `category_listing_assc` VALUES (100, 60);
INSERT INTO `category_listing_assc` VALUES (100, 63);
INSERT INTO `category_listing_assc` VALUES (100, 71);
INSERT INTO `category_listing_assc` VALUES (100, 73);
INSERT INTO `category_listing_assc` VALUES (100, 75);
INSERT INTO `category_listing_assc` VALUES (100, 76);
INSERT INTO `category_listing_assc` VALUES (100, 77);
INSERT INTO `category_listing_assc` VALUES (100, 78);
INSERT INTO `category_listing_assc` VALUES (100, 80);
INSERT INTO `category_listing_assc` VALUES (100, 82);
INSERT INTO `category_listing_assc` VALUES (100, 83);
INSERT INTO `category_listing_assc` VALUES (100, 84);
INSERT INTO `category_listing_assc` VALUES (100, 85);
INSERT INTO `category_listing_assc` VALUES (100, 87);
INSERT INTO `category_listing_assc` VALUES (100, 88);
INSERT INTO `category_listing_assc` VALUES (100, 90);
INSERT INTO `category_listing_assc` VALUES (100, 91);
INSERT INTO `category_listing_assc` VALUES (100, 92);
INSERT INTO `category_listing_assc` VALUES (100, 93);
INSERT INTO `category_listing_assc` VALUES (100, 94);
INSERT INTO `category_listing_assc` VALUES (100, 95);
INSERT INTO `category_listing_assc` VALUES (100, 96);
INSERT INTO `category_listing_assc` VALUES (100, 97);
INSERT INTO `category_listing_assc` VALUES (100, 98);
INSERT INTO `category_listing_assc` VALUES (100, 99);
INSERT INTO `category_listing_assc` VALUES (109, 46);
INSERT INTO `category_listing_assc` VALUES (109, 49);
INSERT INTO `category_listing_assc` VALUES (109, 50);
INSERT INTO `category_listing_assc` VALUES (109, 51);
INSERT INTO `category_listing_assc` VALUES (109, 52);
INSERT INTO `category_listing_assc` VALUES (109, 56);
INSERT INTO `category_listing_assc` VALUES (109, 61);
INSERT INTO `category_listing_assc` VALUES (111, 13);
INSERT INTO `category_listing_assc` VALUES (111, 16);
INSERT INTO `category_listing_assc` VALUES (111, 17);
INSERT INTO `category_listing_assc` VALUES (111, 20);
INSERT INTO `category_listing_assc` VALUES (111, 24);
INSERT INTO `category_listing_assc` VALUES (112, 14);
INSERT INTO `category_listing_assc` VALUES (112, 18);
INSERT INTO `category_listing_assc` VALUES (112, 21);
INSERT INTO `category_listing_assc` VALUES (113, 15);
INSERT INTO `category_listing_assc` VALUES (113, 19);
INSERT INTO `category_listing_assc` VALUES (113, 22);
INSERT INTO `category_listing_assc` VALUES (114, 23);
INSERT INTO `category_listing_assc` VALUES (206, 25);
INSERT INTO `category_listing_assc` VALUES (206, 26);
INSERT INTO `category_listing_assc` VALUES (206, 27);
INSERT INTO `category_listing_assc` VALUES (206, 28);
INSERT INTO `category_listing_assc` VALUES (206, 29);
INSERT INTO `category_listing_assc` VALUES (206, 30);
INSERT INTO `category_listing_assc` VALUES (206, 31);
INSERT INTO `category_listing_assc` VALUES (206, 32);
INSERT INTO `category_listing_assc` VALUES (206, 33);
INSERT INTO `category_listing_assc` VALUES (206, 34);
INSERT INTO `category_listing_assc` VALUES (206, 35);
INSERT INTO `category_listing_assc` VALUES (206, 36);
INSERT INTO `category_listing_assc` VALUES (225, 48);

-- --------------------------------------------------------

-- 
-- Структура таблицы `geocode`
-- 

CREATE TABLE `geocode` (
  `geocode_id` int(11) NOT NULL AUTO_INCREMENT,
  `geocode_address` varchar(255) NOT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  PRIMARY KEY (`geocode_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- 
-- Дамп данных таблицы `geocode`
-- 

INSERT INTO `geocode` VALUES (1, '5141 Cass St., San Diego, CA', 32.8084, -117.255);
INSERT INTO `geocode` VALUES (2, '3763 Promontory St., Unit A, San Diego, CA', 32.7878, -117.238);
INSERT INTO `geocode` VALUES (3, '1 Market Pl, San Diego, CA', 32.711, -117.168);
INSERT INTO `geocode` VALUES (4, '421 West B Street, San Diego, CA', 32.7178, -117.167);
INSERT INTO `geocode` VALUES (5, '1055 2nd Ave, San Diego, CA', 32.7163, -117.163);
INSERT INTO `geocode` VALUES (6, '2000 2nd St, San Diego, CA', 32.695, -117.168);
INSERT INTO `geocode` VALUES (7, '1617 1st Ave, San Diego, CA', 32.7222, -117.164);
INSERT INTO `geocode` VALUES (8, '1404 Vacation Rd, San Diego, CA', 32.7749, -117.239);
INSERT INTO `geocode` VALUES (9, '4000 Coronado Bay Rd, San Diego, CA', 32.6295, -117.139);
INSERT INTO `geocode` VALUES (10, '3999 Mission Blvd, San Diego, CA', 32.7903, -117.254);
INSERT INTO `geocode` VALUES (11, '939 4th Ave, San Diego, CA', 32.715, -117.161);
INSERT INTO `geocode` VALUES (12, '15575 Jimmy Durante Blvd, San Diego, CA', 32.7233, -117.168);
INSERT INTO `geocode` VALUES (13, 'shopping, shopping, 22', 36.8531, -76.0172);
INSERT INTO `geocode` VALUES (14, 'fender, fender, 222', 36.1797, -90.9181);
INSERT INTO `geocode` VALUES (15, 'gibson, gibson, 22', 33.8402, -88.6936);
INSERT INTO `geocode` VALUES (16, 'serge, serge, 22', 48.3027, 0.858812);
INSERT INTO `geocode` VALUES (17, 'short, short, 22', 35.2935, -93.7297);
INSERT INTO `geocode` VALUES (18, '22222, 22, 22', 40.6162, -73.9526);
INSERT INTO `geocode` VALUES (19, '111, 111, 111', 25.1043, 121.521);
INSERT INTO `geocode` VALUES (20, '222, 222, 22', 44.8024, -68.7801);
INSERT INTO `geocode` VALUES (21, '22222, 22, 222', 44.8126, -68.801);

-- --------------------------------------------------------

-- 
-- Структура таблицы `housing_listing`
-- 

CREATE TABLE `housing_listing` (
  `housting_listing_id` int(10) NOT NULL AUTO_INCREMENT,
  `listing_id` int(10) unsigned NOT NULL,
  `bedrooms` float(3,1) NOT NULL,
  `bathrooms` float(3,1) NOT NULL,
  `square_footage` int(10) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`housting_listing_id`),
  KEY `housing_listing_FKIndex1` (`listing_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=36 ;

-- 
-- Дамп данных таблицы `housing_listing`
-- 

INSERT INTO `housing_listing` VALUES (1, 1, 2.0, 3.0, 1750, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (2, 2, 1.0, 3.0, 1620, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (3, 3, 3.0, 3.0, 1450, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (4, 4, 3.0, 2.0, 1550, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (5, 5, 3.0, 1.0, 1600, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (6, 6, 3.0, 3.0, 1250, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (7, 7, 2.0, 3.0, 1270, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (8, 8, 1.0, 3.0, 1110, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (9, 9, 3.0, 3.0, 1111, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (10, 10, 3.0, 2.0, 4444, '57f3d8ae3a920bf6a4d8f415e34e5652.jpg', NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (11, 11, 3.0, 2.0, 1800, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (12, 12, 4.0, 4.0, 2400, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (13, 37, 22.0, 22.0, 2, 'P9300006.JPG', 'PA010041.JPG', 'PA030088.JPG', NULL);
INSERT INTO `housing_listing` VALUES (14, 39, 22.0, 22.0, 0, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (15, 40, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (16, 41, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (17, 42, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (18, 43, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (19, 44, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (20, 45, 99.9, 22.0, 222, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (21, 47, 3.0, 3.0, 3, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (22, 57, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (23, 59, 99.9, 21.0, 11, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (24, 62, 22.0, 2.0, 2, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (25, 64, 2.0, 2.0, 2, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (26, 65, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (27, 66, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (28, 67, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (29, 68, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (30, 69, 22.0, 22.0, 222, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (31, 70, 99.9, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (32, 72, 22.0, 22.0, 22, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (33, 74, 22.0, 22.0, 222, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (34, 100, 0.0, 0.0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `housing_listing` VALUES (35, 101, 0.0, 0.0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Структура таблицы `item_listing`
-- 

CREATE TABLE `item_listing` (
  `item_listing_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `listing_id` int(4) NOT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_listing_id`),
  KEY `listing_id` (`listing_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

-- 
-- Дамп данных таблицы `item_listing`
-- 

INSERT INTO `item_listing` VALUES (1, 13, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (2, 14, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (3, 15, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (4, 16, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (5, 17, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (6, 18, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (7, 19, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (8, 20, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (9, 21, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (10, 22, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (11, 23, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (12, 24, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (13, 38, 'P93000061.JPG', 'PA030091.JPG', NULL, NULL);
INSERT INTO `item_listing` VALUES (14, 53, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (15, 54, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (16, 55, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (17, 58, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (18, 60, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (19, 63, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (20, 71, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (21, 73, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (22, 75, 'PA090013.JPG', NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (23, 76, '35fec95f7d6fcdfee60c03e0a54a65a0.JPG', 'e5714af3a807bbc82197184342a4f00d.jpg', NULL, NULL);
INSERT INTO `item_listing` VALUES (24, 77, 'PA090013.JPG', NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (25, 78, 'f6506f8ca54e99b5acd146a91ef24b2d.JPG', 'a157c6e321e558c4294a26da0a447cf1.JPG', '229a7a86006bb8e5b2e66d7a167dd26a.JPG', 'cc2ee1e6dfac47a6ad04acee3218fed9.JPG');
INSERT INTO `item_listing` VALUES (26, 79, '564e93e2ad2f8be881ea2ebc4b0a35f8.jpg', 'a7a85568233c1599cc48eac5b5997f90.JPG', 'd3f9022f746332c68ebb035739ef56f2.JPG', '5b2e359e45e9145d77c6d6ec951332ec.JPG');
INSERT INTO `item_listing` VALUES (27, 80, '32e623ddeb404f7b3e5d140e97034268.jpg', '', NULL, NULL);
INSERT INTO `item_listing` VALUES (28, 81, '3046b93556c7eb183c03ad333cab6012.jpg', '76eed06d651f3f0de5fb7eb2ffa0f975.jpg', '88ad269401c584e6e485ade4fb6acc0c.JPG', 'bd48e352f2dde8d5c678b707b8e34204.JPG');
INSERT INTO `item_listing` VALUES (29, 82, '000fe49094b9a15583d9ec5c84e1d8a9.jpg', '27680fca72e4f2e90db98ffd783a1b63.JPG', '4ab6ed63834d61cd5aad6f7c7aa73b07.JPG', 'ed1bb0d31502a6da7acee995ae54d5f4.JPG');
INSERT INTO `item_listing` VALUES (30, 83, 'a28fffd55735b9dda666d2db2cd89ce0.JPG', '948035c8b71cb2914f19a7ba9f3291a3.JPG', '450c4feee379b5c21291cf14db07b9a6.JPG', '41292406810d0cfc22147e5dd813917f.jpg');
INSERT INTO `item_listing` VALUES (31, 84, '3ae56f55d89f3d61b26d610aedf7925a.jpg', 'cb25f9d6622774c5617bbaff72678cd8.JPG', 'd9452bb9cbc59afe4171ce7357e7e66d.JPG', '557e72d49763b2c8a6e47011a79b11ff.JPG');
INSERT INTO `item_listing` VALUES (32, 85, 'c7d7d3c5f43c0ca0a48904002a24fe00.jpg', 'd25837f21dbd5725d614ac8bd0729ce9.JPG', 'eeaceb51e6b982643b81ed9af8c38755.JPG', '5914358556bed2a6184d643bd52fd1d8.JPG');
INSERT INTO `item_listing` VALUES (33, 86, 'e54beb5e5c50b4b622bfcb557faf62ea.jpg', '602051fe195b72771266d76e5551def6.JPG', '917b2bf7f9bd15476b3008293119e6b1.jpg', '4356df65c41bd011b9267a5e9584bd6f.JPG');
INSERT INTO `item_listing` VALUES (34, 87, '7d83dbe0d585bbf6d1a833f6dbf15d6b.jpg', '472ac2fc42cbc6b34766c2ab7b67f537.JPG', 'b093a70527c53310f7c1df2958095e82.JPG', '41eabaafa11d838655b0ae6f82f611e6.jpg');
INSERT INTO `item_listing` VALUES (35, 88, '77c1bdedfa7dd6d913cc819721d5bff3.JPG', 'a4b739bf6c6a9d2dd822b0fc69c39014.JPG', 'f503776ac36e02559b309361dfcdc0ad.JPG', 'e0fcb19bf2259138142c9baa71b989a4.JPG');
INSERT INTO `item_listing` VALUES (36, 89, 'db4ffd7c968580c339f6d25b3757da82.jpg', '9dcbfb914e670fa3c350bb07ffdcd067.jpg', '1be8eeb7c5f47bea21517623922d15da.JPG', 'ffae708034c09190b3fe20eb4ce8ac6b.JPG');
INSERT INTO `item_listing` VALUES (37, 90, '3d11d7c56183c390e3d5d58edd8fd110.JPG', NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (38, 91, 'd7ab70499c3e7e8cec9fb6a220a50276.jpg', NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (39, 92, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (40, 93, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (41, 94, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (42, 95, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (43, 96, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (44, 97, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (45, 98, NULL, NULL, NULL, NULL);
INSERT INTO `item_listing` VALUES (46, 99, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Структура таблицы `job_listing`
-- 

CREATE TABLE `job_listing` (
  `job_listing_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `listing_id` int(4) NOT NULL,
  `company_name` varchar(64) DEFAULT NULL,
  `compensation` varchar(64) DEFAULT NULL,
  `compensation_type` enum('none','hourly','salary') CHARACTER SET cp1251 DEFAULT 'none',
  `position_type` enum('none','intern','part-time','full-time','contract') CHARACTER SET cp1251 DEFAULT 'none',
  `application_instructions` mediumtext,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`job_listing_id`),
  KEY `listing_id` (`listing_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- 
-- Дамп данных таблицы `job_listing`
-- 

INSERT INTO `job_listing` VALUES (1, 25, 'Interactive', '40000', 'salary', 'full-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (2, 26, 'Barefoot Solutions', '60000', 'salary', 'full-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (3, 27, 'Internet Matrix', '35000', 'salary', 'full-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (4, 28, 'Union Tribune', '120000', 'salary', 'full-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (5, 29, 'San Diego Union-Tribune', '75000', 'salary', 'full-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (6, 30, 'Kidzui', '29000', 'salary', 'full-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (7, 31, 'SiteLab International', '10', 'hourly', 'part-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (8, 32, 'Barefoot Solutions', '15', 'hourly', 'part-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (9, 33, 'Kidzui', '20', 'hourly', 'part-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (10, 34, 'UCSD', '40', 'hourly', 'part-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (11, 35, 'Barefoot Solutions', '75', 'hourly', 'part-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (12, 36, 'DropShots.com', '100', 'hourly', 'part-time', 'Please respond with your resume and hourly rate', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (13, 46, '', '22.00', 'hourly', 'intern', 'swqqws', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (14, 48, NULL, '22.00', 'salary', 'part-time', 'ascasc', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (15, 49, '', '22.00', 'salary', 'full-time', '222', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (16, 50, '', '22.00', '', 'part-time', 'dqwddqwd', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (17, 51, '', '22.00', '', 'part-time', 'dqwddqwd', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (18, 52, '', '22.00', '', 'part-time', 'dqwddqwd', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (19, 56, 'no compay', '11', 'hourly', 'full-time', '111', NULL, NULL, NULL, NULL);
INSERT INTO `job_listing` VALUES (20, 61, '', '22', '', 'part-time', 'dqwdqwd', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Структура таблицы `listing`
-- 

CREATE TABLE `listing` (
  `listing_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `geocode_id` int(11) DEFAULT NULL,
  `listing_type_id` tinyint(4) NOT NULL,
  `bluser_id` int(10) unsigned DEFAULT '0',
  `location_id` int(10) unsigned NOT NULL,
  `main_image` varchar(64) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `long_description` text,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `is_closed` tinyint(4) NOT NULL DEFAULT '0',
  `is_approved` tinyint(4) NOT NULL DEFAULT '0',
  `is_expired` tinyint(4) NOT NULL DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `zip` int(30) unsigned DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `state` varchar(64) DEFAULT NULL,
  `tags` varchar(128) DEFAULT NULL,
  `price` float DEFAULT '0',
  `share_email` tinyint(1) NOT NULL,
  `share_phone` tinyint(1) NOT NULL,
  `share_name` tinyint(1) NOT NULL,
  `creation_date` datetime NOT NULL,
  `published_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `flag` enum('none','misclassified','forbidden','spam') NOT NULL DEFAULT 'none',
  `category_path_cache` varchar(128) DEFAULT NULL,
  `oodle_listing_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`listing_id`),
  KEY `geocode_id` (`geocode_id`),
  KEY `listing_type_id` (`listing_type_id`),
  FULLTEXT KEY `short_description` (`short_description`,`long_description`,`tags`)
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=utf8 AUTO_INCREMENT=125 ;

-- 
-- Дамп данных таблицы `listing`
-- 

INSERT INTO `listing` VALUES (2, 2, 2, 1, 1, NULL, 'This is a really nice apartment in South PB', 'This is a great place in South Pacific Beach. Right next to Rockys', 0, 0, 0, 0, '3763 Promontory St., Unit A', 92109, 'San Diego', 'CA', 'south pb, garage, grill', 2350, 1, 1, 0, '2007-08-07 15:05:10', '0000-00-00 00:00:00', '2007-08-07 15:05:10', 'none', 'Housing > Housing for rent > Apartament', NULL);
INSERT INTO `listing` VALUES (3, 3, 2, 1, 1, NULL, 'Beautiful Eastlake House For Rent', 'Spacious 3b/2.5ba home, remodeled kitchen w/stainless steel appliances, large yard, garage with built-in cabinets & epoxy floor, desirable schools, gardener included, pets OK. Available for August 1st move-in.', 0, 0, 0, 0, '1 Market Pl', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2150, 1, 1, 0, '2007-08-07 15:05:10', '0000-00-00 00:00:00', '2007-08-07 15:05:10', 'none', 'Housing > Housing for rent > Apartament', NULL);
INSERT INTO `listing` VALUES (5, 5, 2, 1, 1, NULL, '3br - 2ba House - AMAZING VIEWS - Pets allowed!!!', 'All NEW Interior 2 Bdrm/1Ba Condo/WITH OverSized 1.5 Car GARAGE...in sought after SANTEE TOWNE VILLAS...BREATHTAKING VIEW...Upper Corner Unit-BEST IN COMPLEX...Overlooking All of Santee....Kitchen w/Granite Counters, Maple Cabinetry, Stainless Appliances, including built in microwave and Bosch dishwasher..ALL New! A/C, Plush Carpeting, Bedrooms w/Mirrored Wardrobe Doors and Closet Organizers. Clubhouse, Pool & Laundry Rm all Centrally Located in GATED COMMUNITY! $1375/Month + $1000 Sec Dep (can b pd in increments, ALL Pets OK, Water PAID, MILITARY WELCOME....JUST MINS TO FRWY (Int 67,8,125,& 52)....ONLY 20 MINS TO DWNTWN/32ND ST... Lease, AVAIL Aug 1st, (619)8203488 anytime or email @ lions-pride@cox.net ', 1, 1, 1, 1, '1055 2nd Ave', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 1725, 1, 1, 0, '2007-08-07 15:05:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'fff > Housing for rent > Apartament', NULL);
INSERT INTO `listing` VALUES (7, 7, 2, 1, 1, NULL, 'Great downstairs one bedroom with washer & Dryer connections and cover ', 'Unit Number 49. Nice, Light & Bright, downstairs one bedroom Condo with huge private patio and a swimming pool and spa at your front door. This Condo has Washer and Dryer Connections, one assigned parking space and a great location close to shopping, restaurants and more. Great residential neighborhood location.\n\n\nThis Property can be shown by appointment.\nThis property is available for move in August 10th.\nWe are seeking a twelve month lease.\nIn order to qualify for this property we require a credit report on any occupant over the age of 18.\nOur application fee is only $20. ', 1, 0, 0, 0, '1617 1st Ave', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2150, 1, 1, 0, '2007-08-07 15:05:10', '0000-00-00 00:00:00', '2007-08-07 15:05:10', 'forbidden', 'Housing > Housing for rent > Apartament', NULL);
INSERT INTO `listing` VALUES (8, 8, 2, 1, 1, NULL, 'Charming Cottage close to Prospect & La Jolla Cove', 'Rarely available cottage with hardwood floors, large private outdoor patio and parking space. Washer & Dryer use included. No coins. Only four cottages in the complex. Very charming and convenient to all La Jolla has to offer. Will not last! Call for an appointment to see. One year lease. Sorry no pets.\n\nLarry, Agent 858 454-4255 ', 1, 0, 0, 0, '1404 Vacation Rd', 92109, 'San Diego', 'CA', 'south pb, garage, grill', 2850, 1, 1, 0, '2007-08-07 15:05:10', '0000-00-00 00:00:00', '2007-08-07 15:05:10', 'none', 'Housing > Housing for rent > Apartament', NULL);
INSERT INTO `listing` VALUES (9, 9, 2, 1, 1, NULL, 'Rent To '' Own 100% Rent Credit No Qualifying No Banks ', 'This is a wonderful place in PB. Has a two-car garage. ''', 1, 0, 0, 0, '4000 Coronado Bay Rd', 92118, 'San Diego', 'CA', 'south pb, garage, grill', 1250, 1, 1, 0, '2007-08-07 15:05:10', '0000-00-00 00:00:00', '2007-08-07 15:05:10', 'misclassified', 'Housing > Housing for rent > Apartament', NULL);
INSERT INTO `listing` VALUES (10, 10, 2, 1, 1, NULL, 'dwedwed', 'wqddqwdwq\r\ndqw\r\ndqw\r\ndqwd\r\n''', 1, 0, 0, 0, '3999 Mission Blvd', 92109, 'San Diego', 'CA', 'south pb, garage, grill', 1450, 1, 0, 0, '2007-08-07 15:05:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'spam', 'Housing > Housing for rent > Apartament', NULL);
INSERT INTO `listing` VALUES (11, 11, 2, 1, 1, NULL, 'Newly remodld units, new appliances, granite, tile, Hrwwd Flr.', 'Area: Carlsbad/Calavera Hills\nAddress: 3608 Terrace Place\nCarlsbad, CA 92009\nRent: $2,380.00\nDeposit: $2,350.00\nBed: 4\nBath: 3\nAvailable: 08/10/07 possibly 8/1/2007\nType: Detached House\nAmenities: 2579 sq ft, Built 2000, Pets Considered, Family Room, Fireplace, Fenced Yard with Auto Sprinklers, Three Car Garage w/opener.\n\nBrand new 9/2000, ceramic tile entry floor, high ceilings w/recesed lighting , spacious eat in kitchen w/lg center Island/breakfast bar, spacious master suite w/lg. walk in closet , oversized tub and separate shower & nice views. Close to shopping and Freeway\n\nContact Information:\n\n* We show properties Monday-Saturday by appointment *\n\nAmerican Heritage Properties\n9988 Hibert Street, Suite 300\nSan Diego, CA 92131\nPhone: 858-695-9400 ', 1, 0, 0, 0, '939 4th Ave', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2380, 1, 1, 0, '2007-08-07 15:05:10', '0000-00-00 00:00:00', '2007-08-07 15:05:10', 'none', 'Housing > Housing for rent > Apartament', NULL);
INSERT INTO `listing` VALUES (12, 12, 2, 1, 1, NULL, 'BEACH CONDO-HUGE 1,800 sqft ', 'Amazing Apartments for Rent. Available to Move-In the first week of August. Totally remodeled 1 bedroom unit at $950. Cats are Ok WITH additional security deposit. Great location minutes from downtown, airport, beaches, shopping centers, a block and a half from the Harbor Island and very close to Shelter Island. Quick and easy freeway access. Easy walk to Point Loma restaurants and shops.\r\n\r\nThese cozy, bright units come with a fully equipped kitchen (microwave, gas stove, fridge, etc), pedestal sinks, tiled floors(Kitchen/bathroom), granite counter tops, on-site laundry room, off-street parking also available, on-site manager.\r\n\r\nIf you are interested in viewing this units, reply to this add to harborplace@gmail.com or please contact Paola at 619.987.3634 now! Thank you and have a wonderful day\r\nMove-in spacial: Half OFF for the first month''s rent\r\nRent:$950 and $1095\r\nDeposit: $800\r\nCredit checks: $25 each person ', 1, 0, 0, 0, '15575 Jimmy Durante Blvd', 92014, 'San Diego', 'CA', 'south pb, garage, grill', 4050, 1, 1, 0, '2007-08-07 15:05:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'fff > Housing for rent > Apartament', NULL);
INSERT INTO `listing` VALUES (13, 1, 1, 1, 1, NULL, 'What To Expect When Your Expecting?', 'What to expect when your expecting, pregnancy book. Great for first time moms. This is a must have for new, soon to be, mommies. :)', 1, 0, 0, 0, '5141 Cass St.', 92109, 'San Diego', 'CA', '', 2750, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books', NULL);
INSERT INTO `listing` VALUES (14, 2, 1, 1, 1, NULL, 'ROAD & TRACK MAGAZINES', 'Many, many Road & Track Magazines dating from 1988!!!\n\nThere are about 250 magazines total! Wouldn''t this collection look great sitting on a shelf in your custom garage?\n\nEach magazine is priced at $1 each, or buy 12 for $10. Buy them all for $200!!!!\n\nMoving in two weeks, must sell! Call 619-271-8132. Thanks! ', 1, 0, 0, 0, '3763 Promontory St., Unit A', 92109, 'San Diego', 'CA', 'south pb, garage, grill', 2350, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books > Audio', NULL);
INSERT INTO `listing` VALUES (15, 3, 1, 1, 1, NULL, 'Teachers and parents- This one is for YOU! Sat/Sun 8am-1pm ', 'Tons of books are waiting for good homes and classrooms.\n\nPlease come to 1017-1031 Diamond Street Alley Sat/Sun July 14/15 starting at 8am in Pacific Beach for a Sale. Between Cass or Dawes Street, on the SOUTH side of Diamond St.\n\nMany books are for grades 2 through 8, with an emphasis on Native Americans, American History, World History, Human Body and the arts. Lots of great literature too. Quite a few lit. sets, and collector books, encyclopedias, computers, in addition to books for adults.\nOffice supplies, magazines for children and adults, notebooks too.\nSome arts and craft books and supplies.', 1, 0, 0, 0, '1 Market Pl', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2150, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books > Children''s', NULL);
INSERT INTO `listing` VALUES (16, 4, 1, 1, 1, NULL, '14 Mary Kate and Ashley Chapter Books', 'Books are all in good condition. Books include:\n\nTwo of a kind Diaries #31 Dare to Scare\nTwo of a Kind Diaries #29 Love Set Match\nSweet 16 #1 Never Been Kissed\nSweet 16 #2 Wishes and Dreams\nSweet 16 #3 The Perfect Summer\nSweet 16 #4 Getting There\nSweet 16 #10 Keeping Secrets\nSweet 16 #11 Little White Lies\nSo Little Time #3 Too Good to be True\nSo Little Time #6 Secret Crush\nSo Little Time #10 A Girl''s Guide to Guys\nSo Little Time #11 Boy Crazy\nSo Little Time #12 Best Friends Forever\nSo Little Time #13 Love is in the Air ', 1, 0, 0, 0, '421 West B Street', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2450, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books', NULL);
INSERT INTO `listing` VALUES (17, 5, 1, 1, 1, NULL, 'The Very Best Baby Name Book in the Whole Wide World', 'The Very Best Baby Name Book in the Whole Wide World\n\n\nAuthor: Bruce Lansky Category: Family & Relationships\nPublisher: Meadowbrook Pr Parenting\nISBN-10: 0671561138\nISBN-13: 9780671561130 Condition: Used\nFormat: Softcover\nPublication Year: 1996\n\nAdditional Information about The Very Best Baby Name Book in the Whole Wide World\nPortions of this page Copyright 1995 - 2007 Muze Inc. All rights reserved.\n\nSize\nHeight: 7.3 in.\nWidth: 7.5 in.\nThickness: 1.0 in.\nWeight: 11.2 oz.', 1, 0, 0, 0, '1055 2nd Ave', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 1725, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books', NULL);
INSERT INTO `listing` VALUES (18, 6, 1, 1, 1, NULL, 'College Books for sale!!! '''' fffer ''', '''''fref '''''' Elemental Geosystem, 5th edition(Robert W.Christopherson)\r\nISBN -13-149702-2 -----------$45.00\r\n\r\nAtlas of world Geography (RAnd McNally)\r\nISBN 0-13-185852-1 -----------$1.00\r\n\r\nDiscovering The Universe(Neil F. Comings - William J.Kaufmann III)\r\n7th Edition ISBN 0-7167-6796-1 ------$45.00\r\n\r\nDeaf World (Lois Bragg) ISBN 0-8147-9853-5 ------$10.00\r\n\r\nCore Concepts in Health (Paul M. Insel - Walton T.Roth)\r\nISBN 0-07-255931-4 ------ $2.00\r\n\r\nSigns of Life in the USA(Sonia Maasik -Jack Solomon)(4th edition)\r\nISBN 0-312-39784-4 -------$8.00\r\n\r\nThe Books Are in Excellent Condition (Some are Almost New)\r\n\r\nALL PRICES are CASH (Discount if you buy them all) , NO Checks ,You must pick up ', 1, 0, 0, 0, '2000 2nd St', 92118, 'San Diego', 'CA', 'south pb, garage, grill', 2470, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books > Audio', NULL);
INSERT INTO `listing` VALUES (19, 7, 1, 1, 1, NULL, '(2) Advanced Dungeons & Dragons Books', '2 Advanced Dungeons & Dragon Manuals\n\nDungeon Master Guide & Players'' Handbook\n\nUsed very little, no wear or tear. Pics below. ', 1, 0, 0, 0, '1617 1st Ave', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2150, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books > Children''s', NULL);
INSERT INTO `listing` VALUES (20, 8, 1, 1, 1, NULL, 'Passionate Pilgrims : English Travelers to the World of the Desert Ara', 'SIMMONS, JAMES C. Passionate Pilgrims : English Travelers to the World of the Desert Arabs\nNew York, NY, U.S.A. Morrow/Avon. 1987. (ISBN: 0688065597) Hard Cover\nwith dust jacket. Condition: very good. Price: $7. ', 1, 0, 0, 0, '1404 Vacation Rd', 92109, 'San Diego', 'CA', 'south pb, garage, grill', 2850, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books', NULL);
INSERT INTO `listing` VALUES (21, 9, 1, 1, 1, NULL, 'American heritage new illustrated history of the united states', '1963 American Heritage 16 vols complete, 1963. color illustrated covers. Illustrated in color. 16 vols complete. 7''x10'' condition very good. HardCover. Price: $70. ', 1, 0, 0, 0, '4000 Coronado Bay Rd', 92118, 'San Diego', 'CA', 'south pb, garage, grill', 1250, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'spam', 'Items for sale > Books > Audio', NULL);
INSERT INTO `listing` VALUES (22, 10, 1, 1, 1, NULL, '35000 BABY NAMES', 'Over 25,000 possibilities for naming your baby. Includes variant spellings,\nthe use of family names as first names, traditional ''male'' names for females,\nand names from other countries and cultures. ', 1, 0, 0, 0, '3999 Mission Blvd', 92109, 'San Diego', 'CA', 'south pb, garage, grill', 1450, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books > Children''s', NULL);
INSERT INTO `listing` VALUES (23, 11, 1, 1, 1, NULL, 'Middlesex by Jeffrey Eugenides', 'I''m selling Middlesex by Jeffrey Eugenides paperback book brand new, mint condition, spine in perfect condition for $7. Cash only. ', 1, 0, 0, 0, '939 4th Ave', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2380, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books > Fiction', NULL);
INSERT INTO `listing` VALUES (24, 12, 1, 1, 1, NULL, 'assorted national geographics from 1970 decade', 'All these national geographics are in perfect shape. Look like new. over 60 magaxines all togather. deffinately collectors items. come with any reasonable offer...$100 obo call GARY at 619-277-2776', 1, 0, 0, 0, '15575 Jimmy Durante Blvd', 92014, 'San Diego', 'CA', 'south pb, garage, grill', 4050, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Items for sale > Books', NULL);
INSERT INTO `listing` VALUES (25, 1, 1, 1, 1, NULL, 'PHP Developer - In House Only', 'We are an Interactive agency with offices in San Diego and Beverley Hills. We are looking for a developer that can work in house (gaslamp district) in a contractor position that may lead to a full time one if desired.\n\nRequired Skills:\n* 3+ years of PHP OOP\n* 4+ years of HTML/XHTML\n* Familiarity with Prototype or similar javascript packages\n* Basic understanding of Linux server environments (especially Debian/Ubuntu)\n* Experience with Subversion and working in team development situations\n* Good communication skills\n* Cross-browser knowledge and experience\n* Desire to write clean, maintainable code\n\nDesired skills:\n* PHP framework experience, cake or similar\n* Amazon EC2 & S3 Experience\n* Agile Development Experience\n* RoR experience\nPlease respond with your resume and hourly rate', 1, 0, 0, 0, '5141 Cass St.', 92109, 'San Diego', 'CA', 'north pb, porch, grill', 2750, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (26, 2, 1, 1, 1, NULL, 'Computer Tech', 'Marginally socialized computer geek needed to join like-minded team to work in "Yahoo" type atmosphere. Compensation package commensurate with skill set. Job requires experience in designing and building complex web applications. Required skills include PHP & My SQL and familiarity with UNIX/BSD/Linux. Fax Resume to Ryan: 801-439-1977', 1, 0, 0, 0, '3763 Promontory St., Unit A', 92109, 'San Diego', 'CA', 'south pb, garage, grill', 2350, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (27, 3, 1, 1, 1, NULL, 'PHP DEVELOPER - In House Only', 'Internet Matrix, a 12 person San Diego based development firm is looking for innovative individuals responsible for creating and maintaining PHP / MYSQL based web platforms. The right candidate will have the ability to utilize their talents in a broad range of web development projects, with the opportunity to conceive of solutions and then design and implement them within a team environment.\n\n-Excellent skills in PHP / MYSQL / OOP / LAMP is required.\n-Minimum of 3 years production experience with a web development/design firm.\n-Good communication skills.\n\nCompetitive compensation and benefits package available. Internet Matrix, Inc. is an EQUAL OPPORTUNITY EMPLOYER.\n\nTo apply please send resume WITH Salary History', 1, 0, 0, 0, '1 Market Pl', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2150, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (28, 4, 1, 1, 1, NULL, 'Online Product Producer', 'The Online Product Producer will create new content and products for the recruitment area of SignOnSanDiego.com. This position will be instrumental in creating a top-level user experience that transforms the SignOnSanDiego.com Recruitment site into a destination Web site in its own right. The goal is to increase traffic and revenue by creating product lines and features that are desirable to our customers and advertisers in the local marketplace.\n\nQualified candidates must have a bachelor''s degree plus three years experience in product management and content creation. Specific Internet product management experience is highly desirable. Candidates must possess a robust understanding of Internet technology and terminology; knowledge of Internet publishing and HTML; and have a proven track record of coordinating cross-functional teams. The ideal candidate will have an innovative mindset, positive attitude and zeal to succeed.\n\nHuman Resources Dept.\nJob #152 -07/CC\nP.O. Box 120191\nSan Diego, CA 92112-0191\n\nOr email to ut.jobs@uniontrib.com ', 1, 0, 0, 0, '421 West B Street', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2450, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (29, 5, 1, 1, 1, NULL, 'Flex Developer', 'The San Diego Union-Tribune is currently seeking a Flex Developer to deliver high-quality rich Internet applications (RIA) using Adobe Flex framework. This position must develop database driven rich Internet applications (RIAs) utilizing Adobe Flex 2.0 as the presentation tier and Python-Django as the back-end. The RIAs will be used to expand the Union-Tribunes delivery of information and revenue sources.\n\nThe ideal candidate will have a bachelors degree in computer science or related field or equivalency and advanced knowledge and skills in Adobe Flex applications and RIA development. Strong technical skills in Python-Django, MySQL, PHP, J2EE, and HTML are preferred. The ability to communicate ideas in both technical and user- friendly language is required as are good presentation skills.\nHuman Resources Dept.\nJob #\n3203-07/CC\nP.O. Box 120191\nSan Diego, CA 92112-0191\nOr\nEmail your resume to:\nUT.Jobs@uniontrib.com ', 1, 0, 0, 0, '1055 2nd Ave', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 1725, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (30, 6, 1, 1, 1, NULL, 'Ruby on Rails Developer', 'Ruby on Rails Developer\n\nKidzui is a venture-capital backed software company located in La Jolla, CA, that is building a product to radically enhance how kids use computers. Kidzui is a small software download that creates a safe, fun and personalized internet experience for children. With Kidzui, children can independently discover the best content on the internet, for virtually any subject or interest. The Management Team has extensive experience in building world-class consumer software with such partners as CNN, USA Today, LA Times, and Clear Channel Communications. The Founders and Kidzui Executive team sold their last company to AOL. The company has a small staff of extremely dedicated and talented employees.\n\nThe Company is seeking a unique individual to serve as Ruby on Rails Developer and play a pivotal role in the development and launch of the companys first product (which is in BETA). The position will involve the following responsibilities: 1) UI design, 2) Schema Design, 3) Internal Work Flow Tools, 4) Report Generation and 5) Other to be defined.\n\nSkills and Requirements\n\nTwo or more Ruby Rails projects\n\nComfortable with migrations, rake tasks, has_many :through, with_scope\n\nStrong SQL and query optimization skills,\n\nCSS/XHTML\n\nExcellent verbal and written communications skills, sound interpersonal skills, creative thinking, and the ability to work in a fast paced dynamic project oriented environment.\n\nA passion to work extremely hard in a high-energy, team-driven, entrepreneurial start-up environment.\n\nSalary is commensurate with qualifications and experience. Please submit salary requirements with your resume to the craigslist email above.', 1, 0, 0, 0, '2000 2nd St', 92118, 'San Diego', 'CA', 'south pb, garage, grill', 2470, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (31, 7, 1, 1, 1, NULL, '[Sales] Interactive Account Executive - Agency Experience', 'Immediate Opening: Interactive Agency looking for an experienced Account Executive\n\nSan Diego based SiteLab International [www.sitelab.com], an award winning Interactive agency is seeking an experienced Interactive Account Executive to contribute to and share in our companys rapid growth. An Account Executive is responsible for achieving annual sales quotas focused on new and existing business targets through excellent sales development skills and superior communication skills with experience selling online media and Web site development.\n\nPosition will require a combination of several skill sets including consultative solution selling, presentation experience, customer interaction and relationship building.\n\nJob Detail:\n\nEssential Duties and Responsibilities\n Responsible for prospecting, proposal development and writing, closing sales, and billing and collections.\n Generate leads into prospects by cold calling/networking and referrals from outside sources and inbound leads\n Client presentation and proposal writing essential element of the sales process\n Penetrate "targeted" accounts within a vertical market structure\n Identify key players, research and obtain business requirements, and present solutions to begin sales cycle\n Work closely with Sales Management and Production/Marketing Team to determine a strategic approach and client scope of work\n Produce and deliver quality client sales solution through a client proposal\n Ensure strong communication and follow-up by passing lead or prospect through salesforce.com with all designated calls-to-action, follow-up dates, complete profile information, lead source, etc.\n Handle all required client follow-up regarding billing and collections\n Responsible for new business sales quota to achieve sales bonus and increased commission\n Achieving minimum sales goals quarterly is a condition of employment. Must be a closer.\n Some travel required.\n Other duties as assigned. ', 1, 0, 0, 0, '1617 1st Ave', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2150, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (32, 8, 1, 1, 1, NULL, 'SENIOR QUALITY ENGINEER WITH A GREAT MEDICAL DEVICE COMPANY!', '---------------------------------------------------------------------\nRequirements - PLEASE READ!\nPLEASE NOTE EACH OF THE QUALIFICATIONS! A COVER LETTER MUST BE SUBMITTED IN CONJUNCTION WITH THIS POSITION AND SPEAK TO EACH OF THE REQUIREMENTS AND HOW YOU HAVE UTILIZED THEM PREVIOUSLY!\n\nRESUMES LACKING A COVER LETTER WILL NOT BE CONSIDERED. DIRECT HIRE POSITION.\n\nPlease include salary requirements!\n----------------------------------------------------------------------\nDescription\nSUMMARY\nPrimary responsibilities include developing, implementing and improving overall quality systems, including quality standards, test methods, process control techniques, and reviewing documents such as Work Instructions, Quality Assurance Specifications, Final Inspection Instructions, protocols and reports to ensure safety, reliability and efficacy of new products, processes and significant changes related to existing medical devices.\n\nESSENTIAL DUTIES AND RESPONSIBILITIES\nEvaluate design quality, monitoring, qualification, validation and trouble shooting activities. This will encompass product configuration control to assess the effects on materials compatibility, manufacturing processing and product physical properties; change control, validation and verification; defect corrective action process (investigation of performance issues on existing products; liaison and contributor for product development teams; test protocol development and implementation and; data monitoring, analysis and reporting.\nDevelop, recommend, and implement product / process improvements based on production and field input mechanisms.\nAssist the Research and Development department to verify that; modifications to the manufacturing processes and/or product design do not affect product suitability for its intended use; assist in IQ, OQ, PQ of new equipment and processes.\nProvide statistical support to analyze manufacturing processes and to recommend appropriate process controls for ensuring product conformance to specification and favorable yield levels.\nSpecify and design inspection and test equipment as well as associated fixtures.\nAssist with customer complaints investigations, gathers relevant information, and refers them to Regulatory Affairs.\nOther duties as assigned. ', 1, 0, 0, 0, '1404 Vacation Rd', 92109, 'San Diego', 'CA', 'south pb, garage, grill', 2850, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (33, 9, 1, 1, 1, NULL, 'Actionscript Developer', 'Kidzui is a venture-capital backed software company located in La Jolla, CA, that is building a product to radically enhance how kids use computers. Kidzui is a small software download that creates a safe, fun and personalized internet experience for children. With Kidzui, children can independently discover the best content on the internet, for virtually any subject or interest. The Management Team has extensive experience in building world-class consumer software with such partners as CNN, USA Today, LA Times, and Clear Channel Communications. The Founders and Kidzui Executive team sold their last company to AOL. The company has a small staff of extremely dedicated and talented employees.\n\nThe Company is seeking a unique individual to serve as a Software Developer and play a pivotal role in the development and launch of the companys first product (which is in BETA). The position will involve the following responsibilities: 1) UI design, 2) Schema Design, 3) Internal Work Flow Tools, 4) Report Generation and 5) Other to be defined.\n\nSkills and Requirements\n\nTwo or more years Actionscript 2.0\n\nExperience with large Actionscript projects\n\nExperience with code driven animations\n\nUI design skills\n\nCreative\n\nWork well as part of a team\n\nExcellent verbal and written communications skills, sound interpersonal skills, creative thinking, and the ability to work in a fast paced dynamic project oriented environment.\n\nA passion to work extremely hard in a high-energy, team-driven, entrepreneurial start-up environment.\n\nSalary is commensurate with qualifications and experience. Please submit salary requirements with your resume to the craigslist email above.', 1, 0, 0, 0, '4000 Coronado Bay Rd', 92118, 'San Diego', 'CA', 'south pb, garage, grill', 1250, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (34, 10, 1, 1, 1, NULL, 'UCSD Java Developer / SPEAR Team, #43263', 'Imagine working on a campus ranked among the top leading research universities in the United States. Imagine working with a team of IT professionals who develop the best technology innovations in higher education. UCSD''s commitment to excellence has resulted in national recognition for both our technology solutions and our management philosophy. Individual integrity, mutual respect and trust comprise the foundation for our success.\n\nDESCRIPTION:\nSeeking top-notch Java developer/analyst with strong technical knowledge and experience in the development, implementation and integration of object-oriented Web-based administrative information systems. The area of focus would be the development, integration and support of solutions for the Research Administration and Financial Systems. Use state-of-the-art technologies and architectures (e.g., Sun and IBM Enterprise servers and mainframes, SOA, J2EE , XML, SQL, Sybase, Oracle, DB2). We provide our staff with excellent training opportunities.\n\nQUALIFICATIONS:\n Degree in Computer Science, MIS or related field, or equivalent work experience which includes six or more years in software development and at least two years of technical leadership experience.\n Top-notch Java developer/analyst with strong technical knowledge and experience in the development, implementation and integration of object-oriented Web-based administrative information systems, Java Servlets.\n Demonstrated expertise in Internet technologies, including Web tools and third-party applications (typical tools, technologies and products: Java/J2EE, Java Servlets using OO Model 2 design pattern frameworks, JavaScript, HTML, XML, etc.).\n Demonstrated knowledge of UML Modeling and object-oriented programming methodologies.\n Effective skill in written and verbal communications. Demonstrated ability to develop written specifications such as Strategies, Requirements, General Design, Detail Design and Test Plans to support Systems Development Life Cycle processes.\n Proven project leadership ability and experience in working with clients and from different areas on an integrated project.\n Experience developing, deploying and integrating systems in multi-platform environments (examples: Windows, Macintosh, Unix, etc.).\n Demonstrated knowledge and experience with Sybase, Oracle, DB2 or other SQL-based relational database system.\n\nSpecial Conditions of Employment: Background check required.\n\nFor detailed information, visit our Website at http://www.act.ucsd.edu/jobs, job number 43263. Send your resume and a cover letter to actjobs@ucsd.edu, specifying job #43263 in the subject line.\n\nUCSD Job Bulletin: http://joblink.ucsd.edu/\n\nUCSD Administrative Computing and Telecommunications is an Equal Employment Opportunity / Affirmative Action Employer.', 1, 0, 0, 0, '3999 Mission Blvd', 92109, 'San Diego', 'CA', 'south pb, garage, grill', 1450, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (35, 11, 1, 1, 1, NULL, 'VoIP Engineer / High Level Support', 'JOB DESCRIPTION:\n\nVoIP Engineer / High Level Support\n\nThe Company is a rapidly growing San Diego, California based VoIP telephone company and VoIP technology innovator. The Company has developed and launched unique, robust, and proprietary Wholesale and White Label VoIP service offerings for Carriers and Enterprises. Featuring the ultimate selection of end user features via a virtually instant turnkey setup that includes private branding, there isn''t a more complete product suite in the market today. Whether a customer is launching a new VoIP company or looking to reduce costs of existing telecom services, we are the premier choice for VoIP solutions.\n\nResponsibilities:\n\n- Operation and maintenance of VoIP soft switching platform\n\n- Technical support for enterprise customers\n\n- Research and development of new soft switch features and hardware.\n\n- Installation and maintenance of SBCs, proxying equipment, TDM interconnection hardware, etc.\n\n\nRequirements:\n\n- In-depth knowledge of SIP\n\n- Understanding of VoIP switching methodologies such as LCR, SIP Trunking, PSTN interconnection, QoS, NAT traversal.\n\n- Experience with VoIP specific hardware and software.\n\n- Ability to quickly analyze a multifaceted network and diagnose potential problems\n\n- Knowledge of core routing protocols such as BGP and MPLS\n\n\nWe are searching for experienced and highly intuitive VoIP engineers looking for an opportunity to help grow a rapidly expanding nationwide network. If you have expertise in VoIP software and hardware and would like to join an innovative company who is on the cutting edge of the fast paced VoIP market, email us your resume and cover letter. If you have specific experience with VoIP hardware and software such as Cisco, Nextone, SER, Asterisk, Broadsoft, Syllantro, or any others please let us know as this is a benefit.\n\nYour Future Is Calling - Are You Going To Answer? ', 1, 0, 0, 0, '939 4th Ave', 92101, 'San Diego', 'CA', 'south pb, garage, grill', 2380, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (36, 12, 1, 1, 1, NULL, 'SEO needed for Cutting Edge Internet Marketing Firm', 'Our company prides itself on delivering exceptional results to clients as well as our own network of websites. As a multi-faceted company we embrace versatility in our employees and are looking for innovators.\n\nWe are seeking a highly-motivated individual to manage search engine optimization analysis and best-practice implementations, as well as monthly campaigns for client projects as well as our own websites. Candidate will work alongside our knowledgeable SEO strategist, who brings more than 7 years of search optimization experience, and will be responsible for improving search engine visibility and ROI through the implementation of cutting edge optimization strategies.\n\nCandidate needs a strong background of experience with search engines and search engine methodologies, search engine friendly content, link and web site architecture strategies and an understanding of page construction.\n\nThe ideal candidate will have experience in building web pages, or working closely with programmers to build web pages, which rank high in organic search engine listings (whether static, custom dynamic, or CMS based), performing detailed keyword analysis, analyzing and tracking online conversions and developing new search engine optimization strategies.\n\nPrincipal Responsibilities:\n Analyze search engine ranking positions and implementing strategies to improve search engine visibility and ROI via ''on page'' and ''off page'' SEO strategies\n Optimize SEO performance, analyze SEO initiatives, make recommendations and communicate overall SEO objectives and results\n Continuously refine search engine marketing strategies, and understanding of the search engine landscape, and the effectiveness of SEO techniques\n Identifying emerging search engine algorithm trends\n Work with web development team to ensure the development of site architectures compatible with search engine optimization efforts\n Work with SEO team to select the most appropriate keyword phrases for optimization utilizing a variety of online tools and competitive research and analysis\n Develop scopes of work for the execution of search engine marketing and optimization campaigns\n Manage all aspects of SEO projects including kickoff, requirements analysis, development, testing and launch\n Anticipating and/or maintaining awareness of all potential and existing issues facing search engine optimization projects, and collaborating with team members to develop solutions/strategies\n Have a high degree of focus on link popularity development\n Ability to communicate instructions, expectations and deadlines clearly and effectively\n\nProject Management Responsibilities:\n\n Assist in the development of project and communication plans for each initiative\n Help manage risk when developing project timelines, budgets, scope and specs, and quality\n Provide critical support during SEO setup phases and day to day support and troubleshooting of issues for clients\n Work with copywriters and web developers, whether in-house, client-managed, or contracted, to ensure they are applying best practices and producing a product which coincides with our goals as a search engine optimization company.\n\nJob Requirements/Skill Specifications:\n\nEducation:\no Bachelors degree required\no Preferred in CS, CIS, Marketing, or Business Mgmt/Admin\nExperience:\no 2+ years of relevant organic search engine marketing experience\no Experience in quality search engine optimization for multiple client sites desired\nSkills:\no Strong analytical skills and data analysis\no Knowledge of web analytics\no Internet savvy with knowledge of search engines and natural search engine algorithms\no Intermediate or higher Excel proficiency and working knowledge of MS Office software\no Knowledge of HTML and CSS\no Strong quantitative, critical thinking and excellent verbal and written communication skills\no Ability to work in a fast-paced, aggressive growth environment\no Ability to take initiative and work independently\no Excellent communication (written and verbal), listening, and team work skills\nPluses\no Knowledge of PowerPoint and Visio\no Knowledge of XML\no Experience managing Google and/or Yahoo Pay-Per-Click accounts\no Google Adwords Professional or Yahoo Search marketing certification\no Blogging Experience\no DMOZ Editor\no Moderator or Senior member at leading forums\n\nValue Added Expertise:\n\nProgramming / CS / CIS Credentials or Experience:\no PHP or ASP.net programming ability would be a highly valued asset to us.\no Experience as a Wordpress or Drupal developer would be a highly valued asset to us.\n\nSocial Media Marketing/Social Media Optimization:\no Proven experience using sites like digg.com, del.icio.us, myspace, facebook, etc. to market, obtain traffic, drive leads/sales is a major plus.\no Proven success at linkbaiting, obtaining seo-friendly links from social networking, etc.\n\n\n\nSummary:\nIn summary, we are looking for a team member who is sharp, who takes his craft seriously, who will want to see the company succeed, and who is very professional and proactive in dealing with clients.\n\nCompany is confidential\nSalary: $40K-$70K depending on experience ', 1, 0, 0, 0, '15575 Jimmy Durante Blvd', 92014, 'San Diego', 'CA', 'south pb, garage, grill', 4050, 1, 1, 0, '2007-08-07 15:05:11', '0000-00-00 00:00:00', '2007-08-07 15:05:11', 'none', 'Jobs > Information Technology > Web Development', NULL);
INSERT INTO `listing` VALUES (37, NULL, 2, 3, 1, NULL, 'short', '222', 1, 1, 0, 0, 'address', 2222, 'city', 'by', 'ddwedwedwed', 22, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (38, 0, 1, 4, 1, NULL, 'wqdqwdqwd', '222', 0, 0, 0, 0, 'dqdqwdq', 22, 'dqwdqwd', '22', '222', 22, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (39, 0, 2, 20, 1, NULL, 'sqwsq', '22', 0, 0, 0, 0, 'sqsqws', 22, 'sqwsqws', '22', '', 222, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (40, 0, 2, 21, 1, NULL, 'dqwd', '222', 0, 0, 0, 0, 'dwqdq', 22, 'dqwd', '22', '', 222, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (101, 0, 2, 65, 1, NULL, 'dwedwd', '222', 0, 0, 0, 0, 'dwedw', 322, 'dwdwed', 'ewew', 'tGS', 222, 0, 0, 0, '2007-11-06 13:44:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'fff > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (47, 0, 2, 14, 1, NULL, '1234567', '333', 1, 1, 0, 0, '1234567', 33, '1234567', '22', 'wqsqwswq', 3, 0, 0, 0, '0000-00-00 00:00:00', '2007-09-10 20:42:52', '0000-00-00 00:00:00', 'none', 'Housing > Housing for rent > Condo, Townhouse', NULL);
INSERT INTO `listing` VALUES (44, 0, 2, 14, 1, NULL, 'dqwd', '222', 1, 1, 0, 0, 'dwqdq', 22, 'dqwd', '22', '', 222, 0, 0, 0, '0000-00-00 00:00:00', '2007-09-10 22:59:24', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (100, 0, 2, 14, 1, NULL, 'dwedwed', '333', 1, 1, 0, 0, 'dwedwed', 3333, 'dwedwe', '33', 'taags', 333, 0, 0, 0, '2007-11-06 13:43:53', '2007-11-06 13:46:05', '0000-00-00 00:00:00', 'none', 'fff > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (84, 0, 1, 54, 1, NULL, 'sqwsqws', '22', 0, 0, 0, 0, 'sqwswq', 222, 'sqwsqwsqw', '222', 'sqwsqws', 222, 0, 0, 0, '2007-10-11 18:00:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (48, 0, 3, 14, 1, NULL, 'dwdwa', '22', 1, 1, 1, 1, 'dwd', 22, 'dad', '22', 'cascascasc', 44, 1, 1, 0, '2007-08-29 15:55:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'test > ferfef > ferfef', NULL);
INSERT INTO `listing` VALUES (49, 0, 3, 14, 1, NULL, 'qwsqws', '222', 1, 1, 0, 0, 'sqwsqws', 222, 'sqwwsqw', '22', '222', 0, 0, 0, 0, '2007-08-29 15:57:38', '2007-10-03 23:37:16', '2007-08-29 17:20:25', 'none', 'Jobs > Accounting, Finance', NULL);
INSERT INTO `listing` VALUES (50, 0, 3, 28, 1, NULL, 'ddd', '222dwqd', 0, 0, 0, 0, 'ddd', 22, 'dd', '22', '222', 0, 0, 0, 0, '2007-08-29 20:02:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Jobs > Accounting, Finance', NULL);
INSERT INTO `listing` VALUES (51, 0, 3, 30, 1, NULL, 'ddd', '222dwqd', 0, 0, 0, 0, 'ddd', 22, 'dd', '22', '222', 0, 0, 0, 0, '2007-08-29 20:02:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Jobs > Accounting, Finance', NULL);
INSERT INTO `listing` VALUES (52, 0, 3, 32, 1, NULL, 'ddd', '222dwqd', 0, 0, 0, 0, 'ddd', 22, 'dd', '22', '222', 0, 0, 0, 0, '2007-08-29 20:03:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Jobs > Accounting, Finance', NULL);
INSERT INTO `listing` VALUES (53, 0, 1, 36, 1, NULL, 'dqwdqwd', 'dqwdqwd', 0, 0, 0, 0, 'dqwdqw', 0, 'dqwdqwd', 'dqwd', 'dwqdqwd', 222, 0, 0, 0, '2007-08-29 20:06:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (54, 0, 1, 38, 1, NULL, 'dwedewd', '222', 0, 0, 0, 0, 'dwedwed', 222, 'dwedwd', 'wed', 'ddd', 222, 0, 0, 0, '2007-08-29 20:16:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (55, 0, 1, 40, 1, NULL, '12345', '222', 0, 0, 0, 0, 'qwdwd', 22, 'dqwdqd', '22', 'dqwdwd', 22, 0, 0, 0, '2007-08-29 20:24:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (56, 0, 3, 41, 1, NULL, 'www', '11', 0, 0, 0, 0, 'wwww', 11, 'ww', '111', 'ssq', 0, 0, 0, 0, '2007-08-29 20:33:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Jobs > Accounting, Finance', NULL);
INSERT INTO `listing` VALUES (57, 0, 2, 42, 1, NULL, 'dqwdqwd', '22', 0, 0, 0, 0, 'dqwdqw', 22, 'dqwdqwd', '222', 'dqwddwd', 22, 0, 0, 0, '2007-08-29 20:41:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (58, 0, 1, 43, 1, NULL, 'ddd', '222', 1, 0, 0, 0, 'ddd', 22, 'ddd', 'by', 'dqwdqwd', 222, 0, 0, 0, '2007-08-29 20:43:45', '2007-08-29 20:44:41', '0000-00-00 00:00:00', 'forbidden', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (59, 0, 2, 43, 1, NULL, 'cascwwwww', 'www', 0, 0, 0, 0, 'cascwww', 0, 'cascwwww', 'za', 'dqwdq', 11, 0, 0, 0, '2007-08-29 20:59:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (60, 0, 1, 43, 1, NULL, 'dD', 'dqwdqwdwqd', 0, 0, 0, 0, 'dqdqwdq', 222, 'dDd', '222', '222', 222, 0, 0, 0, '2007-08-29 21:00:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (61, 0, 3, 43, 1, NULL, 'dqwdwqd', 'dqwdqwd', 0, 0, 0, 0, 'dqwdqwd', 2200, 'city', 'by', 'dqwdqwd', 0, 1, 1, 0, '2007-08-29 21:08:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Jobs > Accounting, Finance', NULL);
INSERT INTO `listing` VALUES (62, 0, 2, 46, 1, NULL, 'zzzz', 'minsk', 0, 0, 0, 0, 'zzz', 220012, 'Minsk', 'by', 'tgs', 22, 0, 0, 0, '2007-08-29 22:02:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (63, 0, 1, 46, 1, NULL, 'dwdwdzzzzzzzzzzz', 'dqwdqwd', 1, 0, 0, 0, 'dewdewd', 220013, 'dwedwe', 'dwedwe', 'tah', 22, 1, 1, 0, '2007-08-29 22:22:25', '2007-08-29 22:22:32', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (66, 14, 2, 48, 1, NULL, 'fender', 'fender', 0, 0, 0, 0, 'fender', 22222, 'fender', '222', 'fender', 222, 0, 0, 0, '2007-09-17 21:43:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (67, 15, 2, 48, 1, NULL, 'gibson', '222', 0, 0, 0, 0, 'gibson', 22, 'gibson', '22', 'gibson', 22, 0, 0, 0, '2007-09-17 21:45:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (68, 16, 2, 50, 1, NULL, 'serge', '22', 0, 0, 0, 0, 'serge', 222, 'serge', '22', 'serge', 222, 0, 0, 0, '2007-09-18 00:13:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (69, 0, 2, 51, 1, NULL, 'sss@tut.by', '22', 0, 0, 0, 0, 'sss@tut.by', 222, 'sss@tut.by', '22', '22222', 222, 0, 0, 0, '2007-09-18 00:27:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (70, 0, 2, 52, 1, NULL, 'short', 'ddd', 0, 0, 0, 0, 'address', 0, '3c.tut.by', 'dd', 'tags', 22, 0, 0, 0, '2007-09-18 00:44:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (71, 0, 1, 14, 1, NULL, 'dwqdqwd', '2222', 1, 1, 0, 0, 'dqwdqw', 220013, 'dqwdqwd', '22', '', 222, 1, 1, 0, '2007-09-18 21:24:21', '2007-09-18 21:33:51', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (72, 17, 2, 53, 1, NULL, 'short', '', 0, 0, 0, 0, 'short', 222, 'short', '22', 'sqwsq', 22, 0, 0, 0, '2007-09-18 21:40:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (73, 18, 1, 2, 1, NULL, '22', '2222', 0, 0, 0, 0, '22222', 22, '22', '22', '222', 222, 0, 0, 0, '2007-09-28 19:58:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (74, 0, 2, 14, 1, NULL, 'swsw', '2222', 0, 0, 0, 0, 'swsws', 222, 'w222', '22222', '222', 222, 0, 0, 0, '2007-09-28 21:46:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Housing > Houseing for sale', NULL);
INSERT INTO `listing` VALUES (75, 0, 1, 14, 1, NULL, 'blabla&#039;', '222', 1, 0, 0, 0, 'swqsqw', 222, 'sqwsqws', '22', '', 2222, 1, 0, 0, '2007-10-10 15:06:38', '2007-10-10 15:07:18', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (76, 0, 1, 14, 1, NULL, 'efwef', 'dewdwedewd', 1, 0, 0, 0, 'fwefwe', 33, 'wefew', '33', '', 333, 0, 0, 0, '2007-10-11 15:00:11', '2007-10-11 15:16:05', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (77, 0, 1, 14, 1, NULL, 'e23e23', '3333e', 0, 0, 0, 0, 'e23e2', 333, '333', '33', '333', 333, 0, 0, 0, '2007-10-11 15:12:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (78, 0, 1, 14, 1, NULL, 'r32r23r', '333', 0, 0, 0, 0, 'r32r32', 3333, 'rr23r', '333', '', 333, 0, 0, 0, '2007-10-11 15:13:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (85, 0, 1, 55, 1, NULL, 'sqwsw', '22', 0, 0, 0, 0, 'sqwsqs', 222, 'sqwsq', '22', 'w12w21w', 222, 0, 0, 0, '2007-10-11 18:08:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (80, 0, 1, 14, 1, NULL, 'zzzz', 'dwedwed ''', 1, 0, 0, 0, 'zzzz', 444, 'zzz', 'zzz', 'dwdwedew', 1234, 0, 0, 0, '2007-10-11 15:21:15', '2007-10-11 15:22:04', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (82, 0, 1, 14, 1, NULL, 'frfr', '3333', 1, 1, 0, 0, 'frfrf', 33, '3333', '333', '', 333, 1, 0, 0, '2007-10-11 17:22:59', '2007-10-11 17:25:30', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (83, 0, 1, 14, 1, NULL, '111111', '11111', 1, 1, 0, 0, 'sqwsqwswq', 2202212, 'Minsk', 'By', 'sqwsqs', 123, 0, 0, 0, '2007-10-11 17:48:55', '2007-10-11 17:54:28', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (90, 20, 1, 14, 1, NULL, 'ddwedwed', '22few', 0, 0, 0, 0, '222', 222, '222', '22', 'fewfwf', 22, 0, 0, 0, '2007-10-11 18:46:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (91, 0, 1, 14, 1, NULL, 'dqwdqwd', '222', 0, 0, 0, 0, 'dqwdqw', 22, '222', '22', 'tags', 22, 0, 0, 0, '2007-10-11 19:56:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (92, 0, 1, 15, 1, NULL, 'swqswqs', '222', 0, 0, 0, 0, 'sqwsqws', 22, '222', '22', 'xsaxasx', 222, 0, 0, 0, '2007-10-15 18:14:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (93, 0, 1, 59, 1, NULL, 'dwqd', '222', 0, 0, 0, 0, 'dwqdwq', 222, 'dqdwqd', '22', '222', 22, 0, 0, 0, '2007-10-15 18:57:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (94, 0, 1, 14, 1, NULL, 'dwedwd', '22', 0, 0, 0, 0, 'wedwed', 222, 'wdwd', '22', 'sqws', 222, 0, 0, 0, '2007-10-15 19:06:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (95, 0, 1, 60, 1, NULL, 'dqwd', 'sqwsqws', 0, 0, 0, 0, 'dwqd', 222, 'dqwd', 'dd', 'sqwsq', 222, 0, 0, 0, '2007-10-16 20:25:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (96, 21, 1, 61, 1, NULL, '22', '2222', 0, 0, 0, 0, '22222', 2, '22', '222', '222', 222, 0, 0, 0, '2007-10-16 20:55:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (97, 0, 1, 62, 1, NULL, 'sss', '22', 0, 0, 0, 0, 'sss', 22, 'sss', '22', 'tags', 222, 0, 0, 0, '2007-10-16 21:02:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (98, 0, 1, 63, 1, NULL, 'ssss', '222', 0, 0, 0, 0, 'ssss', 22, 'ss2', '22', '22', 222, 0, 0, 0, '2007-10-16 21:03:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (99, 0, 1, 64, 1, NULL, 'swqs', 'wswqs', 0, 0, 0, 0, 'sqws', 2002, 'minsk', 'by', 'swqs', 22, 0, 0, 0, '2007-10-16 21:04:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Items for sale > Art', NULL);
INSERT INTO `listing` VALUES (102, NULL, 0, 0, 0, NULL, 'ferfer', 'ferferferf', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2007-12-25 23:47:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', NULL, NULL);
INSERT INTO `listing` VALUES (103, NULL, 0, 0, 0, NULL, 'ferfer', 'ferferferf', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2007-12-25 23:50:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', NULL, NULL);
INSERT INTO `listing` VALUES (104, NULL, 4, 0, 0, NULL, 'ferfer', 'ferferferf', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2007-12-25 23:51:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', NULL, NULL);
INSERT INTO `listing` VALUES (105, NULL, 4, 0, 0, NULL, 'ferfer', 'ferferferf', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2007-12-25 23:53:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', NULL, NULL);
INSERT INTO `listing` VALUES (112, NULL, 4, 0, 0, NULL, 'test', '<p>test</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 11:47:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Меню', NULL);
INSERT INTO `listing` VALUES (108, NULL, 4, 0, 0, NULL, 'ferfer', '<p>ferferferf</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2007-12-26 00:09:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', '', NULL);
INSERT INTO `listing` VALUES (109, NULL, 4, 0, 0, NULL, 'test', 'test', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2007-12-28 22:16:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Меню > fff', NULL);
INSERT INTO `listing` VALUES (110, NULL, 4, 0, 0, NULL, 'jjjj', '<p><strong>jj</strong></p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2007-12-28 22:22:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', '', NULL);
INSERT INTO `listing` VALUES (111, NULL, 4, 0, 0, 'ab3ee77f1f130b41224b96a6f02c2b20.jpg', 'рекламная акция', '<p><strong>тест</strong></p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2007-12-28 22:38:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Главная страница > fff', NULL);
INSERT INTO `listing` VALUES (113, NULL, 4, 0, 0, '1edc36bac97c560d6d3843ff3037189f.jpg', 'реклама', '<p>мега реклама</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 14:36:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Страницы > Предложени от белгазпромбанка', NULL);
INSERT INTO `listing` VALUES (114, NULL, 4, 0, 0, 'fba410d4b59761b88552982672dd68b7.jpg', 'ауауауа', '<p>ацуацуауцацуа</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 14:38:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Страницы > Предложени от белгазпромбанка', NULL);
INSERT INTO `listing` VALUES (115, NULL, 4, 0, 0, '4c5d10819c792e83671bde7f61583502.jpg', 'новая реклама', '<p>привет всем</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 14:40:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Страницы > Предложени от белгазпромбанка', NULL);
INSERT INTO `listing` VALUES (116, NULL, 4, 0, 0, '660a97e7216d689b9f5e05dca6d5dab6.jpg', 'мывмвым', '<p>ацуацуаца</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 14:41:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Страницы > Предложени от белгазпромбанка', NULL);
INSERT INTO `listing` VALUES (117, NULL, 4, 0, 0, 'ef59ed9251b4c94deb066d33ddc6fdf8.jpg', 'вцувцвцув', '<p>вцувцвцвц</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 14:42:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Страницы > Предложени от белгазпромбанка', NULL);
INSERT INTO `listing` VALUES (118, NULL, 4, 0, 0, NULL, 'вцувц', '<p>вцвцвц</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 14:43:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Страницы > Предложени от белгазпромбанка', NULL);
INSERT INTO `listing` VALUES (119, NULL, 4, 0, 0, 'a1d26a19c5e810c9b6c6f92cc3a342b3.jpg', 'опа', '<p>вцувцвцв</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 14:44:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Страницы > Предложени от белгазпромбанка', NULL);
INSERT INTO `listing` VALUES (120, NULL, 4, 0, 0, 'b7be5abbefa8c9caa9cf162dd915a881.jpg', 'новый год в париже', '<p><em>курцувцувцувцув</em></p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 16:25:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Главная страница > Услуги > Самые свежие услуги', NULL);
INSERT INTO `listing` VALUES (121, NULL, 4, 0, 0, NULL, 'супер новость раз', '<p>вцувцувцув</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 16:29:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'новости', NULL);
INSERT INTO `listing` VALUES (122, NULL, 4, 0, 0, NULL, 'супер новость два', '<p>вцйвцв</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 16:29:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'новости', NULL);
INSERT INTO `listing` VALUES (123, NULL, 4, 0, 0, NULL, ' супер новость три', '<p>вцувцвцв</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 16:29:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'новости', NULL);
INSERT INTO `listing` VALUES (124, NULL, 4, 0, 0, NULL, 'Супер новость четыре', '<p>опа</p>', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2008-01-04 16:44:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'none', 'Новости', NULL);

-- --------------------------------------------------------

-- 
-- Структура таблицы `listing_type`
-- 

CREATE TABLE `listing_type` (
  `listing_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `short_description` varchar(256) CHARACTER SET cp1251 NOT NULL,
  `alias` varchar(20) NOT NULL,
  `additional_xmlfields` mediumtext,
  PRIMARY KEY (`listing_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Дамп данных таблицы `listing_type`
-- 

INSERT INTO `listing_type` VALUES (1, 'Items for Sale', 'items', '<form>\r\n\r\n	<fields>\r\n		\r\n			<field not_required="1">\r\n			<id>image1</id>\r\n			<type>file</type>\r\n			<file>\r\n				<filetype>image</filetype>\r\n				<size>1-8192</size>\r\n				<path>/images/cat_items/</path>\r\n			</file>\r\n			<title>\r\n				<en>Image1</en>\r\n				\r\n			</title>\r\n			\r\n		\r\n		</field>\r\n		<field not_required="1">\r\n			<id>image2</id>\r\n			<type>file</type>\r\n			<file>\r\n				<filetype>image</filetype>\r\n				<size>1-8192</size>\r\n				<path>/images/cat_items/</path>\r\n			</file>\r\n			<title>\r\n				<en>Image2</en>\r\n				\r\n			</title>\r\n			\r\n		\r\n		</field>\r\n		<field not_required="1">\r\n			<id>image3</id>\r\n			<type>file</type>\r\n			<file>\r\n				<filetype>image</filetype>\r\n				<size>1-8192</size>\r\n				<path>/images/cat_items/</path>\r\n			</file>\r\n			<title>\r\n				<en>Image3</en>\r\n				\r\n			</title>\r\n			\r\n		\r\n		</field>\r\n		<field not_required="1">\r\n			<id>image4</id>\r\n			<type>file</type>\r\n			<file>\r\n				<filetype>image</filetype>\r\n				<size>1-8192</size>\r\n				<path>/images/cat_items/</path>\r\n			</file>\r\n			<title>\r\n				<en>Image4</en>\r\n				\r\n			</title>\r\n			\r\n		\r\n		</field>\r\n\r\n\r\n	\r\n	</fields>\r\n</form>');
INSERT INTO `listing_type` VALUES (2, 'Housing', 'housing', '<form>\r\n\r\n	<fields>\r\n	\r\n\r\n		<field not_required="1">\r\n			<id>image1</id>\r\n			<type>file</type>\r\n			<file>\r\n				<filetype>image</filetype>\r\n				<size>1-8192</size>\r\n				<path>/images/cat_items/</path>\r\n			</file>\r\n			<title>\r\n				<en>Image1</en>\r\n				\r\n			</title>\r\n			\r\n		\r\n		</field>\r\n		<field not_required="1">\r\n			<id>image2</id>\r\n			<type>file</type>\r\n			<file>\r\n				<filetype>image</filetype>\r\n				<size>1-8192</size>\r\n				<path>/images/cat_items/</path>\r\n			</file>\r\n			<title>\r\n				<en>Image2</en>\r\n				\r\n			</title>\r\n			\r\n		\r\n		</field>\r\n		<field not_required="1">\r\n			<id>image3</id>\r\n			<type>file</type>\r\n			<file>\r\n				<filetype>image</filetype>\r\n				<size>1-8192</size>\r\n				<path>/images/cat_items/</path>\r\n			</file>\r\n			<title>\r\n				<en>Image3</en>\r\n				\r\n			</title>\r\n			\r\n		\r\n		</field>\r\n		<field not_required="1">\r\n			<id>image4</id>\r\n			<type>file</type>\r\n			<file>\r\n				<filetype>image</filetype>\r\n				<size>1-8192</size>\r\n				<path>/images/cat_items/</path>\r\n			</file>\r\n			<title>\r\n				<en>Image4</en>\r\n				\r\n			</title>\r\n			\r\n		\r\n		</field>\r\n	\r\n	<field id="bedrooms">\r\n			\r\n			<type>int</type>\r\n			<title>\r\n				<en>Bedrooms</en>\r\n			</title>\r\n							\r\n		</field>\r\n		<field id="bathrooms">\r\n			\r\n			<type>int</type>\r\n			<title>\r\n				<en>Bathrooms</en>\r\n			</title>\r\n							\r\n		</field>\r\n		<field id="square_footage" not_required="1">\r\n			\r\n			<type>float</type>\r\n			<title>\r\n				<en>Square Footage</en>\r\n			</title>\r\n							\r\n		</field>\r\n\r\n		\r\n	</fields>\r\n</form>');
INSERT INTO `listing_type` VALUES (3, 'Jobs', 'jobs', '<form>\r\n\r\n	<fields>\r\n\r\n		<field id="company_name" not_required="1">\r\n			\r\n			<type>string</type>\r\n			<title>\r\n				<en>Company</en>\r\n			</title>\r\n							\r\n		</field>\r\n	\r\n		<field id="compensation" not_required="1">\r\n			\r\n			<type>string</type>\r\n			<title>\r\n				<en>Job Compensation</en>\r\n			</title>\r\n							\r\n		</field>\r\n		<field id="compensation_type" not_required="1">\r\n			\r\n			<type>string</type>\r\n			<title>\r\n				<en>Job compensation type</en>\r\n			</title>\r\n			<enum>\r\n				<values>\r\n				<value>hourly</value>\r\n				<value>salary</value>\r\n				</values>\r\n			</enum>						\r\n\r\n		</field>\r\n		<field id="position_type">\r\n			\r\n			<type>string</type>\r\n			<title>\r\n				<en>Job position type</en>\r\n			</title>\r\n			<enum>\r\n				<values>\r\n				<value>intern</value>\r\n				<value>part-time</value>\r\n				<value>full-time</value>\r\n				<value>contract</value>\r\n				</values>\r\n			</enum>						\r\n\r\n		</field>\r\n\r\n		<field id="application_instructions" not_required="1">\r\n			\r\n			<type>string</type>\r\n			<title>\r\n				<en>Application Instructions</en>\r\n			</title>\r\n			<view>textarea</view>\r\n							\r\n		</field>\r\n	\r\n\r\n\r\n\r\n\r\n\r\n	\r\n	\r\n	</fields>\r\n</form>');
INSERT INTO `listing_type` VALUES (4, 'Article', 'articles', NULL);

-- --------------------------------------------------------

-- 
-- Структура таблицы `location`
-- 

CREATE TABLE `location` (
  `location_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `short_description` varchar(255) CHARACTER SET utf8 NOT NULL,
  `subdomain` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `location`
-- 

INSERT INTO `location` VALUES (1, 'San Diegod', 'sandiego');
INSERT INTO `location` VALUES (2, 'new', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `message`
-- 

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_type_id` int(11) NOT NULL,
  `sender_email` varchar(64) NOT NULL,
  `recipient_email` varchar(64) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `body` text NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Дамп данных таблицы `message`
-- 

INSERT INTO `message` VALUES (1, 0, 'byqdes@gmail.com', 'hunter_jensen@hotmail.com', '112222', '111eee<br /><br /> phone: 11122', '0000-00-00 00:00:00');
INSERT INTO `message` VALUES (2, 1, 'byqdes@gmail.com', 'hunter_jensen@hotmail.com', '222222', 'test messahe\r\nswqswq&#039;\r\n\r\n&lt;br&gt; <br /><br /> phone: 112222', '2007-09-11 22:08:52');
INSERT INTO `message` VALUES (3, 1, 'byqdes@gmail.com', 'hunter_jensen@hotmail.com', 'test subject &#039;', 'dwedwedwed&#039;\r\ndqwdwqd&#039; dqwd&lt;sss<br /><br /> phone: 2101664', '2007-09-11 22:21:27');
INSERT INTO `message` VALUES (4, 1, 'byqdes@gmail.com', 'hunter_jensen@hotmail.com', '2222', '2wqsqwswqs<br /><br /> phone: 22222', '2007-09-11 22:42:06');
INSERT INTO `message` VALUES (5, 1, 'byqdes@gmail.com', 'hunter_jensen@hotmail.com', '222222', 'message<br /><br /> phone: www222', '2007-09-11 22:55:06');
INSERT INTO `message` VALUES (6, 1, 'byqdes@gmail.com', 'hunter@barefootlistings.com', 'from: Sergey Volchek - test', 'tetstestswsw<br /><br /> phone: 2101664<br />email: byqdes@gmail.com', '2007-10-01 22:22:07');
INSERT INTO `message` VALUES (7, 1, 'byqdes@gmail.com', 'hunter@barefootlistings.com', 'from: sssss - qqqq', 'qqqqqqq<br /><br /> namesssss<br /> phone: 22222<br />email: byqdes@gmail.com', '2007-10-02 23:08:55');
INSERT INTO `message` VALUES (8, 1, 'ddwed@gmail.com', 'hunter@barefootlistings.com', 'subject', '2222message<br /><br /> name: name<br /> phone: pgone<br />email: ddwed@gmail.com', '2007-10-02 23:12:20');

-- --------------------------------------------------------

-- 
-- Структура таблицы `message_type`
-- 

CREATE TABLE `message_type` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `short_description` varchar(200) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `message_type`
-- 

INSERT INTO `message_type` VALUES (1, 'contact_us_form');

-- --------------------------------------------------------

-- 
-- Структура таблицы `saved_listing`
-- 

CREATE TABLE `saved_listing` (
  `saved_listing_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `search_id` int(10) unsigned NOT NULL,
  `listing_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`saved_listing_id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

-- 
-- Дамп данных таблицы `saved_listing`
-- 

INSERT INTO `saved_listing` VALUES (1, 1, 10);
INSERT INTO `saved_listing` VALUES (13, 5, 8);
INSERT INTO `saved_listing` VALUES (3, 1, 10);
INSERT INTO `saved_listing` VALUES (14, 5, 6);
INSERT INTO `saved_listing` VALUES (12, 5, 10);
INSERT INTO `saved_listing` VALUES (15, 8, 12);
INSERT INTO `saved_listing` VALUES (11, 6, 10);
INSERT INTO `saved_listing` VALUES (10, 5, 11);
INSERT INTO `saved_listing` VALUES (16, 1, 12);
INSERT INTO `saved_listing` VALUES (17, 1, 9);
INSERT INTO `saved_listing` VALUES (18, 1, 32);
INSERT INTO `saved_listing` VALUES (19, 2, 9);
INSERT INTO `saved_listing` VALUES (20, 2, 21);
INSERT INTO `saved_listing` VALUES (21, 2, 34);
INSERT INTO `saved_listing` VALUES (22, 1, 12);
INSERT INTO `saved_listing` VALUES (23, 68, 10);
INSERT INTO `saved_listing` VALUES (24, 69, 11);
INSERT INTO `saved_listing` VALUES (25, 69, 64);
INSERT INTO `saved_listing` VALUES (26, 70, 10);
INSERT INTO `saved_listing` VALUES (27, 71, 11);
INSERT INTO `saved_listing` VALUES (28, 71, 64);
INSERT INTO `saved_listing` VALUES (29, 72, 10);
INSERT INTO `saved_listing` VALUES (30, 73, 11);
INSERT INTO `saved_listing` VALUES (31, 73, 64);
INSERT INTO `saved_listing` VALUES (32, 1, 64);
INSERT INTO `saved_listing` VALUES (33, 1, 12);
INSERT INTO `saved_listing` VALUES (34, 74, 11);
INSERT INTO `saved_listing` VALUES (35, 74, 9);
INSERT INTO `saved_listing` VALUES (36, 1, 64);
INSERT INTO `saved_listing` VALUES (37, 1, 12);
INSERT INTO `saved_listing` VALUES (38, 75, 11);
INSERT INTO `saved_listing` VALUES (39, 75, 9);
INSERT INTO `saved_listing` VALUES (40, 1, 64);
INSERT INTO `saved_listing` VALUES (41, 1, 12);
INSERT INTO `saved_listing` VALUES (42, 76, 11);
INSERT INTO `saved_listing` VALUES (43, 76, 9);
INSERT INTO `saved_listing` VALUES (44, 1, 65);
INSERT INTO `saved_listing` VALUES (45, 77, 10);
INSERT INTO `saved_listing` VALUES (46, 77, 7);
INSERT INTO `saved_listing` VALUES (47, 78, 12);
INSERT INTO `saved_listing` VALUES (48, 78, 11);
INSERT INTO `saved_listing` VALUES (49, 79, 65);
INSERT INTO `saved_listing` VALUES (50, 80, 23);
INSERT INTO `saved_listing` VALUES (51, 1, 12);
INSERT INTO `saved_listing` VALUES (52, 81, 10);
INSERT INTO `saved_listing` VALUES (53, 81, 8);

-- --------------------------------------------------------

-- 
-- Структура таблицы `search`
-- 

CREATE TABLE `search` (
  `search_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bluser_id` int(10) unsigned NOT NULL,
  `short_description` varchar(50) NOT NULL,
  PRIMARY KEY (`search_id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

-- 
-- Дамп данных таблицы `search`
-- 

INSERT INTO `search` VALUES (1, 14, 'Default');
INSERT INTO `search` VALUES (79, 14, 'jjjjj');
INSERT INTO `search` VALUES (80, 14, '123456');
INSERT INTO `search` VALUES (81, 14, 'swsws');
INSERT INTO `search` VALUES (60, 14, 'swsws');
INSERT INTO `search` VALUES (46, 14, '4444');
INSERT INTO `search` VALUES (66, 14, 'deed');
INSERT INTO `search` VALUES (78, 14, 'bbbbb');
INSERT INTO `search` VALUES (77, 14, 'dddd');
