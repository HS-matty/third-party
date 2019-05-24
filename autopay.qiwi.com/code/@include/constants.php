<?php

define('PATH_INCLUDE',PATH_ROOT.'/@include');
define('PATH_APP_DATA',$path_site.'/@app-data');
define('PATH_LIB','z:/web-server-root/@lib');

define('PATH_RADMASTER','d:/dev/Radmaster');
define('PATH_LIB_RADMASTER',PATH_RADMASTER.'/Lib');
define('PATH_TEMPLATE',PATH_ROOT.'/front/tpl');
define('PATH_META_DATA',PATH_ROOT.'/front/meta');
define('PATH_APP',PATH_ROOT.'/app');
define('PATH_LOGIC',PATH_ROOT.'/logic');
set_include_path(".;".PATH_LIB."/PEAR/;".PATH_LIB.';');


?>