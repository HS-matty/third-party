<?php /* Smarty version 2.6.14, created on 2007-11-02 19:00:46
         compiled from z:/home/barefoot_zend/www/application/views/frontend/admin/browse_categories.tpl */ ?>
<?php echo '
<SCRIPT LANGUAGE="JavaScript">
<!--
function parse(id,title){
window.opener.document.getElementById('; ?>
"<?php echo $this->_tpl_vars['id'];  echo '_user_value").innerHTML = '; ?>
'<?php echo $this->_tpl_vars['PathStr']; ?>
'<?php echo ';
window.opener.document.getElementById('; ?>
"<?php echo $this->_tpl_vars['id'];  echo '_puser_value").value = title;
window.opener.document.getElementById('; ?>
"<?php echo $this->_tpl_vars['id'];  echo '").value = id;

self.close();
}

// -->
</SCRIPT>
'; ?>


<?php $_from = $this->_tpl_vars['TreePath']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
<a href="?id=<?php echo $this->_tpl_vars['id']; ?>
&cid=<?php echo $this->_tpl_vars['p']['category_id']; ?>
"><?php echo $this->_tpl_vars['p']['short_description']; ?>
 </a> / 
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['Locations']): ?><h2><?php echo $this->_tpl_vars['LevelTitle']; ?>
</h2><?php endif; ?>
<br>
<ul>
<?php $_from = $this->_tpl_vars['Categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
<li><a href="?id=<?php echo $this->_tpl_vars['id']; ?>
&cid=<?php echo $this->_tpl_vars['c']['category_id']; ?>
"><?php echo $this->_tpl_vars['c']['short_description']; ?>
</a> (<a href="#" onClick="parse(<?php echo $this->_tpl_vars['c']['category_id']; ?>
,'<?php echo $this->_tpl_vars['c']['short_description']; ?>
')">choose</a>)</li>
<?php endforeach; endif; unset($_from); ?>
</ul>