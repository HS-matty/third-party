<?

// 10.09.2001
// (win1251 encoded)
//
//----------   WM HTTPS-interface example
//----------   ������ ������������� WM HTTPS-�����������
//
// Webmoney Transfer (c), Shaposhnikov Max    (maxicus@hotmail.com)

//          ******************************************************
//          ***   ������ ���������� ������� htts-�����������   ***
//          ******************************************************

include("wmconst.inc");


/////////////////////////////////////////////////////////////////
// _DateID - ���������� ���������� 14-�������� ��������.
//           ��� ����������� ����������� ��������� ������� ������
//
// ���������� :
//   ������ - ���������� ��������

function _DateID()
{
  $tm = localtime(time(), 1);

  return sprintf( "%04d%02d%02d%02d%02d%02d", $tm["tm_year"]+1900, $tm["tm_mon"]+1, 
                  $tm["tm_mday"], $tm["tm_hour"], $tm["tm_min"], $tm["tm_sec"]
                );
}



/////////////////////////////////////////////////////////////////
// _GetSign - ������������ ������ �������.
//            ��� ����������� ����������� ��������� ������� ������
//
// ��������� :
//   $inStr  - ������ ��� �������
// ���������� :
//   ������ - �������
//
//! ��� ������ ������� � ��� �� ����������, ��� � ���������� ������ (�� �������
//! � ������ ������������ ������� �����-������), ������ ������������ �����
//! WMSigner � WMSigner.ini
/*
function _GetSign($inStr)
{
  $fp = popen('b:/home/xchange/www/change/x26/wmsigner.exe', "w+");
  print ("$fp <br>");

//  print("<br> instr = $inStr<br>fp = $fp<br>");
  $PlanStr = "$inStr\004\r\n";
  print(strlen($PlanStr)."<br>");
  $a = fwrite($fp,$PlanStr);
  echo $a;
  $s = fgets($fp, 133);
  
  print("<br> = $s<br>");
  pclose($fp);
  exit;
  return $s;
 }

*/
	function	_GetSign($inStr)
 {
 $descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("file", "error-output.txt", "a") // stderr is a file to write to
);


	$process = proc_open('b:/home/xchange/www/change/x26/wmsigner.exe', $descriptorspec, $pipes);

	if (is_resource($process)) {
    // $pipes now looks like this:
    // 0 => writeable handle connected to child stdin
    // 1 => readable handle connected to child stdout
    // Any error output will be appended to /tmp/error-output.txt
      $PlanStr = "$inStr\004\r\n";
	  $a = fwrite($pipes[0],$PlanStr);
      fclose($pipes[0]);
	
	  echo $a;
	  $s = fgets($pipes[1], 133);
	 fclose($pipes[1]);

    
    // It is important that you close any pipes before calling
    // proc_close in order to avoid a deadlock
    $return_value = proc_close($process);

    echo "command returned $return_value<br>";
    print("<br>s = $s<br>");
	exit;
	return $s;
	}
}





/////////////////////////////////////////////////////////////////
// _HttpsReq - ���������� https-������� � ����������������� ������ webmoney
//             ��� ����������� ����������� ��������� ������� ������
//
// ��������� :
//   $addr  - ����� ������� (������� � ����� �������)
//            ��. "/cgi-bin/myscript.cgi?PRM1=VAL1"
// ���������� :
//   ��������� ������ https-������� (��� ����������)

function _HttpsReq($addr)
{
  $ch = curl_init("https://w3s.webmoney.ru".$addr);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

  // CURLOPT_RETURNTRANSFER ����� �������� �����������

  $fp = tmpfile();
  curl_setopt ($ch, CURLOPT_FILE, $fp);
  curl_exec($ch); 
  curl_close($ch);

  fseek($fp,0,SEEK_SET);
  $result = fgets($fp,1024);
  fclose($fp);

  return $result;
}



