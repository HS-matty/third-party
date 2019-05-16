<form action ="" method="get">
Поиск билетов: 
<table border=1>
<tr><td>по номеру билета</td><td> <input type="text" name="ticket_id" value="{$qr->getHTMLValue('ticket_id')}"></td></tr>
<tr><td>по  номеру автобуса</td><td> <input type="text" name="bus_id" value="{$qr->getHTMLValue('bus_id')}"></td></tr>
<tr><td>по фамилии клиента:</td><td> <input type="text" name="client_surname" value="{$qr->getHTMLValue('client_surname')}"> </td></tr>
<tr ><td align='center' colspan=2><input type="submit" value="искать"></td></tr>
</table>
</form>
