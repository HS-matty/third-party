<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   Пример использования WM HTTPS-интерфейсов
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//                   ***********************************************
//                   ***   Денежный перевод с протекцией сделки  ***
//                   ***********************************************

include("wm.inc");



// Параметры запроса
$trn_id  = $HTTP_POST_VARS["trn_n"];
$wmpurse = $HTTP_POST_VARS["wmpurse"];
$summ    = $HTTP_POST_VARS["summ"];
$dsc     = str_replace("\\'", "'", str_replace("\\\"", "\"", $HTTP_POST_VARS["dsc"]));
$pr_code = str_replace("\\'", "'", str_replace("\\\"", "\"", $HTTP_POST_VARS["prcode"]));

// Вызов сервисной функции модуля wm
list($wmtrn_n, $err) = TransCreateProt($wmpurse, $summ, $trn_id, $dsc, $pr_code);


// Вывод результата
if ($wmtrn_n>0)
{ print "Перевод выписан успешно<BR>№ транзакции webmoney: $wmtrn_n"; }
else
{ print "Ошибка перевода : $err"; }



?>