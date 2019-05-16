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
$wmid   = '722140776068';
$msg    = 'test';

// Вызов сервисной функции модуля wm
$res = SendMsg($wmid, $msg);

print "$res<br>";
// Вывод результата
if (strlen($res) <= 0)
{ print "Сообщение успешно отправлено"; }
else
{ print "Ошибка отправки сообщения: $res"; }



?>