/////////////////////////////////////////////////////////////////
// InvCreate - ������� �����
//
// ��������� :
//   $wmid   - WM������������� ���������� �����
//   $summ   - ����� ����� (. - �����������)
//   $inv_id - � ����� � ��������
//   $dsc    - �������� ������� (win1251 encoding)
//   $adr    - ����� �������� (win1251 encoding)
// ���������� :
//   2-���������� ������ ($wminv_id, $err), ���
//     $wminv_id - ����� ���������� ����� (���������� ����� WM-�����)
//     $err      - ����� ������
//
// ��� �������� ��������� $wminv_id �������� ������������� ����� ����������
// ����� (��� ���������� ����� �����, ���������� ����� ���� ������ WM).
// � ������ ������ $wminv_id �������� ������ ������, � $err - ����� ������,
// ��������� � �����.
//
//! ��� ������ ������� � ��� �� ����������, ��� � ���������� ������ (�� �������
//! � ������ ������������ ������� �����-������), ������ ������������ �����
//! WMSigner � WMSigner.ini

function InvCreate($wmid, $summ, $inv_id, $dsc, $adr)
{
  $summ = sprintf("%d", $summ*100)/100;   // ������������ �����

  global $wmconst__shop_wmpurse;
  global $wmconst__shop_wmid;
  global $wmconst__invc_protect;
  global $wmconst__invc_active;

  $OrderID       = "$inv_id";                   // � ����� 
  $PurseOfStores = "$wmconst__shop_wmpurse";    // ������� � ��������, ���� ����� ����������� ������
  $LoginOfStores = "$wmconst__shop_wmid";       // WM id ��������
  $LoginOfCust   = "$wmid";                     // WM id ����������
  $InvAddress    = "$adr";                      // ����� ��������
  $Amount        = "$summ";                     // �����
  $Desc          = "$dsc";                      // �������� �������
  $Period        = "$wmconst__invc_protect";    // ���� ���������
  $Experation    = "$wmconst__invc_active";     // ����� ���������������� �����
  $RequestN      = _DateID();                   // ��������� ������������ ����� �������

  // ������������ ������ ��� �������
  $PlanStr = "$OrderID$LoginOfCust$PurseOfStores$Amount$Desc$InvAddress$Period$Experation$RequestN";
  // ������������ �������
  $SignStr = _GetSign($PlanStr);

  // https-������
  $W3sUrl="/asp/Invoice.asp?SL=$LoginOfStores&SP=$PurseOfStores&CL=$LoginOfCust&IN=$OrderID&D=".
          urlencode($Desc)."&AD=".urlencode($InvAddress).
          "&A=$Amount&E=$Experation&P=$Period&RN=$RequestN&SS=$SignStr";
//print	$W3sUrl;	

  $httpsRes = _HttpsReq($W3sUrl);
//  print $httpsRes;


  // ������ ����������� �� ����������������� ����� ����������
  $err      = "������ ����� � ���������������� ������� WebMoney";
  $wminv_id = "";

  if (substr($httpsRes,0,6) == "Error:")
  {
    $errCode = sprintf("%d", substr($httpsRes,6));

    $err = "����������� ������";
    if ($errCode == "-9")
    { $err = "�������� �������"; }
    elseif ($errCode == "-8")
    { $err = "R==uestN ����� �����������"; }
    elseif ($errCode == "-7")
    { $err = "������� ������� ����� ��������"; }
    elseif ($errCode == "-6")
    { $err = "������� ������� ��������"; }
    elseif ($errCode == "-5")
    { $err = "������� ������ �����"; }
    elseif ($errCode == "-4")
    { $err = "������� ����� WM-������������� web-�������"; }
    elseif ($errCode == "-3")
    { $err = "������� ����� WM-������� web-�������"; }
    elseif ($errCode == "-2")
    { $err = "������� ����� WM-������������� ����������"; }
    elseif ($errCode == "-1")
    { $err = "������� ����� ����� �����"; }
    elseif ($errCode == "5")
    { $err = "Web-������� � ��������� ��������������� �� ����������"; }
    elseif ($errCode == "6")
    { $err = "���������� � ��������� ��������������� �� ����������"; }
    elseif ($errCode == "7")
    { $err = "���������� WM-�������� web-������� �� ����������"; }
    elseif ($errCode == "13")
    { $err = "������� ��������� �����"; }
    elseif ($errCode == "23")
    { $err = "������ �������"; }
    elseif ($errCode == "102")
    { $err = "�������� R==uestN ������ ��� ����� ����������� ��������� R==uestN"; }
  }

  if (substr($httpsRes,0,8) == "WMInvId:")
  {
    $wminv_id = sprintf("%d", substr($httpsRes,8));
    $err      = "";
  }

  return array($wminv_id, $err);
}



