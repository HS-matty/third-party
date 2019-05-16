{HEADER}
<div align="center"> 
  <p>&nbsp;</p>
  <h3><u>Текущая статистика.</u> </h3>
  <p>Остатки по счетам.<br>
  </p>
  <table width="300" border="1" cellspacing="0" cellpadding="0">
    <tr bgcolor="#CCCCFF"> 
      <td width="50%"> 
        <div align="center" class="text">валюта</div>
      </td>
      <td width="50%" bgcolor="#CCCCFF"> 
        <div align="center" class="text">остаток</div>
      </td>
	   <td bgcolor="#CCCCFF"> 
        <div align="center">статус</div>
      </td>

	</tr>
 <!-- BEGIN MONEY_LEFT -->
	<tr>
      <td>
        <div align="center">{MONEY_LEFT.cur_name} </div>
             </td>
      <td>
        <div align="center">{MONEY_LEFT.money_left}</div>
      </td>
       <td>
        <div align="center"><a href="change_fin.php?change_status=1&cur_id={MONEY_LEFT.cur_id}&u_sid={U_SID}">{MONEY_LEFT.status}</a></div>
      </td>

	</tr>
 <!-- END MONEY_LEFT -->
  </table>
  <p>Текущие курсы. </p>
  <table width="300" border="1" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="text" bgcolor="#CCCCFF" width="70%"> 
        <div align="center">валюты</div>
      </td>
      <td bgcolor="#CCCCFF"> 
        <div align="center">курс</div>
      </td>
	 
    </tr>
 <!-- BEGIN RATES -->
	<tr>
      <td>
        <div align="center">{RATES.in_cur_name} &nbsp;&nbsp;  <a href="change_fin.php?change_rates=1&rate_id={RATES.rate_id}&u_sid={U_SID}"> ----> </a>&nbsp;&nbsp;
		{RATES.out_cur_name}</div>
      </td>
      <td>
        <div align="center">{RATES.rate}</div>
      </td>

    </tr>
 <!-- END RATES -->
  </table>
  <p>Текущие транзакции.</p>



 <table width="300" border="1" cellpadding="0" cellspacing="0">
 <!-- BEGIN TRANS -->
	<tr>
      <td width="85%"> 
        <div align="left" class="text">{TRANS.descr}</div>
      </td>
      <td>
        <div align="center">{TRANS.num}</div>
      </td>
    </tr>
 <!-- END TRANS -->
     </table>
<form name="form1" method="POST" action="index.php" align='center'>
  <select name="time_sort">
    <option value="86400">24h</option>
	<option value="300">5 min</option>
    <option value="1800">30 min</option>
    <option value="3600">1h</option>
    
     </select>
  <input type="hidden" name="u_sid" value="{U_SID}">
  <input type="submit" name="Submit" value="Submit">
</form>
  
  <h3><u>Финансовая статистика.</u></h3>
  <h3>&nbsp;</h3>
  <p>&nbsp;</p>
</div>
</body>
</html>
