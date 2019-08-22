<div align="center">
<table width="90%" cellspacing="1" cellpadding="2" border="0">
<form method="post" action="<?=$PHP_SELF?>?action=edit">
<tr bgcolor="#f5f5f5">
<td>Шаблон <b><?=basename($file)?></b> <a href="<?=$PHP_SELF?>?dir=<?=urlencode($dir)?>">(весь список)</a></td>
</tr>
<tr bgcolor="#f5f5f5">
<td>
<textarea name=content style="width: 100%" rows=25>
<?=$content?>
</textarea>
</td>
</tr>
<tr bgcolor="#f5f5f5">
<td>
<input type="submit" name="doedit" value="Изменить" />
</td>
</tr>
<input type="hidden" name="file" value="<?=$file?>" />
</form>
</table>
</div>