/////////////////////////////////////////////////////////////////
// InvCheck - �������� ��������� �����
//
// ��������� :
//   $inv_id   - ���������� � ����� �������� ��� ��������
//   $wmid     - WM������������� ���������� �����
//   $wminv_id - ���������� � WM ����� ��� �������� (����� ��������� ��� $inv_id)
// ���������� :
//   ��������� �����
//     -2 - ������ �������� ���������
//     -1 - ������
//      0 - ���� ������
//      1 - �������, �� ������ �� �������� �� ������� ������� ��������� ������
//      2 - �������
//
// ���� ������� $wminv_id, �� �������� $inv_id ������������.
//
//! ��� ������ ������� � ��� �� ����������, ��� � ���������� ������ (�� �������
//! � ������ ������������ ������� �����-������), ������ ������������ �����
//! WMSigner � WMSigner.ini

function InvCheck($inv_id, $wmid, $wminv_id)
{
  $inv_id   = sprintf("%d", $inv_id);
  $wminv_id = sprintf("%d", $wminv_id);

  global $wmconst__shop_wmid;
  global $wmconst__shop_wmpurse;

  $LoginOfStores = "$wmconst__shop_wmid";      // WM id ��������
  $WMInvId       = "$wminv_id";                // WM� �����
  $PurseOfStores = "$wmconst__shop_wmpurse";   // ������� � ��������, ���� ����� ����������� ������
  $LoginOfCust   = "$wmid";                    // WM id ����������
  $OrderID       = "$inv_id";                  // � ����� � ��������
  $RequestN      = _DateID();                  // ��������� ������������ ����� �������

  // ������������ ������ ��� �������
  $PlanStr = "$OrderID$WMInvId$LoginOfCust$PurseOfStores$RequestN";
  // ������������ �������
  $SignStr = _GetSign($PlanStr);


  // https-������
  $W3sUrl="/asp/GetInvState.asp?SL=$LoginOfStores&WN=$WMInvId&SP=$PurseOfStores&CL=$LoginOfCust&IN=$OrderID&RN=$RequestN&SS=$SignStr";

  $httpsRes = _HttpsReq($W3sUrl);


  // ������ ����������� �� ����������������� ����� ����������
  $state = -2;
  // State:0 - ���� ��� �� ������� �����������; 
  if (substr($httpsRes,0,7) == "State:0")  { $state =  0; }
  // State:1 - ���� �� ��� ������� ����������� � ���������� ��������� �� ������ �����; 
  elseif (substr($httpsRes,0,7) == "State:1")  { $state = -1; }
  // Ok:1 - ���� ������� - ������ ��� ����������� �� ������� ��������; 
  elseif (substr($httpsRes,0,4) == "Ok:1")     { $state =  2; }
  // Ok:2 - ���� �������, �� �� �������� � ���������� - ������ ��� �� � ��������, ��� ���������� ���������� ������ ��� ��������� � ������� ����� ��������� � WebMoney Keeper ��������; 
  elseif (substr($httpsRes,0,4) == "Ok:2")     { $state =  1; }
  // State:2 - ���� ��� �������, �� ������ ���������� ����� ����������� � ����� � ���, ��� ���� ����� 8-�� ������� �������� ���� ��������� ��� ����� ���� ���������, � ��� ��� � �� ��� ������ - ����� ������������ �� ������� ����� � �������� ���; 
  elseif (substr($httpsRes,0,7) == "State:2")  { $state = -1; }
  // Error: Invoice Not Found 
  elseif (substr($httpsRes,0,6) == "Error:Invoice Not Found")   { $state = -2; }

  return $state;
}



