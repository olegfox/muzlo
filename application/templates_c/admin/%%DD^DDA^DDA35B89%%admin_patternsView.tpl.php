<?php /* Smarty version 2.6.27, created on 2016-05-03 19:37:09 compiled from modules/admin_patterns/admin_patternsView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'modules/admin_patterns/admin_patternsView.tpl', 5, false),)), $this); ?><h3 class="add_link"><a class="btn" href="/admin/patterns/add/"><i class="icon-plus"></i> Добавить шаблон</a></h3><h2>Список шаблонов</h2><?php if (count($this->_tpl_vars['obj']) > 0): ?><table class="ui-table"><thead><th>Название шаблона</th><th colspan="3"></th></thead><tbody><?php $_from = $this->_tpl_vars['obj']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['item']):
?><tr><td><?php echo $this->_tpl_vars['item']['title']; ?></td><td align="center"><a href="/admin/patterns/dirs/<?php echo $this->_tpl_vars['item']['id']; ?>
/" class="btn">Директории</a></td><td align="center"><a href="/admin/patterns/edit/<?php echo $this->_tpl_vars['item']['id']; ?>
/" class="btn">Редактировать</a></td><td align="center"><a href="/admin/patterns/delete/<?php echo $this->_tpl_vars['item']['id']; ?>
/" class="btn">Удалить</a></td></tr><?php endforeach; endif; unset($_from); ?></tbody></table><?php endif; ?>