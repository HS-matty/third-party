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
$wmid   = $HTTP_POST_VARS["wmid"];
$msg    = str_replace("\\'", "'", str_replace("\\\"", "\"", $HTTP_POST_VARS["msg"]));

echo $msg;

// ����� ��������� ������� ������ wm
$res = SendMsg($wmid, $msg);


// ����� ����������
if (strlen($res) <= 0)
{ print "��������� ������� ����������"; }
else
{ print "������ �������� ���������: $res"; }



?>