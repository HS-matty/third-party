{HEADER}
  <form name="form1" method="post" action="order.php">
<br>
<table width="50%" border="0" cellspacing="0" cellpadding="4" align="center">
    <tr>
      <td class="txt1"> 
       После заполнения формы, Вам будет выписан счет на указанный webmoney 
          id и выдана ссылка для просмотра состояния вашего заказа. Вы должны оплатить
	  счет в указанный срок.
	  <br>	  <br>
      </td>
    </tr>
  </table>

  <table width="50%" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr> 
      <td bgcolor="#5B75C0" colspan="2" height="12"> 
        <div align="center" class="txt2"> Ваш заказ</div>
      </td>
    </tr>
    <tr bgcolor="#F3F3F3"> 
      <td class="nav"> 
        <div align="right">Заказ:</div>
      </td>
      <td class="nav" width="70%"> 
        {pin_name}
      </td>
    </tr>
    <tr bgcolor="#F3F3F3"> 
      <td class="nav"> 
        <div align="right">Стоимость: </div>
      </td>
      <td class="nav"> 
        {pin_price}
        WMZ</td>
    </tr>
    <tr bgcolor="#F3F3F3"> 
      <td class="nav"> 
        <div align="right">Webmoney ID </div>
      </td>
      <td class="nav"> 
        <input type="text" name="wid">
        <input type="hidden" name="order" value="{id}">
      </td>
    </tr>
    <tr bgcolor="#F3F3F3"> 
      <td class="nav"> 
        <div align="right">email: </div>
      </td>
      <td class="nav"> 
        <input type="text" name="email" >
      </td>
    </tr>
    <tr bgcolor="#F3F3F3"> 
      <td colspan="2" class="nav"> 
        <div align="center"> 
          Срок оплаты счета: {srok} минут
        </div>
      </td>
    </tr>
    <tr bgcolor="#F3F3F3"> 
      <td colspan="2"> 
        <div align="center"> 
          <input type="submit" name="Submit" value="Заказать" class='redbutton'>
        </div>
      </td>
    </tr>
  </table>
{FOOTER}