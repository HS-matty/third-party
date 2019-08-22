<html>
<head>
<title>MEGA SHOP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<TABLE width='100%' height='14px' cellspacing="0" cellpadding="0">
<TR>
	<TD  align=left ><form name="output" method="post" size='10' action="index.php">
Sort by <select name="sort" >
    <option value="by_name">name</option>
    <option value="by_price">price</option>
  </select>
 <input type="submit" class="rb" value="Submit">
</form>
</TD>
</TR>
</TABLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#AEB8F9">
  <tr>
    <td bgcolor="#EFEDFE" cellspacing="0">
      <b><div align="left">$up_left</div></b>
    </td>
  </tr>
</table>

<table width="100%">
<tr>
<td>
<table  width="15%" border="0" cellspacing="1" cellpadding="0" align="left" bgcolor="#C0C6FA">
<tr><td bgcolor='#fffff'><div align=center>Choose category</div></td></tr>
$navigation_left	
</table>
<table width="70%" border="0" cellspacing="1" cellpadding="0" align="left" bgcolor="#C0C6FA">
  <tr>

<td width='25%' bgcolor="#ffffff">
<div align="center">Name</div></td>
<td width='15%' bgcolor="#ffffff">
<div align="center">Category</div></td>
<td width='50%' bgcolor="#ffffff">
<div align="center">Description</div></td>
<td width='10%' bgcolor="#ffffff">
<div align="center">Price</div></td></tr>

  $goods
</table>
<table width="15%" border="0" cellspacing="1" cellpadding="0" align="left" bgcolor="#C0C6FA">
  <tr>
    <td bgcolor="#DCDFFC" >wazzap?</td>
  </tr>
</table>
</td></tr>
</table>
</body>
</html>
