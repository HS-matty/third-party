<?php /* Smarty version 2.6.14, created on 2008-02-10 01:25:05
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/file_view.tpl */ ?>
<div>
<div class="form_item_title"><?php echo $this->_tpl_vars['f']->Title; ?>
</div>


<?php if ($this->_tpl_vars['f']->FileType == 'image'): ?>
	<?php if ($this->_tpl_vars['f']->Value): ?><img height=100 width=100 src="<?php echo $this->_tpl_vars['HostName'];  echo $this->_tpl_vars['f']->FilePath;  echo $this->_tpl_vars['f']->Value; ?>
">
<br>
<?php else: ?> no image loaded

<?php endif; ?>
	<br>
<?php endif; ?>





</div>