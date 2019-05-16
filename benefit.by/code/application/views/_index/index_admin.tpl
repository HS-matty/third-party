<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />

<title>Admin area </title>
{literal}
<style type="text/css">
<!--

#window
{
	position: absolute;
	left: 200px;
	top: 100px;
	width: 400px;
	height: 300px;
	overflow: hidden;
	display: none;
}
#windowTop
{
	height: 30px;
	overflow: 30px;
	background-image: url({/literal}{$HostName}{literal}/images/window_top_end.png);
	background-position: right top;
	background-repeat: no-repeat;
	position: relative;
	overflow: hidden;
	cursor: move;
}
#windowTopContent
{
	margin-right: 13px;
	background-image:url({/literal}{$HostName}{literal}/images/window_top_start.png);
	background-position:left top;
	background-repeat: no-repeat;
	overflow: hidden;
	height: 30px;
	line-height: 30px;
	text-indent: 10px;
	font-family:Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
	color: #6caf00;
}
#windowMin
{
	position: absolute;
	right: 25px;
	top: 10px;
	cursor: pointer;
}
#windowMax
{
	position: absolute;
	right: 25px;
	top: 10px;
	cursor: pointer;
	display: none;
}
#windowClose
{
	position: absolute;
	right: 10px;
	top: 10px;
	cursor: pointer;
}
#windowBottom
{
	position: relative;
	height: 270px;
	background-image: url({/literal}{$HostName}{literal}/images/window_bottom_end.png);
	background-position: right bottom;
	background-repeat: no-repeat;
}
#windowBottomContent
{
	position: relative;
	height: 270px;
	background-image: url({/literal}{$HostName}{literal}/images/window_bottom_start.png);
	background-position: left bottom;
	background-repeat: no-repeat;
	margin-right: 13px;
}
#windowResize
{
	position: absolute;
	right: 3px;
	bottom: 5px;
	cursor: se-resize;
}
#windowContent
{
	position:absolute;
	top: 30px;
	left: 10px;
	width: auto;
	height: auto;
	overflow: auto;
	margin-right: 10px;
	border: 1px solid #6caf00;
	height: 255px;
	width: 375px;
	font-family:Arial, Helvetica, sans-serif;
	font-size: 11px;
	background-color: #fff;
}
#windowContent *
{
	margin: 10px;
}
.transferer2
{
	border: 1px solid #6BAF04;
	background-color: #B4F155;
	filter:alpha(opacity=30); 
	-moz-opacity: 0.3; 
	opacity: 0.3;
}

-->
</style>
{/literal}
<link href="{$HostName}/public/styles/styles.css" rel="stylesheet" type="text/css" />




 <script type="text/javascript" src="{$HostName}/3rd_party/jquery/jquery.js"></script> 
  <script type="text/javascript" src="{$HostName}/3rd_party/jquery/interface.js"></script> 
  <script type="text/javascript" src="{$HostName}/3rd_party/jquery/jquery.form.js"></script> 

</head>

<body >

<div id="container">
	<table cellpadding="0" cellspacing="0" >

		<tr>
			<td valign="top" id="leftColumn">
				<img src="{$HostName}/images/search_top_.gif">

<div id="post">
	<h4 class="blue"><a href="{$HostName}/admin/"></a></h4>
	{if $User->isLogined('AdminUser')}
	<ul>
	<li><a href="{$HostName}/admin/node/nodes/">Контент</a></li>
	<li><a href="{$HostName}/admin/banking/items/">Предложения</a></li>
		

		<li><a href="{$HostName}/admin/index/users/">Пользователи</a></li>
		<li><a href="{$HostName}/admin/banking/currencies/">Валюты</a></li>
		
		<li><a href="{$HostName}/admin/banking/purposes/">Цели кредита</a></li>

		<li><a href="{$HostName}/admin/index/logout/">Выход</a></li>
		
	</ul>
	{/if}
</div>	



		</td>
			<td id="main" width="100%">
							<div id="header"></div>
			
				
				<div {if $Page =='index'} id="content"{else} id="contentFull"{/if}> <!-- START CONTENT-->
				
				{if  $Path}
				
<div class="error_message" id="messageJS">{$Message}</div>

				<div id="item">
				{if $Actions}
				
					{foreach from=$Actions item=a}
						<a href="{$a.link->get()}">{$a.title}</a>&nbsp
				
					{/foreach}
				{/if}
				{include file="$Path"}
				</div>
				{else}
				No page!
				{/if}
					
				</div><!-- END CONTENT-->
			
				<div id="footer">
				
					Powered by <a target="_blank" href="http://www.radmaster.net/engine/">Radmaster engine</a>  based on <a href="http://framework.zend.com" target="_blank" >Zend Framework</a>
				</div>
			</td>
		</tr>
	</table>
</div>



			

		<br /><br /><br />

					</div><img src="{$HostName}/images/bottop_pic_02.gif" alt=""/>
					
					</div>
					
					






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
