<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   Пример использования WM HTTPS-интерфейсов
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//               *************************************************
//               ***   Проверка состояния денежного перевода   ***
//               *************************************************

include("wm.inc");



// Параметры запроса
$trn_id = $HTTP_POST_VARS["trn_n"];

// Вызов сервисной функции модуля wm
$stat = TransCheck($trn_id);


// Вывод результата
if ($stat == 0)
{ print "Ошибка проверки состояния"; }
elseif ($stat == 1)
{ print "Перевод не произведен"; }
elseif ($stat ==  2)
{ print "Перевод произведен"; }
else
{ print "Внутренняя ошибка скрипта"; }



?>