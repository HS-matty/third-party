<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Barefoot Listings /  admin </title>
{literal}
<style type="text/css">
<!--

img { 
	behavior: url({/literal}{$HostName}{literal}/iepngfix.htc); 
}
div#map img {
behavior: none;
}
-->
</style>
{/literal}
<link href="{$HostName}/public/styles/BarefootStyles.css" rel="stylesheet" type="text/css" />






</head>

<body >

<div id="container">
	<table cellpadding="0" cellspacing="0" >

		<tr>
			<td valign="top" id="leftColumn">
				

<div id="post">
	<h4 class="blue"><a href="{$HostName}/admin/"><img border=0  src="{$HostName}/images/pin_small.gif" alt="Post" align="absmiddle" /></a>&nbsp;&nbsp;Admin</h4>
	{if $User->isLogined('AdminUser')}
	<ul>
		<li><a href="{$HostName}/admin/users/">Users</a></li>
		<li><a href="{$HostName}/admin/listings/">Listings</a></li>
		<li><a href="{$HostName}/admin/categories/">Categories</a></li>
		<li><a href="{$HostName}/admin/regions/">Regions</a></li>
		<li><a href="{$HostName}/oodle/">Oodle</a></li>
		<li><a href="{$HostName}/admin/logout/">Logout</a></li>
		
	</ul>
	{/if}
</div>	



		</td>
			<td id="main">
							<div id="header"><a href="{$HostName}/"><img src="{$HostName}/images/logo.gif" alt="Barefoot Listings" border="0" /></a><div id="tagline">Free San Diego Classifieds</div></div>
				<div id="location">San Diego <a href="javascript:;" id="changeLocation" onmouseover="showLocationBubble();" class="smallLink">[Change Location]</a></div>
				<div id="locationBubble" onmouseover = "this.style.display = ''" onmouseout = "this.style.display = 'none'" style="display: none;">
					<h3>Select a Location</h3>
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td valign="top">
						
							{foreach from=$Locations item=l}
							
				<a href="http://{$l.subdomain}.barefootlistings.com" class="smallLink">{$l.short_description}</a><br />
				
							{/foreach}
							</td>
						</tr>
					</table>
				</div>
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
					<a href="{$HostName}/page/terms_of_use/" class="smallLink">Terms of Use</a> |
					<a href="{$HostName}/page/faq/" class="smallLink">FAQ</a> |
					<a href="{$HostName}/page/privacy_policy/" class="smallLink">Privacy Policy</a> |
					<a href="{$HostName}/page/about_us/" class="smallLink">About Us</a> | 
					<a href="{$HostName}/page/contact/" class="smallLink">Contact Us </a>
					
					<br />
					&copy; 2007 Barefoot Solutions.  All rights reserved.
				</div>
			</td>
		</tr>
	</table>
</div>
{if $action == 'search'}

<script>
{literal}
function addFolderAjax_SearchPage(){
FolderName = document.getElementById('folder_name').value;
document.getElementById('folder_name').value = '';
var oDomDoc = Sarissa.getDomDocument();


{/literal}
var url="{$StartLink}/user/addfolder/?n=1&folder_name=" + FolderName; {literal}


//url += '&value=' + escape(ItemValue);
var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("GET",url,true);


xmlhttp.onreadystatechange = function() {

   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
    	
    	//	alert(loading);
    		loading=document.getElementById('loading');
    		loading.parentNode.removeChild(loading);
    		if( xmlhttp.responseText) {
    	
    		    document.getElementById('saveTo').innerHTML  = xmlhttp.responseText;

    			
    		}
    
  
   		}
			
			



	}

}
document.body.appendChild(loading);	
xmlhttp.send(null);

}
{/literal}
</script>



				<div id="saveBubble" style=" display: none; padding-bottom:0px; position: absolute; background-image:url({$HostName}/images/bg_02.gif); background-repeat:repeat-y; width:261px" onmouseover = "this.style.display = ''" onmouseout = "this.style.display = 'none'"  >
	<div style="background-image:url({$HostName}/images/top_pic_01.gif); background-repeat:no-repeat; background-position:top; padding:20px 45px 20px 35px; width:181px ">

				<div id="saveTo">
								<h3>Save to:</h3>
								
								{foreach from=$User->Searches->getFolders() item=f}
									&nbsp;&nbsp;<a href="javascript:;" onclick="saveItemToFav({$f.search_id});hideDiv('saveBubble')">{$f.short_description}</a><br />
								{/foreach}
								
							
								&nbsp;&nbsp;<a href="javascript:;" onclick="showDiv('saveToNew'); hideDiv('saveTo');">New ...</a>
							</div>
							<div id="saveToNew" style="display: none;">
								<h3>Save to New Search</h3>
								New Search Name:<br />
								<input type="text" id="folder_name" size="19" /><br />
								<input type="button" value="Save" onclick="addFolderAjax_SearchPage();hideDiv('saveToNew'); showDiv('saveTo');"/> 
								<input type="button" value="Cancel" onclick="hideDiv('saveToNew'); showDiv('saveTo');" />
							</div>				

		<br /><br /><br />

					</div><img src="{$HostName}/images/bottop_pic_02.gif" alt=""/>
					
					</div>
					
					




	<div id="saveBubble_" style="display: none;">
							<div id="saveTo">
								<h3>Save to:</h3>
								{foreach from=$User->Searches->getFolders() item=f}
									&nbsp;&nbsp;<a href="javascript:;" onclick="saveItemToFav({$f.search_id})">{$f.short_description}</a><br />
								{/foreach}
							
								&nbsp;&nbsp;<a href="javascript:;" onclick="showDiv('saveToNew'); hideDiv('saveTo');">New ...</a>
							</div>
							<div id="saveToNew" style="display: none;">
								<h3>Save to New Search</h3>
								New Search Name:<br />
								<input type="text" size="19" /><br />
								<input type="button" value="Save" /> 
								<input type="button" value="Cancel" onclick="hideDiv('saveToNew'); showDiv('saveTo');" />
							</div>
	</div>
{/if}					
	{if !$UserActions->IsAuth}
						<div id="flagBubble" onmouseover = "this.style.display = ''" onmouseout = "this.style.display = 'none'" style="display: none;">
						<h3>Flag as:</h3>
		<a href="#" onclick="flag(listing_id,'Misclassified')">Misclassified</a><br />
						<a href="#" onclick="flag(listing_id,'Forbidden')">Forbidden</a><br />
						<a href="#" onclick="flag(listing_id,'Spam')">Spam</a>
					</div>
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

<div id="notactive_message" style="display:none">
You must confirm your email address before you may login. Please check your inbox or your spam folder for the account verification email, or click <a onClick="window.open('{$HostName}/auth/resend/','Resend registration data','width=600,height=300,left=400,top=300')"    href="#">here to resend</a>.'; 
</div>
</body>
</html>
