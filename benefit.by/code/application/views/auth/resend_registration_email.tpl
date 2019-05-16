<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Resend register email</title>


<link href="{$HostName}/public/styles/BarefootStyles.css" rel="stylesheet" type="text/css" />
{literal}
<style type="text/css">
<!--
body,td {
	font-size: 13px;
}
-->
</style>
{/literal}
</head>
<body>
<br><br><br>

{if $success}
	<h3>Registration data sent to your email</h3>
{else}

<form method="POST" enctype="multipart/form-data"  id="add_form">

					<!-- InstanceBeginEditable name="content" -->
						<div id="postPage">
							<h3>Get registration data</h3>
							
							<br /><br />
						
							<table width="100%" cellpadding="3" cellspacing="0">
	<tr>
									{assign var="f" value=$Form->getField('email')}
									<td align="right" >Email:</td>
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
							
								<div align="center">	<input type="submit" value="Submit"></div>
							</div>

					
					<!-- InstanceEndEditable -->
					<input type="hidden" name="post" value="1">
					</form>
					
					{/if}
</body>
</html>