<?
require_once "../class.Template.php";

$tpl = new Template("./templates");

$tpl->load("main,styles,counters,banner.top,menu.vert");

$title = "wazaaaap";

// старт буферизации
ob_start();

print "Здесь что угодно";
include "some.inc.php";

$content = ob_get_contents();
ob_end_clean();
// конец буферизации

eval("\$menu_vert = \"".$tpl->get("menu.vert")."\";");
eval("\$banner_top = \"".$tpl->get("banner.top")."\";");
eval("\$counters = \"".$tpl->get("counters")."\";");
eval("\$styles = \"".$tpl->get("styles")."\";");

// вывод всей сгенерированной страницы
eval("print \"".$tpl->get("main")."\";");

?>