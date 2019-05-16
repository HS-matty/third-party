<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (!eregi("admin.php", $PHP_SELF)) { die ("Access Denied"); }

switch($op) {

	case "FileManager":
		include("admin/modules/filemanager.php");
		$lastaction = ""._LISTDIR."";
		$hlpfile = "manual/$language/filemanager.html";
		include("header.php");
		GraphicAdmin($hlpfile);
		html_header();
		displaydir();
		$wdir2="/";
		chdir($basedir . $wdir2);
		include("footer.php");
		break;

	case "root":
		include("admin/modules/filemanager.php");
   		$wdir="/";
		$lastaction = ""._CHANGED2ROOT."";
		$hlpfile = "manual/$language/filemanager.html";
		include("header.php");
		GraphicAdmin($hlpfile);
		html_header();
		displaydir();
		include("footer.php");
		break;

	case "env":
   		$lastaction = ""._DISPHP."";
		$hlpfile = "manual/$language/filemanager.html";
		include("header.php");
		GraphicAdmin($hlpfile);
		html_header();
		phpinfo();
		include("footer.php");
		break;

	case "chdr":
		include("admin/modules/filemanager.php");
		$wdir=$file."/";
		$wdir = ereg_replace("\.\./", "", $wdir);
		$lastaction = ""._CHANGEDDIR." $wdir";
		$hlpfile = "manual/$language/filemanager.html";
		include("header.php");
		GraphicAdmin($hlpfile);
		html_header();
		displaydir();
		$wdir2="/";
		chdir($basedir . $wdir2);
		include("footer.php");
		break;

	case "touch":
		include("admin/modules/filemanager.php");
		touch($basedir.$touchfile);
		$lastaction = ""._TOUCHED." $touchfile";
		$hlpfile = "manual/$language/filemanager.html";
		include("header.php");
		GraphicAdmin($hlpfile);
		html_header();
		displaydir();
		$wdir2="/";
		chdir($basedir . $wdir2);
		include("footer.php");
		break;

	case "del":
		include("admin/modules/filemanager.php");
		if ($confirm)
			{
			if(is_dir($basedir.$file))
				{
				rmdir($basedir.$file);
				}
			else
				{
				unlink($basedir.$file);
				}
			$lastaction = ""._DELETED." $file";
			$hlpfile = "manual/$language/filemanager.html";
			include("header.php");
			GraphicAdmin($hlpfile);
			html_header();
			displaydir();
			}
		else
			{
			$lastaction = ""._FMSURE2DEL."<br>$file?";
			$hlpfile = "manual/$language/filemanager.html";
			include("header.php");
			GraphicAdmin($hlpfile);
			html_header();
			echo "<center><b><font size =\"5\" face=\"arial, helvetica\"><A HREF=\"admin.php?op=del&wdir=$wdir&file=$file&confirm=1\">"._YES."</A></font><br>";
			echo "<p><font size =\"5\" face=\"arial, helvetica\"><A HREF=\"admin.php?wdir=$wdir\">"._NO."</A></font><br><b></center>";
			}
		$wdir2="/";
		chdir($basedir . $wdir2);
		CloseTable();
		include("footer.php");
		break;

	case "move":
		include("admin/modules/filemanager.php");
		if($confirm && $newfile)
 			{
    			if(file_exists($basedir.$newfile))
				{
				$lastaction = ""._DESTFILEEXT."";
				}
			else
				{
				if($do == copy)
					{
					copy($basedir.$file,$basedir.$newfile);
					$lastaction = ""._COPIED."\n$file --> $newfile";
					}
				else
					{
					rename($basedir.$file,$basedir.$newfile);
					$lastaction = ""._MOVREN."\n$file --> $newfile";
					}
				}
		$hlpfile = "manual/$language/filemanager.html";
		include("header.php");
		GraphicAdmin($hlpfile);
			html_header();
			displaydir();
    			$wdir2="/";
			chdir($basedir . $wdir2);
			include("footer.php");
			}
		else
			{
			$lastaction = ""._MOVRENAMING."<br>$file";
		$hlpfile = "manual/$language/filemanager.html";
		include("header.php");
		GraphicAdmin($hlpfile);
			html_header();
			echo "<FORM METHOD=\"POST\" ACTION=\"admin.php\">\n";
			echo "<select name=\"do\">";
			echo "<option value=\"copy\">"._COPY."";
			echo "<option value=\"move\">"._MOVREN2."";
			echo "</select> ";
			echo "($file)";
			echo "<h4>To</h4>";
			echo "<INPUT TYPE=\"TEXT\" NAME=\"newfile\" value=\"$file\" size=\"40\">\n";
			echo "<INPUT TYPE=\"HIDDEN\" NAME=\"wdir\" VALUE=\"$wdir\">\n";			
			echo "<INPUT TYPE=\"HIDDEN\" name=\"op\" VALUE=\"move\">\n";
			echo "<INPUT TYPE=\"HIDDEN\" NAME=\"file\" VALUE=\"$file\">\n";
			echo "<p>";
			echo "<INPUT TYPE=\"SUBMIT\" NAME=\"confirm\" VALUE=\""._OK."\">\n";
			echo "<INPUT TYPE=\"SUBMIT\" NAME=\"cancel\" VALUE=\""._CANCEL."\">\n";
			echo "</FORM>";
			CloseTable();
			include("footer.php");
			}
		break;

	case "edit":
		include("admin/modules/filemanager.php");
		if($confirm && $file)
   			{
    			$lastaction = ""._EDITED." $file";
			$hlpfile = "manual/$language/filemanager.html";
			include("header.php");
			GraphicAdmin($hlpfile);
			html_header();
			$fp=fopen($basedir.$file,"w");
    			fputs($fp,stripslashes($code));
    			fclose($fp);
			displaydir();
			}
		else
			{
			$lastaction = ""._EDITING." $file";
			$hlpfile = "manual/$language/filemanager.html";
			include("header.php");
			GraphicAdmin($hlpfile);
			html_header();
			echo "<FORM METHOD=\"POST\" ACTION=\"admin.php\">\n";
			echo "<INPUT TYPE=\"HIDDEN\" NAME=\"file\" VALUE=\"$file\">\n";
			echo "<INPUT TYPE=\"HIDDEN\" name=\"op\" VALUE=\"edit\">\n";
			echo "<INPUT TYPE=\"HIDDEN\" NAME=\"wdir\" VALUE=\"$wdir\">\n";
			$fp=fopen($basedir.$file,"r");
			$contents=fread($fp,filesize($basedir.$file));
			echo "<TEXTAREA NAME=\"code\" rows=\"$textrows\" cols=\"$textcols\">\n";
			echo htmlspecialchars($contents);
			echo "</TEXTAREA><BR>\n";
			echo "<center><INPUT TYPE=\"SUBMIT\" NAME=\"confirm\" VALUE=\"Save\">\n";
			echo "<INPUT TYPE=\"SUBMIT\" NAME=\"cancel\" VALUE=\"Cancel\"></center><BR>\n";
			echo "</FORM>\n";
			}
		CloseTable();
		include("footer.php");
		break;

	case "show":
		include("admin/modules/filemanager.php");
		$filelocation = $wdir.$file;	
		$lastaction = ""._DISPLAYING." $file";
		$hlpfile = "manual/$language/filemanager.html";
		include("header.php");
		GraphicAdmin($hlpfile);
		html_header();
		if($image == "1")
			{
			echo "<center><img src=\"$file\"></center>";
			}
		else
			{
			show_source($basedir.$file);
			}
		CloseTable();
		include("footer.php");
		break;

	case "mkdir":
		include("admin/modules/filemanager.php");
		if(file_exists($basedir.$wdir.$mkdirfile))
			{
			$lastaction = ""._THEDIR." $wdir$mkdirfile "._ALREADYEXT."";
		$hlpfile = "manual/$language/filemanager.html";
		include("header.php");
		GraphicAdmin($hlpfile);
		html_header();
			}
		else
			{
			$lastaction = ""._DIRCREATED." $wdir$mkdirfile";
			$hlpfile = "manual/$language/filemanager.html";
			include("header.php");
			GraphicAdmin($hlpfile);
			html_header();
			mkdir($basedir.$wdir.$mkdirfile,0750);
			}
		displaydir();
		$wdir2="/";
		chdir($basedir . $wdir2);
		include("footer.php");
		break;

	case "createfile":
		include("admin/modules/filemanager.php");
		$filelocation = $wdir.$file;
		if($done == "1")
   			{
			$lastaction = ""._CREATED." $file";
			$hlpfile = "manual/$language/filemanager.html";
			include("header.php");
			GraphicAdmin($hlpfile);
			html_header();
			$fp=fopen($basedir.$filelocation,"w");
			fputs($fp,stripslashes($code));
			fclose($fp);
			displaydir();
			}
		else
			{
   			if(file_exists($basedir.$filelocation))
   				{
   				$lastaction = "$file "._ALREADYEXT."";
				$hlpfile = "manual/$language/filemanager.html";
				include("header.php");
				GraphicAdmin($hlpfile);
				html_header();
				displaydir();
				}
			else
				{
				$lastaction = ""._CREATING." $file";
				$hlpfile = "manual/$language/filemanager.html";
				include("header.php");
				GraphicAdmin($hlpfile);
				html_header();
				echo "<FORM METHOD=\"POST\" ACTION=\"admin.php\">\n";
				echo "<INPUT TYPE=\"HIDDEN\" NAME=\"file\" VALUE=\"$file\">\n";
				echo "<INPUT TYPE=\"HIDDEN\" name=\"op\" VALUE=\"createfile\">\n";
				echo "<INPUT TYPE=\"HIDDEN\" NAME=\"wdir\" VALUE=\"$wdir\">\n";
				echo "<INPUT TYPE=\"HIDDEN\" NAME=\"done\" VALUE=\"1\">\n";				
				echo "<TEXTAREA NAME=\"code\" rows=\"$textrows\" cols=\"$textcols\">\n";
				if(isset($html))
					{
					echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
					echo "<html>\n";
					echo "<head>\n";
					echo "<title>"._UNTITLED."</title>\n";
					echo "</head>\n";
					echo "<body>\n\n\n\n";
					echo "</body>\n";
					echo "</html>";
					}
				echo "</TEXTAREA><BR>\n";
				echo "<center><INPUT TYPE=\"SUBMIT\" NAME=\"confirm\" VALUE=\"Create\">\n";
				echo "<INPUT TYPE=\"SUBMIT\" NAME=\"cancel\" VALUE=\"Cancel\"></center><BR>\n";
				echo "</FORM>";			
				CloseTable();
				}
			}
		$wdir2="/";
		chdir($basedir . $wdir2);
		include("footer.php");
		break;

}

?>