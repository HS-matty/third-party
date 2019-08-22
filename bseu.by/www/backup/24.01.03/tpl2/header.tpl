<html>
<head>
<title>$title</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.up_menu {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-style: normal; line-height: normal; color: #009900; text-decoration: none}
a:link {  text-decoration: underline; font-style: normal; color: #00A600}
a:visited { text-decoration: underline; font-style: normal; color: #00A600 }
a:hover {  color:#276907;}

.text1 {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000000; text-decoration: none}
text2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-style: normal;}
.goods {  font-family: "Courier New", Courier, mono; font-size: 12px; font-style: normal; color: #00a600; text-decoration: none}
.good_text {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-style: normal; color: #000000; text-decoration: none}
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="up_menu" bgcolor="#E5E5E5">
  <tr> 
    <td width="15%" height="25px"> 
      <div class='up_menu' align="center"><a href="search.php">Advanced search</a></div>
    </td>
    <td width="15%"> 

&nbsp;  </td>
    <td width="*">&nbsp;</td>
    <td width="15%"> 
	  <div align="center"><a href="index.php">Main shop page</a></div>
    </td>
	<td width="15%"> 
      <div align="center"><a href="cart.php">Shopping cart</a></div>
    </td>
    <td width="15%"> 
      <div align="center"><a href="profile.php">Your profile</a></div>
    </td>
  </tr>
  <form name="search_form" method="post" action="search.php">
    <tr bgcolor="#ACD959"> 
      <td colspan="3" align="left" valign="middle" bgcolor="#ACD959" class="text1">  Search 
        site</font> 
        <input type="text" name="search_string" size=10 style="width:150px;">
      </td>
      <td width="*">&nbsp;</td>
      <td colspan="2">
        <div align="center" class="text1">Shopping cart status: <span style="color:red";">$cart_status</span></div>
      </td>
    </tr>
  </form>
</table>