<?php /* Smarty version 2.6.27, created on 2016-02-09 10:52:25 compiled from modules/category/_categoryLevel.tpl */ ?>
<ul>
<?php $_from = $this->_tpl_vars['root']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['level']):
?> <li> <a href="/admin/category/edit/<?php echo $this->_tpl_vars['level']['id']; ?>
/" title="Редактировать категорию"><i class="icon icon-pencil"></i></a> <a href="/admin/secrets/?category=<?php echo $this->_tpl_vars['level']['id']; ?>
"><?php echo $this->_tpl_vars['level']['title']; ?>
</a> <?php if ($this->_tpl_vars['level']['parent_id'] == 0): ?>[ <a href="/admin/category/add/?parent=<?php echo $this->_tpl_vars['level']['id']; ?>
">+ категорию</a> ]<?php endif; ?> <?php if (( ! empty ( $this->_tpl_vars['level']['child'] ) )): ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/category/_categoryLevel.tpl", 'smarty_include_vars' => array('root' => $this->_tpl_vars['level']['child'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars); ?> <?php endif; ?> </li>
<?php endforeach; endif; unset($_from); ?>
</ul>