<form method="get" action="{$HostName}/user/item/">
<select name="type">
{foreach from=$services item=s}
<option value="{$s.category_id}">{$s.short_description}</option>
{/foreach}
</select> <input type="submit" class="button" value="выбрать">
</form>