							<tr style="vertical-align: middle;" height="50px">
								<td align="right">Code{if $f->isRequired}<font color="red">*</font>{/if}:</td>
						<td  >
						<table><tr><td>
						{assign var="f" value=$Form->getField('captcha')}
			<input style="vertical-align: middle;padding:0" type="text" name="captcha" size="10" value="" ></td><td>
			<img src="{$HostName}/image.php" border=0 style="padding:0">
									{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}
						{/if}
						</td></tr></table>
						</td>
							</tr>
