<html>
<head>
<title>АДМИН</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<style type="text/css">
<!--
.m1 {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px}
-->
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000">
<p align="center" class="m1"><a href="logout.php?u_sid={u_sid}">logout</a></p>
<table width="35%" border="0" cellspacing="0" cellpadding="0" align="center" bordercolor="#000000">
  <tr bgcolor="#CCCCCC"> 
    <td colspan="2" height="19" bgcolor="#FFFFFF"> 
      <div align="center" class="m1"><font color="#009900">Доступные пины</font></div>
    </td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td width="70%" height="19"> 
      <div align="center" class="m1">наименование</div>
    </td>
    <td width="33%" height="19"> 
      <div align="center" class="m1">кол-во пинов</div>
    </td>
  </tr>
   <!-- BEGIN AV -->
  <tr bgcolor="#F8F8F8"> 
    <td bgcolor="#F8F8F8"> 
      <div align="center" class="m1">{AV.pin_name}</div>
    </td>
    <td> 
      <div align="center" class="m1">{AV.count}</div>
    </td>
  </tr>
   <!-- END AV -->
</table>

<br>

<table width="35%" border="0" cellspacing="0" cellpadding="0" align="center" bordercolor="#000000">
  <tr bgcolor="#CCCCCC"> 
    <td colspan="2" height="19" bgcolor="#FFFFFF"> 
      <div align="center" class="m1"><font color="#FF0000">Проданные пины</font></div>
    </td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td width="70%" height="19"> 
      <div align="center" class="m1">наименование</div>
    </td>
    <td width="33%" height="19"> 
      <div align="center" class="m1">кол-во пинов</div>
    </td>
  </tr>
   <!-- BEGIN USED -->
  <tr bgcolor="#F8F8F8"> 
    <td class="m1"> 
      <div align="center">{USED.pin_name}</div>
    </td>
    <td> 
      <div align="center" class="m1">{USED.count}</div>
    </td>
  </tr>
   <!-- END USED -->
</table>
<p>&nbsp; </p>
<div align='center'><a href='cards.php?u_sid={u_sid}' target='_blank'>add card</a></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bordercolor="#000000">
  <tr> 
    <td colspan="7"> 
      <div align="center"><span class="m1">Информация о транзакциях</span></div>
    </td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td width="5%" class="m1"> 
      <div align="center"><b>№</b></div>
    </td>
    <td width="20%" class="m1"> 
      <div align="center"><b>Объект тр-ии</b></div>
    </td>
    <td width="10%" class="m1"> 
      <div align="center"><b>wmid</b></div>
    </td>
    <td width="20%" class="m1"> 
      <div align="center"><b>время создания</b></div>
    </td>
	<td width="5%" class="m1"> 
      <div align="center"><b>ip</b></div>
    </td>
	<td width="15%" class="m1"> 
      <div align="center"><b>email</b></div>
    </td>
    <td width="15%" class="m1"> 
      <div align="center"><b>статус</b></div>
    </td>
  </tr>
   <!-- BEGIN TR -->
  <tr bgcolor="#F8F8F8"> 
    <td class="m1" height="14"> 
      <p align="center">{TR.id}</p>
    </td>
    <td height="14" class="m1"> 
      <div align="center"><a href='tran.php?sid={TR.sid}&u_sid={u_sid}' target="_blank">{TR.name}</a></div>
    </td>
    <td height="14" class="m1"> 
      <div align="center">{TR.wmid}</div>
    </td>
    <td height="14" class="m1"> 
      <div align="center">{TR.time_start}</div>
    </td>
    <td  class="m1" bgcolor="#F8F8F8" height="14"> 
      <div align="center">{TR.ip}</div>
    </td>
	 <td  class="m1" bgcolor="#F8F8F8" height="14"> 
      <div align="center">{TR.email}</div>
    </td>
	<td  class="m1" bgcolor="#F8F8F8" height="14"> 
      <div align="center">{TR.status}</div>
    </td>
	 
  </tr>
  <!-- END TR -->
</table>
<p class="m1">&nbsp;</p>
</body>
</html>
