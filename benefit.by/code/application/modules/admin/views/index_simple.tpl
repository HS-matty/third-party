
<html>
<head>
<title>test</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

{include file=$Page->getIndexTmpl('css.tpl')}
</head>
<body>
<div style="padding:40px">

<div style="color:red;padding-left:30px;height:30px">{if $success == 2}Success!
{elseif $success == 1}Not success!{/if}
</div>
{if $Errors}
<div id="errors">
<ul>
<b>Errors:</b><br>
{foreach from=$Errors item=error}
		
<li><b>{$error.FieldTitle}</b>,  {$error.Msg}{if $error.Req}, requirement: {$error.Req} {/if}
	
{/foreach}

</ul>
</div>
{/if}
{if $Messages}
<div id="messages">
<ul>
{foreach from=$Messages item=msg}
<li>{$msg}</li>
{/foreach}
</ul>
</div>
{/if}

{if !$UsersPage}<div>| <a href="{$StartLink}">Home</a> | <a href="{$StartLink}/ucenter/login/">Login</a> |
<a href="{$StartLink}/ucenter/register/">Register</a> |</div>
{/if}
<br>
{if  $Path}


	{include file="$Path"}

	{else}
	<hr>
<h2>Under reconstruction</h2>
	No page!
 
{/if}

{if $debug}
<div style="float:left"> 
	<h3>Common debug</h3>
	
		<ol>
		{foreach from=$DebugLog item=log}
			<li>{$log}</li>
		{/foreach}
		</ol>
	<hr>
	<h3>SQL debug</h3>
	
		<ol>
		{foreach from=$DebugSql item=sql}
			<li>{$sql}</li>
		{/foreach}
		</ol>
		
		<font color='red'>Generated {$generated} sec</font>
</div>	
{/if}
</div>
</body>
</html>