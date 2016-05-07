<?php /* Smarty version 2.6.27, created on 2016-05-06 05:24:36 compiled from main.tpl */ ?>
<?php if ($this->_tpl_vars['IS_AJAX'] == 0): ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '_header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars); ?><div class="centralBlock"><?php if ($this->_tpl_vars['IS_ADMIN'] == 1): ?> <aside> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '_leftMenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars); ?> </aside> <?php endif; ?> <section class="content"> <?php endif; ?> <article> <?php echo $this->_tpl_vars['content']; ?> </article><script>var meta_title='<?php echo $this->_tpl_vars['meta_title'];?>
';</script><?php if ($this->_tpl_vars['IS_AJAX'] == 0): ?> </section></div><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '_footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars); ?> <?php endif; ?>