<?php /* Smarty version 2.6.14, created on 2008-02-10 01:25:05
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/string_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'Z:\\home\\benefitby\\www/application/views/_index/string_view.tpl', 13, false),)), $this); ?>
<div>
<?php if ($this->_tpl_vars['f']->Datasource): ?>
<div class="form_item_title"><?php echo $this->_tpl_vars['f']->Title; ?>
 :</div>
<div id="<?php echo $this->_tpl_vars['f']->ID; ?>
_user_value" style="float:left;"><b><?php if ($this->_tpl_vars['f']->ViewValue):  echo $this->_tpl_vars['f']->ViewValue;  elseif ($this->_tpl_vars['f']->ViewValues): ?>
<?php $_from = $this->_tpl_vars['f']->ViewValues; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
<?php echo $this->_tpl_vars['vv']; ?>
 
<?php endforeach; endif; unset($_from); ?>
</b>
<?php endif; ?>

<?php else: ?>
<div class="form_item_title"><?php echo $this->_tpl_vars['f']->Title; ?>
: </div>
<b><?php if ($this->_tpl_vars['f']->View == 'date'):  echo ((is_array($_tmp=$this->_tpl_vars['f']->Value)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%y") : smarty_modifier_date_format($_tmp, "%d-%m-%y"));  else:  echo $this->_tpl_vars['f']->Value;  endif; ?></b>

<?php endif; ?>
</div>