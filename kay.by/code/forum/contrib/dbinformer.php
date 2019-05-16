<?php
/***************************************************************************
*                               dbinformer.php
*                            -------------------
*   begin                : Saturday, May 05, 2002
*   copyright            : (C) 2002 The phpBB Group
*   email                : n/a
*
*   $Id: dbinformer.php,v 1.11 2002/05/04 12:15:00 Blade Exp $
*
*   Coded by AL, Techie-Micheal, Blade, and Black Fluffy Lion.
*   http://www.phpbb.com/phpBB/groupcp.php?g=7330
*
***************************************************************************/
/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

// Create the config file. Classes by Blade
class config
{
	var $dbms;
	var $dbhost;
	var $dbname;
	var $dbuser;
	var $dbpasswd;
	var $table_prefix;
	function set($ms = '', $h = '', $n = '', $u = '', $p = '', $t = '')
	{
		$this->dbms = $ms;
		$this->dbhost = $h;
		$this->dbname = $n;
		$this->dbuser = $u;
		$this->dbpasswd = $p;
		$this->table_prefix = $t;
	}
	// Make the config file
	function create()
	{
		echo '&lt;?php<br />' . "\n";
		echo '<br />';
		echo '//<br />' . "\n";
		echo '// phpBB 2.x auto-generated config file<br />' . "\n";
		echo '// Do not change anything in this file!<br />' . "\n";
		echo '//<br />' . "\n";
		echo '<br />';
		printf
		(
			'$dbms = \'%s\'' . ";<br /><br />\n"
			. '$dbhost = \'%s\'' . ";<br />\n"
			. '$dbname = \'%s\'' . ";<br />\n"
			. '$dbuser = \'%s\'' . ";<br />\n"
			. '$dbpasswd = \'%s\'' . ";<br /><br />\n"
			. '$table_prefix = \'%s\'' . ";<br /><br />\n"
			. 'define(\'PHPBB_INSTALLED\', true);'. "<br /><br />\n",
			$this->dbms,
			$this->dbhost,
			$this->dbname,
			$this->dbuser,
			$this->dbpasswd,
			$this->table_prefix
		);
		echo  '?>' . "\n";
	}
}

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
echo '<html>';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html" />';
echo '<meta http-equiv="Content-Style-Type" content="text/css" />';
echo '<title>phpBB :: dbinformer.php</title>';
echo '<link rel="stylesheet" href="../templates/subSilver/subSilver.css" type="text/css" />';
echo '<style type="text/css">';
echo '<!--';
echo 'p,ul,td {font-size:10pt;}';
echo 'h3 {font-size:12pt;color:blue}';
echo '//-->';
echo '</style>';
echo '</head>';

echo '<body>';
echo '<a name="top"></a>';
echo '<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center">';
echo '<tr>';
echo '<td class="bodyline"><table width="100%" border="0" cellspacing="0" cellpadding="0">';
echo '<tr>';
echo '<td>';
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
echo '<tr>';
echo '<td><img src="../templates/subSilver/images/logo_phpBB.gif" border="0" alt="phpBB2 : Creating Communities" vspace="1" /></a></td>';
echo '<td align="center" width="100%" valign="middle"><span class="maintitle">dbinformer.php</span>'; 
echo '</td>';
echo '</tr>';
echo '</table>';

echo '<br /><b><div align="center"><a href="#what">What you entered</a> | ' ;
echo '<a href="#connect">Connection to database</a> | ' ;
echo '<a href="#tables">Tables in database</a> | ' ;
echo '<a href="#config">Config file</a></b><br /><br />' ;
echo '<i>Note: this software only works with MySQL currently. Adding the DBAL system is in the works however.</i></div>';

// Form for db details
echo '<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center">';
echo '<tr>';
echo '<td align="center" width="100%" valign="middle"><span class="maintitle"></span></td>';
echo '</tr>';
echo '<tr>';
echo '<td width="100%"><form action="' . $HTTP_SERVER_VARS['PHP_SELF'] . '" method="post"><table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">';
echo '<tr>';
echo '<th colspan="2">Database Configuration</th>';
echo '</tr>';
echo '<tr>';
echo '<td class="row1" align="right"><span class="gen">Database Server Hostname / DSN: </span></td>';
echo '<td class="row2"><input type="text" name="dbhost" value="' . @$HTTP_POST_VARS['dbhost'] . '" /></td>';
echo '</tr>';
echo '<tr>';
echo '<td class="row1" align="right"><span class="gen">Your Database Name: </span></td>';
echo '<td class="row2"><input type="text" name="dbname" value="' . @$HTTP_POST_VARS['dbname'] . '" /></td>';
echo '</tr>';
echo '<tr>';
echo '<td class="row1" align="right"><span class="gen">Database Username: </span></td>';
echo '<td class="row2"><input type="text" name="dbuser" value="' . @$HTTP_POST_VARS['dbuser'] . '" /></td>';
echo '</tr>';
echo '<tr>';
echo '<td class="row1" align="right"><span class="gen">Database Password: </span></td>';
echo '<td class="row2"><input type="password" name="dbpasswd" value="' . @$HTTP_POST_VARS['dbpasswd'] . '" /></td>';
echo '</tr>';
echo '<tr>';
echo '<td class="row1" align="right"><span class="gen">Chosen Prefix: </span></td>';
echo '<td class="row2"><input type="text" name="table_prefix" value="' . @$HTTP_POST_VARS['table_prefix'] . '" /></td>';
echo '</tr>';
echo '<tr>';
echo '<td class="row1" align="right"><span class="gen">Generate a config file for me if the data entered is correct: </span></td>';
echo '</td>';
echo '<td class="row2"><input type="checkbox" name="generate" value="config"></td>';
echo '</tr>';
echo '<tr>';
echo '<td class="catbottom" align="center" colspan="2">';
echo '<input class="mainoption" type="submit" name="submit" value="Submit" /></td>';
echo '</tr>';
echo '</form></td>';
echo '</tr>';
echo '</table><br />';

