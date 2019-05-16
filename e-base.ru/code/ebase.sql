# phpMyAdmin MySQL-Dump
# version 2.2.4
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Хост: localhost:3306
# Время создания: Апр 25 2004 г., 13:08
# Версия сервера: 3.23.49
# Версия PHP: 4.3.3RC2
# БД : `ebase`
# --------------------------------------------------------

#
# Структура таблицы `config`
#

CREATE TABLE config (
  active tinyint(1) NOT NULL default '1',
  session_lifetime int(11) NOT NULL default '0',
  time_trans_clr int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Дамп данных таблицы `config`
#

INSERT INTO config VALUES (1, 600, 1082810211);
# --------------------------------------------------------

#
# Структура таблицы `currencies`
#

CREATE TABLE currencies (
  cur_id int(5) NOT NULL auto_increment,
  cur_name char(30) NOT NULL default '0',
  PRIMARY KEY  (cur_id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `currencies`
#

INSERT INTO currencies VALUES (1, 'wmz');
INSERT INTO currencies VALUES (2, 'wmr');
INSERT INTO currencies VALUES (3, 'wme');
# --------------------------------------------------------

#
# Структура таблицы `pin_list`
#

CREATE TABLE pin_list (
  Pin_id int(11) NOT NULL auto_increment,
  PinT_id int(11) default NULL,
  Pin_content char(32) NOT NULL default '',
  used tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (Pin_id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `pin_list`
#

INSERT INTO pin_list VALUES (1, 1, '452154545254545454', 1);
INSERT INTO pin_list VALUES (2, 1, '2333333', 1);
INSERT INTO pin_list VALUES (3, 2, 'deedddddddededeed', 1);
INSERT INTO pin_list VALUES (4, 3, 'jjkjkjkvfjkvfvf', 0);
INSERT INTO pin_list VALUES (5, 3, 'fdffrfrfr', 0);
INSERT INTO pin_list VALUES (6, 3, '3223', 0);
INSERT INTO pin_list VALUES (7, 3, 'eeeeee', 0);
INSERT INTO pin_list VALUES (8, 3, '3333', 0);
INSERT INTO pin_list VALUES (9, 3, '33333', 0);
# --------------------------------------------------------

#
# Структура таблицы `pin_types`
#

CREATE TABLE pin_types (
  PinT_id int(11) NOT NULL auto_increment,
  PinT_des char(30) NOT NULL default '',
  PinT_price float NOT NULL default '0',
  PinT_nominal int(11) NOT NULL default '0',
  PinT_pic char(30) NOT NULL default '',
  is_active tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (PinT_id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `pin_types`
#

INSERT INTO pin_types VALUES (1, 'юИВШМЮ АЕГКХЛХРМЮЪ 5000', '0.1', 5000, 'aichyna-5000.jpg', 1);
INSERT INTO pin_types VALUES (2, 'Solo ОПЕДНОКЮРЮ', '0.1', 5000, 'solo-5000.jpg', 1);
INSERT INTO pin_types VALUES (3, 'тНПЩМЕР 10 ВЮЯНБ', '0.1', 6900, '4enet-10hours.jpg', 1);
# --------------------------------------------------------

#
# Структура таблицы `sessions`
#

CREATE TABLE sessions (
  session_id char(32) NOT NULL default '0',
  session_ip char(8) NOT NULL default '0',
  session_start int(11) NOT NULL default '0',
  partner_id tinyint(4) NOT NULL default '0',
  is_active tinyint(1) default '0',
  PRIMARY KEY  (session_id),
  KEY partner_id (partner_id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `sessions`
#

# --------------------------------------------------------

#
# Структура таблицы `t_messages`
#

CREATE TABLE t_messages (
  t_message_id int(4) NOT NULL auto_increment,
  session_id varchar(32) NOT NULL default '',
  session_ip varchar(8) NOT NULL default '0',
  t_message varchar(150) NOT NULL default '0',
  t_time int(11) NOT NULL default '0',
  PRIMARY KEY  (t_message_id),
  KEY session_id (session_id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `t_messages`
#

# --------------------------------------------------------

#
# Структура таблицы `t_status`
#

CREATE TABLE t_status (
  status tinyint(4) NOT NULL default '0',
  descr varchar(40) NOT NULL default ''
) TYPE=MyISAM;

#
# Дамп данных таблицы `t_status`
#

INSERT INTO t_status VALUES (0, 'яВЕР БШОХЯЮМ');
INSERT INTO t_status VALUES (-1, 'дЕМЭЦХ МЕ ОНКСВЕМШ');
INSERT INTO t_status VALUES (20, 'яНГДЮМЮ РПЮМГЮЙЖХЪ');
INSERT INTO t_status VALUES (1, 'дЕМЭЦХ ОНКСВЕМШ');
INSERT INTO t_status VALUES (-2, 'нРЙЮГ НР ЯВЕРЮ');
INSERT INTO t_status VALUES (-10, 'нЬХАЙЮ НОКЮРШ');
INSERT INTO t_status VALUES (2, 'рНБЮП НРЦПСФЕМ');
INSERT INTO t_status VALUES (-3, 'дЕМЭЦХ ОНКСВЕМШ, МН ОНГДМН!');
# --------------------------------------------------------

#
# Структура таблицы `transactions`
#

CREATE TABLE transactions (
  trans_id int(11) NOT NULL auto_increment,
  PinT_id int(11) NOT NULL default '0',
  session_id char(32) NOT NULL default '0',
  order_id int(11) NOT NULL default '0',
  in_account char(32) NOT NULL default '0',
  sum float NOT NULL default '0',
  time_start int(16) NOT NULL default '0',
  time_end int(16) NOT NULL default '0',
  status int(6) NOT NULL default '0',
  cur_id int(11) NOT NULL default '0',
  session_ip char(8) NOT NULL default '',
  pin_id int(4) NOT NULL default '0',
  email char(30) NOT NULL default '0',
  PRIMARY KEY  (trans_id),
  KEY session_id (session_id),
  KEY time_end (time_end)
) TYPE=MyISAM;

#
# Дамп данных таблицы `transactions`
#

# --------------------------------------------------------

#
# Структура таблицы `users`
#

CREATE TABLE users (
  u_id tinyint(4) NOT NULL auto_increment,
  name varchar(30) NOT NULL default '',
  login varchar(15) NOT NULL default '',
  pwd varchar(15) NOT NULL default '',
  rights tinyint(4) NOT NULL default '0',
  attempts tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (u_id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `users`
#

INSERT INTO users VALUES (1, 'Admin', 'descent', 'byqdescent', 0, 1);
# --------------------------------------------------------

#
# Структура таблицы `users_sessions`
#

CREATE TABLE users_sessions (
  u_sid char(32) NOT NULL default '',
  u_id tinyint(4) NOT NULL default '0',
  time_login int(11) NOT NULL default '0',
  time_logout int(11) NOT NULL default '0',
  u_ip char(8) NOT NULL default '0',
  PRIMARY KEY  (u_sid)
) TYPE=MyISAM;

#
# Дамп данных таблицы `users_sessions`
#

INSERT INTO users_sessions VALUES ('6b32d4e4847cd4244b00ca33fbf2d1e6', 1, 1082368513, 0, '7f000005');
INSERT INTO users_sessions VALUES ('e7fa058817a625086ff6074e72944bf7', 1, 1082369849, 0, '7f000005');
INSERT INTO users_sessions VALUES ('473bf867f28c4f1ddcd6e50b0e37dd01', 1, 1082372823, 0, '7f000005');
INSERT INTO users_sessions VALUES ('a617d2aea7420036607e6a42e246b0e8', 1, 1082374576, 0, '7f000005');
INSERT INTO users_sessions VALUES ('20c9e9d4d8b110e573253369e5a29a25', 1, 1082402878, 0, '7f000005');
INSERT INTO users_sessions VALUES ('1088b8bf1d9f611df501f998a6191cad', 1, 1082410227, 0, '7f000005');
INSERT INTO users_sessions VALUES ('3ad4b23040fef3f3853788efa7d50bc1', 1, 1082465401, 0, '7f000005');
INSERT INTO users_sessions VALUES ('8ba423793bf7d9ffd5099a0f62b95968', 1, 1082578627, 0, '7f000005');

