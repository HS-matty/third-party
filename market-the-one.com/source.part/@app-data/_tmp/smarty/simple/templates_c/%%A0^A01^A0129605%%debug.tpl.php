<?php /* Smarty version 2.6.14, created on 2017-04-27 20:49:57
         compiled from /%40sys/debug.tpl */ ?>

	<br>
<div class="_container" style="font-size:12px;padding-left:40px;padding-top:15px;background-color:#DFDFDF;width:1000px">
	<h4>Common log:</h4>
	
		<ol>
		<?php $_from = $this->_tpl_vars['log']->getMessageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['msg']):
?>
			<li><?php echo $this->_tpl_vars['msg']; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
		</ol>


	<h4>SQL log:</h4>
	
		<ol>
		<?php $_from = $this->_tpl_vars['log']->getMessageList('sql'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['msg_sql']):
?>
			<li><?php echo $this->_tpl_vars['msg_sql']; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
		</ol>
	
	<h4>User:</h4>
	
		<?php if ($this->_tpl_vars['user']->id): ?>
		<ol>
			<ul>id: <?php echo $this->_tpl_vars['user']->id; ?>
</ul>
			<ul>email: <?php echo $this->_tpl_vars['user']->email; ?>
</ul>
			<ul>type: <?php echo $this->_tpl_vars['user']->type; ?>
</ul>
			<ul>role: <?php echo $this->_tpl_vars['user']->role; ?>
</ul>
		</ol>
		<?php else: ?>
			no user
		<?php endif; ?>
		
	<h4>Default templates:</h4>
	<ul>
	<?php $_from = $this->_tpl_vars['window']->workspace; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['ui_element']):
?>
	
	<?php $this->assign('type', $this->_tpl_vars['ui_element']->getType()); ?>
	<?php $this->assign('file', "/@ui/@element/".($this->_tpl_vars['type']).".tpl"); ?>

		<li><?php echo $this->_tpl_vars['type']; ?>
: <?php echo $this->_tpl_vars['file']; ?>
</li>
	<?php endforeach; endif; unset($_from); ?>
	</ol>
	</h4>
		<br />
		<br />
		<br />
		
</div>