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
$wmid   = 722140776068;
$summ   = 100;
$inv_id = 23;
$dsc    = 'test';
$adr    = 'test';

// ����� ��������� ������� ������ wm
list($wminvc_n, $err) = InvCreate($wmid, $summ, $inv_id, $dsc, $adr);


// ����� ����������

if ($wminvc_n>0)
{ print "���� ������� �������<BR>� ����� WebMoney: $wminvc_n"; }
else
{ print "������ ������� ����� : $err"; }



?>