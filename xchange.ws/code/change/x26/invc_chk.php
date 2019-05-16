<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   Пример использования WM HTTPS-интерфейсов
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//                    ************************************
//                    ***   Проверка состояния счета   ***
//                    ************************************

include("wm.inc");



// Параметры запроса
$inv_id   = $HTTP_POST_VARS["invc_n"];
$wminv_id = $HTTP_POST_VARS["wminvc_n"];
$wmid     = $HTTP_POST_VARS["wmid"];

// Вызов сервисной функции модуля wm
$stat = InvCheck($inv_id, $wmid, $wminv_id);


if ($stat == -2)
{ print "Ошибка проверки состояния"; }
elseif ($stat == -1)
{ print "Счет был удален"; }
elseif ($stat ==  0)
{ print "Счет ждет оплаты"; }
elseif ($stat ==  1)
{ print "Счет оплачен, но деньги не получены по причине наличия протекции сделки"; }
elseif ($stat ==  2)
{ print "Счет оплачен"; }
else
{ print "Внутренняя ошибка скрипта"; }



?>