/////////////////////////////////////////////////////////////////
// TransCreate - �������� �������
//
// ��������� :
//   $wmpurse - �������, �� ������� ������������� �������� �������
//   $summ    - ����� ��������
//   $trn_id  - � ���������� (������ ���� ���������� ��� ��������)
//   $dsc     - ���������� � �������� (win1251)
// ���������� :
//   2-���������� ������ ($wmtrn_id, $err), ���
//     $wmtrn_id - ����� ���������� �������� (���������� ����� WM-��������)
//     $err      - ����� ������
//
// ��� �������� ��������� $wmtrn_id �������� ������������� ����� ����������
// �������� (��� ���������� �����, ���������� ����� ���� ��������� WM).
// � ������ ������ $wmtrn_id �������� ������ ������, � $err - ����� ������,
// ��������� � �����.
//
//! ��� ������ ������� � ��� �� ����������, ��� � ���������� ������ (�� �������
//! � ������ ������������ ������� �����-������), ������ ������������ �����
//! WMSigner � WMSigner.ini

function TransCreate($wmpurse, $summ, $trn_id, $dsc)
{
  $RequestN = _DateID();    // ��������� ������������ ����� �������

  global $wmconst__shop_wmpurse;

  // ������������ ������ ��� �������
  $PlanStr = "$trn_id$wmconst__shop_wmpurse$wmpurse$summ$dsc".
                "0"."$RequestN";
  // ������������ �������
  $SignStr = _GetSign($PlanStr);


  // https-������
  $W3sUrl = "/asp/Trans.asp?TID=$trn_id&P=$wmconst__shop_wmpurse&C=$wmpurse&IN=0&A=$summ&D=".
            urlencode($dsc)."&RN=$RequestN&SS=$SignStr";

  $httpsRes = _HttpsReq($W3sUrl);
  

  // ������ ����������� �� ����������������� ����� ����������
  $err      = "������ ����� � ���������������� ������� WebMoney";
  $wmtrn_id = "";

  if (substr($httpsRes,0,6) == "Error:")
  {
    $errCode = sprintf("%d", substr($httpsRes,6));

    $err = "����������� ������";
    if ($errCode == "-6")
    { $err = "�������� �������"; }
    elseif ($errCode == "-5")
    { $err = "R==uestN ����� �����������"; }
    elseif ($errCode == "-4")
    { $err = "������� ������ �����"; }
    elseif ($errCode == "-3")
    { $err = "������� ����� �������-��������"; }
    elseif ($errCode == "-2")
    { $err = "������� ����� �������-��������"; }
    elseif ($errCode == "-1")
    { $err = "������� ����� ����� ��������"; }
    elseif ($errCode == "5")
    { $err = "�������� � ��������� ��������������� �� ����������"; }
    elseif ($errCode == "6")
    { $err = "���������� � ��������� ��������������� �� ����������"; }
    elseif ($errCode == "7")
    { $err = "���������� �������� �������� �� ����������"; }
    elseif ($errCode == "13")
    { $err = "������� ��������� �����"; }
    elseif ($errCode == "17")
    { $err = "������������ ����� � ������-���������"; }
    elseif ($errCode == "23")
    { $err = "������ �������"; }
    elseif ($errCode == "102")
    { $err = "�������� R==uestN ������ ��� ����� ����������� ��������� R==uestN"; }
    elseif ($errCode == "103")
    { $err = "�������� � ����� ������� (TID) ��� �����������"; }
    elseif ($errCode == "110")
    { $err = "��������� ����������. ".
             "���� ��������� �������� ������ ����������������� ��������. ".
             "��� ����������� ��������� �� ���������� ����� ".
             "� WMID 941977853154 (����������� ���������)"; 
    }
  }

  if (substr($httpsRes,0,9) == "WMTranId:")
  {
    $wmtrn_id = sprintf("%d", substr($httpsRes,9));
    $err      = "";
  }

  return array($wmtrn_id, $err);
}



