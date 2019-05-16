<tr><td>Начальная дата</td><td>
Число:<select name="start_day" style="width:70px;font-weight: bold;">
<option value="0">Число</option>
{section start =1 loop=32 name='day'}
<option value="{$smarty.section.day.index}" {if $qr->getHTMLValue('start_day') == $smarty.section.day.index}selected{/if}>{$smarty.section.day.index}
</option>

{/section}

</select>
Месяц:
<select name="start_month" style="width:100px;font-weight: bold;">
<option value="0" {if !$qr->getHTMLValue('start_month')}selected{/if}>Месяц</option>
<option value="1" {if $qr->getHTMLValue('start_month') == 1}selected{/if}>Январь</option>
<option value="2" {if $qr->getHTMLValue('start_month') == 2}selected{/if}>Февраль</option>
<option value="3" {if $qr->getHTMLValue('start_month') == 3}selected{/if}>Март</option>
<option value="4" {if $qr->getHTMLValue('start_month') == 4}selected{/if}>Апрель</option>
<option value="5" {if $qr->getHTMLValue('start_month') == 5}selected{/if}>Май</option>
<option value="6" {if $qr->getHTMLValue('start_month') == 6}selected{/if}>Июнь</option>
<option value="7" {if $qr->getHTMLValue('start_month') == 7}selected{/if}>Июль</option>
<option value="8" {if $qr->getHTMLValue('start_month') == 8}selected{/if}>Август</option>
<option value="9" {if $qr->getHTMLValue('start_month') == 9}selected{/if}>Сентябрь</option>
<option value="10" {if $qr->getHTMLValue('start_month') == 10}selected{/if}>Октябрь</option>
<option value="11" {if $qr->getHTMLValue('start_month') == 11}selected{/if}>Ноябрь</option>
<option value="12" {if $qr->getHTMLValue('start_month') == 12}selected{/if}>декабрь</option>

</select>
Год:
<select name="start_year" style="width:100px;font-weight: bold;">
<option value="0">Год</option>
<option value='2005' {if $qr->getHTMLValue('start_year') == '2005'}selected{/if}>2005</option>
<option value='2006' {if $qr->getHTMLValue('start_year') == '2006'}selected{/if}>2006</option>
<option value='2007' {if $qr->getHTMLValue('start_year') == '2007'}selected{/if}>2007</option>
</select>

</td></tr>


<tr><td>Конечная дата</td><td>
Число:<select name="end_day" style="width:70px;font-weight: bold;" >
<option value="0">Число</option>
{section start =1 loop=32 name='day'}
<option value="{$smarty.section.day.index}" {if $qr->getHTMLValue('end_day') == $smarty.section.day.index}selected{/if}>{$smarty.section.day.index}
</option>

{/section}
</select>
Месяц:
<select name="end_month" style="width:100px;font-weight: bold;">
<option value="0" {if !$qr->getHTMLValue('start_month')}selected{/if}>Месяц</option>
<option value="1" {if $qr->getHTMLValue('end_month') == 1}selected{/if}>Январь</option>
<option value="2" {if $qr->getHTMLValue('end_month') == 2}selected{/if}>Февраль</option>
<option value="3" {if $qr->getHTMLValue('end_month') == 3}selected{/if}>Март</option>
<option value="4" {if $qr->getHTMLValue('end_month') == 4}selected{/if}>Апрель</option>
<option value="5" {if $qr->getHTMLValue('end_month') == 5}selected{/if}>Май</option>
<option value="6" {if $qr->getHTMLValue('end_month') == 6}selected{/if}>Июнь</option>
<option value="7" {if $qr->getHTMLValue('end_month') == 7}selected{/if}>Июль</option>
<option value="8" {if $qr->getHTMLValue('end_month') == 8}selected{/if}>Август</option>
<option value="9" {if $qr->getHTMLValue('end_month') == 9}selected{/if}>Сентябрь</option>
<option value="10" {if $qr->getHTMLValue('end_month') == 10}selected{/if}>Октябрь</option>
<option value="11" {if $qr->getHTMLValue('end_month') == 11}selected{/if}>Ноябрь</option>
<option value="12" {if $qr->getHTMLValue('end_month') == 12}selected{/if}>декабрь</option>


</select>
Год:
<select name="end_year" style="width:100px;font-weight: bold;">
<option value="0" >Год</option>
<option value='2005' {if $qr->getHTMLValue('end_year') == '2005'}selected{/if}>2005</option>
<option value='2006' {if $qr->getHTMLValue('end_year') == '2006'}selected{/if}>2006</option>
<option value='2007' {if $qr->getHTMLValue('end_year') == '2007'}selected{/if}>2007</option>
</select>


</td></tr>



