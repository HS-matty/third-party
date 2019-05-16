<?

// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   ������ ������������� WM HTTPS-�����������
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//          *****************************************************
//          ***   ������������ html-������ �������� "�����"   ***
//          *****************************************************

include("wmconst.inc");



// ��������� �������
$invc_n    = $HTTP_POST_VARS["invc_n"];
$goodname  = $HTTP_POST_VARS["goodname"];
$summ      = sprintf("%.2f", $HTTP_POST_VARS["summ"]);

$tm = localtime(time(),1);
$invc_date = 
  sprintf( "%04d.%02d.%02d %02d:%02d:%02d", $tm["tm_year"]+1900, $tm["tm_mon"]+1, 
           $tm["tm_mday"], $tm["tm_hour"], $tm["tm_min"], $tm["tm_sec"]
         );
 
// ������������ ������ ���������� �� ������� WMSigner (���� �� �����) 

$PlanStr = 
  "�: $invc_n\r\n".
  "�����: $goodname\r\n".
  "�����: $summ\r\n".
  "���� ��������: $invc_date\r\n".
  "������� ��������: $wmconst__shop_wmpurse\r\n".
  "���� ���������: $wmconst__invc_protect\r\n".
  "����� �����: $wmconst__invc_active\r\n".
  "\004\r\n";

// ������ WMSigner
$fp = popen("./WMSigner", "r+");

fwrite($fp,$PlanStr);
$SignStr = fgets($fp, 133);



?>



<html>
<head>
<title>Webmoney - ����� �������� �����</title>
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
