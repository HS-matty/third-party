<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   ������ ������������� WM HTTPS-�����������
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//                    ************************************
//                    ***   �������� ��������� �����   ***
//                    ************************************

include("wm.inc");



// ��������� �������
$inv_id   = $HTTP_POST_VARS["invc_n"];
$wminv_id = $HTTP_POST_VARS["wminvc_n"];
$wmid     = $HTTP_POST_VARS["wmid"];

// ����� ��������� ������� ������ wm
$stat = InvCheck($inv_id, $wmid, $wminv_id);


if ($stat == -2)
{ print "������ �������� ���������"; }
elseif ($stat == -1)
{ print "���� ��� ������"; }
elseif ($stat ==  0)
{ print "���� ���� ������"; }
elseif ($stat ==  1)
{ print "���� �������, �� ������ �� �������� �� ������� ������� ��������� ������"; }
elseif ($stat ==  2)
{ print "���� �������"; }
else
{ print "���������� ������ �������"; }



?>