<?php /* Smarty version 2.6.14, created on 2007-11-02 18:42:42
         compiled from z:/home/barefoot_zend/www/application/views/frontend/_index/popup_index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->_tpl_vars['Title']; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/sarissa/sarissa.js"></script>
  <script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/sarissa/sarissa_dhtml.js"></script>
<link href="<?php echo $this->_tpl_vars['HostName']; ?>
/design/style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $this->_tpl_vars['HostName']; ?>
/design/ads.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $this->_tpl_vars['HostName']; ?>
/design/forms.css" rel="stylesheet" type="text/css" media="screen" />
<?php echo '
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
'; ?>


</head>

<body>




<?php if ($this->_tpl_vars['Path']): ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['Path']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


	<?php else: ?>
	No page!
 
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
</body>
</html>
