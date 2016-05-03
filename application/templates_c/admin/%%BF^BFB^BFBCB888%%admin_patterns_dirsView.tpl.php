<?php /* Smarty version 2.6.27, created on 2016-03-16 09:04:20 compiled from modules/admin_patterns_dirs/admin_patterns_dirsView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'modules/admin_patterns_dirs/admin_patterns_dirsView.tpl', 5, false),array('modifier', 'date_format', 'modules/admin_patterns_dirs/admin_patterns_dirsView.tpl', 17, false),)), $this); ?><h3 class="add_link"><a class="btn" href="/admin/patterns_dirs/add/"><i class="icon-plus"></i> Добавить директорию</a></h3><h2>Список директорий шаблонов</h2><?php if (count($this->_tpl_vars['obj']) > 0): ?><table class="ui-table"><thead><th>Название директории</th><th>Время начала</th><th>Время окончания</th><th colspan="3"></th></thead><tbody><?php $_from = $this->_tpl_vars['obj']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['item']):
?><tr><td><?php echo $this->_tpl_vars['item']['title']; ?></td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['time_start'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?></td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['time_end'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?></td><td align="center"><a href="/admin/patterns_dirs/music/<?php echo $this->_tpl_vars['item']['id']; ?>
/" class="btn">Музыка</a></td><td align="center"><a href="/admin/patterns_dirs/edit/<?php echo $this->_tpl_vars['item']['id']; ?>
/" class="btn">Редактировать</a></td><td align="center"><a href="/admin/patterns_dirs/delete/<?php echo $this->_tpl_vars['item']['id']; ?>
/" class="btn">Удалить</a></td></tr><?php endforeach; endif; unset($_from); ?></tbody></table><?php endif; ?>