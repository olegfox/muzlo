<?php /* Smarty version 2.6.27, created on 2016-05-03 18:04:31 compiled from main.tpl */ ?>
<?php if ($this->_tpl_vars['IS_AJAX'] == 0): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '_header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars); ?> <?php endif; ?> <?php echo $this->_tpl_vars['content']; ?> <?php if ($this->_tpl_vars['IS_AJAX'] == 0): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '_footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars); ?> <?php endif; ?>