<form action="" method="get">
<table border=1>

<tr><td>по  номеру автобуса</td><td> <input type="text" name="bus_id" value="{$qr->getHTMLValue('bus_id')}"></td></tr>
<tr><td>по названию маршрута</td><td> <input type="text" name="bus_route_title" value="{$qr->getHTMLValue('bus_route_title')}"></td></tr>

{include file=$Page->getIndexTmpl('dates_select.tpl')}

<tr ><td align='center' colspan=2><input type="submit" value="искать"></td></tr>
</table>
<input type="hidden" name="sid" value="{$Sid}">


{include file=$Page->getQr()}

<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#666666" >

  <tr bgcolor="#666666" style="color:#ffffff" align="center" > 
    <td>ID</td>
    <td>Место</td>
    <td>Инфо</td>
    <td>Автобус <a href="?sid={$Sid}" style="color:#ffffee">(очистить)</a></td>
    <td>Отправление</td>
    
    <td>Статус</td>
    <td>Цена</td>
    <td>Скидка</td>
    <td>Конечная цена</td>
  </tr>
  
  {foreach from=$tickets item=t}
  <tr class='table_text' align='center' bgcolor="{cycle values="#FCF2CF,FDF5DB"}" height="20" > 
  
    <td>{$t.ticket_id}</td>
    <td>{$t.ticket_place}</td>
    <td><a href="/admin/busservice/ticket/{$Lang}/?sid={$Sid}&id={$t.ticket_id}">Подробнее</a></td>
    <td ><a href="/admin/busservice/bus/{$Lang}/?sid={$Sid}&id={$t.bus_id}">№{$t.bus_id}, {$t.bus_route_title}</a></td>
    <td>{$t.bus_day_depar|date_format:" %d / %m /  %Y"}, {$t.bus_time_depar}</td>
    
    
    <td>{if $t.ticket_status == "reserve"}Предварительно{elseif $t.ticket_status == "buy"}Покупка{else}ошибка{/if}</td>
    <td>{$t.ticket_price} {$t.ticket_currency_title}</td>
    <td><a href="/admin/busservice/discount_rates/{$t.interval_id}/ru/?sid={$Sid}">{$t.ticket_discount_rate}%, {$t.ticket_discount_title}</a></td>
    <td>{$t.ticket_discount_price} {$t.ticket_currency_title}</td>
  </tr>
{/foreach}
  <tr bgcolor="#ffffff" style="color:red" align="center" > 
    <td>ИТОГО:</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    
    <td></td>
    <td><b>{$Stats.price_sum}</b></td>
    <td></td>
    <td><b>{$Stats.discount_price_sum}</b></td>
  </tr>

</table>
{include file=$Page->getQr()}