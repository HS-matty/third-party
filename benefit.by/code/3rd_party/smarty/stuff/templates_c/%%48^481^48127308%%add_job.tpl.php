<?php /* Smarty version 2.6.14, created on 2007-11-06 17:37:41
         compiled from z:/home/barefoot_zend/www/application/views/frontend/directory/add_job.tpl */ ?>
<?php if ($this->_tpl_vars['Type']): ?>
<div id="form_area">
<form method="POST" enctype="multipart/form-data"  id="add_form">

					<!-- InstanceBeginEditable name="content" -->
						<div id="postPage">
							<h3>Post an Ad</h3>
							Enter your information below to post a housing listing to San Diego <a href="javascript:;" id="changeLocation2" onclick="showLocationBubble('changeLocation2');" class="smallLink">[Change Location]</a>.
							Upon submitting, you will be sent an email with further instructions on how to edit or publish your listing.
							<br /><br />
							<h5>Contact Information</h5>
							<?php if ($this->_tpl_vars['User']->isLogined('RegisteredUser')): ?>
							<table width="100%" cellpadding="3" cellspacing="0">
	<tr>
								
									<td align="right" width="130">Name:</td>
									<td><?php echo $this->_tpl_vars['User']->UserData['first_name']; ?>
 <?php echo $this->_tpl_vars['User']->UserData['last_name']; ?>
</td>
								</tr>
								<tr>
								
									<td align="right" width="130">Email:</td>
									<td><?php echo $this->_tpl_vars['User']->UserData['email']; ?>
</td>
									<td width="10">
								 	<?php $this->assign('f', $this->_tpl_vars['Form']->getField('share_email')); ?>
									<input name ="share_email" value="2"
									<?php if (! $this->_tpl_vars['f']->isValidated || $this->_tpl_vars['f']->Value): ?> checked <?php endif; ?> 
									name ="isactive" type="checkbox"  /></td>
									
									<td class="smallText">Do not display on listing</td>
								</tr>
								<tr>
								
									<td align="right" width="130">Phone:</td>
									<td><?php echo $this->_tpl_vars['User']->UserData['phone_number']; ?>
</td>
									<td width="10">
								 	<?php $this->assign('f', $this->_tpl_vars['Form']->getField('share_phone')); ?>
									<input name ="share_phone" value="2"
									<?php if (! $this->_tpl_vars['f']->isValidated || $this->_tpl_vars['f']->Value): ?> checked <?php endif; ?> 
									name ="isactive" type="checkbox"  /></td>
									
									<td class="smallText">Do not display on listing</td>
								</tr>
								</table>
							
							
							<?php else: ?>
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
									<?php if (! $this->_tpl_vars['f']->isValidated || $this->_tpl_vars['f']->Value): ?> checked <?php endif; ?> 
									name ="isactive" type="checkbox"  /></td>
									
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
									<?php if (! $this->_tpl_vars['f']->isValidated || $this->_tpl_vars['f']->Value): ?> checked <?php endif; ?> 
									name ="isactive" type="checkbox"  /></td>
									
									<td class="smallText">Do not display on listing</td>
								</tr>
																<tr>
												<?php $this->assign('f', $this->_tpl_vars['Form']->getField('company_name')); ?>
									<td align="right">Company:</td>
									<td><input  value="<?php echo $this->_tpl_vars['f']->Value; ?>
" type="text" name="company_name" />
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
									<td align="right">Password:</td>
									<td width="150">
					<?php $this->assign('f', $this->_tpl_vars['Form']->getField('password1')); ?>
									<input type="password" size="30" name="password1" value="" />
										<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
									
									</td>
								
									<td width="10"></td></tr>
										<tr>
									<td align="right">Retype Password:</td>
									<td width="150">
					<?php $this->assign('f', $this->_tpl_vars['Form']->getField('password_retyped')); ?>
									<input type="password" size="30" name="password_retyped" value="" />
										<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
									
									</td>
								
									<td width="10"></td></tr>
							
							</table>
							<?php endif; ?>
							<br />
							<h5>Listing Information</h5>
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="50%" valign="top" style="padding-right: 10px;">

										<table width="100%" cellpadding="3" cellspacing="0">
											<tr>
												<td align="right" width="70">Category:*</td>
												<td><select name="category_id" style="width: 134px;">
<?php $_from = $this->_tpl_vars['Cats']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>

<?php if ($this->_tpl_vars['d']['clevel'] > 2): ?><option value="<?php echo $this->_tpl_vars['d']['category_id']; ?>
">&nbsp&nbsp&nbsp&nbsp <?php echo $this->_tpl_vars['d']['short_description']; ?>
</option><?php else: ?><option   value="<?php echo $this->_tpl_vars['d']['category_id']; ?>
" style="font-weight:bold; color:#000;"><?php echo $this->_tpl_vars['d']['short_description']; ?>
</option><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