if (!isset($HTTP_POST_VARS['submit']))
{
	echo 'Please enter your data.<br />';
}
else
{
	echo '<a name="what"><h3><u>What you entered</u></h3></a>';
	echo 'Database Server Hostname / DSN: <b>' . $HTTP_POST_VARS['dbhost'] . '</b><br />';
	echo 'Your Database Name: <b>' . $HTTP_POST_VARS['dbname'] . '</b><br />';
	echo 'Database Username: <b>' . $HTTP_POST_VARS['dbuser'] . '</b><br />';
	echo 'Database Password: <b>' . $HTTP_POST_VARS['dbpasswd'] . '</b><br />';
	echo '<br />';

	echo '<a name="connect"><h3><u>Connection to database</u></h3></a>';

	// Connect using the details from the form above
	$con = @mysql_connect($HTTP_POST_VARS['dbhost'], $HTTP_POST_VARS['dbuser'], $HTTP_POST_VARS['dbpasswd']);
	
	if (!$con)
	{
		echo 'You have not established a connection to your <b>mySQL</b>-Server.<br />';
		echo '<b>ERROR: </b><i>' . mysql_error() . '</i><br /><br />';
	}
	else
	{
		echo 'You have established a connection to your <b>mySQL</b>-Server.<br />';
	}
	$db = @mysql_select_db($HTTP_POST_VARS['dbname'], $con);
	if (!$db)
	{
		echo 'Your database was not found.<br />';
		echo '<b>ERROR: </b><i>' . mysql_error() . '</i><br />';
		$dbk = FALSE;
	}
	else
	{
		echo 'Your database was found.<br />';
		$dbk = TRUE;
	}
	
	if (isset($con) && isset($db))
	{
		echo '<a name="tables"><h3><u>Tables in database</u></h3></a>';

		echo '<i>Tables with the table prefix you specified are in bold.</i>';
		$result = mysql_list_tables($HTTP_POST_VARS['dbname']);
		echo '<ul>';
		while ($tdata = @mysql_fetch_row($result))
		{	
			// Highlight tables with the table_prefix specified
			if (eregi($HTTP_POST_VARS['table_prefix'], $tdata[0]))
			{
				echo '<li><b>' . $tdata[0] . '</b></li><br />';
				$dbk = TRUE;
			}
			else
			{
				echo '<li>' . $tdata[0] . '</li><br />';
			}
		}
		echo '</ul>';
	}
}

// Create a config file if checked and if the connection went OK
if ($HTTP_POST_VARS['generate'] == 'config' && ($dbk == 'TRUE'))
{
	echo '<a name="config"><h3><u>Config file</u></h3></a>';
	echo 'Copy the <b>19</b> lines below and save them as <i>config.php</i>. Upload the file to your phpBB2 root directory (/phpBB2 by default). Make sure that there is nothing (this includes blank spaces) after the <i>?></i>. If you are using MySQL 4.x then you must change the dbms from <i>mysql</i> to <i>mysql4</i>.<br /><br />';

	// Create our config file
	echo '<table border="1" cellpadding=7><tr><td><code>';
	$c = new config();
	$c->set('mysql', $HTTP_POST_VARS['dbhost'], $HTTP_POST_VARS['dbname'], $HTTP_POST_VARS['dbuser'], $HTTP_POST_VARS['dbpasswd'], $HTTP_POST_VARS['table_prefix']);
	$c->create();
	echo '</code></td></tr></table>';
}
else
{
}

// And they all lived happily ever after...
// The End
echo '<br /><a href="#top"><b>Return to top</b></a>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<div align="center"><span class="copyright">&copy; Copyright 2002 The <a href="http://www.phpbb.com/about.php" target="_phpbb" class="copyright">phpBB Group</a></span></div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</body>';
echo '</html>';

?>