 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />

<title>ResponData {if $Node} / {$Node.ct_title}{/if}</title> 
	<meta name="Keywords" content="" /> 
	<meta name="Description" content="" /> 
	<style type="text/css"> @import url("{$StartLink}/style/style.css");</style> 
	<script type="text/javascript"></script>
		

</head>

<body>



<div class="all">


<div class="header">


	<div class="menu-right">
		<a href="{$StartLink}"><img alt="" src="{$StartLink}/images/link-house.gif" /></a>
		<a href="#"><img alt="" src="{$StartLink}/images/link-map.gif" /></a>
		<a href="#"><img alt="" src="{$StartLink}/images/link-contact.gif" /></a>
	</div>

	<div class="menu">
	 <a href="{$StarLink}/leads/7/">leads</a> <a class="head-nelink"  href="#">|</a>
	 <a href="{$StarLink}/about_us/8/">about us</a> <a class="head-nelink"  href="#">|</a>
   <a href="{$StarLink}/software/9/">software</a> <a class="head-nelink"  href="#">|</a>
   <a href="{$StarLink}/data/10/">data </a> <a class="head-nelink"  href="#">|</a>
   <a href="{$StarLink}/sales/11/">sales </a> <a class="head-nelink"  href="#">|</a>
   <a href="{$StarLink}/seeekers/12/">seekers </a> <a class="head-nelink"  href="#">|</a>
   <a href="{$StarLink}/servises/13/">services</a>
	</div>
	
 	

</div><!-- header -->



<div class="content">
<table cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" valign="top">
		{if $Node}
		{$Node.ct_body}
		{/if}
		</td>
		
		<td rowspan="2" class="right-panel" valign="top">
			<div  style="margin-left: 2px;" class="right-bg">
		<h1>Lorem <span class="blue">ipsum</span></h1>
		<img src="{$StartLink}/images/photo02.jpg" alt="" /> <img src="{$StartLink}/images/photo03.jpg" alt="" />
		<p> Lorem ipsum dolor sit amet, 
magna aliquyam erat, sed diam vol
accusam et justo duo dolores et  rebum. </p>

<p> Stet clita kasd gubergren, no sea takima
ipsum dolor sit amet. Lorem ipsum dolor 
sadipscing elitr. </p>

<p> Ysed diam nonumy eirmod tempor invidunt
ut labore et dolore magna aliquyam erat, 
sed diam voluptua.</p>
		</div>
		
		</td>
	</tr>
	<tr>
		<td valign="top" colspan="2">
		<div class="foo">
			<div class="foo-top"> <a href="{$StarLink}/leads/7/">leads</a> |  <a href="{$StarLink}/about_us/8/">about us</a> |  <a href="{$StarLink}/software/9/">software</a> |  <a href="{$StarLink}/data/10/">data </a> |
   <a href="{$StarLink}/sales/11/">sales </a> |  <a href="{$StarLink}/seekers/12/">seekers </a> |  <a href="{$StarLink}/services/13/">services</a>
	 </div><div class="foo-bottom">Developed by: <a href="">http://moveyourweb.net</a> Copyrights © 2006 ResponData. </div></div></td></tr>
</table>
</div><!-- content -->

<div class="footer"><img src="{$StartLink}/images/footer.png" alt="" /></div>




</div> <!-- all -->
</body>
</html>
