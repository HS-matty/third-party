<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   Пример использования WM HTTPS-интерфейсов
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//               ***********************************************
//               ***   Проверка прохождения аутентификации   ***
//               ***********************************************

include("wm.inc");



// Декодирование переданной формой информации в хэш query
// Параметры запроса
$signedstring  = $HTTP_POST_VARS["signedstring"];
$curclienttime = $HTTP_POST_VARS["curclienttime"];
$wmid          = $HTTP_POST_VARS["WMID"];
$signString    = $HTTP_POST_VARS["signString"];


// Вызов сервисной функции модуля wm
list($status, $err) = TestAutority($wmid, $signedstring, $signString);

// Вывод результата
if ($status == -1)
{ print "Ошибка проверки: $err"; }
elseif ($status ==  0)
{ print "Аутентификация не произведена"; }
elseif ($status ==  1)
{ print "Вы зашли в защищенную зону сервера.\nКлиентское время: $curclienttime\nWMID: $wmid"; }
else
{ print "Внутренняя ошибка скрипта"; }



?>