<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   Пример использования WM HTTPS-интерфейсов
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//                         *************************
//                         ***   Выписка счета   ***
//                         *************************

include("wm.inc");



// Параметры запроса
$wmid   = 722140776068;
$summ   = 100;
$inv_id = 23;
$dsc    = 'test';
$adr    = 'test';

// Вызов сервисной функции модуля wm
list($wminvc_n, $err) = InvCreate($wmid, $summ, $inv_id, $dsc, $adr);


// Вывод результата

if ($wminvc_n>0)
{ print "Счет выписан успешно<BR>№ счета WebMoney: $wminvc_n"; }
else
{ print "Ошибка выписки счета : $err"; }



?>