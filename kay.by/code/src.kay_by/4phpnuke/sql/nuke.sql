# MySQL dump 8.13
#
# Host: localhost    Database: nuke
#--------------------------------------------------------
# Server version	3.23.36

#
# Table structure for table 'nuke_authors'
#

CREATE TABLE nuke_authors (
  aid varchar(30) NOT NULL default '',
  name varchar(50) default NULL,
  url varchar(60) default NULL,
  email varchar(60) default NULL,
  pwd varchar(13) default NULL,
  counter int(11) NOT NULL default '0',
  radminarticle tinyint(2) NOT NULL default '0',
  radmintopic tinyint(2) NOT NULL default '0',
  radminuser tinyint(2) NOT NULL default '0',
  radminsurvey tinyint(2) NOT NULL default '0',
  radminsection tinyint(2) NOT NULL default '0',
  radminlink tinyint(2) NOT NULL default '0',
  radminephem tinyint(2) NOT NULL default '0',
  radminfilem tinyint(2) NOT NULL default '0',
  radminfaq tinyint(2) NOT NULL default '0',
  radmindownload tinyint(2) NOT NULL default '0',
  radminreviews tinyint(2) NOT NULL default '0',
  radminnewsletter tinyint(2) NOT NULL default '0',
  radminsuper tinyint(2) NOT NULL default '1',
  admlanguage varchar(30) NOT NULL default '',
  PRIMARY KEY  (aid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_authors'
#

INSERT INTO nuke_authors VALUES ('God','God','http://phpnuke.org','http://phpnuke.org','Password',0,0,0,0,0,0,0,0,0,0,0,0,0,1,'');

#
# Table structure for table 'nuke_autonews'
#

CREATE TABLE nuke_autonews (
  anid int(11) NOT NULL auto_increment,
  catid int(11) NOT NULL default '0',
  aid varchar(30) NOT NULL default '',
  title varchar(80) NOT NULL default '',
  time varchar(19) NOT NULL default '',
  hometext text NOT NULL,
  bodytext text NOT NULL,
  topic int(3) NOT NULL default '1',
  informant varchar(20) NOT NULL default '',
  notes text NOT NULL,
  ihome int(1) NOT NULL default '0',
  alanguage varchar(30) NOT NULL default '',
  acomm int(1) NOT NULL default '0',
  PRIMARY KEY  (anid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_autonews'
#


#
# Table structure for table 'nuke_banner'
#

CREATE TABLE nuke_banner (
  bid int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  imptotal int(11) NOT NULL default '0',
  impmade int(11) NOT NULL default '0',
  clicks int(11) NOT NULL default '0',
  imageurl varchar(100) NOT NULL default '',
  clickurl varchar(200) NOT NULL default '',
  date datetime default NULL,
  PRIMARY KEY  (bid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_banner'
#


#
# Table structure for table 'nuke_bannerclient'
#

CREATE TABLE nuke_bannerclient (
  cid int(11) NOT NULL auto_increment,
  name varchar(60) NOT NULL default '',
  contact varchar(60) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  login varchar(10) NOT NULL default '',
  passwd varchar(10) NOT NULL default '',
  extrainfo text NOT NULL,
  PRIMARY KEY  (cid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_bannerclient'
#


#
# Table structure for table 'nuke_bannerfinish'
#

CREATE TABLE nuke_bannerfinish (
  bid int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  impressions int(11) NOT NULL default '0',
  clicks int(11) NOT NULL default '0',
  datestart datetime default NULL,
  dateend datetime default NULL,
  PRIMARY KEY  (bid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_bannerfinish'
#


#
# Table structure for table 'nuke_blocks'
#

CREATE TABLE nuke_blocks (
  bid int(10) NOT NULL auto_increment,
  bkey varchar(15) NOT NULL default '',
  title varchar(60) NOT NULL default '',
  content text NOT NULL,
  url varchar(200) NOT NULL default '',
  position char(1) NOT NULL default '',
  weight int(10) NOT NULL default '1',
  active int(1) NOT NULL default '1',
  refresh int(10) NOT NULL default '0',
  time varchar(14) NOT NULL default '0',
  blanguage varchar(30) NOT NULL default '',
  blockfile varchar(255) NOT NULL default '',
  PRIMARY KEY  (bid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_blocks'
#

INSERT INTO nuke_blocks VALUES (1,'main','Main Menu','<strong><big>·</big></strong> <a href=\"index.php\">Home</a><br>\r\n<strong><big>·</big></strong> <a href=\"topics.php\">Topics</a><br>\r\n<strong><big>·</big></strong> <a href=\"sections.php\">Sections</a><br>\r\n<strong><big>·</big></strong> <a href=\"reviews.php\">Reviews</a><br>\r\n<strong><big>·</big></strong> <a href=\"friend.php\">Recommend Us</a><br>\r\n<strong><big>·</big></strong> <a href=\"user.php\">Your Account</a><br>\r\n<strong><big>·</big></strong> <a href=\"submit.php\">Submit News</a><br>\r\n<strong><big>·</big></strong> <a href=\"stats.php\">Stats</a><br>\r\n<strong><big>·</big></strong> <a href=\"top.php\">Top 10</a><br>\r\n','','l',1,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (2,'admin','Administration','Administration Block.<br>\r\nThis box will appear only if you\r\nhas been logged as an Admin. No others users can view this.<br>\r\n<strong><big>·</big></strong> <a href=\"admin.php\">Administration</a><br>\r\n<strong><big>·</big></strong> <a href=\"admin.php?op=logout\">Logout</a>','','l',3,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (3,'online','Who\'s Online','','','l',2,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (4,'poll','Survey','','','r',4,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (5,'past','Past Articles','','','r',5,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (6,'big','Today\'s Big Story','','','r',6,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (7,'login','User\'s Login','','','r',7,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (8,'search','Search Box','','','l',4,0,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (9,'userbox','User\'s Custom Box','','','r',1,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (10,'category','Categories Menu','','','r',2,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (11,'random','Random Headlines','','','r',3,0,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (12,'modules','Modules','','','l',5,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (13,'thelang','Languages','','','l',6,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (14,'','First Right Block','<font class=\"content\">\r\nYou can add/remove/edit blocks for your site with PHP-Nuke.\r\nAlso you can add HTML commands like <a href=\"http://phpnuke.org\">links</a>, <b>Bold</b> text, images, etc.\r\nJust use you imagination.\r\n</font>','','r',8,1,1800,'985591188','','');
INSERT INTO nuke_blocks VALUES (15,'','First Left Block','<font class=\"content\">\r\nYou can add/remove/edit blocks for your site with PHP-Nuke.\r\nAlso you can add HTML commands like <a href=\"http://phpnuke.org\">links</a>, <b>Bold</b> text, images, etc.\r\nJust use you imagination.\r\n</font>','','l',7,1,0,'985591188','','');
INSERT INTO nuke_blocks VALUES (16,'','Information','<br><center><font class=\"content\">\r\n<a href=\"http://phpnuke.org\"><img src=\"images/powered/phpnuke.gif\" border=\"0\" alt=\"Powered by PHP-Nuke\" width=\"88\" height=\"31\"></a>\r\n<br><br>\r\n<a href=\"http://validator.w3.org/check/referer\"><img src=\"images/html401.gif\" width=\"88\" height=\"31\" alt=\"Valid HTML 4.01!\" border=\"0\"></a>\r\n<br><br>\r\n<a href=\"http://jigsaw.w3.org/css-validator\"><img src=\"images/css.gif\" width=\"88\" height=\"31\" alt=\"Valid CSS!\" border=\"0\"></a></font></center>','','r',9,1,0,'985591188','','');

#
# Table structure for table 'nuke_comments'
#

CREATE TABLE nuke_comments (
  tid int(11) NOT NULL auto_increment,
  pid int(11) default '0',
  sid int(11) default '0',
  date datetime default NULL,
  name varchar(60) NOT NULL default '',
  email varchar(60) default NULL,
  url varchar(60) default NULL,
  host_name varchar(60) default NULL,
  subject varchar(85) NOT NULL default '',
  comment text NOT NULL,
  score tinyint(4) NOT NULL default '0',
  reason tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (tid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_comments'
#

#
# Table structure for table 'nuke_counter'
#

CREATE TABLE nuke_counter (
  type varchar(80) NOT NULL default '',
  var varchar(80) NOT NULL default '',
  count int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_counter'
#

INSERT INTO nuke_counter VALUES ('total','hits',1);
INSERT INTO nuke_counter VALUES ('browser','WebTV',0);
INSERT INTO nuke_counter VALUES ('browser','Lynx',0);
INSERT INTO nuke_counter VALUES ('browser','MSIE',0);
INSERT INTO nuke_counter VALUES ('browser','Opera',0);
INSERT INTO nuke_counter VALUES ('browser','Konqueror',0);
INSERT INTO nuke_counter VALUES ('browser','Netscape',1);
INSERT INTO nuke_counter VALUES ('browser','Bot',0);
INSERT INTO nuke_counter VALUES ('browser','Other',0);
INSERT INTO nuke_counter VALUES ('os','Windows',0);
INSERT INTO nuke_counter VALUES ('os','Linux',1);
INSERT INTO nuke_counter VALUES ('os','Mac',0);
INSERT INTO nuke_counter VALUES ('os','FreeBSD',0);
INSERT INTO nuke_counter VALUES ('os','SunOS',0);
INSERT INTO nuke_counter VALUES ('os','IRIX',0);
INSERT INTO nuke_counter VALUES ('os','BeOS',0);
INSERT INTO nuke_counter VALUES ('os','OS/2',0);
INSERT INTO nuke_counter VALUES ('os','AIX',0);
INSERT INTO nuke_counter VALUES ('os','Other',0);

#
# Table structure for table 'nuke_downloads_categories'
#

CREATE TABLE nuke_downloads_categories (
  cid int(11) NOT NULL auto_increment,
  title varchar(50) NOT NULL default '',
  cdescription text NOT NULL,
  PRIMARY KEY  (cid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_downloads_categories'
#


#
# Table structure for table 'nuke_downloads_downloads'
#

CREATE TABLE nuke_downloads_downloads (
  lid int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  sid int(11) NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  description text NOT NULL,
  date datetime default NULL,
  name varchar(100) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  hits int(11) NOT NULL default '0',
  submitter varchar(60) NOT NULL default '',
  downloadratingsummary double(6,4) NOT NULL default '0.0000',
  totalvotes int(11) NOT NULL default '0',
  totalcomments int(11) NOT NULL default '0',
  filesize int(11) NOT NULL default '0',
  version varchar(10) NOT NULL default '',
  homepage varchar(200) NOT NULL default '',
  PRIMARY KEY  (lid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_downloads_downloads'
#


#
# Table structure for table 'nuke_downloads_editorials'
#

CREATE TABLE nuke_downloads_editorials (
  downloadid int(11) NOT NULL default '0',
  adminid varchar(60) NOT NULL default '',
  editorialtimestamp datetime NOT NULL default '0000-00-00 00:00:00',
  editorialtext text NOT NULL,
  editorialtitle varchar(100) NOT NULL default '',
  PRIMARY KEY  (downloadid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_downloads_editorials'
#


#
# Table structure for table 'nuke_downloads_modrequest'
#

CREATE TABLE nuke_downloads_modrequest (
  requestid int(11) NOT NULL auto_increment,
  lid int(11) NOT NULL default '0',
  cid int(11) NOT NULL default '0',
  sid int(11) NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  description text NOT NULL,
  modifysubmitter varchar(60) NOT NULL default '',
  brokendownload int(3) NOT NULL default '0',
  name varchar(100) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  filesize int(11) NOT NULL default '0',
  version varchar(10) NOT NULL default '',
  homepage varchar(200) NOT NULL default '',
  PRIMARY KEY  (requestid),
  UNIQUE KEY requestid (requestid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_downloads_modrequest'
#


#
# Table structure for table 'nuke_downloads_newdownload'
#

CREATE TABLE nuke_downloads_newdownload (
  lid int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  sid int(11) NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  description text NOT NULL,
  name varchar(100) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  submitter varchar(60) NOT NULL default '',
  filesize int(11) NOT NULL default '0',
  version varchar(10) NOT NULL default '',
  homepage varchar(200) NOT NULL default '',
  PRIMARY KEY  (lid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_downloads_newdownload'
#


#
# Table structure for table 'nuke_downloads_subcategories'
#

CREATE TABLE nuke_downloads_subcategories (
  sid int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  title varchar(50) NOT NULL default '',
  PRIMARY KEY  (sid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_downloads_subcategories'
#


#
# Table structure for table 'nuke_downloads_votedata'
#

CREATE TABLE nuke_downloads_votedata (
  ratingdbid int(11) NOT NULL auto_increment,
  ratinglid int(11) NOT NULL default '0',
  ratinguser varchar(60) NOT NULL default '',
  rating int(11) NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingcomments text NOT NULL,
  ratingtimestamp datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (ratingdbid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_downloads_votedata'
#


#
# Table structure for table 'nuke_ephem'
#

CREATE TABLE nuke_ephem (
  eid int(11) NOT NULL auto_increment,
  did int(2) NOT NULL default '0',
  mid int(2) NOT NULL default '0',
  yid int(4) NOT NULL default '0',
  content text NOT NULL,
  elanguage varchar(30) NOT NULL default '',
  PRIMARY KEY  (eid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_ephem'
#


#
# Table structure for table 'nuke_faqAnswer'
#

CREATE TABLE nuke_faqAnswer (
  id tinyint(4) NOT NULL auto_increment,
  id_cat tinyint(4) default NULL,
  question varchar(255) default NULL,
  answer text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_faqAnswer'
#


#
# Table structure for table 'nuke_faqCategories'
#

CREATE TABLE nuke_faqCategories (
  id_cat tinyint(3) NOT NULL auto_increment,
  categories varchar(255) default NULL,
  flanguage varchar(30) NOT NULL default '',
  PRIMARY KEY  (id_cat)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_faqCategories'
#


#
# Table structure for table 'nuke_headlines'
#

CREATE TABLE nuke_headlines (
  hid int(11) NOT NULL auto_increment,
  sitename varchar(30) NOT NULL default '',
  headlinesurl varchar(200) NOT NULL default '',
  PRIMARY KEY  (hid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_headlines'
#

INSERT INTO nuke_headlines VALUES (1,'PHP-Nuke','http://phpnuke.org/backend.php');
INSERT INTO nuke_headlines VALUES (2,'LinuxCentral','http://linuxcentral.com/backend/lcnew.rdf');
INSERT INTO nuke_headlines VALUES (3,'Slashdot','http://slashdot.org/slashdot.rdf');
INSERT INTO nuke_headlines VALUES (4,'NewsForge','http://www.newsforge.com/newsforge.rdf');
INSERT INTO nuke_headlines VALUES (5,'PHPBuilder','http://phpbuilder.com/rss_feed.php');
INSERT INTO nuke_headlines VALUES (6,'Linux.com','http://linux.com/mrn/front_page.rss');
INSERT INTO nuke_headlines VALUES (7,'Freshmeat','http://freshmeat.net/backend/fm.rdf');
INSERT INTO nuke_headlines VALUES (8,'AppWatch','http://static.appwatch.com/appwatch.rdf');
INSERT INTO nuke_headlines VALUES (9,'LinuxWeelyNews','http://lwn.net/headlines/rss');
INSERT INTO nuke_headlines VALUES (10,'HappyPenguin','http://happypenguin.org/html/news.rdf');
INSERT INTO nuke_headlines VALUES (11,'Segfault','http://segfault.org/stories.xml');
INSERT INTO nuke_headlines VALUES (13,'KDE','http://www.kde.org/news/kdenews.rdf');
INSERT INTO nuke_headlines VALUES (14,'Perl.com','http://www.perl.com/pace/perlnews.rdf');
INSERT INTO nuke_headlines VALUES (15,'Themes.org','http://www.themes.org/news.rdf.phtml');
INSERT INTO nuke_headlines VALUES (16,'BrunchingShuttlecocks','http://www.brunching.com/brunching.rdf');
INSERT INTO nuke_headlines VALUES (17,'MozillaNewsBot','http://www.mozilla.org/newsbot/newsbot.rdf');
INSERT INTO nuke_headlines VALUES (18,'NewsTrolls','http://newstrolls.com/newstrolls.rdf');
INSERT INTO nuke_headlines VALUES (19,'FreakTech','http://sunsite.auc.dk/FreakTech/FreakTech.rdf');
INSERT INTO nuke_headlines VALUES (20,'AbsoluteGames','http://files.gameaholic.com/agfa.rdf');
INSERT INTO nuke_headlines VALUES (21,'SciFi-News','http://www.technopagan.org/sf-news/rdf.php');
INSERT INTO nuke_headlines VALUES (22,'SisterMachineGun','http://www.smg.org/index/mynetscape.html');
INSERT INTO nuke_headlines VALUES (23,'LinuxM68k','http://www.linux-m68k.org/linux-m68k.rdf');
INSERT INTO nuke_headlines VALUES (24,'Protest.net','http://www.protest.net/netcenter_rdf.cgi');
INSERT INTO nuke_headlines VALUES (25,'HollywoodBitchslap','http://hollywoodbitchslap.com/hbs.rdf');
INSERT INTO nuke_headlines VALUES (26,'DrDobbsTechNetCast','http://www.technetcast.com/tnc_headlines.rdf');
INSERT INTO nuke_headlines VALUES (27,'RivaExtreme','http://rivaextreme.com/ssi/rivaextreme.rdf.cdf');
INSERT INTO nuke_headlines VALUES (28,'Linuxpower','http://linuxpower.org/linuxpower.rdf');
INSERT INTO nuke_headlines VALUES (29,'PBSOnline','http://cgi.pbs.org/cgi-registry/featuresrdf.pl');
INSERT INTO nuke_headlines VALUES (30,'Listology','http://listology.com/recent.rdf');
INSERT INTO nuke_headlines VALUES (31,'Linuxdev.net','http://linuxdev.net/archive/news.cdf');
INSERT INTO nuke_headlines VALUES (32,'LinuxNewbie','http://www.linuxnewbie.org/news.cdf');
INSERT INTO nuke_headlines VALUES (33,'exoScience','http://www.exosci.com/exosci.rdf');
INSERT INTO nuke_headlines VALUES (34,'Technocrat','http://technocrat.net/rdf');
INSERT INTO nuke_headlines VALUES (35,'PDABuzz','http://www.pdabuzz.com/netscape.txt');
INSERT INTO nuke_headlines VALUES (36,'MicroUnices','http://mu.current.nu/mu.rdf');
INSERT INTO nuke_headlines VALUES (37,'TheNextLevel','http://www.the-nextlevel.com/rdf/tnl.rdf');
INSERT INTO nuke_headlines VALUES (38,'Gnotices','http://news.gnome.org/gnome-news/rdf');
INSERT INTO nuke_headlines VALUES (39,'DailyDaemonNews','http://daily.daemonnews.org/ddn.rdf.php3');
INSERT INTO nuke_headlines VALUES (40,'PerlMonks','http://www.perlmonks.org/headlines.rdf');
INSERT INTO nuke_headlines VALUES (41,'PerlNews','http://news.perl.org/perl-news-short.rdf');
INSERT INTO nuke_headlines VALUES (42,'BSDToday','http://www.bsdtoday.com/backend/bt.rdf');
INSERT INTO nuke_headlines VALUES (43,'DotKDE','http://dot.kde.org/rdf');
INSERT INTO nuke_headlines VALUES (44,'GeekNik','http://www.geeknik.net/backend/weblog.rdf');
INSERT INTO nuke_headlines VALUES (45,'HotWired','http://www.hotwired.com/webmonkey/meta/headlines.rdf');
INSERT INTO nuke_headlines VALUES (46,'JustLinux','http://www.justlinux.com/backend/features.rdf');
INSERT INTO nuke_headlines VALUES (47,'LAN-Systems','http://www.lansystems.com/backend/gazette_news_backend.rdf');
INSERT INTO nuke_headlines VALUES (48,'DigitalTheatre','http://www.dtheatre.com/backend.php3?xml=yes');
INSERT INTO nuke_headlines VALUES (49,'Linux.nu','http://www.linux.nu/backend/lnu.rdf');
INSERT INTO nuke_headlines VALUES (50,'Lin-x-pert','http://www.lin-x-pert.com/linxpert_apps.rdf');
INSERT INTO nuke_headlines VALUES (51,'MaximumBSD1','http://www.maximumbsd.com/backend/weblog.rdf1');
INSERT INTO nuke_headlines VALUES (52,'SolarisCentral','http://www.SolarisCentral.org/news/SolarisCentral.rdf');

#
# Table structure for table 'nuke_links_categories'
#

CREATE TABLE nuke_links_categories (
  cid int(11) NOT NULL auto_increment,
  title varchar(50) NOT NULL default '',
  cdescription text NOT NULL,
  PRIMARY KEY  (cid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_links_categories'
#


#
# Table structure for table 'nuke_links_editorials'
#

CREATE TABLE nuke_links_editorials (
  linkid int(11) NOT NULL default '0',
  adminid varchar(60) NOT NULL default '',
  editorialtimestamp datetime NOT NULL default '0000-00-00 00:00:00',
  editorialtext text NOT NULL,
  editorialtitle varchar(100) NOT NULL default '',
  PRIMARY KEY  (linkid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_links_editorials'
#


#
# Table structure for table 'nuke_links_links'
#

CREATE TABLE nuke_links_links (
  lid int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  sid int(11) NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  description text NOT NULL,
  date datetime default NULL,
  name varchar(100) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  hits int(11) NOT NULL default '0',
  submitter varchar(60) NOT NULL default '',
  linkratingsummary double(6,4) NOT NULL default '0.0000',
  totalvotes int(11) NOT NULL default '0',
  totalcomments int(11) NOT NULL default '0',
  PRIMARY KEY  (lid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_links_links'
#


#
# Table structure for table 'nuke_links_modrequest'
#

CREATE TABLE nuke_links_modrequest (
  requestid int(11) NOT NULL auto_increment,
  lid int(11) NOT NULL default '0',
  cid int(11) NOT NULL default '0',
  sid int(11) NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  description text NOT NULL,
  modifysubmitter varchar(60) NOT NULL default '',
  brokenlink int(3) NOT NULL default '0',
  PRIMARY KEY  (requestid),
  UNIQUE KEY requestid (requestid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_links_modrequest'
#


#
# Table structure for table 'nuke_links_newlink'
#

CREATE TABLE nuke_links_newlink (
  lid int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  sid int(11) NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  description text NOT NULL,
  name varchar(100) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  submitter varchar(60) NOT NULL default '',
  PRIMARY KEY  (lid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_links_newlink'
#


#
# Table structure for table 'nuke_links_subcategories'
#

CREATE TABLE nuke_links_subcategories (
  sid int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  title varchar(50) NOT NULL default '',
  PRIMARY KEY  (sid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_links_subcategories'
#


#
# Table structure for table 'nuke_links_votedata'
#

CREATE TABLE nuke_links_votedata (
  ratingdbid int(11) NOT NULL auto_increment,
  ratinglid int(11) NOT NULL default '0',
  ratinguser varchar(60) NOT NULL default '',
  rating int(11) NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingcomments text NOT NULL,
  ratingtimestamp datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (ratingdbid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_links_votedata'
#


#
# Table structure for table 'nuke_message'
#

CREATE TABLE nuke_message (
  mid int(11) NOT NULL auto_increment,
  title varchar(100) NOT NULL default '',
  content text NOT NULL,
  date varchar(14) NOT NULL default '',
  expire int(7) NOT NULL default '0',
  active int(1) NOT NULL default '1',
  view int(1) NOT NULL default '1',
  mlanguage varchar(30) NOT NULL default '',
  PRIMARY KEY  (mid),
  UNIQUE KEY mid (mid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_message'
#

INSERT INTO nuke_message VALUES (1,'Welcome to PHP-Nuke!','Congratulations! You have now a web portal installed!. You can edit or change this message from the <a href=\"admin.php\">Administration</a> page. Remember to set/change nickname and/or password for the main admin user. There aren\'t any registered/default user, so maybe you want to open <a href=\"user.php\">an account</a> for you. Please read carefully the README file for some details, CREDITS files to see from where comes the things and remember that this is free software under the GPL License (read COPYING file for details). Hope you enjoy this software. Please report any bug you find, and you\'ll for sure, so drop me an email when one of this annoying things happens and I\'ll try to fix it for the next release. If you liked this software and want to make a contribution you may contact me for donations or purchase something from my <a href=\"http://www.amazon.com/exec/obidos/wishlist/1N51JTF344VHI\">Wish List</a>. PHP-Nuke is proudly sponsored by <a href=\"http://www.mandrakesoft.com\">MandrakeSoft</a>, creators of Linux Mandrake. Now, have fun using PHP-Nuke!','993373194',0,1,1,'');

#
# Table structure for table 'nuke_modules'
#

CREATE TABLE nuke_modules (
  mid int(10) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  active int(1) NOT NULL default '0',
  view int(1) NOT NULL default '0',
  KEY mid (mid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_modules'
#

INSERT INTO nuke_modules VALUES (1,'AvantGo',0,0);
INSERT INTO nuke_modules VALUES (2,'FAQ',0,0);
INSERT INTO nuke_modules VALUES (3,'Members_List',1,0);
INSERT INTO nuke_modules VALUES (4,'Feedback',1,0);
INSERT INTO nuke_modules VALUES (5,'Addon_Sample',0,0);
INSERT INTO nuke_modules VALUES (6,'Downloads',1,0);
INSERT INTO nuke_modules VALUES (7,'Web_Links',1,0);

#
# Table structure for table 'nuke_poll_check'
#

CREATE TABLE nuke_poll_check (
  ip varchar(20) NOT NULL default '',
  time varchar(14) NOT NULL default '',
  pollID int(10) NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_poll_check'
#


#
# Table structure for table 'nuke_poll_data'
#

CREATE TABLE nuke_poll_data (
  pollID int(11) NOT NULL default '0',
  optionText char(50) NOT NULL default '',
  optionCount int(11) NOT NULL default '0',
  voteID int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_poll_data'
#

INSERT INTO nuke_poll_data VALUES (1,'Ummmm, not bad',0,1);
INSERT INTO nuke_poll_data VALUES (1,'Cool',0,2);
INSERT INTO nuke_poll_data VALUES (1,'Terrific',0,3);
INSERT INTO nuke_poll_data VALUES (1,'The best one!',0,4);
INSERT INTO nuke_poll_data VALUES (1,'what the hell is this?',0,5);
INSERT INTO nuke_poll_data VALUES (1,'',0,6);
INSERT INTO nuke_poll_data VALUES (1,'',0,7);
INSERT INTO nuke_poll_data VALUES (1,'',0,8);
INSERT INTO nuke_poll_data VALUES (1,'',0,9);
INSERT INTO nuke_poll_data VALUES (1,'',0,10);
INSERT INTO nuke_poll_data VALUES (1,'',0,11);
INSERT INTO nuke_poll_data VALUES (1,'',0,12);

#
# Table structure for table 'nuke_poll_desc'
#

CREATE TABLE nuke_poll_desc (
  pollID int(11) NOT NULL auto_increment,
  pollTitle varchar(100) NOT NULL default '',
  timeStamp int(11) NOT NULL default '0',
  voters mediumint(9) NOT NULL default '0',
  planguage varchar(30) NOT NULL default '',
  artid int(10) NOT NULL default '0',
  PRIMARY KEY  (pollID)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_poll_desc'
#

INSERT INTO nuke_poll_desc VALUES (1,'What do you think about PHP-Nuke?',961405160,9,'english',0);

#
# Table structure for table 'nuke_pollcomments'
#

CREATE TABLE nuke_pollcomments (
  tid int(11) NOT NULL auto_increment,
  pid int(11) default '0',
  pollID int(11) default '0',
  date datetime default NULL,
  name varchar(60) NOT NULL default '',
  email varchar(60) default NULL,
  url varchar(60) default NULL,
  host_name varchar(60) default NULL,
  subject varchar(60) NOT NULL default '',
  comment text NOT NULL,
  score tinyint(4) NOT NULL default '0',
  reason tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (tid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_pollcomments'
#


#
# Table structure for table 'nuke_priv_msgs'
#

CREATE TABLE nuke_priv_msgs (
  msg_id int(10) NOT NULL auto_increment,
  msg_image varchar(100) default NULL,
  subject varchar(100) default NULL,
  from_userid int(10) NOT NULL default '0',
  to_userid int(10) NOT NULL default '0',
  msg_time varchar(20) default NULL,
  msg_text text,
  read_msg tinyint(10) NOT NULL default '0',
  PRIMARY KEY  (msg_id),
  KEY msg_id (msg_id),
  KEY to_userid (to_userid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_priv_msgs'
#


#
# Table structure for table 'nuke_queue'
#

CREATE TABLE nuke_queue (
  qid smallint(5) unsigned NOT NULL auto_increment,
  uid mediumint(9) NOT NULL default '0',
  uname varchar(40) NOT NULL default '',
  subject varchar(100) NOT NULL default '',
  story text,
  storyext text NOT NULL,
  timestamp datetime NOT NULL default '0000-00-00 00:00:00',
  topic varchar(20) NOT NULL default '',
  alanguage varchar(30) NOT NULL default '',
  PRIMARY KEY  (qid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_queue'
#


#
# Table structure for table 'nuke_quotes'
#

CREATE TABLE nuke_quotes (
  qid int(10) unsigned NOT NULL auto_increment,
  quote text,
  PRIMARY KEY  (qid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_quotes'
#

INSERT INTO nuke_quotes VALUES (1,'Nos morituri te salutamus - CBHS');

#
# Table structure for table 'nuke_referer'
#

CREATE TABLE nuke_referer (
  rid int(11) NOT NULL auto_increment,
  url varchar(100) NOT NULL default '',
  PRIMARY KEY  (rid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_referer'
#


#
# Table structure for table 'nuke_related'
#

CREATE TABLE nuke_related (
  rid int(11) NOT NULL auto_increment,
  tid int(11) NOT NULL default '0',
  name varchar(30) NOT NULL default '',
  url varchar(200) NOT NULL default '',
  PRIMARY KEY  (rid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_related'
#


#
# Table structure for table 'nuke_reviews'
#

CREATE TABLE nuke_reviews (
  id int(10) NOT NULL auto_increment,
  date date NOT NULL default '0000-00-00',
  title varchar(150) NOT NULL default '',
  text text NOT NULL,
  reviewer varchar(20) default NULL,
  email varchar(60) default NULL,
  score int(10) NOT NULL default '0',
  cover varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  url_title varchar(50) NOT NULL default '',
  hits int(10) NOT NULL default '0',
  rlanguage varchar(30) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_reviews'
#


#
# Table structure for table 'nuke_reviews_add'
#

CREATE TABLE nuke_reviews_add (
  id int(10) NOT NULL auto_increment,
  date date default NULL,
  title varchar(150) NOT NULL default '',
  text text NOT NULL,
  reviewer varchar(20) NOT NULL default '',
  email varchar(60) default NULL,
  score int(10) NOT NULL default '0',
  url varchar(100) NOT NULL default '',
  url_title varchar(50) NOT NULL default '',
  rlanguage varchar(30) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_reviews_add'
#


#
# Table structure for table 'nuke_reviews_comments'
#

CREATE TABLE nuke_reviews_comments (
  cid int(10) NOT NULL auto_increment,
  rid int(10) NOT NULL default '0',
  userid varchar(25) NOT NULL default '',
  date datetime default NULL,
  comments text,
  score int(10) NOT NULL default '0',
  PRIMARY KEY  (cid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_reviews_comments'
#


#
# Table structure for table 'nuke_reviews_main'
#

CREATE TABLE nuke_reviews_main (
  title varchar(100) default NULL,
  description text
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_reviews_main'
#

INSERT INTO nuke_reviews_main VALUES ('Reviews Section Title','Reviews Section Long Description');

#
# Table structure for table 'nuke_seccont'
#

CREATE TABLE nuke_seccont (
  artid int(11) NOT NULL auto_increment,
  secid int(11) NOT NULL default '0',
  title text NOT NULL,
  content text NOT NULL,
  counter int(11) NOT NULL default '0',
  slanguage varchar(30) NOT NULL default '',
  PRIMARY KEY  (artid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_seccont'
#


#
# Table structure for table 'nuke_sections'
#

CREATE TABLE nuke_sections (
  secid int(11) NOT NULL auto_increment,
  secname varchar(40) NOT NULL default '',
  image varchar(50) NOT NULL default '',
  PRIMARY KEY  (secid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_sections'
#


#
# Table structure for table 'nuke_session'
#

CREATE TABLE nuke_session (
  username varchar(25) NOT NULL default '',
  time varchar(14) NOT NULL default '',
  host_addr varchar(20) NOT NULL default '',
  guest int(1) NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_session'
#


#
# Table structure for table 'nuke_stories'
#

CREATE TABLE nuke_stories (
  sid int(11) NOT NULL auto_increment,
  catid int(11) NOT NULL default '0',
  aid varchar(30) NOT NULL default '',
  title varchar(80) default NULL,
  time datetime default NULL,
  hometext text,
  bodytext text NOT NULL,
  comments int(11) default '0',
  counter mediumint(8) unsigned default NULL,
  topic int(3) NOT NULL default '1',
  informant varchar(20) NOT NULL default '',
  notes text NOT NULL,
  ihome int(1) NOT NULL default '0',
  alanguage varchar(30) NOT NULL default '',
  acomm int(1) NOT NULL default '0',
  haspoll int(1) NOT NULL default '0',
  pollID int(10) NOT NULL default '0',
  PRIMARY KEY  (sid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_stories'
#


#
# Table structure for table 'nuke_stories_cat'
#

CREATE TABLE nuke_stories_cat (
  catid int(11) NOT NULL auto_increment,
  title varchar(20) NOT NULL default '',
  counter int(11) NOT NULL default '0',
  PRIMARY KEY  (catid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_stories_cat'
#


#
# Table structure for table 'nuke_topics'
#

CREATE TABLE nuke_topics (
  topicid int(3) NOT NULL auto_increment,
  topicname varchar(20) default NULL,
  topicimage varchar(20) default NULL,
  topictext varchar(40) default NULL,
  counter int(11) NOT NULL default '0',
  PRIMARY KEY  (topicid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_topics'
#

INSERT INTO nuke_topics VALUES (1,'linux','linux.gif','Linux',0);
INSERT INTO nuke_topics VALUES (2,'amd','amd.gif','AMD',0);
INSERT INTO nuke_topics VALUES (3,'suse','suse.gif','SuSE',0);
INSERT INTO nuke_topics VALUES (4,'caldera','caldera.gif','Caldera Systems',0);
INSERT INTO nuke_topics VALUES (5,'apple','mac.gif','Apple / Mac',0);
INSERT INTO nuke_topics VALUES (6,'beos','beos.gif','BeOS',0);
INSERT INTO nuke_topics VALUES (7,'compaq','compaq.gif','Compaq',0);
INSERT INTO nuke_topics VALUES (8,'corel','corel.gif','Corel',0);
INSERT INTO nuke_topics VALUES (9,'debian','debian.gif','Debian',0);
INSERT INTO nuke_topics VALUES (10,'phpnuke','phpnuke.gif','PHP-Nuke',0);
INSERT INTO nuke_topics VALUES (11,'freebsd','freebsd.gif','FreeBSD',0);
INSERT INTO nuke_topics VALUES (12,'gimp','gimp.gif','GIMP',0);
INSERT INTO nuke_topics VALUES (13,'gnome','gnome.gif','GNOME',0);
INSERT INTO nuke_topics VALUES (14,'gnu','gnu.gif','GNU / GPL',0);
INSERT INTO nuke_topics VALUES (15,'hp','hp.gif','Hewlett Packard',0);
INSERT INTO nuke_topics VALUES (16,'ibm','ibm.gif','IBM',0);
INSERT INTO nuke_topics VALUES (17,'intel','intel.gif','Intel',0);
INSERT INTO nuke_topics VALUES (18,'java','java.gif','Java',0);
INSERT INTO nuke_topics VALUES (19,'kde','kde.gif','KDE',0);
INSERT INTO nuke_topics VALUES (20,'mandrake','mandrake.gif','Mandrake',0);
INSERT INTO nuke_topics VALUES (21,'microsoft','microsoft.gif','Microsoft',0);
INSERT INTO nuke_topics VALUES (22,'mozilla','mozilla.gif','Mozilla',0);
INSERT INTO nuke_topics VALUES (23,'netscape','netscape.gif','Netscape',0);
INSERT INTO nuke_topics VALUES (24,'perl','perl.gif','Perl',0);
INSERT INTO nuke_topics VALUES (25,'redhat','redhat.gif','Red Hat',0);
INSERT INTO nuke_topics VALUES (26,'sgi','sgi.gif','Silicon Graphics',0);
INSERT INTO nuke_topics VALUES (27,'sun','sun.gif','Sun Microsystems',0);
INSERT INTO nuke_topics VALUES (28,'x','x.gif','X Window',0);

#
# Table structure for table 'nuke_users'
#

CREATE TABLE nuke_users (
  uid int(11) NOT NULL auto_increment,
  name varchar(60) NOT NULL default '',
  uname varchar(25) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  femail varchar(60) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  user_avatar varchar(30) default NULL,
  user_regdate varchar(20) NOT NULL default '',
  user_icq varchar(15) default NULL,
  user_occ varchar(100) default NULL,
  user_from varchar(100) default NULL,
  user_intrest varchar(150) default NULL,
  user_sig varchar(255) default NULL,
  user_viewemail tinyint(2) default NULL,
  user_theme int(3) default NULL,
  user_aim varchar(18) default NULL,
  user_yim varchar(25) default NULL,
  user_msnm varchar(25) default NULL,
  pass varchar(40) NOT NULL default '',
  storynum tinyint(4) NOT NULL default '10',
  umode varchar(10) NOT NULL default '',
  uorder tinyint(1) NOT NULL default '0',
  thold tinyint(1) NOT NULL default '0',
  noscore tinyint(1) NOT NULL default '0',
  bio tinytext NOT NULL,
  ublockon tinyint(1) NOT NULL default '0',
  ublock tinytext NOT NULL,
  theme varchar(255) NOT NULL default '',
  commentmax int(11) NOT NULL default '4096',
  counter int(11) NOT NULL default '0',
  newsletter int(1) NOT NULL default '0',
  PRIMARY KEY  (uid)
) TYPE=MyISAM;

#
# Dumping data for table 'nuke_users'
#

INSERT INTO nuke_users VALUES (1,'','Anonymous','','','','blank.gif','Nov 10, 2000','','','','','',0,0,'','','','',10,'',0,0,0,'',0,'','',4096,0,0);

