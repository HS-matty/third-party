<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   ������ ������������� WM HTTPS-�����������
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//               *************************************************
//               ***   �������� ��������� ��������� ��������   ***
//               *************************************************

include("wm.inc");



// ��������� �������
$trn_id = $HTTP_POST_VARS["trn_n"];

// ����� ��������� ������� ������ wm
$stat = TransCheck($trn_id);


// ����� ����������
if ($stat == 0)
{ print "������ �������� ���������"; }
elseif ($stat == 1)
{ print "������� �� ����������"; }
elseif ($stat ==  2)
{ print "������� ����������"; }
else
{ print "���������� ������ �������"; }



?>