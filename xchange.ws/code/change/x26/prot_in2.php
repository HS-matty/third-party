<?
// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   ������ ������������� WM HTTPS-�����������
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//               ***********************************************
//               ***   �������� ����������� ��������������   ***
//               ***********************************************

include("wm.inc");



// ������������� ���������� ������ ���������� � ��� query
// ��������� �������
$signedstring  = $HTTP_POST_VARS["signedstring"];
$curclienttime = $HTTP_POST_VARS["curclienttime"];
$wmid          = $HTTP_POST_VARS["WMID"];
$signString    = $HTTP_POST_VARS["signString"];


// ����� ��������� ������� ������ wm
list($status, $err) = TestAutority($wmid, $signedstring, $signString);

// ����� ����������
if ($status == -1)
{ print "������ ��������: $err"; }
elseif ($status ==  0)
{ print "�������������� �� �����������"; }
elseif ($status ==  1)
{ print "�� ����� � ���������� ���� �������.\n���������� �����: $curclienttime\nWMID: $wmid"; }
else
{ print "���������� ������ �������"; }



?>