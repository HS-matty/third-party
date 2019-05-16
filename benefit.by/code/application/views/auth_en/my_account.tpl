			
					<!-- InstanceBeginEditable name="content" -->
					<form method="post" action="">
						<div id="postPage">
							<h3>Edit an Account</h3>
						Modify any of the information below and click 'Save' to save your updated account information.		<br /><br />
						
						{if $success}<span style="color:#ff0000">Your account information has been saved.</span>{/if}
							<h5>Account Information</h5>

							<table width="100%" cellpadding="3" cellspacing="0">
								<tr>
									{assign var="f" value=$Form->getField('first_name')}
									<td align="right" width="120">First Name</td>
									<td><input type="text" name="first_name"  value="{$f->getValue()}"/>
										{if $f->Errors}
									{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}{/if}
									</td>
								</tr>
								<tr>
																{assign var="f" value=$Form->getField('last_name')}
									<td align="right">Last Name</td>
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
									<td align="right">Phone</td>

									<td><input type="text" name="phone_number"  value="{$f->getValue()}" />
										{if $f->Errors}	{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}{/if}
									</td>
								</tr>
								<tr>
									{assign var="f" value=$Form->getField('password')}
									<td align="right"><span class="red">*</span>Password</td>
									<td><input type="password" name="password"  />
									{if $f->Errors}	{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}{/if}</td>
								</tr>
								<tr>
									{assign var="f" value=$Form->getField('confirm_password')}
									
									<td align="right"><span class="red">*</span>Confirm Password</td>

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
								<input type="submit" value="Save"/>							</div>

						</div>
						</form>
					<!-- InstanceEndEditable -->
			
			