<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   ������ ������������� WM HTTPS-�����������
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//               **************************************************************
//               ***   �������� �������������� �������� wm-��������������   ***
//               **************************************************************

include("wm.inc");



// ��������� �������
$wmid    = $HTTP_POST_VARS["wmid"];
$wmpurse = $HTTP_POST_VARS["wmpurse"];

// ����� ��������� ������� ������ wm
list($status, $err) = CheckWMIDPurse($wmid, $wmpurse);

// ����� ����������
if ($status == -1)
{ print "������ ��������: $err"; }
elseif ($status ==  0)
{ print "���������� WM �������������� �� ����������"; }
elseif ($status ==  1)
{ print "WM ������������� ����������, �� �� �� ����� ���������� ��������"; }
elseif ($status ==  2)
{ print "WM ������������� ���������� � ����� ��������� �������"; }
else
{ print "���������� ������ �������"; }



?>