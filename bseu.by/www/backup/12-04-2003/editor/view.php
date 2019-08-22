<?
if(!isset($file)) {
	print "Не указан файл.<br />\n";
	die();
}
print join("", file($file));
?>