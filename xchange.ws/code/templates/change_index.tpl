<html>
<head>
<title>{TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>

<body bgcolor="#FFFFFF" text="#000000">

<p>
  <script>
var kurs = {RATE};

function in_out(is_t){

document.f1.in_val.value = document.f1.in_val.value.replace(",",".");
document.f1.in_val.value = document.f1.in_val.value.replace("-","");
in_val = Math.round( document.f1.in_val.value*100)/100;
if (isNaN(in_val))   in_val = "0"; 
document.f1.out_val.value = Math.floor(in_val*kurs*100+0.00001)/100;
 if (is_t) out_in();
}

function out_in(is_t){
document.f1.out_val.value = document.f1.out_val.value.replace(",",".");
document.f1.out_val.value = document.f1.out_val.value.replace("-","");
out_val = Math.round( document.f1.out_val.value*100)/100;
if (isNaN(out_val))   out_val = "0"; 
document.f1.in_val.value = Math.ceil(out_val/kurs*100-0.00001)/100;
 if (is_t) {in_out();}
}


</script>
</p>
�� 1 {IN_CUR_NAME} ���� {RATE} {OUT_CUR_NAME} 
<form name="f1" method="post" action="change.php">
  <p> <br>
  </p>
  <table width="430" border="0">
    {CURRS}

    <tr> 
      <td>in</td>
      <td> 
        <input  onactivate=in_out(true)  onfocusout=in_out(true) ondeactivate=in_out(true)  onKeyUp=in_out() onChange=in_out() type="text" name="in_val" maxlength="10" value='0'>
      </td>
    </tr>
    <tr> 
      <td>out({MONEY_LEFT} ��������) </td>
      <td> 
        <input onBlur=out_in() onKeyUp=out_in() onChange=out_in() type="text" name="out_val" maxlength="10" value=0>
      </td>
    </tr>
  </table>
  <p>
  <input type="hidden" name="in_cur" value="{IN_CUR}">
  <input type="hidden" name="out_cur" value="{OUT_CUR}">
  <input type="hidden" name="sid" value="{SID}">
	<input type="submit" name="Submit" value="Submit">
  </p>
 
</form>
</body>
</html>