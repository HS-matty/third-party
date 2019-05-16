<?
define('WE_ARE_HERE',true);
require('../includes/head.php');
require('../includes/functions.php');
require('../includes/template.php');
require('../includes/cfg.php');

$template = new Template("../html_x/");
$template->set_filenames(array(
	'info' => 'info.t',
	'header' => 'header.t',
	'footer' => 'footer.t')
);

$template->assign_vars(array(
		"title" => 'e-base.ru - электронная коммерция в Беларуси / общая информация',
		"url" => $url)
	);

$template->assign_var_from_handle('HEADER','header');
$template->assign_var_from_handle('FOOTER','footer');
$template->pparse("info");



?>