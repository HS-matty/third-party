<?
session_start();

define('IN_SHOP', true);

include ("../functions.php");
include('../cfg/var.php');
include('../cfg/conf.inc');
require_once "../class.Template.php";
$tpl = new Template("./tpl");

//�������� ����, ������ �� ������������ �����������

if (check_log()=='true') print "Logined"; //���� ��, �� ��� ��
else {
	print "not logined, please <a href='login.php'>login</a> "; //���� ���, �� ������� .
	exit;
}



?>