-- MySQL dump 8.22
--
-- Host: localhost    Database: smsgate
---------------------------------------------------------
-- Server version	3.23.55-nt

--
-- Table structure for table 'bitmap'
--

DROP TABLE IF EXISTS bitmap;
CREATE TABLE bitmap (
  id int(11) NOT NULL auto_increment,
  width int(10) unsigned NOT NULL default '0',
  height int(10) unsigned NOT NULL default '0',
  image mediumblob NOT NULL,
  res_id int(10) unsigned NOT NULL default '0',
  depth tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY res_id (res_id)
) TYPE=MyISAM;

--
-- Table structure for table 'config'
--

DROP TABLE IF EXISTS config;
CREATE TABLE config (
  param mediumtext NOT NULL,
  value mediumtext NOT NULL
) TYPE=MyISAM;

--
-- Table structure for table 'discarded_sms'
--

DROP TABLE IF EXISTS discarded_sms;
CREATE TABLE discarded_sms (
  id int(11) NOT NULL auto_increment,
  added int(10) unsigned NOT NULL default '0',
  hex_data mediumblob NOT NULL,
  cause int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table structure for table 'imelody'
--

DROP TABLE IF EXISTS imelody;
CREATE TABLE imelody (
  id int(11) NOT NULL auto_increment,
  header mediumblob NOT NULL,
  melody mediumblob NOT NULL,
  footer mediumblob NOT NULL,
  res_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY res_id (res_id)
) TYPE=MyISAM;

--
-- Table structure for table 'incoming_sms_ind'
--

DROP TABLE IF EXISTS incoming_sms_ind;
CREATE TABLE incoming_sms_ind (
  ind int(10) unsigned NOT NULL default '0',
  added int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (ind)
) TYPE=MyISAM;

--
-- Table structure for table 'nokring'
--

DROP TABLE IF EXISTS nokring;
CREATE TABLE nokring (
  id int(11) NOT NULL auto_increment,
  res_id int(10) unsigned NOT NULL default '0',
  ringtone mediumblob NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY res_id (res_id)
) TYPE=MyISAM;

--
-- Table structure for table 'pending_sms'
--

DROP TABLE IF EXISTS pending_sms;
CREATE TABLE pending_sms (
  id int(11) NOT NULL auto_increment,
  hex_data mediumblob NOT NULL,
  added int(10) unsigned NOT NULL default '0',
  last_attempt int(10) unsigned NOT NULL default '0',
  attempts int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table structure for table 'processed_sms'
--

DROP TABLE IF EXISTS processed_sms;
CREATE TABLE processed_sms (
  id int(11) NOT NULL auto_increment,
  hex_data mediumblob NOT NULL,
  added int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table structure for table 'resource_type'
--

DROP TABLE IF EXISTS resource_type;
CREATE TABLE resource_type (
  id int(11) NOT NULL auto_increment,
  res_id int(10) unsigned NOT NULL default '0',
  res_type int(10) unsigned NOT NULL default '0',
  hits int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY ures_type (res_id,res_type)
) TYPE=MyISAM;

