
$header

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#FFFFFF">
      <div align="center" class="text_gray">Welcome to $shopname! 
        We offer a great number of PC GAMES on CDs!<br>
        We hope you'll enjoy shopping here!</div>
    </td>
  </tr>
  <tr> 
    <td ><div class="text_gray">Your site position:<br></div><div class="path"> 
      $path_2_cat</div></td>
  </tr>

</table>
<br>
<div align=center><form name="form1" method="post" action="index.php">Sort by
  <select name="sort">
    $sort_
  </select>
  <input style="background-color:#EFEDFE;" type="submit" name="Submit" value="Submit">
</form>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width='150px' valign='top'>
	<table width='100%' bgcolor='#e5e5e5' cellspacing="1" cellpadding="0">
	<tr>
          <td align='center' class="text_menu_header" bgcolor="#E0F1C0"> 
            <div align="center">Catalog.</div>
          </td>
        </tr>
	$navigation_left
	
	</table>
	</td>
    <td width='20px' valign='top'>
	</td>
	<td valign='top'>
<table width='100%' cellspacing="0" align="left">
	 $index
	 	</table>
		
	</td>
    <td width='20px' valign='top' align=Right>
	</td>
    <td width='150px' valign='top'>
	  <table cellpadding="0" cellspacing="1" width="100%" bgcolor='#e5e5e5'>
        <tr>
          <td width='100%' class="text_menu_header" bgcolor="#E0F1C0" align='center'>Site 
            information</td></tr>

	<tr><td bgcolor='white' class='text_menu'><a href="">Order making.</a></td></tr>
	<tr><td bgcolor='white' class='text_menu'><a href="">Payment</a></td></tr>
	<tr><td bgcolor='white' class='text_menu'><a href="">Other</a></td></tr>
	</table>
	
	</td>

  </tr>
</table>

$footer