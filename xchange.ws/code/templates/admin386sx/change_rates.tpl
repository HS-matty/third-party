<body bgcolor="#FFFFFF" text="#000000">{HEADER}

<form name="rates" method="post" action="change_fin.php">
  <table width="459" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr bgcolor="#CCFF00"> 
      <td width="70%"> 
        <div align="center">currency</div>
      </td>
      <td> 
        <div align="center">rate</div>
      </td>
    </tr>
    <!-- BEGIN RATES -->
    <tr>
      <td>
        <div align="center">{RATES.in_cur_name}---&gt;{RATES.out_cur_name}</div>
      </td>
      <td>
        <div align="center">
          <input type="text" size='4' name="rate" maxlength="5" value="{RATES.rate}">
		  <input type="hidden" name="rate_id" value="{RATES.rate_id}">
		  <input type="hidden" name="rate_submited" value='1'>
		  <input type='hidden' name='u_sid' value = '{U_SID}'>
        </div>
      </td>
    </tr>
    <!-- END RATES -->
  </table>
  <p align="center"> 
    <input type="submit" name="Submit" value="Submit">&nbsp&nbsp&nbsp&nbsp<a href="index.php?u_sid='{U_SID}">��������� ��� ���������</a>
  </p>
</form>
</body>
</html>