/////////////////////////////////////////////////////////////////
// TransCreateProt - �������� �������
//
// ��������� :
//   $wmpurse - �������, �� ������� ������������� �������� �������
//   $summ    - ����� ��������
//   $trn_id  - � ���������� (������ ���� ���������� ��� ��������)
//   $dsc     - ���������� � �������� (win1251)
//   $pr_code - ��� ��������� (win1251)
// ���������� :
//   2-���������� ������ ($wmtrn_id, $err), ���
//     $wmtrn_id - ����� ���������� �������� (���������� ����� WM-��������)
//     $err      - ����� ������
//
// ��� �������� ��������� $wmtrn_id �������� ������������� ����� ����������
// �������� (��� ���������� �����, ���������� ����� ���� ��������� WM).
// � ������ ������ $wmtrn_id �������� ������ ������, � $err - ����� ������,
// ��������� � �����.
//
//! ��� ������ ������� � ��� �� ����������, ��� � ���������� ������ (�� �������
//! � ������ ������������ ������� �����-������), ������ ������������ �����
//! WMSigner � WMSigner.ini

function TransCreateProt($wmpurse, $summ, $trn_id, $dsc, $pr_code)
{
  $RequestN      = _DateID();    // ��������� ������������ ����� �������

  global $wmconst__trans_prtime;
  global $wmconst__shop_wmpurse;

  // ������������ ������ ��� �������
  $PlanStr = "$trn_id$wmconst__shop_wmpurse$wmpurse$summ$dsc".
             "0"."$pr_code"."$wmconst__trans_prtime"."$RequestN";
  // ������������ �������
  $SignStr = _GetSign($PlanStr);


  // https-������
  $W3sUrl = "/asp/TransDelayed.asp?TID=$trn_id&P=$wmconst__shop_wmpurse&C=$wmpurse&IN=0&A=$summ&D=".
            urlencode($dsc)."&PC=".urlencode($pr_code)."&PL=$wmconst__trans_prtime".
            "&RN=$RequestN&SS=$SignStr";

  $httpsRes = _HttpsReq($W3sUrl);
  

  // ������ ����������� �� ����������������� ����� ����������
  $err      = "������ ����� � ���������������� ������� WebMoney";
  $wmtrn_id = "";

  if (substr($httpsRes,0,6) == "Error:")
  {
    $errCode = sprintf("%d", substr($httpsRes,6));

    $err = "����������� ������";
    if ($errCode == "-10")
    { $err = "�������� ������ ���������"; }
    elseif ($errCode == "-9")
    { $err = "�������� ��� ���������"; }
    elseif ($errCode == "-6")
    { $err = "�������� �������"; }
    elseif ($errCode == "-5")
    { $err = "R==uestN ����� �����������"; }
    elseif ($errCode == "-4")
    { $err = "������� ������ �����"; }
    elseif ($errCode == "-3")
    { $err = "������� ����� �������-��������"; }
    elseif ($errCode == "-2")
    { $err = "������� ����� �������-��������"; }
    elseif ($errCode == "-1")
    { $err = "������� ����� ����� ��������"; }
    elseif ($errCode == "5")
    { $err = "����������� ������� � ��������� ��������������� �� ����������"; }
    elseif ($errCode == "6")
    { $err = "���������� � ��������� ��������������� �� ����������"; }
    elseif ($errCode == "7")
    { $err = "�������� ����������� ������� �� ����������"; }
    elseif ($errCode == "13")
    { $err = "������� ��������� �����"; }
    elseif ($errCode == "17")
    { $err = "������������ ����� � ������-���������"; }
    elseif ($errCode == "23")
    { $err = "������ �������"; }
    elseif ($errCode == "102")
    { $err = "�������� R==uestN ������ ��� ����� ����������� ��������� R==uestN"; }
    elseif ($errCode == "103")
    { $err = "�������� � ����� ������� (TID) ��� �����������"; }
    elseif ($errCode == "110")
    { $err = "��������� ����������. ".
             "���� ��������� �������� ������ ����������������� ��������. ".
             "��� ����������� ��������� �� ���������� ����� ".
             "� WMID 941977853154 (����������� ���������)"; 
    }
  }

  if (substr($httpsRes,0,9) == "WMTranId:")
  {
    $wmtrn_id = sprintf("%d", substr($httpsRes,9));;
    $err      = "";
  }

  return array($wmtrn_id, $err);
}



