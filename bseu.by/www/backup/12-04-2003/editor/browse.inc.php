<div align="center">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<form method="get" action="<?=$PHP_SELF?>?action=browse">
<tr>
<td align="left" valign="middle">
<b><a href="<?=$PHP_SELF?>?dir=<?=urlencode($dir)?>" style="text-decoration: none">Редактирование шаблонов.</a></b>
</td>
<td align="right" valign="middle">
Текущая директория:
&nbsp;
<input type="text" name="dir" size="40" value="<?=$dir?>" />
&nbsp;
<input type="submit" name="dobrowse" value="Изменить" />
</td>
</tr>
</form>
</table>
</div>
<hr width="100%" size="1" noshade />