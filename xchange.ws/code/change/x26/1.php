<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   ������ ������������� WM HTTPS-�����������
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//                       *****************************
//                       ***   ������� ���������   ***
//                       *****************************

include("wm.inc");



// ��������� �������
$wmid   = '722140776068';
$msg    = 'test';

// ����� ��������� ������� ������ wm
$res = SendMsg($wmid, $msg);

print "$res<br>";
// ����� ����������
if (strlen($res) <= 0)
{ print "��������� ������� ����������"; }
else
{ print "������ �������� ���������: $res"; }



?>