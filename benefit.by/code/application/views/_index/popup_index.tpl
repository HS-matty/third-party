<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$Title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="{$HostName}/3rd_party/sarissa/sarissa.js"></script>
  <script type="text/javascript" src="{$HostName}/3rd_party/sarissa/sarissa_dhtml.js"></script>
<link href="{$HostName}/design/style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$HostName}/design/ads.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$HostName}/design/forms.css" rel="stylesheet" type="text/css" media="screen" />
{literal}
<style type="text/css">
<!--
.inp3 {	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #6C6C6C;
	height: auto;
	width: 170px;
	margin-bottom:10px;
}
.txt {	color:#278823;
		font-size: 12px;
		font-family: Tahoma, Arial, Helvetica, sans-serif;
}
-->
</style>
{/literal}

</head>

<body>




{if  $Path}

	{include file="$Path"}


	{else}
	No page!
 
{/if}



{if $debug}
<div id="debug">
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
</body>
</html>

