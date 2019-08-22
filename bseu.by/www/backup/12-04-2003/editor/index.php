<?
$def_path = $DOCUMENT_ROOT."/1/demo/templates";
if(!isset($dir)) {
	if(!isset($file)) { $dir = $def_path; }
	else $dir = dirname($file);
}
if(!isset($action)) $action = "browse";
$dir = urldecode($dir);

$trailer = substr($dir, -1);
if((ord($trailer)) != 47) $dir = "$dir".chr(47);

require "../class.Template.php";
require "header.inc.php";
require "browse.inc.php";

unset($files);
unset($dirs);

if(!@is_dir($dir)) {
	print $dir." Не является директорией.<br />\n";
	die();
}

$tpl = new Template($dir);

if($action == "browse") {
	if($d = opendir($dir)) {
		while(($file = readdir($d)) !== false) {
			if(is_file($dir.$file)) {
				if(strpos($file, ".".$tpl->m_extension) != false) $files[] = $file;
			}
			if(is_dir($dir.$file)) {
				if($file != "." && $file != "..") $dirs[] = $file;
			}
		}  
		closedir($d);
	} else {
		print "Ошибка при открытии директории<br />";
		die();
	}
	if(isset($dirs)) {
		print "<div align=\"center\">\n";
		print "<table width=\"600\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n";
		while(list(, $file) = each($dirs)) {
			print "<tr bgcolor=\"#e0e0e0\">\n";
			print "<td align=\"left\"><a href=\"".$PHP_SELF."?action=browse&dir=".urlencode($dir.$file)."\"><b>$file</b></a></td>\n";
			print "</tr>\n";
		}
		print "</table>\n";
		print "</div>\n";
	}
	print "<div align=\"center\">\n";
	print "<table width=\"600\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n";
	if(isset($files)) {
		while(list(, $file) = each($files)) {
			$writeable = is_writeable($dir.$file);
			print "<tr bgcolor=\"#f5f5f5\">\n";
			print "<td align=\"center\" width=\"10%\"><a href=\"".$PHP_SELF."?action=edit&file=".urlencode($dir.$file)."\">Изменить</a></td>\n";
			print "<td align=\"center\" width=\"10%\"><a target=\"_blank\" href=\"view.php?file=".urlencode($dir.$file)."\">Просмотр</a></td>\n";
			print "<td align=\"left\" width=\"70%\">&nbsp;".$file."</td>\n";
			print "<td align=\"center\" width=\"10%\" nowrap>".(($writeable) ? "OK" : "Только для чтения")."</td>\n";
			print "</tr>\n";
		}
	} else {
		print "<tr bgcolor=\"#f5f5f5\"><td>в данной директории шаблонов не найдено.</td></tr>";
	}
	print "</table>\n";
	print "</div>\n";
} elseif($action == "edit") {
	if(!isset($file)) {
		print "Не указан файл.<br />";
		die();
	}
	if(!isset($doedit)) {
		if(!is_file($file)) {
			print "Ошибка при открытии файла '$file'<br />\n";
			die();
		}
		$content = htmlspecialchars(join("", file($file)));
		include "editform.inc.php";
	} else {
		$content = str_replace("\r", "", stripslashes($content));

		$fp = fopen($file, "w");
		fputs($fp, $content, strlen($content));
		fclose($fp);
		print "Шаблон <b>".basename($file)."</b> сохранен.<br />";
		print "Вернуться в <a href=\"".$PHP_SELF."?action=browse&dir=".urlencode($dir)."\">список</a>.<br />";
	}
}

require "footer.inc.php";
?>