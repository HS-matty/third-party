<?php /* Smarty version 2.6.14, created on 2008-01-04 16:19:35
         compiled from z:/home/benefitby/www/application/views/_index/index_admin.tpl */ ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />

<title>Barefoot Listings /  admin </title>
<?php echo '
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
	background-image: url(';  echo $this->_tpl_vars['HostName'];  echo '/images/window_top_end.png);
	background-position: right top;
	background-repeat: no-repeat;
	position: relative;
	overflow: hidden;
	cursor: move;
}
#windowTopContent
{
	margin-right: 13px;
	background-image:url(';  echo $this->_tpl_vars['HostName'];  echo '/images/window_top_start.png);
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
	background-image: url(';  echo $this->_tpl_vars['HostName'];  echo '/images/window_bottom_end.png);
	background-position: right bottom;
	background-repeat: no-repeat;
}
#windowBottomContent
{
	position: relative;
	height: 270px;
	background-image: url(';  echo $this->_tpl_vars['HostName'];  echo '/images/window_bottom_start.png);
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
'; ?>

<link href="<?php echo $this->_tpl_vars['HostName']; ?>
/public/styles/BarefootStyles.css" rel="stylesheet" type="text/css" />




 <script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/jquery/jquery.js"></script> 
  <script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/jquery/interface.js"></script> 
  <script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/jquery/jquery.form.js"></script> 

</head>

<body >

<div id="container">
	<table cellpadding="0" cellspacing="0" >

		<tr>
			<td valign="top" id="leftColumn">
				<img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/search_top_.gif">

<div id="post">
	<h4 class="blue"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/"><img border=0  src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/pin_small.gif" alt="Post" align="absmiddle" /></a>&nbsp;&nbsp;Admin</h4>
	<?php if ($this->_tpl_vars['User']->isLogined('AdminUser')): ?>
	<ul>
	<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/node/nodes/">Контент</a></li>
		<!-- li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/index/users/">Users</a></li>
		<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/index/listings/">Listings</a></li>
		
		<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/index/regions/">Regions</a></li-->

		<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/index/logout/">Logout</a></li>
		
	</ul>
	<?php endif; ?>
</div>	



		</td>
			<td id="main">
							<div id="header"></div>
			
				
				<div <?php if ($this->_tpl_vars['Page'] == 'index'): ?> id="content"<?php else: ?> id="contentFull"<?php endif; ?>> <!-- START CONTENT-->
				
				<?php if ($this->_tpl_vars['Path']): ?>
				
<div class="error_message" id="messageJS"><?php echo $this->_tpl_vars['Message']; ?>
</div>

				<div id="item">
				<?php if ($this->_tpl_vars['Actions']): ?>
				
					<?php $_from = $this->_tpl_vars['Actions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a']):
?>
						<a href="<?php echo $this->_tpl_vars['a']['link']->get(); ?>
"><?php echo $this->_tpl_vars['a']['title']; ?>
</a>&nbsp
				
					<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['Path']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
				<?php else: ?>
				No page!
				<?php endif; ?>
					
				</div><!-- END CONTENT-->
			
				<div id="footer">
				
					Powered by <a target="_blank" href="http://www.radmaster.net/engine/">Radmaster engine</a>  based on <a href="http://framework.zend.com" target="_blank" >Zend Framework</a>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php if ($this->_tpl_vars['action'] == 'search'): ?>

<script>
<?php echo '
function addFolderAjax_SearchPage(){
FolderName = document.getElementById(\'folder_name\').value;
document.getElementById(\'folder_name\').value = \'\';
var oDomDoc = Sarissa.getDomDocument();


'; ?>

var url="<?php echo $this->_tpl_vars['StartLink']; ?>
/user/addfolder/?n=1&folder_name=" + FolderName; <?php echo '


//url += \'&value=\' + escape(ItemValue);
var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("GET",url,true);


xmlhttp.onreadystatechange = function() {

   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
    	
    	//	alert(loading);
    		loading=document.getElementById(\'loading\');
    		loading.parentNode.removeChild(loading);
    		if( xmlhttp.responseText) {
    	
    		    document.getElementById(\'saveTo\').innerHTML  = xmlhttp.responseText;

    			
    		}
    
  
   		}
			
			



	}

}
document.body.appendChild(loading);	
xmlhttp.send(null);

}
'; ?>

</script>



				<div id="saveBubble" style=" display: none; padding-bottom:0px; position: absolute; background-image:url(<?php echo $this->_tpl_vars['HostName']; ?>
/images/bg_02.gif); background-repeat:repeat-y; width:261px" onmouseover = "this.style.display = ''" onmouseout = "this.style.display = 'none'"  >
	<div style="background-image:url(<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_pic_01.gif); background-repeat:no-repeat; background-position:top; padding:20px 45px 20px 35px; width:181px ">

				<div id="saveTo">
								<h3>Save to:</h3>
								
								<?php $_from = $this->_tpl_vars['User']->Searches->getFolders(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
									&nbsp;&nbsp;<a href="javascript:;" onclick="saveItemToFav(<?php echo $this->_tpl_vars['f']['search_id']; ?>
);hideDiv('saveBubble')"><?php echo $this->_tpl_vars['f']['short_description']; ?>
</a><br />
								<?php endforeach; endif; unset($_from); ?>
								
							
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

					</div><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/bottop_pic_02.gif" alt=""/>
					
					</div>
					
					




	<div id="saveBubble_" style="display: none;">
							<div id="saveTo">
								<h3>Save to:</h3>
								<?php $_from = $this->_tpl_vars['User']->Searches->getFolders(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
									&nbsp;&nbsp;<a href="javascript:;" onclick="saveItemToFav(<?php echo $this->_tpl_vars['f']['search_id']; ?>
)"><?php echo $this->_tpl_vars['f']['short_description']; ?>
</a><br />
								<?php endforeach; endif; unset($_from); ?>
							
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
<?php endif; ?>					
	<?php if (! $this->_tpl_vars['UserActions']->IsAuth): ?>
						<div id="flagBubble" onmouseover = "this.style.display = ''" onmouseout = "this.style.display = 'none'" style="display: none;">
						<h3>Flag as:</h3>
		<a href="#" onclick="flag(listing_id,'Misclassified')">Misclassified</a><br />
						<a href="#" onclick="flag(listing_id,'Forbidden')">Forbidden</a><br />
						<a href="#" onclick="flag(listing_id,'Spam')">Spam</a>
					</div>
<?php endif; ?>


<?php if ($this->_tpl_vars['debug']): ?>
<div id="debug">
	<h3>Common debug</h3>
	
		<ol>
		<?php $_from = $this->_tpl_vars['DebugLog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['log']):
?>
			<li><?php echo $this->_tpl_vars['log']; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
		</ol>
	<hr>
	<h3>SQL debug</h3>
	
		<ol>
		<?php $_from = $this->_tpl_vars['DebugSql']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sql']):
?>
			<li><?php echo $this->_tpl_vars['sql']; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
		</ol>
		
		<font color='red'>Generated <?php echo $this->_tpl_vars['generated']; ?>
 sec</font>
</div>
	
<?php endif; ?>

<div id="notactive_message" style="display:none">
You must confirm your email address before you may login. Please check your inbox or your spam folder for the account verification email, or click <a onClick="window.open('<?php echo $this->_tpl_vars['HostName']; ?>
/auth/resend/','Resend registration data','width=600,height=300,left=400,top=300')"    href="#">here to resend</a>.'; 
</div>
</body>
</html>