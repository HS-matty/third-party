<?
if(!isset($file)) {
	print "�� ������ ����.<br />\n";
	die();
}
print join("", file($file));
?>