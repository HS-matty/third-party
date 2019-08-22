<html>
<head>
<title>$title</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
<!--

a:link {  text-decoration: none; font-style: normal; color: #00A600}
a:visited { text-decoration: none; font-style: normal; color: #00A600 }
a:hover {  color:#276907;text-decoration: underline;}

.upper_menu {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-style: normal; line-height: normal; color: #009900; text-decoration: underline}

.path {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-style: normal; line-height: normal; }

.copyright {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-style: normal; line-height: normal; color: #009900; text-decoration: none}
.text_gray {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #666666; text-decoration: none}
.text_menu_header {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000000; text-decoration: none}
.text_menu {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-style: normal;}
.goods_describe {  font-family: "Courier New", Courier, mono; font-size: 12px; font-style: normal; color: #00a600; text-decoration: none}
.goods_text {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-style: normal; color: #000000; text-decoration: none}
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#E5E5E5">
  <tr> 
    <td width="15%" height="25px"> 
      <div  align="center"><a href="search.php" ><div class="upper_menu">Advanced search</div></a></td>
	  <td width="15%"> &nbsp;  </td>
    <td width="*">&nbsp;</td>
    <td width="15%" align='center'> 
	  <a href="index.php" ><div class="upper_menu">Main shop page</div></a>
    </td>
	<td width="15%" align='center'> 
      <a href="cart.php"  align='center'><div class="upper_menu">Shopping cart</div></a>
    </td>
    <td width="15%"> 
      <a href="profile.php" align='center'><div class="upper_menu">Your profile</div></a>
    </td>
  </tr>
  <form name="search_form" method="post" action="search.php">
    <tr bgcolor="#ACD959"> 
      <td colspan="3" align="left" valign="middle" bgcolor="#ACD959" class="text_gray">  Search 
        site</font> 
        <input type="text" name="search_string" size=10 style="width:150px;">
      </td>
      <td width="*">&nbsp;</td>
      <td colspan="2">
        <div align="center" class="text_gray">Shopping cart status: <span style="color:red";">$cart_status</span></div>
      </td>
    </tr>
  </form>
</table>