</select></td>
											</tr>
											<tr>
				<?php $this->assign('f', $this->_tpl_vars['Form']->getField('short_description')); ?>
												<td align="right">Short Description:*</td>
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
												</td>
											</tr>

										</table>
									</td>
									<td valign="top">
										<table width="100%" cellpadding="3" cellspacing="0">
											<tr>
												<td align="right" width="200">Compensation:</td>
				<?php $this->assign('f', $this->_tpl_vars['Form']->getField('compensation')); ?>
												<td><input type="text" name="compensation" value="<?php echo $this->_tpl_vars['f']->Value; ?>
" size="10" />	<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?></td>
											</tr>

											<tr>
												<td align="right">Compensation Type:</td>
					<td>
													<select name="compensation_type">
						<?php $this->assign('f', $this->_tpl_vars['Form']->getField('compensation_type')); ?>

<option value="">none</option>
					<?php $_from = $this->_tpl_vars['f']->EnumList; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?><option value="<?php echo $this->_tpl_vars['e']; ?>
" <?php if ($this->_tpl_vars['e'] == $this->_tpl_vars['f']->Value): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']; ?>
</option><?php endforeach; endif; unset($_from); ?>
													</select>
												</td>
											</tr>
											<tr>
				<td align="right">Position Type:*</td>
					<td>
													<select name="position_type">
													<option value="">none</option>
						<?php $this->assign('f', $this->_tpl_vars['Form']->getField('position_type')); ?>

					<?php $_from = $this->_tpl_vars['f']->EnumList; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?><option value="<?php echo $this->_tpl_vars['e']; ?>
" <?php if ($this->_tpl_vars['e'] == $this->_tpl_vars['f']->Value): ?> selected <?php endif; ?> > <?php echo $this->_tpl_vars['e']; ?>
</option><?php endforeach; endif; unset($_from); ?>
													</select>
													
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

												<td align="right"></td>
												<td>
						</td>
											</tr>
											<tr>
												<td align="right"></td>
												<td>
												
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
												<td align="right" width="70" valign="top">Job Description:</td>
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
											
										
												<tr>
			<?php $this->assign('f', $this->_tpl_vars['Form']->getField('application_instructions')); ?>
												<td align="right" width="70" valign="top">Application Instructions:</td>
												<td><textarea name="application_instructions" style="width: 100%; height: 80px;"><?php echo $this->_tpl_vars['f']->Value; ?>
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
							
									<td valign="top">
										<h5>Tags</h5>
										<table width="100%" cellpadding="3" cellspacing="0">
											<tr>
												<td align="right" width="30">Tags:</td>
												
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
							
							<table border=0 style="padding:0">
							<tr style="vertical-align: middle;" height="50px">
								<td align="right">Code:</td>
						<td  >
						<?php $this->assign('f', $this->_tpl_vars['Form']->getField('captcha')); ?>
			<input style="vertical-align: middle;padding:0" type="text" name="captcha" size="10" value="" ></td><td>
			<img src="<?php echo $this->_tpl_vars['HostName']; ?>
/image.php" border=0 style="padding:0">
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
							</table><br>
						<!--	<input type="button" value="Post Ad" onCLick="postForm()"/>-->
						<input type="submit" name="go" value="Post Ad">
							</div>

						</div>
					<!-- InstanceEndEditable -->
					<input type="hidden" name="post" value="1">
					</form></DIV>
					
<?php else: ?>
<h3>Choose item type</h3>
<form method="get">
<select name="type" style="width:120px">
<?php $_from = $this->_tpl_vars['Types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['t']):
?>

<option value="<?php echo $this->_tpl_vars['t']['item_type_id']; ?>
"><?php echo $this->_tpl_vars['t']['item_type_title']; ?>
</option> 
<?php endforeach; endif; unset($_from); ?>
</select>
<br>
<input type="submit" value="choose">
</form>
<?php endif; ?>




	<script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/sarissa/sarissa.js"></script>
  <script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/sarissa/sarissa_dhtml.js"></script>


<?php echo '
<SCRIPT LANGUAGE="JavaScript">
<!--





function postForm(){


var PostItems = \'ajax=1\';


Form = document.getElementById(\'add_form\');




for (var i = 0; i < Form.length; i++) {

		if(Form[i].type!=\'button\')
        PostItems += \'&\' + Form[i].name + \'=\' + Form[i].value;
       
       
    }


var oDomDoc = Sarissa.getDomDocument();

'; ?>
var url = "<?php echo $this->_tpl_vars['StartLink']; ?>
/directory/add/?type=3";<?php echo '



//url += \'&value=\' + escape(ItemValue);
var xmlhttp =  new XMLHttpRequest();
xmlhttp.open("POST",url,true);

xmlhttp.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');



xmlhttp.onreadystatechange = function() {
   	 if (xmlhttp.readyState == 4) {
    
        	if(xmlhttp.status == 200){
    
   			 var form_area= document.getElementById(\'form_area\');
           	 if(xmlhttp.responseText == \'ok\'){

					 '; ?>
window.location="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/success/";<?php echo '
					 
				}else{
					form_area.innerHTML = xmlhttp.responseText;
			
				}
		}



	}
}

xmlhttp.send(PostItems);


 
}

// -->
</SCRIPT>
'; ?>