﻿			
					<!-- InstanceBeginEditable name="content" -->
					<form method="post" action="{$HostName}/auth/register/">
						<div id="postPage">
							<h3>Регистрация</h3>
						
							<table width="100%" cellpadding="3" cellspacing="0">
								<tr>
									{assign var="f" value=$Form->getField('first_name')}
									<td align="right" width="120">Имя</td>
									<td><input type="text" name="first_name"  value="{$f->getValue()}"/>
										{if $f->Errors}
									{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}{/if}
									</td>
								</tr>
								<tr>
																{assign var="f" value=$Form->getField('last_name')}
									<td align="right">Фамилия</td>
									<td><input type="text" name="last_name"   value="{$f->getValue()}"/>
										{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}{/if}
									</td>

								</tr>
								<tr>
								{assign var="f" value=$Form->getField('email')}
									<td align="right"><span class="red">*</span>Email</td>
									<td><input type="text"  name="email"  value="{$f->getValue()}"/>
													{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}{/if}</td>
								</tr>
								<tr>
								{assign var="f" value=$Form->getField('phone_number')}
									<td align="right">Телефон</td>

									<td><input type="text" name="phone_number"  value="{$f->getValue()}" />
										{if $f->Errors}	{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}{/if}
									</td>
								</tr>
								<tr>
									{assign var="f" value=$Form->getField('password')}
									<td align="right"><span class="red">*</span>Пароль</td>
									<td><input type="password" name="password"  />
									{if $f->Errors}	{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}{/if}</td>
								</tr>
								<tr>
									{assign var="f" value=$Form->getField('confirm_password')}
									
									<td align="right"><span class="red">*</span>Повторение пароля</td>

									<td><input type="password" name="confirm_password"  />
									
									{if $f->Errors}	{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}{/if}</td>
								</tr>
							</table>
							<br />
							<h5>&nbsp;</h5>
							<br />
							<div align="center">
							<input type="hidden" name="post" value="1">
								<input name="register_button" id="register_button" type="submit" value="Submit"/>							</div>

						</div>
						</form>
					<!-- InstanceEndEditable -->
			
			