/////////////////////////////////////////////////////////////////
// TransCheck - �������� ���������� ���������� ��������� ��������
//
// ��������� :
//   $trn_id  - � ���������� �������� (������ ���� ���������� ��� ��������)
// ���������� :
//   0 - ������ ��� ��������
//   1 - �� ����������
//   2 - ����������
//
//! ��� ������ ������� � ��� �� ����������, ��� � ���������� ������ (�� �������
//! � ������ ������������ ������� �����-������), ������ ������������ �����
//! WMSigner � WMSigner.ini

function TransCheck($trn_id)
{
  $RequestN = _DateID();         // ��������� ������������ ����� �������

  global $wmconst__shop_wmpurse;

  // ������������ ������ ��� �������
  $PlanStr = "0$trn_id$wmconst__shop_wmpurse$RequestN";
  // ������������ �������
  $SignStr = _GetSign($PlanStr);

  // https-������
  $W3sUrl = "/asp/GetTran.asp?CTID=$trn_id&WTID=0&P=$wmconst__shop_wmpurse&RN=$RequestN&SS=$SignStr";

  $httpsRes = _HttpsReq($W3sUrl);

  
  // ������ ����������� �� ����������������� ����� ����������
  if (substr($httpsRes,0,6) == "Error:")
  { return 0; }
  elseif (substr($httpsRes,0,10) == "TranState:")
  { if (substr($httpsRes,10) > 0)
    { return 2; }
    return 1;
  }
  
  return 0;
}



/////////////////////////////////////////////////////////////////
// SendMsg - ������� ���������
//
// ��������� :
//   $wmid - WM������������� ���������� ���������
//   $msg - ����� ���������
// ���������� :
//   ����� ������ ��� ������ ������ � ������ ������
//
//! ��� ������ ������� � ��� �� ����������, ��� � ���������� ������ (�� �������
//! � ������ ������������ ������� �����-������), ������ ������������ �����
//! WMSigner � WMSigner.ini

