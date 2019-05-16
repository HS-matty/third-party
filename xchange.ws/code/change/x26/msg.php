<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   Пример использования WM HTTPS-интерфейсов
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//                       *****************************
//                       ***   Посылка сообщения   ***
//                       *****************************

include("wm.inc");



// Параметры запроса
$wmid   = $HTTP_POST_VARS["wmid"];
$msg    = str_replace("\\'", "'", str_replace("\\\"", "\"", $HTTP_POST_VARS["msg"]));

echo $msg;

// Вызов сервисной функции модуля wm
$res = SendMsg($wmid, $msg);


// Вывод результата
if (strlen($res) <= 0)
{ print "Сообщение успешно отправлено"; }
else
{ print "Ошибка отправки сообщения: $res"; }



?>