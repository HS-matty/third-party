<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
  <p>e-base</p>
  <p>1) Сколько хотим обменять</p>
       <form name="cur_choose" method="post" action="/change/index.php">
  <table width="430" border="1" cellpadding="1" bordercolor="#333333">
    <tr> 
      <td width="85"> 
        <div align="center">валюта</div>
      </td>
      <td width="107"> 
        <div align="center">сумма</div>
      </td>
      <td width="101" valign="middle"> 
        <p align="center">валюта </p>
      </td>
      <td width="119"> 
        <div align="center">сумма</div>
      </td>
      <td width="119">
        <div align="center">action</div>
      </td>
    </tr>
    <tr> 
      <td width="85">

          <select name="in_cur" size="1">
            <option value="wmz">wmz</option>
			<option value="wmr">wmr</option>
			<option value="wme">wme</option>
          </select>

      </td>
      <td width="107">

          <input type="text" name="in_sum" value="" size="12">

      </td>
      <td width="101"><select name="out_cur" size="1">
            <option value="wmz">wmz</option>
			<option value="wmr">wmr</option>
			<option value="wme">wme</option>
          </select></td>
      <td width="119">  <input type="text" name="in_sum" value="" size="12"></td>
      <td width="119"><input type="submit" name="go" value="change"></td>
    </tr>

  </table>
	       </form>
  <p>&nbsp; </p>
</div>
<div align="center"></div>
</body>
</html>
