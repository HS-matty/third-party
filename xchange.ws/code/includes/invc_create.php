<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   ������ ������������� WM HTTPS-�����������
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//                         *************************
//                         ***   ������� �����   ***
//                         *************************

include("wm.inc");



// ��������� �������
$wmid   = $HTTP_POST_VARS["wmid"];
$summ   = $HTTP_POST_VARS["summ"];
$inv_id = $HTTP_POST_VARS["invc_n"];
$dsc    = str_replace("\\'", "'", str_replace("\\\"", "\"", $HTTP_POST_VARS["dsc"]));
$adr    = str_replace("\\'", "'", str_replace("\\\"", "\"", $HTTP_POST_VARS["addr"]));

// ����� ��������� ������� ������ wm
list($wminvc_n, $err) = InvCreate($wmid, $summ, $inv_id, $dsc, $adr);


// ����� ����������

if ($wminvc_n>0)
{ print "���� ������� �������<BR>� ����� WebMoney: $wminvc_n"; }
else
{ print "������ ������� ����� : $err"; }



?>