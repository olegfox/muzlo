<?php /* Smarty version 2.6.27, created on 2016-03-16 09:05:36 compiled from modules/admin_music_files/admin_music_filesView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'modules/admin_music_files/admin_music_filesView.tpl', 5, false),)), $this); ?><h3 class="add_link"><a class="btn" href="/admin/music_files/add/"><i class="icon-plus"></i> Добавить музыкальный файл</a></h3><h2>Список музыкальных файлов</h2><?php if (count($this->_tpl_vars['obj']) > 0): ?><table class="ui-table"><thead><th>Название трека</th><th>Исполнитель</th><th>Жанр</th><th colspan="2"></th></thead><tbody><?php $_from = $this->_tpl_vars['obj']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['item']):
?><tr><td><?php echo $this->_tpl_vars['item']['title']; ?></td><td><?php echo $this->_tpl_vars['item']['owner']; ?></td><td><?php echo $this->_tpl_vars['item']['genre']; ?></td><td align="center"><a href="/admin/music_files/edit/<?php echo $this->_tpl_vars['item']['id']; ?>
/" class="btn">Редактировать</a></td><td align="center"><a href="/admin/music_files/delete/<?php echo $this->_tpl_vars['item']['id']; ?>
/" class="btn">Удалить</a></td></tr><?php endforeach; endif; unset($_from); ?></tbody></table><?php if (! empty ( $this->_tpl_vars['obj']['pagination'] )): ?><div class="paginator"><?php echo $this->_tpl_vars['obj']['pagination']; ?></div><?php endif; ?>
<?php endif; ?>