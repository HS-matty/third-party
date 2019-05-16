
{if $success}
	<h3>Восстановление пароля</h3>
	<br />
	<h1>Пароль выслан на вам на емаил</h1>
{else}

<form method="POST" enctype="multipart/form-data"  id="add_form">

					<!-- InstanceBeginEditable name="content" -->
						<div id="postPage">
							<h3>Восстановление пароля</h3>
							<br />
						
							<table width="100%" cellpadding="3" cellspacing="0">
	<tr>
									{assign var="f" value=$Form->getField('email')}
									<td width="46%" align="right" >Email:</td>
									<td colspan=2><input value="{$f->getValue()}" type="text" name="email" />	{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}
	{/if}</td>
	
								</tr>
							
							<tr style="vertical-align: middle;" height="50px">
								<td align="right">Code:</td>
						<td align="left" width="100">
						{assign var="f" value=$Form->getField('captcha')}
			<input style="align:left;vertical-align: middle;padding:0" type="text" name="captcha" size="10" value="" >
				{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}
						{/if}
			</td><td>
			<img src="{$HostName}/image.php" border=0 style="padding:0">
								
						</td>
							</tr>
							</table>
							
								<div align="center">	<input type="submit" class="button" value="Отправить"></div>
							</div>

					
					<!-- InstanceEndEditable -->
					<input type="hidden" name="post" value="1">
					</form>
					
					{/if}
