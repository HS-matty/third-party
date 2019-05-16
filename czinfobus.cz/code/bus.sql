-- phpMyAdmin SQL Dump
-- version 2.6.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Авг 30 2005 г., 13:19
-- Версия сервера: 4.1.12
-- Версия PHP: 5.0.4
-- 
-- БД: `bus`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `auth_groups`
-- 

CREATE TABLE `auth_groups` (
  `group_id` smallint(5) unsigned NOT NULL auto_increment,
  `group_name` varchar(30) NOT NULL default '',
  `group_descr` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Дамп данных таблицы `auth_groups`
-- 

INSERT INTO `auth_groups` VALUES (1, 'guests', 'Just common fronback users');
INSERT INTO `auth_groups` VALUES (2, 'admins', 'Administrators');
INSERT INTO `auth_groups` VALUES (3, 'partners', 'Partners');
INSERT INTO `auth_groups` VALUES (4, 'clients', 'Clients here');

-- --------------------------------------------------------

-- 
-- Структура таблицы `auth_sessions`
-- 

CREATE TABLE `auth_sessions` (
  `s_id` varchar(32) NOT NULL default '0',
  `user_start_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `user_id` varchar(45) NOT NULL default '',
  `param` int(11) NOT NULL default '0',
  `closed` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Дамп данных таблицы `auth_sessions`
-- 

INSERT INTO `auth_sessions` VALUES ('e68c6f909489cea142ea97de698e7f28', 0x323030352d30382d30382031393a30393a3239, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('542b937831598d37dbbcb68e4b96da69', 0x323030352d30382d30382031393a32323a3432, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('63ccf8676a4557add874b0ef78d1305f', 0x323030352d30382d30382031393a34333a3235, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('8c1336285304a0ed7c1a7fb7c3c27994', 0x323030352d30382d30382032313a30383a3438, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('47cda2b3061a7765eadbc5b336ac5ae2', 0x323030352d30382d30392031353a34373a3335, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('8b69e1343654093f2688340819fbbffd', 0x323030352d30382d30392031363a34303a3337, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('c20760c1f1e79728b06a427c2bb621a2', 0x323030352d30382d30392031363a34333a3130, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('6501a5a67a08f9d84ad32f0cb3ce48d4', 0x323030352d30382d30392031373a31383a3537, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('3789d8434ab752a88eb1164fd28de30f', 0x323030352d30382d30392031383a31353a3339, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('9f7e2aa1f2dab7d6f3f4811debc345fc', 0x323030352d30382d30392031393a33373a3236, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('fab848baf198d5892a0e41971311daa6', 0x323030352d30382d31302031313a34373a3130, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('e22f7d08d7641a044497bbbfa68e8bd2', 0x323030352d30382d31302031323a35313a3139, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('742249f6385fc1e6eed9a5122e9363ce', 0x323030352d30382d31302031333a35353a3439, '5', 0, '2005-08-10 14:33:08');
INSERT INTO `auth_sessions` VALUES ('6e81f3d56b9fd083437f96bce8ec7d55', 0x323030352d30382d31302031343a33333a3138, '5', 0, '2005-08-10 14:34:40');
INSERT INTO `auth_sessions` VALUES ('7337370ca0284a15ccf8f9204363ebe8', 0x323030352d30382d31302031343a33353a3037, '5', 0, '2005-08-10 14:35:09');
INSERT INTO `auth_sessions` VALUES ('34f09cf945baf28b1d1ebdbcdaa11efe', 0x323030352d30382d31302031343a33353a3331, '5', 0, '2005-08-10 14:35:55');
INSERT INTO `auth_sessions` VALUES ('5e83b026e0d73a1bf221039ab94d7d95', 0x323030352d30382d31302031343a33373a3338, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('3be582a2ff5306edb14f6e16efe77368', 0x323030352d30382d31302031343a33383a3038, '5', 0, '2005-08-10 14:40:25');
INSERT INTO `auth_sessions` VALUES ('b4c8a11f755d59c225511f04b69d32df', 0x323030352d30382d31302031343a34353a3232, '5', 0, '2005-08-10 14:49:53');
INSERT INTO `auth_sessions` VALUES ('3b685e97fa1727e3ab7c4227aec09b9e', 0x323030352d30382d31302031343a35303a3032, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('43995bf38327f33e80f4ae3fe644a61e', 0x323030352d30382d31302031363a33333a3138, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('bd73a3fe33e4acbcd3fe218a92062e93', 0x323030352d30382d31302031373a34373a3032, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('614ad56863a879531cc13c4df22f8eb4', 0x323030352d30382d31312031343a34383a3135, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('6eca853bcdfad987cc59be5b03c50eb9', 0x323030352d30382d31312031353a35353a3130, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('24e6941d5cb26d158274ca6c894a7880', 0x323030352d30382d31312031373a31343a3133, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('299b6e990395f2dd2a2c99569f72c95f', 0x323030352d30382d31312031383a30363a3532, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('622adc778702d62dd39e2cbcc59dc667', 0x323030352d30382d31312031383a35303a3531, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('dcfa2ef41a5cdf6144928252a2a8628d', 0x323030352d30382d31322031343a34353a3237, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('201b8baab98fbc056f072d4c485b5e81', 0x323030352d30382d31342032323a31373a3132, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('910776a3b058c952a15f3d1b00284a55', 0x323030352d30382d31342032333a31333a3235, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('24e42e2b56f1388d6ae7c3c75d5ad9db', 0x323030352d30382d31352031353a31303a3330, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('57b42c01954a9ecbac3974ab0a5dd834', 0x323030352d30382d31352031363a30303a3434, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('61f107afd82383648518359b05a6f174', 0x323030352d30382d31352031373a30313a3334, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('b536876ba6bb409b4beb875c3cb646c9', 0x323030352d30382d31352031373a35363a3137, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('994a158dcfede89832463e6d657b1baa', 0x323030352d30382d31352031383a35313a3437, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('d6f865454d65e3017a6f9ee1cc409381', 0x323030352d30382d31352031393a34343a3032, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('a57aa5cded76e210ed63fe1754b04e16', 0x323030352d30382d31352032313a30313a3234, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('ce305b063917c59101e94fb26ed7f9a6', 0x323030352d30382d31352032313a35323a3132, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('7e58dfc5054a061196da10773b9c15f8', 0x323030352d30382d31352032323a34323a3239, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('66a7a9e8d9f2abf3d8bca3abbf4e7425', 0x323030352d30382d31352032333a33323a3433, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('a19568f1718e8de6a7b3c944871dd4a3', 0x323030352d30382d31362031323a30333a3433, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('db0f7af9423c434342463ad7f909feb9', 0x323030352d30382d31362031323a35383a3136, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('a9df2af6f3d532aff7443028f32df733', 0x323030352d30382d31362031333a30343a3437, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('f7e6215baeea5b4e080ac3bea134fced', 0x323030352d30382d31362031343a30393a3438, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('ce487355f81d652cb56243634883f8c0', 0x323030352d30382d31362031353a30303a3039, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('dac8ac75e0025aca73ea1f24bbe793b1', 0x323030352d30382d31362031353a35323a3237, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('170e0ce45f2589710d13aa24347ddcb9', 0x323030352d30382d31362031363a34353a3030, '5', 0, '2005-08-16 16:57:12');
INSERT INTO `auth_sessions` VALUES ('504a45f0a9e80208d36e5806ed95f319', 0x323030352d30382d31362031363a35393a3238, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('3cade56c673207761596a1a55cfb399c', 0x323030352d30382d31362031383a35393a3234, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('6e354be6af1b15f9637551811937d39e', 0x323030352d30382d31362032303a31383a3439, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('2578f4ff7d539154c84b29690d958400', 0x323030352d30382d31362032303a34323a3237, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('dc092a0e4b0ff544a926a33100b51347', 0x323030352d30382d31362032323a35383a3538, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('daca2307c04dade50d8d7470ae91780b', 0x323030352d30382d31382031353a33303a3033, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('5ebf8f68ca01504f28bd804e5147f37b', 0x323030352d30382d31382031363a34353a3234, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('d379d31b4e0dc083a8b0a27c773491ca', 0x323030352d30382d31382031373a34373a3239, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('95df66040ccbfdc5906bfbc2132b7c02', 0x323030352d30382d31382031383a33313a3439, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('aae847bb4a2a3dbe187bcc4407783903', 0x323030352d30382d31382031393a32343a3230, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('5dcd1d2c60a6bc4f84059453e277fa29', 0x323030352d30382d32312031343a30323a3035, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('7dcc07e40ebb4ebf638685a1b5b3455a', 0x323030352d30382d32312031353a31363a3430, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('e9824604b577a6cd27001cdee0990c7d', 0x323030352d30382d32312031363a30373a3134, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('2cccfe2e360afb7e6d5a600d844506e9', 0x323030352d30382d32312031373a30383a3030, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('4ed08e85e6e92451a32f35ea15ec19f7', 0x323030352d30382d32312031373a35393a3139, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('8bee2c6e1c776b7e936cc733ae1ddebd', 0x323030352d30382d32312031383a35333a3539, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('8da08262d3971dce07e42fd6607fa18c', 0x323030352d30382d32312031393a34343a3434, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('2de5ed638368feb7b0240775661c9f99', 0x323030352d30382d32312032303a33353a3138, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('3294a41fc6f617ca5fcfb0bef296a8ec', 0x323030352d30382d32322031333a34353a3033, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('6035797ae98b921371a0b8fcf873cd58', 0x323030352d30382d32322031343a33353a3236, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('0dd1ce2bbaa5a6d305da79ae62e6d1a8', 0x323030352d30382d32322031353a32353a3336, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('39478fe6b1eb20696dd0409aa058373a', 0x323030352d30382d32322031363a34323a3133, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('41074f91b3cb17d9c50f3c303be6b8bc', 0x323030352d30382d32322031373a33323a3238, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('e3290fc3a6cffe0ad6168f982fc146b6', 0x323030352d30382d32322031383a33343a3232, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('c8147b3364de048c9a97ad14742cee38', 0x323030352d30382d32322031393a32343a3336, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('6aa445c87d2657858b02c69d15eb50eb', 0x323030352d30382d32322032303a31363a3538, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('f6a58f6245783be1d4360ce5afe5b80d', 0x323030352d30382d32322032313a30383a3234, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('998831166d7add5867fb01143c860cae', 0x323030352d30382d32322032313a35393a3439, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('8224b21b7b7628562538170beafcd2af', 0x323030352d30382d32322032323a35303a3138, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('5cf568faf2b5384791ec46a8d0a6c487', 0x323030352d30382d32332031313a32333a3237, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('9651fae0370b4f20ccbaa4946947c1c1', 0x323030352d30382d32332031323a31363a3338, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('3dd05e21294c828d157da12b29442374', 0x323030352d30382d32332031333a30373a3331, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('b22d4e6b6029e4a645eb6d4278662b08', 0x323030352d30382d32332031343a31383a3431, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('fb4c317c6032606ed2727df305421c4f', 0x323030352d30382d32332031353a32373a3233, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('86536229007652381cffda2cbec7f02e', 0x323030352d30382d32332031353a32383a3137, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('38d8a7adc749e35fb346356eaf427418', 0x323030352d30382d32332031393a35393a3139, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('89b3c4eb36d779f0d64f6c5db5a13445', 0x323030352d30382d32332032303a35383a3434, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('6d2f7f7ebcb84e03043402f168c89434', 0x323030352d30382d32332032313a34393a3032, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('508393bc24cd467575d0f3f610226ab1', 0x323030352d30382d32342031313a30353a3436, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('4d226d78f05be4f8d5f747da7f4ec101', 0x323030352d30382d32342031313a35383a3036, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('c6b3583699a62aaade373eb3f1d201bb', 0x323030352d30382d32342031323a34383a3234, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('822ca74f53a93b8406acd62b4c45a48f', 0x323030352d30382d32342031343a30393a3139, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('06bf2e9b9492854afb6178e7ce195b4a', 0x323030352d30382d32342031343a33383a3132, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('46ee6c62adc7f741dcde137760a9e60e', 0x323030352d30382d32342031353a30343a3233, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('4ddd209a6a980fd0f04cff5f13b0b8a0', 0x323030352d30382d32342031353a34323a3132, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('daa20e320afa223b75c4646c68706982', 0x323030352d30382d32342031353a35393a3237, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('ca63d1f51fb8106fd8860f738e2d69ed', 0x323030352d30382d32342031363a35333a3334, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('f48a6808172d2db73e54924c8130faf8', 0x323030352d30382d32342031373a31353a3035, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('a8cd5fd04018740c178721dab218b4db', 0x323030352d30382d32352031333a33393a3335, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('c24cbe824eccc94b66a3b82ad36b2715', 0x323030352d30382d32352031343a33313a3530, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('ca9f118d2427ab043e0368fb407e1401', 0x323030352d30382d32352031353a30373a3431, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('5caea60ecfc223a16109419821b96f42', 0x323030352d30382d32352031353a35383a3137, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('454b675d08c745d89f0396e4b897cf33', 0x323030352d30382d32352031373a31333a3237, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('4ab1ddadb3ae448e3ecb122fe72ac5b4', 0x323030352d30382d32352031373a35313a3236, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('c67f552f790c9e20c8ab1216a125c8df', 0x323030352d30382d32352031383a34313a3333, '5', 0, '2005-08-25 18:52:13');
INSERT INTO `auth_sessions` VALUES ('33c6316287d1f09a42c8199a0288586a', 0x323030352d30382d32352031383a35323a3230, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('4f4514e435ea60a84817d816c9291cc4', 0x323030352d30382d32352031383a35373a3132, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('4d504c37efd6a4523092ae4bd3bf8edb', 0x323030352d30382d32352031393a35383a3232, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('de3950d4851b65205d1cb9e46b9c7c84', 0x323030352d30382d32352032303a34383a3537, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('a6bc87c88770ee189297123a1c73df19', 0x323030352d30382d32352032313a33393a3530, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('09b631cc5f10c102156bbbad2b7a2ae7', 0x323030352d30382d32362031333a35313a3232, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('2c60ed4fd4f4447c3d0cfabcfbaae835', 0x323030352d30382d32362031343a34353a3533, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('85aac29ec3113f0a90a2e4e53cc6d28e', 0x323030352d30382d32362031353a33363a3036, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('bdaf1700744431298d34eafeec75bdd5', 0x323030352d30382d32362031373a30313a3530, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('37c2f842f2aed95e1bd59f5b12b03b07', 0x323030352d30382d32392031323a33393a3038, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('0654ff0e3c2d37bd6c0d0958a2f0e161', 0x323030352d30382d32392031333a34373a3339, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('81a91a3d08377624b0abf43a9b4f7906', 0x323030352d30382d32392031343a34303a3330, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('2c7b2764da75421d50b7bb7dc6980291', 0x323030352d30382d32392031353a32363a3231, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('0f3419e5837dbc182d36d77d143b9c1c', 0x323030352d30382d32392031353a32363a3237, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('3496832a1b40ccb0ddb17c6123e3aac1', 0x323030352d30382d32392031363a32303a3339, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('ec2452d053d38b16816ebeccc5b49743', 0x323030352d30382d32392031363a32313a3339, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('ee69d696c045fedbdfdc02641e6c0d1c', 0x323030352d30382d32392031373a34303a3539, '', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('b797ad6be671b2b76c1f8bfddb541137', 0x323030352d30382d32392031373a34313a3130, '', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('957c12e649ff6b64dd2a1f7c52c4acb6', 0x323030352d30382d32392031373a34333a3231, '', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('4a462bf67af8c0e6c4e70cb4a8205b04', 0x323030352d30382d32392032323a33333a3236, '5', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('ca1ed092c367a068cfbb7432257a6eef', 0x323030352d30382d32392032323a33343a3533, '', 0, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('e6d58de0f055d5358a9c49867b644278', 0x323030352d30382d32392032323a33373a3237, '17', 5, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('2474580b1cc693810d476ba206d9cb3d', 0x323030352d30382d32392032323a34313a3438, '17', 5, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('438bbbb69117f0f1e30dae6342ed4d79', 0x323030352d30382d32392032323a34323a3032, '17', 5, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('b68c635e4612f813152a0ee462180593', 0x323030352d30382d32392032323a34323a3236, '17', 5, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('c3eaac3144c6f44e29efedd0f337be46', 0x323030352d30382d32392032323a34323a3534, '17', 5, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('eca3106400ffaf27bdf7868af3fe9579', 0x323030352d30382d32392032323a34343a3539, '17', 5, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('b056486a48f0ec675b370064f85fc490', 0x323030352d30382d32392032323a34373a3531, '17', 5, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('77aed08bb9cca72f54986196b8a3dd91', 0x323030352d30382d32392032333a34303a3130, '17', 5, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('d3d8dc10048e384810e5b9a1e8b9d145', 0x323030352d30382d32392032333a34333a3331, '17', 6, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('6d3edf694a9139098a852b346630e361', 0x323030352d30382d33302030303a32353a3536, '17', 6, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('9f3ee518e9d899e95439cd92e4bbc3fb', 0x323030352d31302d33302030313a32313a3131, '17', 6, '0000-00-00 00:00:00');
INSERT INTO `auth_sessions` VALUES ('a27e6efa1a0b79a600404fdeb2f3197c', 0x323030352d30382d33302030313a33363a3538, '5', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Структура таблицы `auth_users`
-- 

CREATE TABLE `auth_users` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL default '0',
  `user_name` varchar(45) character set utf8 NOT NULL default '',
  `user_login` varchar(15) character set utf8 NOT NULL default '',
  `user_password` varchar(45) character set utf8 NOT NULL default '',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0 AUTO_INCREMENT=19 ;

-- 
-- Дамп данных таблицы `auth_users`
-- 

INSERT INTO `auth_users` VALUES (5, 2, 'Manager', 'manager', '1d0258c2440a8d19e716292b231e3190');
INSERT INTO `auth_users` VALUES (10, 2, 'Supervisor', 'supervisor', '81dc9bdb52d04dc20036dbd8313ed055');
INSERT INTO `auth_users` VALUES (15, 1, 'Frontback user', 'user', 'ee11cbb19052e40b07aac0ca060c23ee');
INSERT INTO `auth_users` VALUES (16, 1, 'Guest', 'guest', '084e0343a0486ff05530df6c705c8bb4');
INSERT INTO `auth_users` VALUES (17, 3, 'Partner', 'partner', '7454739e907f5595ae61d84b8547f574');
INSERT INTO `auth_users` VALUES (18, 4, 'Client', 'client', '7454739e907f5595ae61d84b8547f574');

-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_buses`
-- 

CREATE TABLE `bus_buses` (
  `bus_id` int(10) unsigned NOT NULL auto_increment,
  `bustype_id` mediumint(8) unsigned NOT NULL default '0',
  `bus_route_title` varchar(50) NOT NULL default '',
  `route_id` int(10) unsigned NOT NULL default '0',
  `bus_time_arrival` varchar(15) NOT NULL default '',
  `bus_day_arrival` date NOT NULL default '0000-00-00',
  `bus_time_depar` varchar(12) NOT NULL default '',
  `bus_day_depar` date NOT NULL default '0000-00-00',
  `bus_addedby` varchar(70) NOT NULL default '',
  `bus_addedtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `bus_ticket_price` float NOT NULL default '0',
  `places_range` varchar(15) NOT NULL default '0',
  `bus_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`bus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- 
-- Дамп данных таблицы `bus_buses`
-- 

INSERT INTO `bus_buses` VALUES (1, 1, 'Минск-Прага', 1, '12-00', 0x303030302d30302d3030, '12-00', 0x303030302d30302d3030, 'Крутой чувак', 0x323030352d30382d32322031373a30303a3331, 2222, '45', 1);
INSERT INTO `bus_buses` VALUES (2, 1, 'Москва-Минск', 27, '12-00', 0x303030302d30302d3030, '14-00', 0x303030302d30302d3030, 'Manager', 0x323030352d30382d32322031373a30303a3331, 333, '23', 1);
INSERT INTO `bus_buses` VALUES (3, 1, 'Moscow-Minsk / Москва-Мин', 70, '12:00:00', 0x323030352d31302d3132, '11:30:00', 0x323030352d31302d3038, 'test', 0x323030352d30382d32342031323a34373a3335, 230, '1-30', 1);
INSERT INTO `bus_buses` VALUES (4, 1, 'Moscow-Minsk / Москва-Мин', 70, '12:30:00', 0x323030352d30392d3135, '11:30:00', 0x323030352d30392d3038, 'Manager', 0x323030352d30382d32342031333a30313a3234, 100, '10-30', 1);
INSERT INTO `bus_buses` VALUES (5, 1, 'Kiev-Riga / Киев-Рига', 71, '17:10:00', 0x323030352d30392d3031, '12:23:00', 0x323030352d30382d3239, 'Manager', 0x323030352d30382d32342031333a31353a3438, 150, '15-30', 1);
INSERT INTO `bus_buses` VALUES (6, 1, 'Kiev-Riga / Киев-Рига', 71, '19:00:00', 0x323030352d30382d3237, '09:00:00', 0x323030352d30382d3234, 'Manager', 0x323030352d30382d32342031343a31363a3431, 100, '1-70', 1);
INSERT INTO `bus_buses` VALUES (7, 1, 'Moscow-Minsk / Москва-Мин', 70, '12:00:00', 0x323030352d30392d3037, '11:30:00', 0x323030352d30392d3035, 'Manager', 0x323030352d30382d32342031353a31363a3133, 100, '1-50', 1);
INSERT INTO `bus_buses` VALUES (8, 1, 'Kiev-Riga / Киев-Рига', 71, '17:10:00', 0x323030352d30392d3135, '12:23:00', 0x323030352d30392d3132, 'Manager', 0x323030352d30382d32342031363a30363a3231, 150, '15-30', 1);
INSERT INTO `bus_buses` VALUES (9, 1, 'Moscow-Minsk / Москва-Мин', 70, '12:00:00', 0x323030352d31302d3035, '11:30:00', 0x323030352d31302d3031, 'Manager', 0x323030352d30382d32342031363a30363a3335, 230, '1-30', 1);
INSERT INTO `bus_buses` VALUES (10, 1, 'Minsk-Moskva / Минск-Моск', 68, '12:00:00', 0x323030352d31302d3137, '11:30:00', 0x323030352d31302d3132, 'Manager', 0x323030352d30382d32342031363a30363a3431, 1000, '1-50', 1);
INSERT INTO `bus_buses` VALUES (11, 1, 'NEW / Новый', 72, '12:30:00', 0x323030352d31302d3133, '11:30:00', 0x323030352d31302d3131, 'Manager', 0x323030352d30382d32342031363a30373a3032, 1111, '13-30', 1);
INSERT INTO `bus_buses` VALUES (12, 1, 'Пинск / Pinsk-Mpgilev', 69, '11:11:00', 0x323030352d30392d3134, '11:11:00', 0x323030352d30392d3133, 'Manager', 0x323030352d30382d32342031363a35353a3235, 123, '11-30', 1);
INSERT INTO `bus_buses` VALUES (13, 1, ' /', 0, '11:11:00', 0x323030352d31302d3234, '11:11:00', 0x323030352d31302d3137, 'Microsoft', 0x323030352d30382d33302030303a34373a3138, 212, '11-30', 1);
INSERT INTO `bus_buses` VALUES (14, 1, '1 / 1', 1, '11:11:00', 0x323030352d31302d3137, '11:11:00', 0x323030352d31302d3130, 'Microsoft', 0x323030352d30382d33302030313a30323a3237, 212, '11-30', 1);
INSERT INTO `bus_buses` VALUES (15, 1, '1 / 1', 1, '11:11:00', 0x323030352d31302d3331, '11:11:00', 0x323030352d31302d3234, 'Microsoft', 0x323030352d30382d33302030313a30323a3439, 212, '11-30', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_busowners`
-- 

CREATE TABLE `bus_busowners` (
  `busowner_id` mediumint(8) unsigned NOT NULL auto_increment,
  `busowner_title` varchar(90) NOT NULL default '',
  `busowner_inn` varchar(50) NOT NULL default '',
  `busowner_address` varchar(100) NOT NULL default '',
  `busowner_phone1` varchar(50) NOT NULL default '',
  `busowner_phone2` varchar(50) NOT NULL default '',
  `busowner_fax` varchar(30) NOT NULL default '',
  `busowner_email` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`busowner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `bus_busowners`
-- 

INSERT INTO `bus_busowners` VALUES (1, 'Infobus', 'none', 'none', 'none', 'none', 'none', 'byq@kay.by');
INSERT INTO `bus_busowners` VALUES (2, 'Microsoft', '123457564', 'Zhukovskogo', '21212121', '12112', '12121', 'dee@.com');

-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_bustype`
-- 

CREATE TABLE `bus_bustype` (
  `bustype_id` int(10) unsigned NOT NULL auto_increment,
  `bustype_title` varchar(90) NOT NULL default '',
  `bustype_places_num` mediumint(8) unsigned NOT NULL default '0',
  `bustype_tv` tinyint(1) NOT NULL default '0',
  `bustype_toilet` tinyint(1) unsigned NOT NULL default '0',
  `bustype_cond` tinyint(1) unsigned NOT NULL default '0',
  `bustype_bar` tinyint(1) unsigned NOT NULL default '0',
  `busowner_id` mediumint(8) unsigned NOT NULL default '0',
  `bustype_pic` varchar(70) NOT NULL default '',
  PRIMARY KEY  (`bustype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `bus_bustype`
-- 

INSERT INTO `bus_bustype` VALUES (1, 'Самый лучшей автобус в мире (икарус)', 70, 1, 1, 1, 1, 1, 'c:\\work\\test.jpg');

-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_clients`
-- 

CREATE TABLE `bus_clients` (
  `client_id` int(10) unsigned NOT NULL auto_increment,
  `client_name` varchar(100) NOT NULL default '',
  `client_login` varchar(50) NOT NULL default '',
  `client_password` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `bus_clients`
-- 

INSERT INTO `bus_clients` VALUES (1, 'testing', 'testing', 'ae2b1fca515949e5d54fb22b8ed95575');

-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_days`
-- 

CREATE TABLE `bus_days` (
  `days_id` int(11) NOT NULL auto_increment,
  `route_id` int(11) NOT NULL default '0',
  `bustype_id` int(10) unsigned NOT NULL default '0',
  `day_departure` tinyint(4) NOT NULL default '0',
  `time_departure` time NOT NULL default '00:00:00',
  `time_arrival` time NOT NULL default '00:00:00',
  `day_arrival` tinyint(4) NOT NULL default '0',
  `places_range` varchar(70) NOT NULL default '',
  `days_ticket_price` float NOT NULL default '0',
  PRIMARY KEY  (`days_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

-- 
-- Дамп данных таблицы `bus_days`
-- 

INSERT INTO `bus_days` VALUES (58, 59, 0, 1, 0x31313a31313a3030, 0x31323a33303a3030, 5, '', 0);
INSERT INTO `bus_days` VALUES (60, 64, 1, 1, 0x31313a31313a3030, 0x31313a31313a3030, 1, '', 11);
INSERT INTO `bus_days` VALUES (61, 64, 1, 3, 0x31313a31313a3030, 0x31313a31313a3030, 1, '', 111);
INSERT INTO `bus_days` VALUES (62, 67, 1, 1, 0x31313a31313a3030, 0x31313a31313a3030, 1, '11-11', 11);
INSERT INTO `bus_days` VALUES (63, 67, 1, 3, 0x31313a31313a3030, 0x31313a31313a3030, 1, '11-11', 111);
INSERT INTO `bus_days` VALUES (64, 68, 1, 2, 0x31313a33303a3030, 0x32303a30303a3030, 4, '11-30', 1200);
INSERT INTO `bus_days` VALUES (65, 68, 1, 3, 0x31313a33303a3030, 0x31323a30303a3030, 1, '1-50', 1000);
INSERT INTO `bus_days` VALUES (66, 69, 1, 2, 0x31313a31313a3030, 0x31313a31313a3030, 3, '11-20', 123);
INSERT INTO `bus_days` VALUES (67, 69, 1, 2, 0x31313a31313a3030, 0x31313a31313a3030, 3, '11-30', 11);
INSERT INTO `bus_days` VALUES (68, 70, 1, 1, 0x31313a33303a3030, 0x31323a30303a3030, 3, '1-50', 100);
INSERT INTO `bus_days` VALUES (69, 70, 1, 4, 0x31313a33303a3030, 0x31323a33303a3030, 4, '10-30', 100);
INSERT INTO `bus_days` VALUES (70, 70, 1, 1, 0x31303a33303a3030, 0x31303a33303a3030, 3, '1-20', 150);
INSERT INTO `bus_days` VALUES (71, 70, 1, 6, 0x31313a33303a3030, 0x31323a30303a3030, 3, '1-30', 230);
INSERT INTO `bus_days` VALUES (72, 71, 1, 3, 0x30393a30303a3030, 0x31393a30303a3030, 6, '1-70', 100);
INSERT INTO `bus_days` VALUES (73, 71, 1, 1, 0x31323a32333a3030, 0x31373a31303a3030, 4, '15-30', 150);
INSERT INTO `bus_days` VALUES (74, 72, 1, 2, 0x32323a33303a3030, 0x32323a33303a3030, 4, '13-30', 9999);
INSERT INTO `bus_days` VALUES (75, 72, 1, 3, 0x31313a32333a3030, 0x31303a32333a3030, 3, '10-30', 1000);
INSERT INTO `bus_days` VALUES (76, 73, 1, 3, 0x30313a31313a3030, 0x31313a31313a3030, 4, '11-60', 1111);
INSERT INTO `bus_days` VALUES (77, 74, 1, 3, 0x30313a31313a3030, 0x31313a31313a3030, 4, '11-60', 1111);
INSERT INTO `bus_days` VALUES (78, 75, 1, 1, 0x31313a31313a3030, 0x31313a31313a3030, 1, '11-50', 11);
INSERT INTO `bus_days` VALUES (79, 76, 1, 1, 0x31313a31313a3030, 0x31313a31313a3030, 1, '11-50', 11);
INSERT INTO `bus_days` VALUES (80, 77, 1, 4, 0x31313a31313a3030, 0x31313a31313a3030, 3, '11-30', 50);
INSERT INTO `bus_days` VALUES (81, 78, 1, 4, 0x31313a31313a3030, 0x31313a31313a3030, 3, '11-30', 500);
INSERT INTO `bus_days` VALUES (82, 1, 1, 1, 0x31313a31313a3030, 0x31313a31313a3030, 1, '11-30', 212);

-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_dealers`
-- 

CREATE TABLE `bus_dealers` (
  `dealer_id` int(10) unsigned NOT NULL auto_increment,
  `dealer_name` varchar(70) NOT NULL default '',
  `dealer_login` varchar(20) NOT NULL default '',
  `dealer_password` varchar(32) NOT NULL default '',
  `dealer_corp_name` varchar(50) NOT NULL default '',
  `dealer_inn` varchar(50) NOT NULL default '',
  `dealer_address` varchar(100) NOT NULL default '',
  `dealer_phone1` varchar(50) NOT NULL default '',
  `dealer_phone2` varchar(50) NOT NULL default '',
  `dealer_email` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`dealer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Дамп данных таблицы `bus_dealers`
-- 

INSERT INTO `bus_dealers` VALUES (5, '', 'testing', 'ae2b1fca515949e5d54fb22b8ed95575', 'Test', '12345678', 'dwed3123123', '213321', 'dewdew', 'dewdewd');
INSERT INTO `bus_dealers` VALUES (6, '', 'microsoft', '5f532a3fc4f1ea403f37070f59a7a53a', 'Microsoft', '12345678', 'Zhukovskogo 10-1-121', '2233249', '2233238', 'none@microsof.com');

-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_points`
-- 

CREATE TABLE `bus_points` (
  `point_id` int(11) NOT NULL auto_increment,
  `point_latin_name` varchar(50) NOT NULL default '',
  `point_ru_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`point_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Дамп данных таблицы `bus_points`
-- 

INSERT INTO `bus_points` VALUES (1, 'Moscow', 'Москва');
INSERT INTO `bus_points` VALUES (2, 'Minsk', 'Минск');
INSERT INTO `bus_points` VALUES (3, 'Praha', 'Прага');
INSERT INTO `bus_points` VALUES (4, 'Baranovichi', 'Барановичи');
INSERT INTO `bus_points` VALUES (5, 'рррр', 'ррр');

-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_routes`
-- 

CREATE TABLE `bus_routes` (
  `route_id` int(11) NOT NULL auto_increment,
  `route_addedby` varchar(50) NOT NULL default '',
  `route_addedtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `route_name_ru` varchar(70) NOT NULL default '',
  `route_name_latin` varchar(70) NOT NULL default '',
  `route_valid` date NOT NULL default '2006-12-01',
  `route_active` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`route_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `bus_routes`
-- 

INSERT INTO `bus_routes` VALUES (1, 'Manager', 0x323030352d30382d33302030313a30363a3236, 'dddddd', 'ddddddddd', 0x323030362d31322d3031, 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_stations`
-- 

CREATE TABLE `bus_stations` (
  `station_id` int(11) NOT NULL auto_increment,
  `station_order` smallint(6) NOT NULL default '0',
  `point_id` int(11) NOT NULL default '0',
  `time_in_road` time NOT NULL default '00:00:00',
  `route_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`station_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

-- 
-- Дамп данных таблицы `bus_stations`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `bus_tickets`
-- 

CREATE TABLE `bus_tickets` (
  `ticket_id` int(10) unsigned NOT NULL auto_increment,
  `bus_id` int(10) unsigned NOT NULL default '0',
  `ticket_status` enum('free','reserved','waiting') NOT NULL default 'free',
  `ticket_owner` enum('nobody','dealer','user','admin') NOT NULL default 'nobody',
  `ticket_owner_id` int(10) unsigned NOT NULL default '0',
  `ticket_place` int(11) NOT NULL default '0',
  `ticket_timedate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ticket_deleted` tinyint(1) NOT NULL default '0',
  `ticket_member_name` varchar(70) NOT NULL default '',
  PRIMARY KEY  (`ticket_id`),
  UNIQUE KEY `bus_ticket` (`ticket_place`,`bus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

-- 
-- Дамп данных таблицы `bus_tickets`
-- 

INSERT INTO `bus_tickets` VALUES (10, 8, 'waiting', 'admin', 5, 16, 0x323030352d30382d33302030313a33383a3033, 0, '');
INSERT INTO `bus_tickets` VALUES (19, 8, 'reserved', 'dealer', 6, 18, 0x323030352d30382d33302030323a34373a3239, 0, '');
INSERT INTO `bus_tickets` VALUES (40, 8, 'reserved', 'dealer', 6, 19, 0x323030352d30382d33302030343a30303a3139, 0, 'Ивыанов Иван');

-- --------------------------------------------------------

-- 
-- Структура таблицы `content_articles`
-- 

CREATE TABLE `content_articles` (
  `article_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '1',
  `article_header` varchar(20) NOT NULL default '',
  `article_meta` varchar(50) NOT NULL default '',
  `article_descr` varchar(100) NOT NULL default '',
  `article_body` text NOT NULL,
  `article_timedate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `article_lang` varchar(3) NOT NULL default '',
  PRIMARY KEY  (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- 
-- Дамп данных таблицы `content_articles`
-- 

INSERT INTO `content_articles` VALUES (29, 10, 'Новая новость!"!!', 'жцувжцувлёжцулжцё', 'цужвлцужвлцжл', 'Обладательница Гран-при международного конкурса молодых исполнителей эстрадной песни "Витебск-2005" в рамках фестиваля искусств "Славянский базар в Витебске" Полина Смолова не исключает своего участия в конкурсе "Евровидение" 2006 года. Об этом она заявила в интервью БелаПАН.\r\n\r\nНапомним, что именно Смолова стала победительницей зрительского голосования национального этапа "Евровидения" в этом году, однако по решению жюри Беларусь на конкурсе представляла Анжелика Агурбаш.\r\n\r\nПолина Смолова считает, что конкурсы молодых исполнителей в рамках "Славянского базар в Витебске" и "Евровидение" нельзя сравнивать. "Евровидение" — это конкурс песни, отношений стран-соседей, всего-всего, но не творчества и вокала, — сказала певица. — А на "Славянском базаре" проходит конкурс настоящего вокала, настоящих профессионалов, которых оценивает профессиональное жюри".\r\n', 0x323030352d30382d31312031393a32363a3439, 'ru');
INSERT INTO `content_articles` VALUES (12, 5, 'header', 'full_header', 'Вид на жительство в Чехии', 'Creates ga consistent snapshot by dumping all tables in a Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates Creates\r\n', 0x323030352d30382d31312031393a32363a3439, 'ru');
INSERT INTO `content_articles` VALUES (13, 5, 'contacts', 'full contacts', 'dexription', 'Manuel Barrueco plays ''300 Years of Guitar Masterpieces\r\n	(Vox Box CD3X 3007)\r\n		includes:\r\n	(1) Bach: Suite No. 4 in E Major\r\n	    Bach: Suite No. 2 in A Minor\r\n	    Albeniz: First Suite Espanola, op. 47\r\n	(2) Scarlatti: Sonatas\r\n	    Cimarosa: Sonatas\r\n	    Paganini: Sonata in A Major, op.3 no. 1\r\n	    Giuliani: Variations sur les Folies d''Espagne, op. 45\r\n	    Paganini: Sonata in E Minor, Op. 3 no. 6\r\n	    Giuliani: Gran Sonata Eroica in A Major, Op. 150\r\n	    Granados: Spanish Dances\r\n	(3) Granados: Spanish Dances (continued)\r\n	    Villa-Lobos: Etudes for Guitar\r\n	    Guarnieri: Estudo No. 1\r\n	    Chavez: 3 pieces for Guitar\r\n	    Villa-Lobos: Suite populaire bresilienne\r\n', 0x323030352d30382d31312031393a32363a3439, '');
INSERT INTO `content_articles` VALUES (28, 10, 'news', 'news', 'news', 'news', 0x323030352d30382d31312031393a32363a3439, 'ru');
INSERT INTO `content_articles` VALUES (27, 10, 'testheader', 'test_fulheader', 'descriprion', 'bodybodybodybodybody\r\nbody\r\n\r\n\r\nbody\r\n\r\n', 0x323030352d30382d31312031393a32363a3439, 'ru');
