<?php /* Smarty version 2.6.14, created on 2007-11-06 13:45:59
         compiled from z:/home/barefoot_zend/www/application/views/frontend/directory/edit_house.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'z:/home/barefoot_zend/www/application/views/frontend/directory/edit_house.tpl', 200, false),)), $this); ?>

<div id="item" style="padding-left:10px">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['itemjs'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form method="POST" enctype="multipart/form-data" action="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/edititem/?item_id=<?php echo $this->_tpl_vars['item_id']; ?>
&sid=<?php echo $this->_tpl_vars['UserActions']->Sid; ?>
" name="form1">
	<?php $this->assign('f', $this->_tpl_vars['Form']->getField('listing_id')); ?>
	<input type="hidden" name="listing_id" value="<?php echo $this->_tpl_vars['f']->Value; ?>
">


					<!-- InstanceBeginEditable name="content" -->
						<div id="postPage">
							<h3>Edit an Ad</h3>
								<h5>Contact Information</h5>
							<table width="100%" cellpadding="3" cellspacing="0">
	<tr>
									<?php $this->assign('f', $this->_tpl_vars['Form']->getField('first_name')); ?>
									<td align="right" width="130">First Name:</td>
									<td><input value="<?php echo $this->_tpl_vars['f']->Value; ?>
" type="text" name="first_name" />	<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?></td>
								</tr>
								<tr>
																	<?php $this->assign('f', $this->_tpl_vars['Form']->getField('last_name')); ?>
									<td align="right">Last Name:</td>
									<td><input  value="<?php echo $this->_tpl_vars['f']->Value; ?>
" type="text" name="last_name" />
										<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?></td>
								</tr>
							

								<tr>
									<td align="right">Email:*</td>
									<td width="150">
					<?php $this->assign('f', $this->_tpl_vars['Form']->getField('email')); ?>
									<input type="text" size="30" name="email" value="<?php echo $this->_tpl_vars['f']->Value; ?>
" />
										<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
									
									</td>
								
									<td width="10">
								 	<?php $this->assign('f', $this->_tpl_vars['Form']->getField('share_email')); ?>
									<input name ="share_email" value="2"
									<?php if (! $this->_tpl_vars['f']->Value): ?> checked <?php endif; ?> 
									name ="share_name" type="checkbox"  /></td>
									
									<td class="smallText">Do not display on listing</td>
								</tr>
									
						 
								<tr>
									<?php $this->assign('f', $this->_tpl_vars['Form']->getField('phone_number')); ?>
									<td align="right">Phone:</td>

									<td width="150"><input value="<?php echo $this->_tpl_vars['f']->Value; ?>
" type="text" name="phone_number" /> <?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?></td>
	<td width="10">
								 	<?php $this->assign('f', $this->_tpl_vars['Form']->getField('share_phone')); ?>
									<input name ="share_phone" value="2"
									<?php if (! $this->_tpl_vars['f']->Value): ?> checked <?php endif; ?> 
									name ="share_phone" type="checkbox"  /></td>
									
									<td class="smallText">Do not display on listing</td>
								</tr>
							
							</table>
							<br />
						
						<h5>Listing Information</h5>
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="50%" valign="top" style="padding-right: 10px;">

										<table width="100%" cellpadding="3" cellspacing="0">
										<tr>
												<td align="right" width="70">Category:*</td>
												<td><select name="category_id" style="width: 134px;">
													<?php $this->assign('f', $this->_tpl_vars['Form']->getField('category_id')); ?>
<?php $_from = $this->_tpl_vars['Cats']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>

<?php if ($this->_tpl_vars['d']['clevel'] > 2): ?><option <?php if ($this->_tpl_vars['d']['category_id'] == $this->_tpl_vars['f']->Value): ?> selected <?php endif; ?> value="<?php echo $this->_tpl_vars['d']['category_id']; ?>
">&nbsp&nbsp&nbsp&nbsp <?php echo $this->_tpl_vars['d']['short_description']; ?>
</option><?php else: ?><option   value="<?php echo $this->_tpl_vars['d']['category_id']; ?>
" style="font-weight:bold; color:#000;" <?php if ($this->_tpl_vars['d']['category_id'] == $this->_tpl_vars['f']->Value): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['d']['short_description']; ?>
</option><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

</select></td>
											</tr>
										
											<tr>
				<?php $this->assign('f', $this->_tpl_vars['Form']->getField('short_description')); ?>
												<td align="right">Short description:*</td>
												<td><input type="text" name="short_description" size="40" value="<?php echo $this->_tpl_vars['f']->Value; ?>
"/>
													<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
												</td>
												
											</tr>

											<tr>
						<?php $this->assign('f', $this->_tpl_vars['Form']->getField('address')); ?>
												<td align="right">Address:*</td>
												<td><input type="text" name="address" value="<?php echo $this->_tpl_vars['f']->Value; ?>
" size="40" />
																									<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?></td>
											</tr>
											<tr>
							<?php $this->assign('f', $this->_tpl_vars['Form']->getField('city')); ?>
												<td align="right">City:*</td>
												<td><input type="text" name="city" value="<?php echo $this->_tpl_vars['f']->Value; ?>
" size="30" />
													<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
												</td>
											</tr>

											<tr>
		<?php $this->assign('f', $this->_tpl_vars['Form']->getField('state')); ?>
												<td align="right">State:*</td>
												<td><input type="text" name="state" value="<?php echo $this->_tpl_vars['f']->Value; ?>
" size="2" />
												
							<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
												</td>
											</tr>
											<tr>
			<?php $this->assign('f', $this->_tpl_vars['Form']->getField('zip')); ?>
												<td align="right">Zip:*</td>
												<td><input type="text" name="zip" size="10"  value="<?php echo $this->_tpl_vars['f']->Value; ?>
"/>
																		
							<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
												</td></tr>
												
												
											

										</table>
									</td>
									<td valign="top">
										<table width="100%" cellpadding="3" cellspacing="0">
											<tr>
												<td align="right" width="90">Bedrooms:*</td>
				<?php $this->assign('f', $this->_tpl_vars['Form']->getField('bedrooms')); ?>
												<td><input type="text" name="bedrooms" value="<?php echo $this->_tpl_vars['f']->Value; ?>
" size="3" />	<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?></td>
											</tr>

											<tr>
												<td align="right">Bathrooms:*</td>
				<?php $this->assign('f', $this->_tpl_vars['Form']->getField('bathrooms')); ?>
												<td><input type="text" name="bathrooms" value="<?php echo $this->_tpl_vars['f']->Value; ?>
" size="3" />
												<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>	
												</td>
											</tr>
											<tr>
			<?php $this->assign('f', $this->_tpl_vars['Form']->getField('square_footage')); ?>
												<td align="right">Square Feet:</td>
												<td><input type="text" name="square_footage" value="<?php echo $this->_tpl_vars['f']->Value; ?>
" size="10" />
						<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>	
												</td>
											</tr>

											<tr>
				<?php $this->assign('f', $this->_tpl_vars['Form']->getField('price')); ?>
												<td align="right">Price:*</td>
												<td><input type="text" name="price" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['f']->Value)) ? $this->_run_mod_handler('number_format', true, $_tmp) : smarty_modifier_number_format($_tmp)); ?>
" size="10" />
													<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>	
						</td>
											</tr>
										
										</table>
									</td>
								</tr>
								<tr>

									<td colspan="2">
										<table width="100%" cellpadding="3" cellspacing="0">
											<tr>
			<?php $this->assign('f', $this->_tpl_vars['Form']->getField('long_description')); ?>
												<td align="right" width="70" valign="top">Description:</td>
												<td><textarea name="long_description" style="width: 100%; height: 80px;"><?php echo $this->_tpl_vars['f']->Value; ?>
</textarea>		<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>	</td>
											</tr>
										</table>
									</td>

								</tr>
							</table>
							<br />
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="50%" valign="top" style="padding-right: 10px;">
										<h5>Images</h5>
										<table width="100%" cellpadding="3" cellspacing="0">

											<tr>
												<td align="right" width="60">Primary:</td>
												<td><input type="file" size="30" name="image1" />
													<?php $this->assign('f', $this->_tpl_vars['Form']->getField('image1')); ?>
												
												<?php if ($this->_tpl_vars['f']->FileType == 'image'): ?>
<?php if ($this->_tpl_vars['f']->Value): ?>
<div class="form_item_title"> 	<a href="<?php echo $this->_tpl_vars['HostName'];  echo $this->_tpl_vars['f']->FilePath;  echo $this->_tpl_vars['f']->Value; ?>
" target="_blank">View image</a> | Delete <input type="checkbox" name="<?php echo $this->_tpl_vars['f']->ID; ?>
_image_delete" value="checkbox" /></div>


<?php else: ?> no image loaded
<?php endif; ?>


<?php endif; ?>
												
												</td>
											</tr>
											<tr>
												<td align="right">Image 2:</td>
												<td>
												
												
												<input type="file" size="30" name="image2"/>	<?php $this->assign('f', $this->_tpl_vars['Form']->getField('image2')); ?>
												
	<?php if ($this->_tpl_vars['f']->FileType == 'image' && $this->_tpl_vars['f']->Value): ?>
<div class="form_item_title"> 	<a href="<?php echo $this->_tpl_vars['HostName'];  echo $this->_tpl_vars['f']->FilePath;  echo $this->_tpl_vars['f']->Value; ?>
" target="_blank">View image</a> | Delete <input type="checkbox" name="<?php echo $this->_tpl_vars['f']->ID; ?>
_image_delete" value="checkbox" /></div>
<?php else: ?> no image loaded
<?php endif; ?>



</td>
											</tr>

											<tr>
												<td align="right">Image 3:</td>
												<td><input type="file" size="30" name="image3"/>	<?php $this->assign('f', $this->_tpl_vars['Form']->getField('image3')); ?>
												
												<?php if ($this->_tpl_vars['f']->FileType == 'image'): ?>
	<?php if ($this->_tpl_vars['f']->Value): ?><div class="form_item_title"> 	<a href="<?php echo $this->_tpl_vars['HostName'];  echo $this->_tpl_vars['f']->FilePath;  echo $this->_tpl_vars['f']->Value; ?>
" target="_blank">View image</a> | Delete <input type="checkbox" name="<?php echo $this->_tpl_vars['f']->ID; ?>
_image_delete" value="checkbox" /></div>

<?php else: ?> no image loaded
<?php endif; ?>


<?php endif; ?></td>
											</tr>
											<tr>
												<td align="right">Image 4:</td>
												<td>
													
												<input type="file" size="30" name="image4"/><?php $this->assign('f', $this->_tpl_vars['Form']->getField('image4')); ?>
												
												<?php if ($this->_tpl_vars['f']->FileType == 'image'): ?>
	<?php if ($this->_tpl_vars['f']->Value): ?><div class="form_item_title"> 	<a href="<?php echo $this->_tpl_vars['HostName'];  echo $this->_tpl_vars['f']->FilePath;  echo $this->_tpl_vars['f']->Value; ?>
" target="_blank">View image</a> | Delete <input type="checkbox" name="<?php echo $this->_tpl_vars['f']->ID; ?>
_image_delete" value="checkbox" /></div>

<?php else: ?> no image loaded
<?php endif; ?>


<?php endif; ?></td>
											</tr>

										</table>
									</td>
									<td valign="top">
										<h5>Tags</h5>
										<table width="100%" cellpadding="3" cellspacing="0">
											<tr>
												<td align="right" width="30">Tags*:</td>
												
					<?php $this->assign('f', $this->_tpl_vars['Form']->getField('tags')); ?>
												<td><input type="text" name="tags" value="<?php echo $this->_tpl_vars['f']->Value; ?>
"size="51" />
												<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>	</td>

											</tr>
											<tr>
												<td colspan="2" class="smallText">
								
													<br />
													Tags are search keywords that make your listing easier to find.  Provide up 
													to five tags, separated by commas (e.g. loft, studio, beach, garage, yard).
												</td>
											</tr>
										</table>
									</td>

								</tr>
							</table>
							<br />
							<h5>&nbsp;</h5>
							<br />
							<div align="center">
							
				<input type="hidden" id="active_flag" name="active" value="0">
							<input type="hidden" name="view" value="view">
							</div>

						</div>
					<!-- InstanceEndEditable -->
					<input type="hidden" name="post" value="1">
					</form>
					</div>
					
<?php if (! $this->_tpl_vars['isajax']): ?>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/sarissa/sarissa.js"></script>
  <script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/sarissa/sarissa_dhtml.js"></script>

<?php echo '
<SCRIPT LANGUAGE="JavaScript">
<!--

var NextView = \'view\';

//document.getElementById(\'view\').innerHTML = NextView;

function changeView____(view){

Item = document.getElementById(\'item\');

'; ?>
var url = "<?php echo $this->_tpl_vars['StartLink']; ?>
/directory/edit_item/?type=3&ajax=1&item_id=<?php echo $this->_tpl_vars['item_id']; ?>
&sid=<?php echo $this->_tpl_vars['sid']; ?>
";<?php echo '

url += \'&view=\' + NextView;


var oDomDoc = Sarissa.getDomDocument();




var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("POST",url,true);

xmlhttp.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');



xmlhttp.onreadystatechange = function() {
   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
	  	
           	 Item.innerHTML = \'\';
			Item.innerHTML = xmlhttp.responseText;	if(NextView == \'view\') NextView = \'edit\';
else if(NextView == \'edit\') NextView = \'view\';
///document.getElementById(\'view\').innerHTML = NextView
			
			
		}



	}
}

xmlhttp.send();



}





// -->
</SCRIPT>
'; ?>


<?php endif; ?>