function SendMsg($wmid, $msg)
{
  $RequestN = _DateID();         // ��������� ������������ ����� �������

  global $wmconst__shop_wmid;

  // ������������ ������ ��� �������
  $PlanStr = "$wmconst__shop_wmid$wmid$msg$RequestN";
  // ������������ �������
  $SignStr = _GetSign($PlanStr);


  // https-������
  $W3sUrl = "/asp/SendMsg.asp?S=$wmconst__shop_wmid&R=$wmid&M=".urlencode($msg)."&RN=$RequestN&SS=$SignStr";

  $httpsRes = _HttpsReq($W3sUrl);
  

  // ������ ����������� �� ����������������� ����� ����������
  if (substr($httpsRes,0,6) == "Error:")
  {
    $errCode = sprintf("%d", substr($httpsRes,6));

    $err = "����������� ������";
    if ($errCode == "-7")
    { $err = "������� �������������� �������, �������� ��� �� ������"; }
    elseif ($errCode == "-6")
    { $err = "���������� ������ �������� ���������"; }
    elseif ($errCode == "-5")
    { $err = "����������� ��� ������� ������ �������"; }
    elseif ($errCode == "-4")
    { $err = "R==uestN ����� �����������"; }
    elseif ($errCode == "-3")
    { $err = "����������� ��� ������� ����� ����� ���������"; }
    elseif ($errCode == "-2")
    { $err = "����������� ��� ������� ����� wm-������������� ����������"; }
    elseif ($errCode == "-1")
    { $err = "����������� ��� ������� ����� wm-������������� �����������"; }
    elseif ($errCode == "5")
    { $err = "����������� ��������� � ��������� ��������������� �� ����������"; }
    elseif ($errCode == "6")
    { $err = "���������� ��������� � ��������� ��������������� �� ����������"; }
    elseif ($errCode == "14")
    { $err = "������ �������"; }
    elseif ($errCode == "102")
    { $err = "�������� R==uestN ������ ��� ����� ����������� ��������� R==uestN"; }
    elseif ($errCode == "103")
    { $err = "�������� � ����� ������� (TID) ��� �����������"; }
    elseif ($errCode == "110")
    { $err = "��������� ����������. ".
             "���� ��������� �������� ������ ����������������� ��������. ".
             "��� ����������� ��������� �� ���������� ����� ".
             "� WMID 941977853154 (����������� ���������)"; 
    }

    return $err;
  }

  return "";
}



/////////////////////////////////////////////////////////////////
// TestAutority - �������� ���������� ������� ����� ����������� ��������������
//
// ��������� :
//   $cliWMID    - WM-������������� �������, �������� ���������� �����������������
//   $cliPlanStr - ��������, ����������� ��������
//   $cliSignStr - ������� ������� ��� ��������������
// ���������� :
//   2-���������� ������ ($status, $err), ���
//     $status -1 ������ ��� ��������
//              0 ������ �� ������ ��������������
//              1 ������ ������ ��������������
//     $err    ����� ������ (��� status = -1)
//
//! ��� ������ ������� � ��� �� ����������, ��� � ���������� ������ (�� �������
//! � ������ ������������ ������� �����-������), ������ ������������ �����
//! WMSigner � WMSigner.ini

function TestAutority($cliWMID, $cliPlanStr, $cliSignStr)
{
  global $wmconst__shop_wmid;

  // ������������ ������ ��� �������
  $PlanStr = "$wmconst__shop_wmid$cliWMID$cliPlanStr$cliSignStr";
  // ������������ �������
  $SignStr = _GetSign($PlanStr);


  global $wmconst__shop_wmid;

  // https-������
  $W3sUrl = "/asp/classicauth.asp?WMID=$wmconst__shop_wmid&".
               "CWMID=$cliWMID&CPS=".urlencode($cliPlanStr)."&CSS=$cliSignStr&SS=$SignStr";

  $httpsRes = _HttpsReq($W3sUrl);
  

  // ������ ����������� �� ����������������� ����� ����������

  $err = "";
  $status = -1;

  if (substr($httpsRes,0,6) == "Error:")
  {
    $errCode = sprintf("%d", substr($httpsRes,6));

    $err = "����������� ������";
    if ($errCode == "-7")
    { $err = "������� �������������� �������, �������� ��� �� ������"; }
    elseif ($errCode == "-6")
    { $err = "���������� ������ ��������"; }
    elseif ($errCode == "-5")
    { $err = "����������� ��� ������� ������ ������� �������"; }
    elseif ($errCode == "-4")
    { $err = "����������� ��� ������� ������ ��� ������� (���������� ��� ������ AccesMarker)"; }
    elseif ($errCode == "-3")
    { $err = "����������� ��� ������� ����� ����� AccesMarker"; }
    elseif ($errCode == "-2")
    { $err = "����������� ��� ������� ����� wm-������������� ������������ (�������)"; }
    elseif ($errCode == "-1")
    { $err = "����������� ��� ������� ����� wm-������������� ������������ ���(web-�������)"; }
    elseif ($errCode == "110")
    { $err = "��������� ����������. ".
             "���� ��������� �������� ������ ����������������� ��������. ".
             "��� ����������� ��������� �� ���������� ����� ".
             "� WMID 941977853154 (����������� ���������)"; 
    }
  }
  else
  {
    if (substr($httpsRes,0,3) == "Yes")
    { $status = 1; }
    elseif (substr($httpsRes,0,3) == "No")
    { $status = 0; }
    else
    { $err = "����� �� ���������"; }
  }

  return array($status, $err);
}




