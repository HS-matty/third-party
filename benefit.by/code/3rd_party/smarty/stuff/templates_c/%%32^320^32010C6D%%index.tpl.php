<?php /* Smarty version 2.6.14, created on 2007-11-02 23:52:43
         compiled from z:/home/barefoot_zend/www/application/views/frontend/_index/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'z:/home/barefoot_zend/www/application/views/frontend/_index/index.tpl', 531, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Barefoot Listings</title>
<?php echo '
<style type="text/css">
<!--

img { 
	behavior: url(';  echo $this->_tpl_vars['HostName'];  echo '/iepngfix.htc); 
}
div#map img {
behavior: none;
}
-->
</style>
'; ?>

<link href="<?php echo $this->_tpl_vars['HostName']; ?>
/public/styles/BarefootStyles.css" rel="stylesheet" type="text/css" />





<script src="<?php echo $this->_tpl_vars['HostName']; ?>
/public/scripts/common.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['HostName']; ?>
/public/scripts/prototype.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['HostName']; ?>
/public/scripts/scriptaculous.js?load=effects,controls" language="javascript" type="text/javascript"></script>


	<script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/sarissa/sarissa.js"></script>
  <script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/sarissa/sarissa_dhtml.js"></script>

<?php echo '
<SCRIPT LANGUAGE="JavaScript">
<!--
 var loading = document.createElement(\'div\'); 
 
  loading.id = \'loading\'; 
 
  loading.style.position = \'absolute\'; 
 
  loading.style.fontSize = \'12px\'; 
 
     loading.style.fontWeight = \'bold\'; 
 
     loading.style.color = \'#000\'; 
 
     loading.style.background = \'#E6E6E6\'; 
 
     loading.style.top = \'50%\' 
 
     loading.style.left = \'50%\' 
 
     loading.style.marginLeft=\'-45px\' 
 
     loading.style.marginTop = \'-70px\' 
 
     //loading.style.width = \'170px\'; 
 
     loading.style.padding = \'10px 20px\'; 
 
     loading.style.border = \'1px solid #333\'; 
 
     loading.style.zIndex = \'200\'; 
 
     loading.innerHTML = \'Please wait! Loading...\';


function saveItemToFav(folder_id){


var oDomDoc = Sarissa.getDomDocument();

'; ?>


var url="<?php echo $this->_tpl_vars['StartLink']; ?>
/user/saveListingToFav/?listing_id=" + add_listing_id + '&folder_id=' + folder_id; <?php echo '


//url += \'&value=\' + escape(ItemValue);
var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("GET",url,true);


xmlhttp.onreadystatechange = function() {
   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
    		loading=document.getElementById(\'loading\');
    		loading.parentNode.removeChild(loading);
    			document.getElementById(\'my_searches_link\').style.display=\'block\';
    
   			 //xmlhttp.responseText;

   		}
			
			



	}

}
	document.body.appendChild(this.loading);	
xmlhttp.send(null);






}
function forgot_password(){
//leftVal = - ((800 - screen.width) / 2);
//topVal =  - ((500 - screen.height) / 2);
leftVal = \'400\';
topVal = \'200\';


'; ?>


//window.open('<?php echo $this->_tpl_vars['HostName']; ?>
/auth/forgot_password/','Forgot Password','width=600,height=300','width=600,height=300,left='+leftVal+',top='+topVal);	
//alert('width=600,height=300,left='+leftVal+',top='+topVal);
alert('zz');
	
	
<?php echo '

}
function flag(ListingId,flagStr){



var oDomDoc = Sarissa.getDomDocument();

'; ?>


var url="<?php echo $this->_tpl_vars['StartLink']; ?>
/directory/flag/?listing_id=" + ListingId + "&type=" + flagStr; <?php echo '


//url += \'&value=\' + escape(ItemValue);
var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("GET",url,true);


xmlhttp.onreadystatechange = function() {
   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
    		loading=document.getElementById(\'loading\');
    		loading.parentNode.removeChild(loading);	
    
   			 var message = document.getElementById(\'messageJS\');
   			 message.innerHTML = xmlhttp.responseText;
   			 var link = document.getElementById(\'flagLink\');
   			 link.innerHTML = "[Flagged]";
   			 link.onmouseover  = "";
   			 
   		}
			
			



	}

}
	document.body.appendChild(this.loading);	
xmlhttp.send(null);


 
}

function init(){
'; ?>


<?php if ($this->_tpl_vars['User']->isLogined('RegisteredUser')): ?>

	 showDiv('yourAccount'); 
   	 hideDiv('login');
   	 var name = '<?php echo $this->_tpl_vars['User']->UserData['first_name']; ?>
';
   	 document.getElementById('user_name').innerHTML = 'Welcome ' + name;

<?php else: ?>

	 showDiv('login'); 
   	 hideDiv('yourAccount');

<?php endif; ?>

<?php if ($this->_tpl_vars['map']): ?> onLoad(); <?php endif; ?>

<?php echo '



}


function login(){


//showDiv(\'yourAccount\'); hideDiv(\'login\')
var oDomDoc = Sarissa.getDomDocument();
var Login = document.getElementById(\'username\').value;
var Pass = document.getElementById(\'password\').value;


'; ?>


var url="<?php echo $this->_tpl_vars['StartLink']; ?>
/auth/login/?login=" + Login + "&password=" + Pass; <?php echo '


//url += \'&value=\' + escape(ItemValue);
var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("GET",url,true);

var name= \'z\';
xmlhttp.onreadystatechange = function() {
   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
    		loading=document.getElementById(\'loading\');
    		loading.parentNode.removeChild(loading);	
    
   			 //var message = document.getElementById(\'messageJS\');
   			 if(xmlhttp.responseText == \'ok\') {
   			 
   			 showDiv(\'yourAccount\'); 
   			 hideDiv(\'login\');
   				getUserName();
   			
   			
   			 
   			 
   			 }else if(xmlhttp.responseText == \'not_active\'){
   		 document.getElementById(\'login_message\').innerHTML = document.getElementById(\'notactive_message\').innerHTML;
   			 }
   			 else document.getElementById(\'login_message\').innerHTML = \'wrong login or password\'; 
   	//		 var link = document.getElementById(\'flagLink\');
   	//		 link.innerHTML = "[Flagged]";
   	//		 link.onmouseover  = "";
   			 
   		}
			
			
   	


	}

}
document.body.appendChild(this.loading);	
xmlhttp.send(null);


 
}

function getUserName(){

var oDomDoc = Sarissa.getDomDocument();



'; ?>


var url="<?php echo $this->_tpl_vars['StartLink']; ?>
/auth/get_user_data/?field=first_name"; <?php echo '


//url += \'&value=\' + escape(ItemValue);
var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("GET",url,true);


xmlhttp.onreadystatechange = function() {
   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
    

				
				 document.getElementById(\'user_name\').innerHTML = \'Welcome \' + xmlhttp.responseText;
			}



	}

}
xmlhttp.send(null);



}




var global_listing_id   = '; ?>
'<?php echo $this->_tpl_vars['Item']['listing_id']; ?>
';<?php echo '

function sendMessage(listing_id, not_usePostfix){



var oDomDoc = Sarissa.getDomDocument();

'; ?>


if(!listing_id) listing_id = global_listing_id;
else global_listing_id =  listing_id;

var postfix = '';
if(listing_id) postfix = listing_id;
var url="<?php echo $this->_tpl_vars['StartLink']; ?>
/directory/item/?item_id=" + listing_id + "&form=1"; <?php echo '

if(not_usePostfix) postfix = \'\';
var nameTitle = \'name\' + postfix;
var NameObj = document.getElementById(nameTitle);
var Name = nameTitle.value;
var emailTitle = \'email\' + postfix;
var messageTitle  = \'message\' + postfix;
var securityTitle = \'security\' + postfix;

var Email= document.getElementById(emailTitle).value;
var Message = document.getElementById(messageTitle).value;
var Security= document.getElementById(securityTitle).value;

//url += \'&value=\' + escape(ItemValue);
var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("POST",url,true);

xmlhttp.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');



xmlhttp.onreadystatechange = function() {
   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
        	loading=document.getElementById(\'loading\');
    		loading.parentNode.removeChild(loading);
    		
   			 var res= document.getElementById(\'response\'+ global_listing_id);
   			 var popup_message=  document.createElement("div");	
   			 
           			 

					if(xmlhttp.responseText == \'ok\'){
							document.forms.contact.reset();
							popup_message.innerHTML = \'Your message has been sent!<br>\';
					} else popup_message.innerHTML = xmlhttp.responseText + \'<br>\';
					res.innerHTML = \'\';
					res.appendChild(popup_message);
			}



	}
}

	document.body.appendChild(this.loading);

xmlhttp.send(\'name=\' + Name + \'&email=\' + Email + \'&message=\' +Message + \'&security=\' + Security);


return false;
 
}


function refreshFolderList(){



}
function addSearchFolder(folder_name){



var oDomDoc = Sarissa.getDomDocument();

'; ?>


var url="<?php echo $this->_tpl_vars['StartLink']; ?>
/user/addfolder/?folder_name=" + folder_name; <?php echo '



//url += \'&value=\' + escape(ItemValue);
var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("GET",url,true);

xmlhttp.onreadystatechange = function() {
   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
        	loading=document.getElementById(\'loading\');
    		loading.parentNode.removeChild(loading);
    		
   			
   			  	 	
           			if(xmlhttp.responseText == \'ok\'){

					}
			}



	}
}
	document.body.appendChild(this.loading);
xmlhttp.send();


 
}


 -->
</SCRIPT>




'; ?>


<?php if ($this->_tpl_vars['map']): ?>

   <?php echo $this->_tpl_vars['map']->printHeaderJS(); ?>

   <?php echo $this->_tpl_vars['map']->printMapJS(); ?>



<?php endif; ?>

<script>


<?php echo '
function showSmallWindow(id,div){

win = document.getElementById(\'listing\' + id + \'_small_popup\');
if(!win) return false;

	win.style.left = getLeft(div) + Element.getWidth(div) - 5 + "px";

	win.style.top = getTop(div) + Element.getHeight(div) - 78 + "px";

	win.style.left = 30;
	win.style.top = 30;
	win.style.position = \'absolute\';

	win.style.display = "";

}


function insertNewText(point,id){ 
		var html = document.getElementById(id);


		if(!html) return;
		html = html.innerHTML;
         map.closeInfoWindow();
       //  var gS = GSize(-500, -400);
         map.openInfoWindowHtml(eval(\'new GLatLng\'+point),html);
         var center  = map.getCenter();
         lat = center.lat();
         lng = center.lng();
  		map.panTo(new GLatLng(lat - 5, lng));
         
    }

function forceScrollBottom_alt(div){
	var _div = div.parent.parent.parent.parent;
	alert(_div.id);
	
}
function forceScrollBottom(divName)
{
var mydiv = document.getElementById(divName);
//var mydiv = document.evaluate(\'//divName\', document, null, XPathResult.ANY_TYPE, null ).iterateNext();

//var debug = "ScrollTop: " + mydiv.scrollTop;
for (i = 50; i < mydiv.scrollHeight; i += 50)
{
var tmp = mydiv.scrollTop;
// pre-store scrollTop
mydiv.scrollTop += i;
// update scrollTop
if (tmp == mydiv.scrollTop)
{
break;
}
//debug += i + "ScrollTop: " + mydiv.scrollTop + "\\n";
}
//alert(debug);
}
 
'; ?>
  
</script>

<?php if ($this->_tpl_vars['Config']->Environment == 'prod'): ?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2737603-1";
_udn="barefootlistings.com";
urchinTracker();
</script>
<?php endif; ?>

</head>

<body onload="init()" >

<div id="container">
	<table cellpadding="0" cellspacing="0" 
	<?php if ($this->_tpl_vars['Page'] != 'index'): ?> width="100%" <?php endif; ?>>
		<tr>
			<td valign="top" id="leftColumn">
				<div id="search">
	<form action="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/search/" method="get">
		<h4 class="blue">Search</h4>
		<input type="text" style="width: 130px;" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['GET']['search'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"name="search" />
		<br /><br />
			<select name="cid" style="width: 134px;">

	
<?php $_from = $this->_tpl_vars['Tree']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['flevel']):
?>
<option value="<?php echo $this->_tpl_vars['flevel']['k_item']; ?>
" <?php if ($this->_tpl_vars['cid'] == $this->_tpl_vars['flevel']['k_item']): ?> selected <?php endif; ?>>><?php echo $this->_tpl_vars['flevel']['s_name']; ?>
</option>
	<?php if ($this->_tpl_vars['flevel']['a_tree']): ?>
	<?php $_from = $this->_tpl_vars['flevel']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['slevel']):
?>
	<option value="<?php echo $this->_tpl_vars['slevel']['k_item']; ?>
" class="sub" <?php if ($this->_tpl_vars['cid'] == $this->_tpl_vars['slevel']['k_item']): ?> selected <?php endif; ?>>&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['slevel']['s_name']; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
	<?php endif;  endforeach; endif; unset($_from); ?>



</select>		<br /><br />
		<div align="center"><input type="submit" value="Search" /></div>
	</form>	
</div><div id="post">
	<h4 class="blue"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/pin_small.gif" alt="Post" align="absmiddle" />&nbsp;&nbsp;Post Ad to...</h4>
	<ul>
		<li><a href="<?php echo $this->_tpl_vars['StartLink']; ?>
/directory/add/?type=2">Housing</a></li>
		<li><a href="<?php echo $this->_tpl_vars['StartLink']; ?>
/directory/add/?type=1">Items for Sale</a></li>
		<li><a href="<?php echo $this->_tpl_vars['StartLink']; ?>
/directory/add/?type=3">Jobs</a></li>
	</ul>
</div>	
<div id="login" style="display: block;">
	<h4 class="blue">Login</h4>
	<div id="login_message" style="color:#ff0000"></div>
	<form action="" method="post">
		Email:<br>
		<input style="width: 130px;" id="username" name="username" type="text">

		<br>
		Password:<br>
		<input style="width: 130px;" id="password" name="password" type="password">
		<br>
		<div align="center"><input value="Login" class="button" onclick="login()" id="login_button" name="login_button" type="button"></div>
	
		<div id="my_searches_link"	<?php if ($this->_tpl_vars['User']->isLogined('FrontendUser') && $this->_tpl_vars['User']->Searches->hasListingSearches()): ?> style="display:block"<?php else: ?> style="display:none"<?php endif; ?>>
		<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/user/my_searches/" class="smallLink">My Searches</a><br>
		</div>
	
		<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/auth/register/" class="smallLink">Register</a><br>
		<a href="#" onClick="window.open('<?php echo $this->_tpl_vars['HostName']; ?>
/auth/forgot_password/','Forgot My Password','width=600,height=300,left=400,top=300')" class="smallLink">Forgot My Password</a>
	</form>	

</div>
<div id="yourAccount" style="display: none;">
	<h4 class="blue" id="user_name"></h4>
	<ul>
		<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/user/my_postings/">My Postings</a></li>
		<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/user/my_searches/">My Searches</a></li>
		<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/auth/my_account/">My Account</a></li>
		<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/auth/logout/">Logout</a></li>

	</ul>
</div>
		</td>
			<td id="main">
							<div id="header"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/logo.gif" alt="Barefoot Listings" border="0" /></a><div id="tagline">Free San Diego Classifieds</div></div>
				<div id="location">San Diego <a href="javascript:;" id="changeLocation" onmouseover="showLocationBubble();" class="smallLink">[Change Location]</a></div>
				<div id="locationBubble" onmouseover = "this.style.display = ''" onmouseout = "this.style.display = 'none'" style="display: none;">
					<h3>Select a Location</h3>
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td valign="top">
						
							<?php $_from = $this->_tpl_vars['Locations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['l']):
?>
							
				<a href="http://<?php echo $this->_tpl_vars['l']['subdomain']; ?>
.barefootlistings.com" class="smallLink"><?php echo $this->_tpl_vars['l']['short_description']; ?>
</a><br />
				
							<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
					</table>
				</div>
				<div <?php if ($this->_tpl_vars['Page'] == 'index'): ?> id="content"<?php else: ?> id="contentFull"<?php endif; ?>> <!-- START CONTENT-->
				
				<?php if ($this->_tpl_vars['Path']): ?>
				
<div class="error_message" id="messageJS"><?php echo $this->_tpl_vars['Message']; ?>
</div>

				<div id="item">
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
					<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/page/terms_of_use/" class="smallLink">Terms of Use</a> |
					<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/page/faq/" class="smallLink">FAQ</a> |
					<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/page/privacy_policy/" class="smallLink">Privacy Policy</a> |
					<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/page/about_us/" class="smallLink">About Us</a> | 
					<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/page/contact/" class="smallLink">Contact Us </a>
					
					<br />
					&copy; 2007 Barefoot Solutions.  All rights reserved.
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