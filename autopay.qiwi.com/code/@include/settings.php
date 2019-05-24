<?php

error_reporting(E_ERROR);

$debug_level  = 0;
$captcha_turn_off = 1;


ini_set('auto_detect_line_endings', true);
//if(!setlocale(LC_ALL, 'ru_RU.utf8')) 
setlocale(LC_ALL, 'en_US.utf8');
mb_internal_encoding("UTF-8");


/*if($_REQUEST['test'] == 1){
	
	print getenv("LANG");
print $_ENV['LANG'];
print "calling localeconv() directly\n";
print_r(localeconv());
printf("%f",-123.456);
print "\ncalling setlocale() before localeconv()\n";
print(setlocale(LC_ALL,null));
print_r(localeconv());
printf("%f",-123.456);

exit();
	
}*/




?>