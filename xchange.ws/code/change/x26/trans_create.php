<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   ������ ������������� WM HTTPS-�����������
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//                       ****************************
//                       ***   �������� �������   ***
//                       ****************************

include("wm.inc");



// ��������� �������
$trn_id  = $HTTP_POST_VARS["trn_n"];
$wmpurse = $HTTP_POST_VARS["wmpurse"];
$summ    = $HTTP_POST_VARS["summ"];
$dsc     = str_replace("\\'", "'", str_replace("\\\"", "\"", $HTTP_POST_VARS["dsc"]));

// ����� ��������� ������� ������ wm
list($wmtrn_n, $err) = TransCreate($wmpurse, $summ, $trn_id, $dsc);


// ����� ����������
if ($wmtrn_n>0)
{ print "������� ������� �������<BR>� ���������� webmoney: $wmtrn_n"; }
else
{ print "������ �������� : $err"; }



?>