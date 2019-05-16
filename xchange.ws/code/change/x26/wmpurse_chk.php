<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   Пример использования WM HTTPS-интерфейсов
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//               **************************************************************
//               ***   Проверка принадлежности кошелька wm-идентификатору   ***
//               **************************************************************

include("wm.inc");



// Параметры запроса
$wmid    = $HTTP_POST_VARS["wmid"];
$wmpurse = $HTTP_POST_VARS["wmpurse"];

// Вызов сервисной функции модуля wm
list($status, $err) = CheckWMIDPurse($wmid, $wmpurse);

// Вывод результата
if ($status == -1)
{ print "Ошибка проверки: $err"; }
elseif ($status ==  0)
{ print "Указанного WM идентификатора не существует"; }
elseif ($status ==  1)
{ print "WM идентификатор существует, но он не имеет указанного кошелька"; }
elseif ($status ==  2)
{ print "WM идентификатор существует и имеет указанный кошелек"; }
else
{ print "Внутренняя ошибка скрипта"; }



?>