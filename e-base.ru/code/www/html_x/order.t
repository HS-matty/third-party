{HEADER}
  <form name="form1" method="post" action="order.php">
<br>
<table width="50%" border="0" cellspacing="0" cellpadding="4" align="center">
    <tr>
      <td class="txt1"> 
       ����� ���������� �����, ��� ����� ������� ���� �� ��������� webmoney 
          id � ������ ������ ��� ��������� ��������� ������ ������. �� ������ ��������
	  ���� � ��������� ����.
	  <br>	  <br>
      </td>
    </tr>
  </table>

  <table width="50%" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr> 
      <td bgcolor="#5B75C0" colspan="2" height="12"> 
        <div align="center" class="txt2"> ��� �����</div>
      </td>
    </tr>
    <tr bgcolor="#F3F3F3"> 
      <td class="nav"> 
        <div align="right">�����:</div>
      </td>
      <td class="nav" width="70%"> 
        {pin_name}
      </td>
    </tr>
    <tr bgcolor="#F3F3F3"> 
      <td class="nav"> 
        <div align="right">���������: </div>
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
          ���� ������ �����: {srok} �����
        </div>
      </td>
    </tr>
    <tr bgcolor="#F3F3F3"> 
      <td colspan="2"> 
        <div align="center"> 
          <input type="submit" name="Submit" value="��������" class='redbutton'>
        </div>
      </td>
    </tr>
  </table>
{FOOTER}