<?

// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   Пример использования WM HTTPS-интерфейсов
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//          *****************************************************
//          ***   Формирование html-текста элемента "Касса"   ***
//          *****************************************************

include("wmconst.inc");



// Параметры запроса
$invc_n    = $HTTP_POST_VARS["invc_n"];
$goodname  = $HTTP_POST_VARS["goodname"];
$summ      = sprintf("%.2f", $HTTP_POST_VARS["summ"]);

$tm = localtime(time(),1);
$invc_date = 
  sprintf( "%04d.%02d.%02d %02d:%02d:%02d", $tm["tm_year"]+1900, $tm["tm_mon"]+1, 
           $tm["tm_mday"], $tm["tm_hour"], $tm["tm_min"], $tm["tm_sec"]
         );
 
// Формирование строки выдаваемой на подпись WMSigner (счет на товар) 

$PlanStr = 
  "№: $invc_n\r\n".
  "товар: $goodname\r\n".
  "сумма: $summ\r\n".
  "дата создания: $invc_date\r\n".
  "кошелек магазина: $wmconst__shop_wmpurse\r\n".
  "срок протекции: $wmconst__invc_protect\r\n".
  "время жизни: $wmconst__invc_active\r\n".
  "\004\r\n";

// Запуск WMSigner
$fp = popen("./WMSigner", "r+");

fwrite($fp,$PlanStr);
$SignStr = fgets($fp, 133);



?>



<html>
<head>
<title>Webmoney - Вывод элемента касса</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>

<OBJECT ID="WMAcceptor"
	CLASSID="CLSID:463ED66E-431B-11D2-ADB0-0080C83DA4EB"
	CODEBASE="ftp://cit.molot.ru/pub/WMAcceptor.CAB#version=1,0,0,20"
	WIDTH=94
	HEIGHT=92
	LANGUAGE="JavaScript">
 <PARAM NAME="nInvoice" VALUE=<? echo $invc_n; ?>>
 <PARAM NAME="nState" VALUE=32>
 <PARAM NAME="strStoresPurse" VALUE="<? echo $wmconst__shop_wmpurse; ?>">
 <PARAM NAME="Notes" VALUE="<? echo $goodname; ?>">
 <PARAM NAME="Amount" VALUE=<? echo $summ; ?>>
 <PARAM NAME="DateOfCreate" VALUE="<? echo $invc_date; ?>">
 <PARAM NAME="Expiration" VALUE=<? echo $wmconst__invc_active; ?>>
 <PARAM NAME="Protection" VALUE=<? echo $wmconst__invc_protect; ?>>
 <PARAM NAME="Signature" VALUE="<? echo $SignStr; ?>">
</OBJECT>
