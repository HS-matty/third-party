<?php /* Smarty version 2.6.14, created on 2008-02-25 13:25:33
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/admin/nodes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'Z:\\home\\benefitby\\www/application/views/admin/nodes.tpl', 30, false),)), $this); ?>
﻿	<p> <a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/node/nodes/?node_id=1">Root </a> 
<?php $_from = $this->_tpl_vars['TreePath']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/node/nodes/?node_id=<?php echo $this->_tpl_vars['p']['category_id']; ?>
"><?php echo $this->_tpl_vars['p']['short_description']; ?>
 </a> / 
<?php endforeach; endif; unset($_from); ?>
</p>
<table width="100%" cellpadding="3" cellspacing="0">
									<tr>
										<td colspan="7" class="tableHeading">Категории</td>
									</tr>
		</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['View']->getIndexTmpl('grid_small.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form id="test" method="post" action="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/node/listings/" >

<input type="hidden" name="page" value="" id="page">
<input type="hidden" name="post" value=1>
<table width="100%" cellpadding="3" cellspacing="0" border="0">
									<tr>
										<td colspan="7" class="tableHeading"></td>
									</tr>
									<!-- tr>
										<td width="60">Category:</td>
										<td width="180"></td>
										
										
										
										
										<td width="60">Email</td>
										<td width="100">
<input type="text" name="email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['Params']['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
										</td>
										<td width="75"></td>
										<td></td>
									</tr -->
									<!-- tr>
									
										<td>Flag:</td>
										<td><select name="flag">
						<option value="none" selected="selected">none</option>
					<option <?php if ($this->_tpl_vars['Params']['flag'] == 'misclassified'): ?> selected <?php endif; ?> value="misclassified">misclassified</option>
					<option <?php if ($this->_tpl_vars['Params']['flag'] == 'forbidden'): ?> selected <?php endif; ?> value="forbidden">forbidden</option>
					<option <?php if ($this->_tpl_vars['Params']['flag'] == 'spam'): ?> selected <?php endif; ?>>spam</option>
										</select></td>
										<td></td>
										<td>

										</td>
										<td></td>
										<td width="100"></td>
										<td><input type="submit" value="Search" /></td>
									</tr -->
								</table>
								
								</form>
<div id="listings">

</div>


<?php echo '
<!-- a href="#" id="windowOpen">Open window</a -->
<div id="window">
	<div id="windowTop">
		<div id="windowTopContent">Window example</div>
		<img src="/images/window_min.jpg" id="windowMin" />
		<img src="/images/window_max.jpg" id="windowMax" />
		<img src="/images/window_close.jpg" id="windowClose" />
	</div>
	<div id="windowBottom"><div id="windowBottomContent">&nbsp;</div></div>

	<div id="windowContent"><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut eget  lectus in diam iaculis tempor. Suspendisse consectetuer, 
	</div>
	<img src="/images/window_resize.gif" id="windowResize" />
</div>


<div id="output1">


</div>


<script type="text/javascript">



$("#listings").load("';  echo $this->_tpl_vars['HostName'];  echo '/admin/node/listings",{'; ?>
cid: <?php echo $this->_tpl_vars['cid']; ?>
,post:1<?php echo '});

	

$(document).ready(


	function()
	{
	
		
	
	 var options = { 
        target:        \'#listings\',   // target element(s) to be updated with server response 
        beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form\'s \'action\' attribute 
        //type:      type        // \'get\' or \'post\', override for form\'s \'method\' attribute 
        //dataType:  null        // \'xml\', \'script\', or \'json\' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
 
    // bind form using \'ajaxForm\' 
    $(\'#test\').ajaxForm(options); 
    
    
	
	
	
		$(\'#windowOpen\').bind(
			\'click\',
			function() {
			
				if($(\'#window\').css(\'display\') == \'none\') {
				
					$(this).TransferTo(
						{
							to:\'window\',
							className:\'transferer2\', 
							duration: 400,
							complete: function()
							{
								
							$(\'#window\').show();
							}
						}
					);
					
					$.get("http://benefitby/1.txt", function(data){
 					 	$(\'#windowContent\').text(data);
 					 	$(\'#window\').show();
					});
						
						
				}
				this.blur();
				return false;
			}
		);
		$(\'#windowClose\').bind(
			\'click\',
			function()
			{
				$(\'#window\').TransferTo(
					{
						to:\'windowOpen\',
						className:\'transferer2\', 
						duration: 400
					}
				).hide();
			}
		);
		$(\'#windowMin\').bind(
			\'click\',
			function()
			{
				$(\'#windowContent\').SlideToggleUp(300);
				$(\'#windowBottom, #windowBottomContent\').animate({height: 10}, 300);
				$(\'#window\').animate({height:40},300).get(0).isMinimized = true;
				$(this).hide();
				$(\'#windowResize\').hide();
				$(\'#windowMax\').show();
			}
		);
		$(\'#windowMax\').bind(
			\'click\',
			function()
			{
				var windowSize = $.iUtil.getSize(document.getElementById(\'windowContent\'));
				$(\'#windowContent\').SlideToggleUp(300);
				$(\'#windowBottom, #windowBottomContent\').animate({height: windowSize.hb + 13}, 300);
				$(\'#window\').animate({height:windowSize.hb+43}, 300).get(0).isMinimized = false;
				$(this).hide();
				$(\'#windowMin, #windowResize\').show();
			}
		);
		$(\'#window\').Resizable(
			{
				minWidth: 200,
				minHeight: 60,
				maxWidth: 700,
				maxHeight: 400,
				dragHandle: \'#windowTop\',
				handlers: {
					se: \'#windowResize\'
				},
				onResize : function(size, position) {
					$(\'#windowBottom, #windowBottomContent\').css(\'height\', size.height-33 + \'px\');
					var windowContentEl = $(\'#windowContent\').css(\'width\', size.width - 25 + \'px\');
					if (!document.getElementById(\'window\').isMinimized) {
						windowContentEl.css(\'height\', size.height - 48 + \'px\');
					}
				}
			}
		);
	}
);

function showRequest(formData, jqForm, options) { 
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData); 
 
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 
 
   // alert(\'About to submit: \\n\\n\' + queryString); 
 
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true; 
} 
 
// post-submit callback 
function showResponse(responseText, statusText)  { 
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object\'s responseText property 
 
    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to \'xml\' then the first argument to the success callback 
    // is the XMLHttpRequest object\'s responseXML property 
 
    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to \'json\' then the first argument to the success callback 
    // is the json data object returned by the server 
 
  //  alert(\'status: \' + statusText + \'\\n\\nresponseText: \\n\' + responseText + 
     //   \'\\n\\nThe output div should have already been updated with the responseText.\'); 
} 
</script>
'; ?>