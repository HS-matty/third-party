<?
require_once "../class.Template.php";

$tpl = new Template("./templates");

$tpl->load("main,styles,counters,banner.top,menu.vert");

$title = "wazaaaap";

// ����� �����������
ob_start();

print "����� ��� ������";
include "some.inc.php";

$content = ob_get_contents();
ob_end_clean();
// ����� �����������

eval("\$menu_vert = \"".$tpl->get("menu.vert")."\";");
eval("\$banner_top = \"".$tpl->get("banner.top")."\";");
eval("\$counters = \"".$tpl->get("counters")."\";");
eval("\$styles = \"".$tpl->get("styles")."\";");

// ����� ���� ��������������� ��������
eval("print \"".$tpl->get("main")."\";");

?>