/////////////////////////////////////////////////////////////////
// CheckWMIDPurse - �������� �������������� WM-�������� WM-��������������
//
// ��������� :
//   $WMID    - WM-������������� �������, �������� ���������� �����������������
//   $WMpurse - ��������, ����������� ��������
// ���������� :
//   2-���������� ������ ($status, $err), ���
//     $status -1 ������ ��� ��������
//              0 - ���������� WM �������������� �� ����������
//              1 - WM ������������� ����������, �� �� �� ����� ���������� ��������
//              2 - WM ������������� ���������� � ����� ��������� �������
//     $err    ����� ������ (��� status = -1)
//
//! ��� ������ ������� � ��� �� ����������, ��� � ���������� ������ (�� �������
//! � ������ ������������ ������� �����-������), ������ ������������ �����
//! WMSigner � WMSigner.ini

function CheckWMIDPurse($WMID, $WMpurse)
{
  $RequestN = _DateID();         // ��������� ������������ ����� �������

  global $wmconst__shop_wmid;

  // ������������ ������ ��� �������
  $PlanStr = "$wmconst__shop_wmid$WMID$WMpurse$RequestN";
  // ������������ �������
  $SignStr = _GetSign($PlanStr);


  // https-������
  $W3sUrl = "/asp/TestPurse.asp?S=$wmconst__shop_wmid&".
            "I=$WMID&P=$WMpurse&RN=$RequestN&SS=$SignStr";

  $httpsRes = _HttpsReq($W3sUrl);
  
  // ������ ����������� �� ����������������� ����� ����������

  $err = "";
  $status = -1;

  if (substr($httpsRes,0,6) == "Error:")
  {
    $errCode = sprintf("%d", substr($httpsRes,6));

    $err = "����������� ������";
    if ($errCode == "-8")
    { $err = "���������� ������ �������� wm-����������"; }
    elseif ($errCode == "-7")
    { $err = "������� �������������� �������, �������� ��� �� ������"; }
    elseif ($errCode == "-6")
    { $err = "���������� ������ �������� wm-����������"; }
    elseif ($errCode == "-5")
    { $err = "����������� ��� ������� ������ �������"; }
    elseif ($errCode == "-4")
    { $err = "R==uestN ����� �����������"; }
    elseif ($errCode == "-2")
    { $err = "����������� ��� ������� ����� wm-������� ������������"; }
    elseif ($errCode == "-1")
    { $err = "����������� ��� ������� ����� wm-������������� ������������"; }
    elseif ($errCode == "102")
    { $err = "�������� R==uestN ������ ��� ����� ����������� ��������� R==uestN"; }
    elseif ($errCode == "110")
    { $err = "��������� ����������. ".
             "���� ��������� �������� ������ ����������������� ��������. ".
             "��� ����������� ��������� �� ���������� ����� ".
             "� WMID 941977853154 (����������� ���������)"; 
    }
  }
  elseif (substr($httpsRes,0,7) == "Result:")
  {
    $httpsRes = sprintf("%d", substr($httpsRes,7));

    if ($httpsRes>=0 && $httpsRes<=2)
    { $status = $httpsRes; }
    else
    { $err = "����������� ��� ����������"; }
  }
  else
  { $err = "����� �� ���������"; }

  return array($status, $err);
}



?>